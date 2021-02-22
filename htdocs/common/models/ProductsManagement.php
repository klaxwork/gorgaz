<?php

namespace common\models;

use common\models\models\CmsTree;
use \yii;
use \common\components\M;
use \common\models\models\EcmOrderProducts;
use \common\models\models\EcmOrders;
use \common\models\models\EcmProducts;
use \common\models\models\EdiBootstrap;
use \common\models\models\EdiRelationClients;
use \yii\base\Exception;
use \yii\BaseYii;
use \yii\helpers\Json;


class ProductsManagement
{
    public function run($catalog_id, $startName, $subCatalogName) {
        //$calatalog_id = 908;
        //$startName = 'Твистеры съедобные LJ Pro Series TROUTINO';
        //$subCatalogName = 'Lucky John TROUTINO';

        M::printr($catalog_id, '$calatalog_id');
        $oParent = CmsTree::model()->findByPk($catalog_id);
        M::printr($oParent->node_name, '$oParent->node_name');

        $catalogs = [];

        $criteria = new CDbCriteria();
        $criteria->addCondition('t.product_name ilike :start');
        $criteria->params['start'] = "{$startName}%";
        //$criteria->addCondition('"appProduct"."cms_tree_ref" IS NULL');

        //M::printr($criteria, '$criteria');

        $oProducts = EcmProducts::model()->with(['appProduct'])->findAll($criteria);
        M::printr(count($oProducts), 'count($oProducts)');
        $i = 0;
        foreach ($oProducts as $oProduct) {
            //$transaction = Yii::app()->db->beginTransaction();

            $product_name = trim($oProduct->product_name);
            M::printr($product_name, '$product_name');

            $color = $this->getColor($product_name);
            M::printr($color, '$color');

            $catalogName = "{$subCatalogName} {$color}";
            M::printr($catalogName, '$catalogName');

            //exit;
            //если нет такого каталога
            if (isset($catalogs[$catalogName])) {
                $oCatalog = $catalogs[$catalogName];
            } else {
                //найти в $oParent такой каталог
                $is_exist = false;
                $oChs = $oParent->children()->findAll();
                foreach ($oChs as $oCh) {
                    if ($oCh->node_name == $catalogName) {
                        $is_exist = true;
                        break;
                    }
                }

                if (!$is_exist) {
                    //создать подкаталог
                    $oCatalog = new CmsTree();
                    $oCatalog->node_name = $catalogName;
                    $oCatalog->url_alias = \QW\Translit::text($color);
                    $oCatalog->is_node_published = true;
                    $oCatalog->appendTo($oParent);

                    //создать content
                    $oContent = new CmsNodeContent();
                    $oContent->cms_tree_ref = $oCatalog->id;
                    $oContent->cms_templates_ref = 1;
                    $oContent->page_title = $catalogName;
                    $oContent->vcs_revision = 1;
                    $oContent->save();
                } else {
                    $oCatalog = $oCh;
                }
                $catalogs[$catalogName] = $oCatalog;
            }
            $oCatalog->dt_updated = new CDbExpression('NOW()');
            $oCatalog->saveNode();

            M::printr($oCatalog->node_name, '$oCatalog->node_name');

            //привязать товар к каталогу
            $oAppProduct = $oProduct->appProduct;
            if (empty($oAppProduct)) {
                $oAppProduct = new AppProducts();
                $oAppProduct->edi_bootstrap_ref = EdiBootstrap::getDefaultBootstrap()->id;
                $oAppProduct->ecm_products_ref = $oProduct->id;
            }
            $oAppProduct->cms_tree_ref = $oCatalog->id;
            $oAppProduct->dt_updated = new CDbExpression('NOW()');
            $oAppProduct->save();

            M::printr('');
            //$transaction->rollback();
            //$transaction->commit();
            (new Map())->checkNode($oCatalog, true);
            //(new Map())->checkProduct($oProduct, true);
            $i++;
            //if ($i > 2) break;
        }


    }

    public function getColor($str) {
        $color = '';

        //Lucky John
        //Мягкие приманки Lunker City SWIMFISH 5.0 (12,7см) / 207 Chartreuse Shad / 4шт
        //Мягкие приманки Sawamura GROGGY 70 2.75 (7 см) / цвет 11 / 6шт
        //Спиннербейт Sawamura One'Up Spin 3/16 oz #101
        //Воблер TsuYoki AGENT 36F 013
        if (1) {
            //M::printr($str, '$str');
            //$p1 = strpos($str, '#');
            //$str1 = trim(substr($str, $p1 + 1, 999));
            //M::printr($str1, '$str1');
            $p2 = mb_strrpos(trim($str), ' ');
            if ($p2 === false) {
                $p2 = 999;
            }
            $color = mb_substr($str, $p2 + 1, 999);
        }
        //M::printr($color, '$color');
        //exit;
        return $color;
    }
}