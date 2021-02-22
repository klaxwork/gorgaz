<?php

class Comments extends CFormModel
{
    public $id;
    public $ecm_products_ref;
    public $client_id = null;
    public $client_message = null;
    public $admin_answer = null;
    public $positive = null;
    public $negative = null;
    public $is_published = false;
    public $dt_updated = null;
    public $rate = 1;
    public $votes = [];
    public $vote = [];
    public $is_notify_client = false;

    public $ediRelationClient;
    public $oQuestComment;

    public function __construct()
    {
        parent::__construct();

        //получить все значения оценок
        $this->votes = Votes::getVotes();
        $this->dt_updated = new CDbExpression('NOW()');
    }

    public static function model()
    {
        return new self;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ecm_products_ref, client_id, client_message', 'required'),
            //array('url_alias', 'unique', 'Url Alias must be unique'),
            //array('template_name, alias', 'length', 'max' => 255),
            //array('description', 'length', 'max' => 1000),
            array('id, rate, ecm_products_ref, client_id, client_message, admin_answer, is_published, votes, positive, negative', 'safe'),
        );

    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'ecm_products_ref' => 'Квест',
            'client_id' => 'Клиент',
            'client_message' => 'Отзыв клиента',
            'positive' => 'Достоинства',
            'negative' => 'Недостатки',
            'admin_answer' => 'Ответ администратора',
            'is_published' => 'Опубликовать',
            'dt_updated' => 'Дата обновления',
            'rate' => 'Оценка',
        );
    }

    public function checkVotes($votes)
    {
        $summ = 0;
        $empty = false;
        foreach ($votes as $vote) {
            $val = $vote['value'];
            if ($val < 0) {
                $val = 0;
                $vote['value'] = 0;
            }
            if ($val > 10) {
                $val = 10;
                $vote['value'] = 10;
            }
            if ($val == 0) {
                $empty = true;
            }

            $summ += $val;
        }
        if ($empty == true && $summ > 0) {
            //return 'Оценка обязательна по всем полям, либо оставьте везде 0 для отзыва без оценки.';
            throw new Exception('Оценка обязательна по всем полям, либо оставьте везде 0 для отзыва без оценки.');
        }

    }

    public function fromArray($array)
    {
        $array['is_published'] = isset($array['is_published']) ? true : false;
        $this->setAttributes($array);
        $this->dt_updated = new CDbExpression('NOW()');

        /*
        try {
            $this->checkVotes($this->votes);
        } catch (Exception $e) {
            $this->addError('message', $e->getMessage());
            throw new Exception($e->getMessage());
        }
        */
    }

    /**
     * @param $id -- AppQuestComments.id
     * @return $this
     * @throws Exception
     */
    public function getComment($id)
    {
        $oComment = AppQuestComments::model()->with(['questVote'])->findByPk($id);
        if (empty($oComment)) {
            throw new Exception('Notify not found!');
        }
        $this->setAttributes($oComment->attributes);
        $this->client_id = $oComment->client->client_id;

        //получить все значения оценок

        //$this->votes = Votes::getVote('product_vote');
        //$this->votes = Votes::getVotes($oComment->id);
        //$this->votes = $oComment->getVotes('product_vote');
        $this->vote = $oComment->getVotes();
        return $this;
    }

    public function getComments($ecm_products_ref, $limit = '-1', $offset = 0)
    {
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(['ecm_products_ref' => $ecm_products_ref]);
        $criteria->addCondition('is_published IS TRUE');
        $criteria->addCondition('is_trash IS FALSE');
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->order = 'dt_created DESC';
        $oComments = AppQuestComments::model()->with('client')->findAll($criteria);
        return $oComments;
    }

    public function getBootstrap($ecm_products_ref)
    {
        $oEcmProduct = EcmProducts::model()->with(
            [
                'appProduct.ediBootstrap'
            ]
        )->findByPk($ecm_products_ref);
        if (empty($oEcmProduct)) {
            throw new Exception('Can`t find ecmProduct');
        }
        if (empty($oEcmProduct->appProduct->ediBootstrap)) {
            throw new Exception('Can`t find ediBootstrap');
        }
        $ediBootstrap = $oEcmProduct->appProduct->ediBootstrap;
    }

    public function setRelationClient($client_id)
    {
        $EdiRelationClient = EdiRelationClients::model()->findByAttributes(['client_id' => $client_id]);
        $this->ediRelationClient = $EdiRelationClient;
        return $EdiRelationClient;
    }

    public function save()
    {
        //сохранить сам комментарий
        if (!$this->validate()) {
            throw new Exception('Not validated...');
        }

        $oQuestComment = new AppQuestComments();
        if ($this->id) {
            $oQuestComment = AppQuestComments::model()->findByPk($this->id);
        }

        if (!$this->ediRelationClient) {
            $this->setRelationClient($this->client_id);
        }

        $oQuestComment->edi_relation_clients_ref = $this->ediRelationClient->id;
        $oQuestComment->setAttributes($this->getAttributes());
        if (!$oQuestComment->validate()) {
            throw new Exception('QuestComment Validate error');
        }
        if (!$oQuestComment->save()) {
            $this->addErrors($oQuestComment->getErrors());
            throw new Exception('Not saved...');
        }
        $this->oQuestComment = $oQuestComment;
        $this->id = $oQuestComment->id;

        $this->countRating();
        return true;
    }

    public function countRating($ecm_products_ref = false)
    {
        if (!$ecm_products_ref) {
            if (!empty($this->ecm_products_ref)) {
                $ecm_products_ref = $this->ecm_products_ref;
            }
        }

        if (!$ecm_products_ref) {
            throw new Exception('ecm_products_ref is empty!');
        }

        //получить все комментарии с оценками данного товара
        $oProduct = EcmProducts::model()->findByPk($ecm_products_ref);
        $oComments = $oProduct->getComments($ecm_products_ref);
        $s = 0;
        foreach ($oComments as $oComment) {
            if (!$oComment->is_trash && $oComment->is_published) {
                $s += (int)$oComment->rate;
            }
        }

        //получить среднее значение
        $average = 0;
        if (count($oComments) > 0) {
            $average = $s / count($oComments);
        }
        //сохранить данные в продукте
        $oProduct->rating = $average;
        if (!$oProduct->save()) {
            throw new Exception('Can`t save ecm_product');
        }

        return true;
    }

    /*/
    public function countRating($ecm_products_ref = false)
    {
        if (!$ecm_products_ref) {
            if (!empty($this->ecm_products_ref)) {
                $ecm_products_ref = $this->ecm_products_ref;
            }
        }
        if (!$ecm_products_ref) {
            throw new Exception('ecm_products_ref is empty!');
        }
        $countVotes = AppVotes::model()->count();

        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(['ecm_products_ref' => $ecm_products_ref, 'is_published' => true]);
        $oComments = AppQuestComments::model()
            ->with(
                [
                    'votes',
                ]
            )
            ->findAll($criteria);
        $votes = [];
        $counter = 0;
        foreach ($oComments as $oComment) {
            if (count($oComment->votes) < $countVotes) {
                continue;
            }
            foreach ($oComment->votes as $oVote) {
                if ($oVote->vote_value == 0) {
                    continue;
                }
                if (!isset($votes[$oVote->app_votes_ref])) {
                    $votes[$oVote->app_votes_ref] = 0;
                }
                $votes[$oVote->app_votes_ref] += $oVote->vote_value;
                $counter++;
            }
        }
        $summ = 0;
        if (count($votes) > 0) {
            $counter = $counter / count($votes);
            foreach ($votes as $key_vote => $vote) {
                $votes[$key_vote] = $vote / $counter;
                $summ += $vote / $counter;
            }
            $summ = $summ / count($votes);
            str_replace('.', ',', $summ);
        }
        //M::printr($summ, '$summ');
        M::xlog($summ, '$summ');
        $ecmProduct = EcmProducts::model()->findByPk($ecm_products_ref);
        //M::printr($ecmProduct, 'Before save: $ecmProduct');
        M::xlog($ecmProduct, 'Notify');
        $ecmProduct->rating = $summ;
        //M::printr($ecmProduct, 'Before validate: $ecmProduct');
        M::xlog($ecmProduct, 'Notify');
        $ecmProduct->validate();
        //M::printr($ecmProduct, 'After validate: $ecmProduct');
        if (!$ecmProduct->save()) {
            M::xlog('!$ecmProduct->save()', 'Notify');
            M::xlog($ecmProduct, 'Notify');
            //M::printr($ecmProduct, 'IN $ecmProduct');
            throw new Exception('Can`t save rating in EcmProducts');
        }
        M::xlog($ecmProduct, 'Notify');
        //M::printr($ecmProduct, 'After save: $ecmProduct');

        //return $oComments;
    }
    //*/

}