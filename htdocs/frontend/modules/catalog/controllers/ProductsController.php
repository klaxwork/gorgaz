<?php

namespace frontend\modules\catalog\controllers;

use common\models\models\AppClients;
use common\models\models\AppComments;
use common\models\models\CmsNodeContent;
use common\models\models\EdiRelationClients;
use common\models\Translit;
use yii\db\Connection;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use common\components\M;
use common\models\models\CmsTree;
use common\models\models\EcmProducts;
use frontend\components\FrontendController;
use yii\web\Response;

class ProductsController extends FrontendController
{
    //public $layout = '//layouts/ct-default';

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['*'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function init()
    {
        /*/
        if (Yii::app()->request->isAjaxRequest) {
            $this->layout = '//layouts/ajax-popup';
        }
        $cs = Yii::app()->clientScript;
        $themePath = Yii::app()->theme->baseUrl;
        $cs->registerScriptFile($themePath . '/assets/js/keymaster-master/keymaster.js', CClientScript::POS_END);
        //*/
    }

    public function actionIndex()
    {
        $roots = CmsTree::model()->roots()->findAll(array('order' => 't.id ASC'));
        $id = 0;
        $this->render('index', compact('roots'));
    }

    public function actionGetEcmProducts($id = 200)
    {
        $oParent = CmsTree::findOne($id);
        //M::printr($oParent, '$oParent');

        $oQuery = EcmProducts::find()
            ->joinWith(
                [
                    'fields.customField',
                    'appProduct.tree',
                    'productStore.warehouse',
                ]
            )
            ->where('"tree"."ns_root_ref" = :cat_root', [':cat_root' => $oParent->ns_root_ref])
            ->andOnCondition(
                '"tree"."ns_left_key" >= :cat_left AND "tree"."ns_right_key" <= :cat_right AND "is_closed" IS FALSE',
                [
                    ':cat_left' => $oParent->ns_left_key,
                    ':cat_right' => $oParent->ns_right_key,
                ]
            )
            ->limit(100);

        if (!empty($_POST['SearchString'])) {
            $oQuery->andWhere(
                'product_name ILIKE :searchString OR ("customField"."field_key" = :field_key AND "fields"."field_value" ILIKE :searchString)',
                [
                    'searchString' => "%{$_POST['SearchString']}%",
                    'field_key' => '1c_product_vendor',
                ]
            );
        }

        if (empty($_POST['isShowAll'])) {
            $oQuery->andWhere('"appProduct"."id" IS NULL');
        }

        $oProducts = $oQuery->all();


        //M::printr(count($oProducts), 'count($oProducts)');

        $arr = [];
        if (!empty($oProducts)) {
            foreach ($oProducts as $oProduct) {
                //$fields = $oProduct->getProductFields();
                $oVendor = $oProduct->getField('1c_product_vendor');
                $oUnit = $oProduct->getField('unit');

                $item = $oProduct->attributes;
                $item['ecm_product'] = $oProduct->attributes;
                $item['ecm_products_ref'] = $oProduct->id;
                $item['images'] = 0;
                if (!empty($oProduct->hasGallery)) {
                    $item['images'] = count($oProduct->hasGallery);
                }
                //$item['countOffers'] = $oProduct->getCountOffers();
                $item['unit'] = $oUnit; //$oProduct->getField('unit');
                //M::printr($item['unit'], '$item[\'unit\']');
                $item['vendor'] = $oVendor; //$oProduct->getField('1c_product_vendor');
                $arr[] = $item;
            }
        }

        $JS = [
            'success' => true,
            'message' => '',
            'messages' => [],
            'response_data' => $arr,
        ];

        if (\Yii::$app->request->isAjax) {
            return Json::encode($JS);
        }
    }

    public function actionGetProductComments($ecm_products_ref = false)
    {
        $JS = [
            'success' => true,
            'message' => '',
            'messages' => [],
            'html' => [],
        ];

        try {
            if (!$ecm_products_ref) {
                throw new Exception('ecm_products_ref is empty');
            }
            $oProduct = EcmProducts::findOne($ecm_products_ref);
            if (empty($oProduct)) {
                throw new Exception('oProduct is empty');
            }
            $oComments = $oProduct->getProductComments();
            //M::printr($oProduct->attributes, '$oProduct->attributes');
            $html = '';
            foreach ($oComments as $oComment) {
                $render = $this->renderPartial('_partial/_comment.php', ['oComment' => $oComment]);
                //M::printr($render, '$render');
                $html .= $render;
            }
            //M::printr($html, '$html');
            $JS['html'] = $html;

        } catch (Exception $e) {
            $JS['message'] = $e->getMessage();
            $JS['success'] = false;
        }
        if (\Yii::$app->request->isAjax) {
            return Json::encode($JS);
        }
        return false;
    }

    public function actionSaveComment()
    {
        $JS = [
            'success' => true,
            'message' => '',
            'messages' => [],
        ];
        try {

            //сохранение коммента
            //M::printr($_GET, '$_GET');
            //M::printr($_POST, '$_POST');

            if (empty($_POST['ecm_products_ref'])) {
                throw new Exception('ecm_products_ref is empty');
            }

            $edi_relation_clients_ref = null;
            if (1) {
                //сохранить юзера
                $data = Json::encode($_POST);
                $oClient = new AppClients();
                $oClient->client_view_name = $_POST['name'];
                $oClient->client_hash_key = hash('sha256', $data);
                $oClient->data = $data;
                if (!$oClient->save()) {
                    $JS['messages'] = $oClient->getErrors();
                    throw new Exception('Some errors in $oClient->save()');
                }
                //M::printr($oClient, '$oClient');

                $oRelationClient = new EdiRelationClients();
                $oRelationClient->app_clients_ref = $oClient->id;
                $oRelationClient->client_view_name = $_POST['name'];
                $oRelationClient->data = $data;
                if (!$oRelationClient->save()) {
                    $JS['messages'] = $oRelationClient->getErrors();
                    throw new Exception('Some errors in $oRelationClient->save()');
                }
                //M::printr($oRelationClient, '$oRelationClient');
            }

            if (1) {
                //сохранить коммент
                $ecm_products_ref = $_POST['ecm_products_ref'];
                $oComment = new AppComments();
                $oComment->ecm_products_ref = $ecm_products_ref;
                $oComment->edi_relation_clients_ref = $oRelationClient->id;
                $oComment->client_message = $_POST['client_message'];
                $oComment->positive = $_POST['positive'];
                $oComment->negative = $_POST['negative'];
                if (!$oComment->save()) {
                    $JS['messages'] = $oComment->getErrors();
                    throw new Exception('Some errors in $oComment->save()');
                }
                //M::printr($oComment, '$oComment');
            }
        } catch (Exception $e) {
            $JS['message'] = $e->getMessage();
            $JS['success'] = false;
        }

        if (\Yii::$app->request->isAjax) {
            return Json::encode($JS);
        }
        return false;
    }

    public function actionGetProductFields($ecm_products_ref = false)
    {
        $JS = [
            'success' => true,
            'message' => '',
            'messages' => [],
            'html' => [],
        ];

        try {
            if (!$ecm_products_ref) {
                throw new Exception('ecm_products_ref is empty');
            }
            $oProduct = EcmProducts::find()
                ->alias('t')
                ->joinWith(
                    [
                        'fields.customField.customFieldMeta',
                        'fields.customFieldDict',
                    ]
                )
                ->where(['t.id' => $ecm_products_ref])
                ->one();
            if (empty($oProduct)) {
                throw new Exception('oProduct is empty');
            }

            $oFields = $oProduct->getProductFields();
            //M::printr($oFields, '$oFields');

            $html = '';
            foreach ($oFields as $oField) {
                if (!$oField->customField->is_visible) continue;
                $render = $this->renderPartial('_partial/_field.php', ['oField' => $oField]);
                //M::printr($render, '$render');
                $html .= $render;
            }

            if (0) {
                $oComments = $oProduct->getProductComments();
                //M::printr($oProduct->attributes, '$oProduct->attributes');
                foreach ($oComments as $oComment) {
                    $render = $this->renderPartial('_partial/_comment.php', ['oComment' => $oComment]);
                    //M::printr($render, '$render');
                    $html .= $render;
                }
                //M::printr($html, '$html');
            }
            $JS['html'] = $html;

        } catch (Exception $e) {
            $JS['message'] = $e->getMessage();
            $JS['success'] = false;
        }
        if (\Yii::$app->request->isAjax) {
            return Json::encode($JS);
        }
        return false;
    }

}


