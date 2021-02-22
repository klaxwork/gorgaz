<?php

namespace backend\modules\cms\controllers;

use common\components\M;
use common\models\models\CmsTree;
use common\models\models\EcmProducts;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\components\BackendController;

/**
 * Default controller for the `cms` module
 */
class DefaultController extends BackendController
{
    public function behaviors() {
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

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionGlobal() {
        //$oPartner = AppPartners::model()->findByPk($this->partner_id);

        //$this->pageTitle = 'Каталог товаров';

        /*
        $cs = Yii::app()->clientScript;
        $themePath = Yii::app()->theme->baseUrl;

        $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/jquery.fancytree-all.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.childcounter.js', CClientScript::POS_END);
        $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.columnview.js', CClientScript::POS_END);
        $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.dnd.js', CClientScript::POS_END);
        $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.edit.js', CClientScript::POS_END);
        $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.filter.js', CClientScript::POS_END);
        */
        return $this->render('global');
    }

    public function actionGetEcmProducts($id) {
        //$this->enableCsrfValidation = false;
        //отключаем проверку Csrf
        $oParent = CmsTree::findOne(['id' => $id]);
        $oQuery = EcmProducts::find()->alias('products');
        $oQuery->andWhere(['products.is_trash' => false]);
        if (!empty($_POST['SearchString'])) {
            $oQuery->andOnCondition('products.product_name ILIKE :searchString OR ("customField"."field_key" = :field_key AND "fields"."field_value" ILIKE :searchString)');
            $oQuery->params['searchString'] = "%{$_POST['SearchString']}%";
            $oQuery->params['field_key'] = "1c_product_vendor";
        }


        #TODO Если каталог "НЕРАСПРЕДЕЛЕННЫЕ ИЗ 1С", то показать все из корня
        if ($id == 7185 || $id == 0) {
            #TODO Если галочка "Показать все" не стоит, то показать те, которые не имеют привязок
            if (empty($_POST['isShowAll'])) {
                $oQuery->andOnCondition('appProducts.id IS NULL');
            }
        } else {
            $oQuery->andOnCondition('tree.id = :tree');
            $oQuery->params['tree'] = $id;
            //$criteria->addCondition('"tree"."id" = :tree');
            //$criteria->params['tree'] = $id;
        }
        //$criteria->together = true;
        $oQuery->orderBy(['products.product_name' => 'ASC']);
        //$criteria->order = 't.product_name ASC';
        $oQuery->limit = 1000;
        //$criteria->limit = 1000;
        $oQuery->joinWith(
            [
                'appProducts.tree',
                'fields.customField.customFieldMeta',
                'fields.customFieldDict',
                //'appProducts.hasGallery.gallery.storage',
                //'products.ecmProduct.hasGallery.gallery.storage',
            ]
        );
        $oProducts = $oQuery->all();
        //M::printr('$oProducts', count($oProducts));
        $arr = [];
        if (!empty($oProducts)) {
            foreach ($oProducts as $oProduct) {
                $item = $oProduct->attributes;
                $item['ecm_product'] = $oProduct->attributes;
                $item['ecm_products_ref'] = $oProduct->id;
                $item['images'] = 0;
                /*/
                if (!empty($oProduct->appProducts->hasGallery)) {
                    $item['images'] = count($oProduct->appProducts->hasGallery);
                }
                //*/
                $item['store'] = $oProduct->getProductCount();
                $item['price'] = $oProduct->product_price;
                //$item['countOffers'] = $oProduct->getCountOffers();
                $item['unit'] = $oProduct->getField('unit');
                //M::printr($item['unit'], '$item[\'unit\']');
                $item['vendor'] = $oProduct->getField('1c_product_vendor');
                $arr[] = $item;
            }
        }

        /*/
        $oTree = CmsTree::model()
            ->with(
                [
                    'products.ecmProduct.hasGallery.gallery.storage',
                ]
            )
            ->find($criteria);
        $arr = [];
        //M::printr($oTree, '$oTree');
        //exit;
        if (!empty($oTree)) {
            foreach ($oTree->products as $oAppProduct) {
                $oProduct = $oAppProduct->ecmProduct;
                $item = $oAppProduct->attributes;
                $item['ecm_product'] = $oProduct->attributes;
                $item['images'] = 0;
                if (!empty($oProduct->hasGallery)) {
                    $item['images'] = count($oProduct->hasGallery);
                }
                //$item['countOffers'] = $oProduct->getCountOffers();
                $item['vendor'] = $oProduct->getField('1c_product_vendor');
                $arr[] = $item;
            }
        }
        //*/
        /*
        $criteria = new CDbCriteria();
        $criteria->addCondition('"tree"."id" = :tree');
        $criteria->addCondition('"t"."is_trash" IS NOT TRUE');
        $criteria->order = 'product_name ASC';
        $criteria->params['tree'] = $id;
        $oProducts = EcmProducts::model()
            ->with(
                [
                    'appProduct.tree',
                    'appProduct.hasGallery.gallery.storage',
                ]
            )
            ->findAll($criteria);
        //$oProducts = [];
        $arr = [];
        foreach ($oProducts as $oProduct) {
            $item = $oProduct->attributes;
            $item['images'] = 0;
            if (!empty($oProduct->hasGallery)) {
                $item['images'] = count($oProduct->hasGallery);
            }
            //$item['countOffers'] = $oProduct->getCountOffers();
            $item['vendor'] = $oProduct->getField('1c_product_vendor');
            $arr[] = $item;
        }
        */

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

    public function actionUnbindNoms() {
        M::printr($_POST, '$_POST');
        exit;
    }
}
