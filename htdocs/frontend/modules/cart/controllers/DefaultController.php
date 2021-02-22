<?php

namespace frontend\modules\cart\controllers;

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
    }

    public function actionFormComment($ecm_products_ref)
    {
        $formName = 'PostReview';
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
                    $oClient = new Clients();
                    $oClient->ediBootstrap = EdiBootstrap::getDefaultBootstrap();
                    $oClient->fromArray($_POST[$formName]);
                    //$oClient->region_key = $oProduct->appProduct->hasRegion->region->region_key;
                    //M::xlog(['$oClient', $oClient]);
                    if (!$oClient->save()) {
                        //M::printr($oClient, '$oClient');
                        //exit;
                        //M::xlog(['!SAVE $oClient', $oClient]);
                        $JS['messages'] += $oClient->getErrors();
                        throw new Exception('Невозможно сохранить клиента');
                    }
                    //M::xlog(['Saved $oClient', $oClient]);
                }

                $oComment = new Comments();

                //передать данные в модель отзыва
                $oComment->fromArray($_POST[$formName]);
                $oComment->ecm_products_ref = $oProduct->id;
                $oComment->client_id = $oClient->oClient['id'];
                $oComment->ediRelationClient = $oClient->ediRelationClient;
                //M::xlog(['$oComment', $oComment]);
                //сохранить данные модели отзыва
                if (!$oComment->save()) {
                    //M::xlog(['!SAVE $oComment', $oComment]);
                    $JS['messages'] += $oComment->getErrors();
                    throw new Exception('Невозможно сохранить отзыв');
                }
                //M::xlog(['Saved $oComment', $oComment]);

                //сохранить данные оценки
                $oQuestVote = new AppQuestVotes();
                $oQuestVote->app_quest_comments_ref = $oComment->id;
                //$oQuestVote->app_votes_ref = $_POST[$formName]['app_votes_ref'];
                //$oQuestVote->vote_value = $_POST[$formName]['vote_value'];
                //M::xlog(['$oQuestVote', $oQuestVote]);
                if (!$oQuestVote->save()) {
                    //M::xlog(['!SAVE $oQuestVote', $oQuestVote]);
                    $JS['messages'] += $oQuestVote->getErrors();
                    throw new Exception('Can`t save Vote...');
                }
                //M::xlog(['Saved $oQuestVote', $oQuestVote]);
                /*
                //TODO Отправить уведомление
                $notify = new TwigNotify('AddQuestComment');
                $notify->product = $oProduct->attributes;
                //отправить
                $notify->send();
                //M::printr($notify, '$notify');
                */

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

        return $this->renderPartial('formReview', compact('formName', 'oProduct'));
    }

}
