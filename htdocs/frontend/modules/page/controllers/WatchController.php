<?php

namespace frontend\modules\page\controllers;

use common\models\ar_inherit\Tree;

use common\models\ElSearch;
use common\models\ElSearchFilter;
use common\models\models\EcmProducts;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\FrontendController;
use common\models\models\CmsTree;
use common\components\M;
use frontend\components\widgets\CatalogCardWidget\CatalogCardWidget;

class WatchController extends FrontendController
{

    public function actionView($node_id = 200) {
        //M::printr($node_id, '$node_id');
        //M::printr('');

        //M::printr($this->layout, '$this->layout');


        $oNode = CmsTree::find()
            ->onCondition(['id' => $node_id])
            ->one();

        if ($node_id == 110) {
            $oCategory = CmsTree::find()
                ->alias('tree')
                ->joinWith(['content'])
                ->where('tree.id = :id', [':id' => 200])
                ->one();
            $oChs = $oCategory
                ->children(1)
                ->joinWith('content')
                ->onCondition(['is_node_published' => true])
                ->all();
            $this->data['oCategory'] = $oCategory;
            $this->data['oChs'] = $oChs;

            $oBlock = CmsTree::getBlock('catalog');
            $this->data['oBlock'] = $oBlock;

            $this->page_title = 'Каталог';
        }

        if (0) {
            if ($node_id == 100) {
                $this->is_main_page = true;
            }

            if ($node_id == 110) {
                $oCategory = CmsTree::find()
                    ->alias('tree')
                    ->joinWith(['content'])
                    ->where('tree.id = :id', [':id' => 200])
                    ->one();
                $oChs = $oCategory
                    ->children(1)
                    ->with('content')
                    ->all();
                $this->data['oCategory'] = $oCategory;
                $this->data['oChs'] = $oChs;
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
            //$node = \CmsTree\Node::with($node_id);
            //$this->fillSeo($node);
            //$this->page($node->model());
        }


        return $this->page($oNode);
    }

    public function actionIndex() {
        //$this->layout = '@theme/views/layouts/index';
        return $this->render('index');
    }

    public function actionAbout() {
        //$this->layout = '@theme/views/layouts/index';
        return $this->render('about');
    }

    public function actionWork() {
        //$this->layout = '@theme/views/layouts/index';
        return $this->render('work');
    }

    public function actionBlog() {
        //$this->layout = '@theme/views/layouts/index';
        return $this->render('blog');
    }

    public function actionContacts() {
        //$this->layout = '@theme/views/layouts/index';
        return $this->render('contacts');
    }

    public function actionMain() {
        return $this->render('main');
    }
}
