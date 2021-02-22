<?php

namespace frontend\components;

use common\models\models\AppRedirects;
use common\models\models\CmsAliases;
use common\models\models\CmsTree;
use common\models\models\EcmProducts;
use yii\base\Configurable;
use \Yii;
use yii\helpers\Json;
use yii\web\UrlRule;
use common\components\M;
use yii\web\Response;

class MyUrlRule extends UrlRule implements Configurable
{

    public $urlSuffix;
    public $caseSensitive;

    public function init() {
        $this->pattern = 'test';
        $this->route = 'test';
        parent::init();
    }

    private function getRedirect($pathInfo) {
        if (0) {
            //M::printr('private function getRedirect($pathInfo)');
            $pathArr = [];
            foreach (explode('/', $pathInfo) as $p) {
                $p = trim($p);
                if (!empty($p)) {
                    $pathArr[] = trim($p);
                }
            }
            $pathInfo = '/' . implode('/', $pathArr) . '/';
            //найти путь в таблице редиректов
            $oRedirect = AppRedirects::find()
                ->onCondition('from_url = :path', [':path' => $pathInfo])
                ->one();
            if (!empty($oRedirect)) {
                header("HTTP/1.1 301 Moved Permanently");
                if (substr($oRedirect->to_url, -1) != '/') {
                    $oRedirect->to_url .= '/';
                }
                Yii::$app->response->redirect($oRedirect->to_url, 301)->send();
                //return false;
            }
        }
    }

    private function getNode($pathInfo) {
        return false;
        //M::printr('private function getNode($pathInfo)');
        //M::printr($pathInfo, '$pathInfo');

        //поискать путь "$request->url/" в таблице cms_aliases
        $oAlias = CmsAliases::find()
            ->with(['tree'])
            ->onCondition('url_path = :path', [':path' => $pathInfo])
            ->orderBy('dt_created DESC')
            ->one();

        if (empty($oAlias)) {
            return false;
        }

        //Если есть, то перейти на отображение данной страницы
        if ($oAlias->is_deprecated) {
            $alive = $oAlias->find()
                ->joinWith(['tree'])
                ->onCondition(['tree.id' => $oAlias->cms_tree_ref, 'is_deprecated' => false])
                ->one();
            if (!empty($alive)) {
                header("HTTP/1.1 301 Moved Permanently");
                if (substr($alive->url_path, -1) != '/') {
                    $alive->url_path .= '/';
                }
                \Yii::$app->response->redirect($alive->url_path, 301)->send();
            }
            return false;
        }
        return $oAlias->tree;
    }


    private function getNodeWithPath($path, $without_region = false) {

        $criteria = new CDbCriteria();
        //$criteria->addCondition('"tree".is_trash = FALSE');
        $criteria->addColumnCondition(['"t".url_path' => $path]);

        if (!$without_region) {
            $criteria->addColumnCondition(['"region".region_key' => Yii::app()->region->subdomain]);
        }

        $criteria->order = '"t"."dt_created" DESC';

        $page = CmsAliases::model()
            ->with(
                [
                    'tree',
                    'tree.bindings',
                    'tree.product.hasRegion.region',
                ]
            )
            ->find($criteria);


        if (isset($page->tree->id)) {
            if ($page->is_deprecated) {
                $alive = $page->alive()->findByAttributes(['cms_tree_ref' => $page->tree->id]);
                if (!empty($alive)) {
                    header("HTTP/1.1 301 Moved Permanently");
                    if (substr($alive->url_path, -1) != '/') {
                        $alive->url_path .= '/';
                    }
                    Yii::app()->request->redirect($alive->url_path, true, 301);
                }
            }
            return $page;
        }
        return false;
    }

