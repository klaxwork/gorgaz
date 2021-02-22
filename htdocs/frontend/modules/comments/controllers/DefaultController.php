<?php

namespace frontend\modules\comments\controllers;

use common\models\models\AppClients;
use common\models\models\AppComments;
use common\models\models\EdiBootstrap;
use common\models\models\EdiRelationClients;
use common\models\TwigNotify;
use yii;
use common\models\models\EcmProducts;
use yii\base\Exception;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\FrontendController;
use common\models\models\CmsTree;
use common\components\M;
use yii\helpers\Json;

class DefaultController extends FrontendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLoadMoreComments()
    {
        //M::printr([$_POST, $_GET]);
        //exit;

        $limit = !empty($_POST['limit']) ? $_POST['limit'] : 2;
        $offset = !empty($_POST['offset']) ? $_POST['offset'] : 0;

        $JS = [
            'success' => true,
            'limit' => $limit,
            'offset' => $offset,
        ];

        try {
            $ecm_products_ref = !empty($_POST['ecm_products_ref']) ? $_POST['ecm_products_ref'] : false;

            if (!$ecm_products_ref) {
                throw new Exception('Товар не указан!');
            }

            //загрузить необходимое количество комментариев
            $oProduct = EcmProducts::findOne($ecm_products_ref);
            $oComments = $oProduct->getProductComments($limit, $offset);

            $JS['comments'] = $this->renderPartial('_comments', ['oComments' => $oComments]);
            $JS['count'] = count($oComments);
            $JS['countAll'] = $oProduct->getCommentsCount();

        } catch (Exception $e) {
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
        }

        if (Yii::$app->request->isAjax) {
            return Json::encode($JS);
        }
        return false;
    }

    public function actionFormComments($ecm_products_ref)
    {
        $formName = 'PostComment';
        //Получить товар по его ID
        $oProduct = EcmProducts::find()
            ->alias('product')
            ->joinWith(
                [
                    'appProduct.tree',
                    //'comments.questVote.vote',
                ]
            )
            ->where(['product.id' => $ecm_products_ref])
            ->one();
        $JS = [
            'success' => true,
            'message' => null,
            'messages' => [],
        ];
        if (isset($_POST[$formName]) && !empty($_POST[$formName])) {
            //M::printr($_POST, '$_POST');
            //M::xlog(['$_POST', $_POST]);

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $tr = trim($_POST[$formName]['email']);
                if (empty($tr)) {
                    throw new Exception('Не указана электронная почта');
                }

                if (1) {
                    //сохранить клиента
                    $oAppClient = new AppClients();
                    $data = Json::encode($_POST[$formName]);
                    $oAppClient->client_hash_key = hash('sha256', $data);
                    $oAppClient->data = $data;
                    $oAppClient->client_view_name = $_POST[$formName]['first_name'];
                    if (!$oAppClient->save()) {
                        throw new Exception('Невозможно сохранить клиента appClient');
                    }

                    $oClient = new EdiRelationClients();
                    $oClient->client_view_name = !empty($_POST[$formName]['first_name']) ? $_POST[$formName]['first_name'] : '';
                    $oClient->data = Json::encode($_POST[$formName]);
                    $oClient->app_clients_ref = $oAppClient->id;
                    if (!$oClient->save()) {
                        $JS['messages'] += $oClient->getErrors();
                        throw new Exception('Невозможно сохранить клиента');
                    }
                }

                $oAppComment = new AppComments();

                //передать данные в модель отзыва
                $oAppComment->setAttributes($_POST[$formName]);
                $oAppComment->ecm_products_ref = $oProduct->id;
                $oAppComment->edi_relation_clients_ref = $oClient->id;
                //M::xlog(['$oComment', $oComment]);
                //сохранить данные модели отзыва
                if (!$oAppComment->save()) {
                    //M::xlog(['!SAVE $oComment', $oComment]);
                    $JS['messages'] += $oAppComment->getErrors();
                    throw new Exception('Невозможно сохранить отзыв');
                }
                //M::xlog(['Saved $oComment', $oComment]);

                //сохранить данные оценки
                if (0) {
                    $oQuestVote = new AppQuestVotes();
                    $oQuestVote->app_quest_comments_ref = $oAppComment->id;
                    //$oQuestVote->app_votes_ref = $_POST[$formName]['app_votes_ref'];
                    //$oQuestVote->vote_value = $_POST[$formName]['vote_value'];
                    //M::xlog(['$oQuestVote', $oQuestVote]);
                    if (!$oQuestVote->save()) {
                        //M::xlog(['!SAVE $oQuestVote', $oQuestVote]);
                        $JS['messages'] += $oQuestVote->getErrors();
                        throw new Exception('Can`t save Vote...');
                    }
                    //M::xlog(['Saved $oQuestVote', $oQuestVote]);
                }
                /*/
                //TODO Отправить уведомление
                $notify = new TwigNotify('AddQuestComment');
                $notify->product = $oProduct->attributes;
                //отправить
                $notify->send();
                //M::printr($notify, '$notify');
                //*/

                $transaction->commit();
            } catch (Exception $e) {
                $JS['success'] = false;
                $JS['message'] = $e->getMessage();
                $transaction->rollback();
            }

            if (Yii::$app->request->isAjax) {
                return Json::encode($JS);
            }

        }

        return $this->renderPartial('_form', ['formName' => $formName, 'oProduct' => $oProduct]);
    }

}
