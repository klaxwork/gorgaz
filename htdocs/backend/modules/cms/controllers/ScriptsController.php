<?php

namespace backend\modules\cms\controllers;

use common\models\Map;
use common\models\models\AppProducts;
use common\models\models\EcmProducts;
use common\models\models\EdiBootstrap;
use Yii;
use common\models\models\CmsNodeContent;
use common\models\CMSTreeManagement;
use backend\models\NodeForm;
use common\models\Translit;
use yii\db\Connection;
use yii\db\Exception;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use common\components\M;
use common\models\models\CmsTree;
use backend\components\BackendController;
use yii\web\Response;

class ScriptsController extends BackendController
{
    //public $layout = '//layouts/ct-default';

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Перенос url_alias из cms_node_content.url_alias в cms_tree.url_alias
     */
    public function actionIndex()
    {
        $oNodes = CmsTree::find()
            ->joinWith([
                'content'
            ])
            ->orderBy(['id' => 'ASC'])
            ->all();
        M::printr(count($oNodes), 'count($oNodes)');

        foreach ($oNodes as $oNode) {
            if(!empty($oNode->content)){
                $oNode->url_alias = $oNode->content->url_alias;
                $oNode->save();
            }

        }
    }

}
