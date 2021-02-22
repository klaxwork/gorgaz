<?php

namespace frontend\modules\page\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\FrontendController;
use common\models\models\CmsTree;
use common\components\M;

class CatalogController extends FrontendController
{

    public function actionView($node_id = 200)
    {

        M::printr($node_id, '$node_id');
        M::printr('');
        return false;
        exit;

        if ($node_id == 100) {
            $this->is_main_page = true;
        }

        if ($node_id == 200) {
            $oCategory = CmsTree::model()->getCategoryByPk($node_id);
            $this->fillSeo($oCategory);
            $this->render('catalog', compact('oCategory'));
            Yii::app()->end();
        }

        if ($node_id == 201) {
            $oCategory = CmsTree::model()->getCategoryByPk($node_id);
            $this->fillSeo($oCategory);
            $this->render('news', compact('oCategory'));
            Yii::app()->end();
        }


        //\CmsTree\Cache\Dependency::instance();
        $node = \CmsTree\Node::with($node_id);
        $this->fillSeo($node);
        $this->page($node->model());


    }

}