    //*/
    public function parseRequest($manager, $request) //($manager, $request)
    {
        //M::printr($manager, '$manager');
        //M::printr($request, '$request');
        //M::printr($this->pattern, '$this->pattern');
        //M::printr($this->route, '$this->route');
        $pathInfo = $request->getPathInfo();
        M::printr($pathInfo, '$pathInfo');
        return false;
        exit;

        $this->getRedirect($pathInfo);
        //M::printr($pathInfo, '$pathInfo');

        if (substr($pathInfo, -1) == '/') {
            //убрать "/" в конце "$request->url"
            //M::printr(strlen($pathInfo), 'strlen($pathInfo)');
            $pathInfo[strlen($pathInfo) - 1] = ' ';
        }
        $pathInfo = trim("/{$pathInfo}");
        //M::printr($pathInfo, '$pathInfo2');

        //искать путь в таблице cms_aliases
        $oNode = null;
        $oAlias = CmsAliases::find()
            ->with(['tree'])
            ->onCondition('url_path = :path', [':path' => $pathInfo])
            ->orderBy('dt_created DESC')
            ->one();
        //если нет, то вернуть false
        if (empty($oAlias)) {
            return false;
        }

        //Если есть, то перейти на отображение данной страницы
        if ($oAlias->is_deprecated) {
            //если адрес устарел, то найти живой
            $alive = CmsAliases::find()
                //->joinWith(['tree'])
                ->where(['cms_tree_ref' => $oAlias->cms_tree_ref, 'is_deprecated' => false])
                ->one();
            if (empty($alive)) {
                return false;
            }
            //header("HTTP/1.1 301 Moved Permanently");
            if (substr($alive->url_path, -1) != '/') {
                $alive->url_path .= '/';
            }
            \Yii::$app->response->redirect($alive->url_path, 301)->send();
        }
        $oNode = $oAlias->tree;

        //M::printr($manager, '$manager');
        if (!empty($oNode)) {
            //проверить, что делать с этим узлом по таблице cms_binding
            $_GET['node_id'] = $oNode->id;
            //M::printr($oNode, '$oNode');

            // match binding nodes
            $root = CmsTree::find()
                ->with('bindings')
                ->onCondition(['id' => $oNode->ns_root_ref])
                ->one();
            $bindings = $root->bindings;
            //M::printr($bindings, '$bindings');
            if (!empty($bindings)) {
                $handlers = array_filter(
                    $bindings,
                    function ($item) {
                        return (isset($item['mode']) && in_array($item['mode'], ['HANDLER', 'MODULE']));
                    }
                );
                foreach ($handlers as $run) {
                    //M::printr($run, '$run');
                    $props = Json::decode($run->data);
                    if (isset($props['route'])) {
                        $_GET += $props;
                        $route = [$props['route'] . '/view', $_GET];
                        return $route;
                    } elseif (isset($props['run'])) {
                        $_GET += $props;
                        $route = ['page/' . $props['run'] . '/bind', $_GET];
                        return $route;
                    }
                }
            }
            return ['page/watch/view', $_GET];
        }

        //M::printr($oNode, '$oNode');

        //добавить в начале "/"
        return false; //['catalog/default/view', ['id' => $id] + $_GET;
        //M::printr($request->url, '$request->url');
        //return parent::parseRequest($manager, $request);
    }
    //*/

