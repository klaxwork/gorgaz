<?php

namespace common\models;

use common\models\models\CmsTree;

class CMSTreeManagement
{
    public $id;
    public $node_name;
    public $url_alias;
    public $menu_title;
    public $menu_index;
    public $seo_title;
    public $seo_keywords;
    public $seo_description;
    public $is_menu_visible;
    public $is_seo_noindexing;
    public $is_node_published;

    public $root_id;

    public function __constructor()
    {
        return $this;
    }

    public static function getNewNode($id)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'ns_left_key ASC';
        $menu = CmsTree::model()->findByPk($id, $criteria);
        M::printr($menu, '$menu');
        return $menu;
    }


    public function getNodex($id)
    {
        $oNode = CmsTree::model()->findByPk($id);
        $criteria = new CDbCriteria();
        $criteria->order = 'ns_left_key ASC';
        $menu = CmsTree::model()->findByPk($id, $criteria);
        //M::printr($menu, '$menu');
        $descendants = $menu->descendants()->findAll($criteria);
        //M::printr($descendants, '$descendants');

    }

    public function saveNode()
    {

    }

    public function actionCreateNode($isRoot = false)
    {
        $model = new NodeForm();

        if (!empty($_POST)) {
            $root = new CmsTree();
            $root->node_name = 'First tree';
            $root->saveNode();
            M::printr($root, '$root');
        }

        $this->render('createNode');
    }

    public function actionEditNode($id = 0, $isRoot = false)
    {
        $model = new NodeForm();

        if (!empty($_POST)) {
            $root = new CmsTree();
            $root->node_name = 'First tree';
            $root->saveNode();
            M::printr($root, '$root');
        }

        $this->render('createNode');
    }

    public function actionMoveNode()
    {
    }

    public function actionGwDataTree()
    {
    }

    public static function getTree($id)
    {
        $root = CmsTree::findOne(['id' => $id]);

        //$criteria->order = 't.ns_left_key ASC';
        //$criteria->addCondition('t.is_trash IS NOT TRUE');
        $descendants = $root->children()->orderBy(['ns_left_key' => 'ASC'])->all();
        //M::printr($descendants, '$descendants');
        return $descendants;
    }

    //преобразовать массив в дерево
    public static function createTree($items)
    {
        //берем item и ищем его потомков
        foreach ($items as $key_item => $item) {
            if (!isset($items[$key_item]['ns_left_key'])) {
                continue;
            }
            $items[$key_item]['children'] = array();
            $is_visible = false;
            foreach ($items as $key_item_ch => $item_ch) {
                if (!isset($item_ch['ns_left_key'])) {
                    continue;
                }
                //проверка на принадлежность родителю
                if ($item_ch['ns_left_key'] > $item['ns_left_key'] && $item_ch['ns_left_key'] < $item['ns_right_key']) {
                    /*if ($item_ch['action_type'] == 'ROUTE' && API::checkAccess($item_ch['action'])) {
                        $is_visible = true;
                    }*/
                    $item_ch['title'] = $item_ch['node_name'];
                    if ($item_ch['is_trash']) {
                        $item_ch['title'] .= ' <span class="fa fa-trash-o"></span>';
                    }
                    if (0) { //($item_ch['is_seo_noindexing']) {
                        $item_ch['title'] .= ' <span class="fa fa-pencil-square"></span>';
                    }
                    if (!$item_ch['is_node_published']) {
                        $item_ch['title'] .= ' <span class="fa fa-eye-slash"></span>';
                    }
                    $item_ch['key'] = $item_ch['id'];
                    $items[$key_item]['children'][] = $item_ch;
                    unset($items[$key_item_ch]);
                }
            }
            if (!empty($items[$key_item]['children'])) {
                //$items[$key_item]['folder'] = true;
                $items[$key_item]['children'] = array_values(self::createTree($items[$key_item]['children']));
            }
            if ($is_visible == false) {
                //$items[$key_item]['is_visible'] = false;
            }
        }

        return $items;
    }


}
