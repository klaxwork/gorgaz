<?php

namespace backend\modules\cms\controllers;

use common\models\models\CmsNodeContent;
use common\models\Translit;
use yii\db\Connection;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use common\components\M;
use common\models\models\CmsTree;
use backend\components\BackendController;
use yii\web\Response;

class TreeController extends BackendController
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

    public function actionWatch($id)
    {
        $root = CmsTree::model()->findByPk($id);
        //M::printr($root, '$root');
        $oTree = CMSTreeManagement::getTree($id);
        //M::printr($oTree, '$oTree');

        $tree = array();
        foreach ($oTree as $oNode) {
            if ($oNode->is_trash === true) {
                continue;
            }
            $node = $oNode->attributes;
            $node['key'] = $oNode->id;
            $node['title'] = $oNode->node_name;
            $tree[] = $node;
        }
        //M::printr($tree, '$tree');

        $res = array_values(CMSTreeManagement::createTree($tree));
        //M::printr($res, '$res');
        //$JS = CJSON::encode($res);


        $this->render('watch', compact('id', 'root', 'res'));
    }

    public function actionNews()
    {
        $root = CmsTree::model()->findByAttributes(['url_alias' => 'news', 'ns_level' => 1]);
        //M::printr($root, '$root');
        $criteria = new CDbCriteria();
        $criteria->addCondition('is_trash IS FALSE');
        $criteria->order = 'dt_created DESC';
        $oNews = $root->descendants()->findAll($criteria);
        //M::printr($oNews, '$oNews');

        $this->render('news', compact('id', 'root', 'oNews'));
    }

    public function actionCreateNode($parent = false)
    {
        $formName = 'CreateNode';
        $oNode = new CmsTree();

        if (!empty($_POST)) {
            $JS = array();
            $JS['success'] = true;
            $JS['messages'] = [];
            try {
                $db = \Yii::$app->db;
                $transaction = $db->beginTransaction();
                //создать узел.
                $oParent = CmsTree::findOne($parent);
                $oNode->node_name = $_POST[$formName]['page_title'];
                if (!$oNode->appendTo($oParent)) {
                    $JS['messages'] = array_merge([], $oNode->getErrors());
                }

                //создаем content
                $oContent = new CmsNodeContent();
                $oContent->page_title = $_POST[$formName]['page_title'];
                $oContent->cms_tree_ref = $oNode->id;
                $oContent->cms_templates_ref = 1;
                $oContent->url_alias = Translit::text($_POST[$formName]['page_title']);
                if (!$oContent->save()) {
                    $JS['messages'] = array_merge([], $JS['messages'], $oContent->getErrors());
                }
                //создаем url_alias--id
                $oContent->url_alias = Translit::text($_POST[$formName]['page_title']) . '--' . $oContent->id;
                if (!$oContent->save()) {
                    $JS['messages'] = array_merge([], $JS['messages'], $oContent->getErrors());
                }
                //$transaction->rollBack();
                $transaction->commit();
            } catch (\Exception $e) {
                $JS['messages'] = $e->getMessage();
                $JS['success'] = false;
                $transaction->rollBack();
            }
            return Json::encode($JS);
        }

        return $this->renderPartial('createNode', compact('formName', 'oNode', 'parent'));
    }

    public function actionCreateNews($id = false)
    {
        $formName = 'CreateNews';
        $model = new NewsForm();
        //$model->is_seo_noindexing = true;

        if (!empty($_POST)) {
            $JS = array();
            $JS['errors'] = false;
            $root = CmsTree::model()->find('url_alias = :alias', ['alias' => 'news']);
            $model->fromArray($_POST[$formName]);
            $model->root_id = $root->id;
            if (!$model->save()) {
                $JS['errors'] = true;
                $JS['error'] = $model->getErrors();
            }
            //создать карту сайта
            (new CmsTree\Site('qw'))->map();

            print CJSON::encode($JS);
            Yii::app()->end();
        }
        $this->render('createNews', compact('formName', 'model', 'id'));
    }

    public function actionEditNode($id)
    {
        $formName = 'EditNode';
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.id = ' . $id);
        $criteria->order = '"customField"."field_name" ASC';
        $oNode = CmsTree::model()->with(['content.hasGallery.gallery.category', 'appNomenclature.ecmNomenclature.fields.customField', 'properties'])->find($criteria);
        //M::printr($oNode, '$oNode');
        $descendants = [];
        if ($oNode->ns_root_ref == 200) {
            $descendants = CMSTreeManagement::getTree($id);
        }
        //M::printr($descendants, '$descendants');
        $model = new NodeForm();
        $model->id = $id;
        $model->fields = [];
        if (!empty($oNode->appNomenclature)) {
            $model->ecm_nomenclature_ref = $oNode->appNomenclature->ecmNomenclature->id;
            $model->fields = !empty($oNode->appNomenclature->ecmNomenclature->fields) ? $oNode->appNomenclature->ecmNomenclature->fields : [];
        }
        //M::printr($model, 'BEFORE BEFORE $model');
        $model->fromArray($oNode->attributes);
        $model->dt_created = $oNode->dt_created;
        $model->dt_updated = $oNode->dt_updated;
        $model->page_longtitle = !empty($oNode->content) ? $oNode->content->page_longtitle : '';
        $model->page_body = !empty($oNode->content) ? $oNode->content->page_body : '';
        $model->page_teaser = !empty($oNode->content) ? $oNode->content->page_teaser : '';
        $model->page_description = !empty($oNode->content) ? $oNode->content->page_description : '';
        $model->key = "";
        if (!empty($oNode->properties)) {
            foreach ($oNode->properties as $property) {
                if ($property->cms_node_properties_fields_ref == 4) {
                    $model->key = $property->property_value;
                    break;
                }
            }
        }

        //получить картинки каталога
        if (1) {
            $oContent = $oNode->content;
            $x = '1';
            foreach ($oContent->hasGallery as $oImage) {
                if ($oImage
                        ->gallery
                        ->category
                        ->dev_key == 'ecm:illustrations') {
                    $model->images_illustrations['x' . $x] = $oImage->gallery->storage->id;
                }
                $x++;
            }
        }

        //M::printr($model, '$model');
        if (!empty($_POST)) {
            $transaction = Yii::app()->db->beginTransaction();
            $JS = [];
            $JS['errors'] = false;
            try {
                if (isset($_POST[$formName]['do_delete'])) {
                    if ($oNode->is_node_protected == false) {
                        $oNode->is_trash = true;
                        if (!$oNode->saveNode()) {
                            $JS['messages'][] = $oNode->getErrors();
                            throw new Exception('Can`t save Node');
                        }
                        $oNode->deleteNode();
                        $transaction->commit();
                        print CJSON::encode($JS);
                        Yii::app()->end();
                    }
                }

                //M::printr($model, 'BEFORE $model');
                $model->fromArray($_POST[$formName]);
                $model->is_menu_visible = isset($_POST[$formName]['is_menu_visible']) ? true : false;
                $model->is_seo_noindexing = isset($_POST[$formName]['is_seo_noindexing']) ? true : false;
                $model->is_node_published = isset($_POST[$formName]['is_node_published']) ? true : false;
                $model->is_in_markets = isset($_POST[$formName]['is_in_markets']) ? true : false;
                $model->is_in_google = isset($_POST[$formName]['is_in_google']) ? true : false;
                //M::printr($model, 'AFTER $model');
                $model->id = $id;
                //сохранить ноду
                if (!$model->save()) {
                    $JS['error'] = $model->getErrors();
                }
                $transaction->commit();
                //$transaction->rollback();
            } catch (Exception $e) {
                $JS['errors'] = true;
                $JS['messages'] = 'Messages1:' . $e->getMessage();
                $JS['error'] = $model->getErrors();
                //M::printr($e->getMessage(), '$e');
                $transaction->rollback();
            }

            if (Yii::app()->request->isAjaxRequest) {
                print CJSON::encode($JS);
            }
            Yii::app()->end();
        } else {
            $this->render('editNode', compact('formName', 'model', 'id', 'descendants'));
        }
    }

    public function actionEditNews($id)
    {
        $formName = 'EditNode';
        $oNode = CmsTree::model()->with(
            [
                'content.hasGallery.gallery.category',
                'content.hasGallery.gallery.storage.croppeds.cropped',
            ]
        )->findByPk($id);
        //M::printr($oNode, '$oNode');

        $model = new NewsForm();
        $model->id = $id;
        $model->fromArray($oNode->attributes);
        $model->page_longtitle = !empty($oNode->content) ? $oNode->content->page_longtitle : '';
        $model->page_body = !empty($oNode->content) ? $oNode->content->page_body : '';
        $model->page_teaser = !empty($oNode->content) ? $oNode->content->page_teaser : '';
        //M::printr($model->page_body, '$model->page_body');

        $oGalleryCategory = AppGalleryCategories::model()->getGalleryCategory('ecm:teaser_news');
        //картинка новости
        if (!empty($oNode->content->hasGallery)) {
            $oOrigin = $oNode->content->hasGallery->gallery->storage;
            $model->image_teaser_news = $oOrigin->id;
        }

        //M::printr($model, '$model');
        if (!empty($_POST)) {
            //M::printr($_POST, '$_POST');
            $transaction = Yii::app()->db->beginTransaction();
            $JS = [];
            $JS['errors'] = false;
            try {
                if (isset($_POST[$formName]['do_delete'])) {
                    if ($oNode->is_node_protected == false) {
                        $oNode->is_trash = true;
                        if (!$oNode->saveNode()) {
                            $JS['messages'][] = $oNode->getErrors();
                            throw new Exception('Can`t save Node');
                        }
                        $transaction->commit();
                        print CJSON::encode($JS);
                        Yii::app()->end();
                    }
                }
                //M::printr($model, 'BEFORE $model');
                $model->fromArray($_POST[$formName]);
                $model->is_menu_visible = isset($_POST[$formName]['is_menu_visible']) ? true : false;
                $model->is_seo_noindexing = isset($_POST[$formName]['is_seo_noindexing']) ? true : false;
                $model->is_node_published = isset($_POST[$formName]['is_node_published']) ? true : false;
                //M::printr($model, 'AFTER $model');
                $model->id = $id;
                //сохранить ноду
                if (!$model->save()) {
                    $JS['error'] = $model->getErrors();
                }
                $JS['response']['tree'] = $model->tree;
                $JS['response']['node_content'] = $model->node_content;
                $transaction->commit();
                //$transaction->rollback();

                //создать карту сайта
                (new CmsTree\Site('qw'))->map();
            } catch (Exception $e) {
                $JS['errors'] = true;
                $JS['error'][] = $e->getMessage();
                //M::printr($e->getMessage(), '$e');

                $transaction->rollback();
            }

            if (Yii::app()->request->isAjaxRequest) {
                print CJSON::encode($JS);
            }
            Yii::app()->end();
        }

        $this->render('editNews', compact('formName', 'model', 'id'));
    }

    public function actionMoveNode()
    {
        $data = array();
        $oCategory = new CmsTree();

        $move = CJSON::decode($_POST['move']);
        $to = CJSON::decode($_POST['to']);
        $hit = $_POST['hit'];
        //M::printr($move, '$move');
        //M::printr($to, '$to');
        //M::printr($hit, '$hit');

        $id = 3;
        $criteria = new CDbCriteria();
        //$criteria->addCondition('id = ' . $id);
        $criteria->order = 'ns_left_key ASC';
        $src = CmsTree::model()->findByPk($move['data']['id'], $criteria);
        $dst = CmsTree::model()->findByPk($to['data']['id'], $criteria);

        if ($hit == 'over') {
            $src->moveAsFirst($dst);
        }

        if ($hit == 'before') {
            $src->moveBefore($dst);
        }

        if ($hit == 'after') {
            $src->moveAfter($dst);
        }
        $src->dt_updated = new CDbExpression('NOW()');
        $src->saveNode();

        (new Map())->checkNode($src, true);
        //M::printr($src, '$src');
        //M::printr($dst, '$dst');
        //$this->render('create', array('model' => $oCategory));
    }

    public function actionGwDataTree($id = 200)
    {
        $root = CmsTree::model()->findByPk($id);

        $oTree = CMSTreeManagement::getTree($id);
        //M::printr($oTree, '$oTree');
        $tree = array();
        foreach ($oTree as $oNode) {
            $node = $oNode->attributes;
            $node['key'] = $oNode->id;
            $node['title'] = $oNode->node_name;
            if ($node['is_trash']) {
                $node['title'] .= ' <span class="fa fa-trash-o"></span>';
            }
            if ($node['is_seo_noindexing']) {
                $node['title'] .= ' <span class="fa fa-pencil-square"></span>';
            }
            if (!$node['is_node_published']) {
                $node['title'] .= ' <span class="fa fa-eye-slash"></span>';
            }
            if ($node['is_in_markets']) {
                $node['title'] .= ' <span title="YandexMarket" class="icon-basket"></span>';
            }

            $node['expanded'] = false;
            $tree[] = $node;
        }

        $result = array_values(CMSTreeManagement::createTree($tree));
        //M::printr($result, '$result');
        print CJSON::encode($result);
    }

    public function actionDeleteNode($id)
    {
        $oNode = CmsTree::model()->findByPk($id);
        if (!empty($oNode) && $oNode->is_node_protected == false) {
            $oNode->deleteNode();
        }
        $this->redirect($this->createUrl('/cms/tree'));
    }

    public function actionGetRegionProps()
    {
        if (!empty($_POST)) {
            //M::printr($_POST, '$_POST');
            //получить все props из таблицы
            $oProps = AppRegionNodeOverrides::model()->with('property')->findAllByAttributes(
                array(
                    'cms_tree_ref' => $_POST['node_id'],
                    'app_regions_ref' => $_POST['region_id'],
                ),
                array(
                    'order' => '"property"."id" ASC',
                )
            );
            //M::printr($oProps, '$oProps');
            $props = array();
            foreach ($oProps as $oProp) {
                //M::printr($oProp, '$oProp');
                $prop = $oProp->attributes;
                $prop['prop'] = $oProp->property->attributes;
                $props[] = $prop;
            }
            //M::printr($props, '$props');
            $JS = ['success' => true, 'regionProps' => $props];
            if (Yii::app()->request->isAjaxRequest) {
                print CJSON::encode($JS);
            }
            Yii::app()->end();
        }
    }

    public function actionSaveRegionProps()
    {
        if (!empty($_POST)) {
            //M::printr($_POST, '$_POST');
            $JS = ['success' => true];

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $cms_tree_ref = $_POST['node_id'];
                $app_regions_ref = $_POST['region_id'];
                foreach ($_POST['fields'] as $prop) {
                    $app_region_properties_ref = $prop['id'];
                    //если пусто, то удалить поле из базы
                    if (empty($prop['value'])) {
                        AppRegionNodeOverrides::model()->deleteAllByAttributes(
                            [
                                'cms_tree_ref' => $cms_tree_ref,
                                'app_regions_ref' => $app_regions_ref,
                                'app_region_properties_ref' => $app_region_properties_ref,
                            ]
                        );
                    } else {
                        //найти поле в БД
                        $oProp = AppRegionNodeOverrides::model()->findByAttributes(
                            [
                                'cms_tree_ref' => $cms_tree_ref,
                                'app_regions_ref' => $app_regions_ref,
                                'app_region_properties_ref' => $app_region_properties_ref,
                            ]
                        );
                        //если такого нет, то создать
                        if (empty($oProp)) {
                            $oProp = new AppRegionNodeOverrides();
                            $oProp->cms_tree_ref = $cms_tree_ref;
                            $oProp->app_regions_ref = $app_regions_ref;
                            $oProp->app_region_properties_ref = $app_region_properties_ref;
                        }
                        //Записать в БД
                        $oProp->property_value = $prop['value'];
                        if (!$oProp->save()) {
                            throw new Exception('Can`t save data in AppRegionNodeOverrides');
                        }
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                $JS['success'] = false;
                $JS['message'] = $e->getMessage();
                $transaction->rollback();
            }

            if (Yii::app()->request->isAjaxRequest) {
                print CJSON::encode($JS);
            }
            Yii::app()->end();
        }
    }

    public function actionLazyDataTree($id = 200)
    {
        $page = !empty($_GET['page']) ? $_GET['page'] : '';
        //получить запрашиваемую папку
        $oRoot = CmsTree::find()
            ->with('content')
            ->where('id = :id', [':id' => $id])
            ->one();

        $oTree = $oRoot->children(1)->with('content')->all();

        $tree = array();
        foreach ($oTree as $oNode) {
            //M::printr($oNode, '$oNode');
            $content = $oNode->content;
            if (empty($content)) {
                $content = new CmsNodeContent();
                //M::printr($content->attributes, '$content->attributes');
                //exit;
            }
            $node = array_merge(
                [],
                $content->attributes,
                $oNode->attributes
            );
            $oChs = $oNode->children(1)->all();
            $isChs = !empty($oChs);
            $node['key'] = $oNode->id;
            $node['title'] = $content->page_title;
            if ($node['is_trash']) {
                $node['title'] .= ' <span title="Удалено" class="fa fa-trash-o"></span> <span title="Удалено" class="icon-trash"></span>';
            }
            if ($node['is_seo_noindexing'] && $page == 'seo') {
                $node['title'] .= ' <span title="Не индексируется" class="icon-blocked"></span>';
            }
            if ($node['is_in_markets']) {
                $node['title'] .= ' <span title="YandexMarket" class="icon-basket"></span>';
            }
            if (0) { //(count($oNode->products) > 0) {
                $node['title'] .= ' <span title="Есть товары" class="icon-price-tag3"></span>';
            }
            if ($node['is_in_google']) {
                $node['title'] .= ' <span title="Google & eLama" class="icon-google"></span>';
            }

            $node['expanded'] = false;
            $node['lazy'] = $isChs;
            $tree[] = $node;
        }

        $nodes = Json::encode($tree);
        return $nodes;
    }

    public function actionFreeNoms()
    {
        return $this->render('freeNoms');
    }
}