    public function createUrl($manager, $route, $params) //($manager, $route, $params, $ampersand = '&')
    {
        //M::printr([$manager, $route, $params], '[$manager, $route, $params]');
        //$url = Yii::app()->createUrl('/page/catalog', ['id' => 123 || 'alias' => 'url_alias']);
        if ($route == 'route/product') {
            //M::printr('PRODUCT');
            //M::printr([$route, $params], '[$route, $params]');
            //M::xlog(['$route' => $route, '$params' => $params]);
            if (isset($params['id'])) {
                $id = $params['id'];
                $oProduct = EcmProducts::find()
                    ->alias('product')
                    ->joinWith(['appProduct.tree'])
                    ->where(['product.id' => $id])
                    ->one();
            } elseif (isset($params['alias'])) {
                $alias = $params['alias'];
                $oProduct = EcmProducts::find()
                    ->alias('product')
                    ->joinWith(['appProduct.tree'])
                    ->where(['product.url_alias' => $alias])
                    ->one();
            }
            if (empty($oProduct->appProduct)) return false;
            if (empty($oProduct->appProduct->tree)) return false;
            $oCategory = $oProduct->appProduct->tree;
            $_GET['product_id'] = $oProduct->id;
            if (!empty($oCategory)) {
                //M::printr($oCategory->getPath(), '$oCategory->getPath()');
                $path = $oCategory->getPath() . '?product_id=' . $oProduct->id;
                return $path;
            }
        }

        if ($route == 'route/catalog') {
            //M::printr('CATALOG');
            //M::printr([$route, $params], '[$route, $params]');
            //return false;
            if (1) {
                $oCategory = null;
                //найти категорию с данным id или alias
                if (isset($params['id'])) {
                    $id = $params['id'];
                    //print $category_id;
                    //$oCategory = CmsTree::model()->getCategoryByPk($id);
                    $oCategory = CmsTree::find()
                        ->onCondition(['id' => $id])
                        ->one();
                } elseif (isset($params['alias'])) {
                    $alias = $params['alias'];
                    //print $category_alias;
                    //$oCategory = CmsTree::model()->getCategoryByAlias($alias);
                    $oCategory = CmsTree::find()
                        ->onCondition(['url_alias' => $alias])
                        ->one();
                }
                //получить путь до корня
                //M::printr($oCategory, '$oCategory ???');
                if (!empty($oCategory)) {
                    //M::printr($oCategory->getPath(), '$oCategory->getPath()');
                    $path = $oCategory->getPath();
                    return $path;
                }
                //M::printr($ampersand, '$ampersand');
            }

        }

        if (0) {
            if ($route == 'page/lookup') { // загружаем url_path из cms_aliases.cms_tree_ref

                $suffix = $this->urlSuffix === null ? $manager->urlSuffix : $this->urlSuffix;

                if (!empty($params['node_id'])) {
                    $alias = CmsAliases::model()
                        ->cache(7200, \CmsTree\Cache\Dependency::instance())
                        ->with(['tree'])
                        ->alive()
                        ->findByAttributes(['cms_tree_ref' => $params['node_id']]);
                    if (!empty($alias->url_path)) {
                        $x = substr($alias->url_path, 1) . $suffix;
                        return $x;
                    }
                }
            }

            //$url = Yii::app()->createUrl('/page/catalog', ['id' => 123 || 'alias' => 'url_alias']);
            if ($route == 'page/catalog') {
                $oCategory = null;
                //найти категорию с данным id или alias
                if (isset($params['id'])) {
                    $id = $params['id'];
                    //print $category_id;
                    $oCategory = CmsTree::model()->getCategoryByPk($id);
                } elseif (isset($params['alias'])) {
                    $alias = $params['alias'];
                    //print $category_alias;
                    $oCategory = CmsTree::model()->getCategoryByAlias($alias);
                }
                //получить путь до корня
                //M::printr($oCategory, '$oCategory ???');
                if (!empty($oCategory)) {
                    //M::printr($oCategory->getPath(), '$oCategory->getPath()');
                    return $oCategory->getPath();
                }
                //M::printr($ampersand, '$ampersand');
            }

            //$url = Yii::app()->createUrl('/page/catalog', ['id' => 123 || 'alias' => 'url_alias']);
            if ($route == 'page/news') {
                $oCategory = null;
                //найти категорию с данным id или alias
                if (isset($params['id'])) {
                    $id = $params['id'];
                    //print $category_id;
                    $oCategory = CmsTree::model()->getCategoryByPk($id);
                } elseif (isset($params['alias'])) {
                    $alias = $params['alias'];
                    //print $category_alias;
                    $oCategory = CmsTree::model()->getCategoryByAlias($alias);
                }
                //получить путь до корня
                //M::printr($oCategory, '$oCategory ???');
                if (!empty($oCategory)) {
                    //M::printr($oCategory->getPath(), '$oCategory->getPath()');
                    return $oCategory->getPath();
                }
                //M::printr($ampersand, '$ampersand');
            }

            if ($route == 'page/product') {
                //M::printr($route, '$route');
                //найти товар с данным id или alias
                if (isset($params['id'])) {
                    $id = $params['id'];
                    $oProduct = EcmProducts::model()->getProductByPk($id);
                } elseif (isset($params['alias'])) {
                    $alias = $params['alias'];
                    $oProduct = EcmProducts::model()->getProductByAlias($alias);
                }
                //получить путь до корня
                if (!empty($oProduct)) {
                    return $oProduct->getPath();
                }

            }

            if ($route == 'page/fullPath') { // загружаем url_path из cms_aliases.cms_tree_ref

                //M::printr($manager, '$manager');
                //M::printr($params, '$params');

                $oQuestNode = CmsTree::model()->with(['product.hasRegion.region'])->findByPk($params['node_id']);
                //M::printr($oQuestNode, '$oQuestNode');
                $oQuestRegion = $oQuestNode->product->hasRegion->region;

                $prefix = '';
                if (Yii::app()->region->use != $oQuestRegion->region_key || Yii::app()->region->use != Yii::app()->region->default) {
                    $prefix .= "{$oQuestRegion->region_key}.";
                }
                $prefix .= Yii::app()->region->domain . "/";
                //M::printr(Yii::app()->region->name, 'Yii::app()->region->name');
                //M::printr(Yii::app()->region->use, 'Yii::app()->region->use');

                $path = $prefix;
                $suffix = $this->urlSuffix === null ? $manager->urlSuffix : $this->urlSuffix;
                if (!empty($params['node_id'])) {
                    $alias = CmsAliases::model()
                        ->with(['tree'])
                        ->alive()
                        ->findByAttributes(['cms_tree_ref' => $params['node_id']]);
                    if (!empty($alias->url_path)) {
                        $path .= substr($alias->url_path, 1) . $suffix;
                    }
                }

                //M::printr($path, '$path');

                //получить данные о квесте


                return $path;
                /*
                $suffix=$this->urlSuffix===null ? $manager->urlSuffix : $this->urlSuffix;

                if (!empty($params['node_id'])) {
                    $alias = CmsAliases::model()
                        ->with(['tree'])
                        ->alive()
                        ->findByAttributes(['cms_tree_ref' => $params['node_id']])
                    ;
                    if (!empty($alias->url_path)) {
                        return substr($alias->url_path, 1) . $suffix;
                    }
                }
                */
            }
        }
        return false;
    }

}

