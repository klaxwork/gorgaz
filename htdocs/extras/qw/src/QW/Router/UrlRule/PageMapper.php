<?php

namespace QW\Router\UrlRule;


class PageMapper extends \CBaseUrlRule
{


    public $urlSuffix;

    public $caseSensitive;



    private function getNodeWithPath($path, $without_region = false)
    {

        $criteria = new \CDbCriteria();
        //$criteria->addCondition('"tree".is_trash = FALSE');
        $criteria->addColumnCondition(['"t".url_path' => $path]);

        if (!$without_region) {
            $criteria->addColumnCondition(['"region".region_key' => \Yii::app()->region->subdomain]);
        }

        $criteria->order = '"t"."dt_created" DESC';

        $page = \CmsAliases::model()
            ->with(
                [
                    'tree',
                    'tree.bindings',
                    'tree.product.hasRegion.region',
                ]
            )
            ->find($criteria)
        ;


        if (isset($page->tree->id)) {
            if ($page->is_deprecated) {
                $alive = $page->alive()->findByAttributes(['cms_tree_ref' => $page->tree->id]);
                if (!empty($alive)) {
                    header("HTTP/1.1 301 Moved Permanently");
                    if (substr($alive->url_path, -1) != '/') {
                        $alive->url_path .= '/';
                    }
                    \Yii::app()->request->redirect($alive->url_path, true, 301);
                }
            }
            return $page;
        }


    }


    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {


        if ($manager->caseSensitive && $this->caseSensitive === null || $this->caseSensitive) {
            $case = '';
        } else {
            $case = 'i';
        }

        if ($this->urlSuffix !== null) {
            $pathInfo = $manager->removeUrlSuffix($rawPathInfo, $this->urlSuffix);
        }

        // URL suffix required, but not found in the requested URL
        if ($manager->useStrictParsing && $pathInfo === $rawPathInfo) {
            $urlSuffix = $this->urlSuffix === null ? $manager->urlSuffix : $this->urlSuffix;
            if ($urlSuffix != '' && $urlSuffix !== '/') {
                return false;
            }
        }


        if (preg_match('/^([\w\-\/]+)/s' . $case, $pathInfo, $matches)) {

            // lookup by region nodes
            $page = $this->getNodeWithPath('/' . $matches[1]);

            if (!$page) {
                // lookup without region
                $page = $this->getNodeWithPath('/' . $matches[1], true);
            }

            if (!empty($page)) {

                $_GET['node_id'] = $page->tree->id;

                $root = \CmsTree::model()->findByPk($page->tree->ns_root_ref);
                $bindings = $root->bindings;
                if (!empty($bindings)) {
                    $handlers = array_filter(
                        $bindings, function ($item) {
                        return (isset($item['mode']) && in_array($item['mode'], ['HANDLER', 'MODULE']));
                    }
                    );
                    foreach ($handlers as $run) {
                        $props = \CJSON::decode($run->data);
                        if (isset($props['route'])) {
                            $_GET += $props;
                            return $props['route'] . '/view';
                        } elseif (isset($props['run'])) {
                            $_GET += $props;
                            return 'page/' . $props['run'] . '/bind';
                        }
                    }
                }

                return 'page/watch/view';

            }

        }
        return false;
    }

    public function createUrl($manager, $route, $params, $ampersand)
    {

        $suffix = $this->urlSuffix ?: $manager->urlSuffix;

        if ($route == 'page/lookup') { // загружаем url_path из cms_aliases.cms_tree_ref


            if (!empty($params['node_id'])) {

                $node_id = (int) $params['node_id'];

                $idx = new \QW\Route\Search;
                $node = $idx->node($node_id);

                /*
                if (empty($node->url_path)) {
                    $node = \CmsAliases::model()
                        ->cache(7200, \CmsTree\Cache\Dependency::instance())
                        ->with(['tree'])
                        ->alive()
                        ->findByAttributes(['cms_tree_ref' => $node_id])
                    ;
                }*/


                if (!empty($node->url_path)) {
                    $target = substr($node->url_path, 1) . $suffix;
                    return $target;
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
                $oCategory = \CmsTree::model()->getCategoryByPk($id);
            } elseif (isset($params['alias'])) {
                $alias = $params['alias'];
                //print $category_alias;
                $oCategory = \CmsTree::model()->getCategoryByAlias($alias);
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
                $oProduct = \EcmProducts::model()->getProductByPk($id);
            } elseif (isset($params['alias'])) {
                $alias = $params['alias'];
                $oProduct = \EcmProducts::model()->getProductByAlias($alias);
            }
            //получить путь до корня
            if (!empty($oProduct)) {
                return $oProduct->getPath();
            }

        }


        if ($route == 'page/fullPath') { // загружаем url_path из cms_aliases.cms_tree_ref

            if (empty($params['node_id'])) {
                return '';
            }

            $path = null;

            // baseUrl with scheme
            $baseUrl = \Yii::app()->getBaseUrl(true);

            // default http scheme
            $scheme = (strstr($baseUrl, 'https:')) ? 'https' : 'http';


            $idx = new \QW\Route\Search;
            $node = $idx->node($params['node_id']);
            if (!empty($node->url_path)) {

                $subdomain = null;

                if (!empty($node->region_key) && $node->region_key != \Yii::app()->region->default) {
                    $scheme = 'http'; // для всех доменов кроме москвы (в будущем сделать region->is_https)
                    $subdomain = $node->region_key . ".";
                }
                elseif ($scheme == 'http' && $node->region_key == \Yii::app()->region->default) {
                    $scheme = 'https'; // для всех доменов кроме москвы (в будущем сделать region->is_https)
                }

                $path = $scheme . "://" . $subdomain . \Yii::app()->region->domain . $node->url_path . $suffix;

            }

            // если узел не найден генерируем ссылку на корень домена
            else {

                $subdomain = null;

                if (\Yii::app()->region->subdomain != \Yii::app()->region->default) {
                    $scheme = 'http'; // для всех доменов кроме москвы (в будущем сделать region->is_https)
                    $subdomain = \Yii::app()->region->subdomain . ".";
                }
                elseif ($scheme == 'http' && $node->region_key == \Yii::app()->region->default) {
                    $scheme = 'https'; // для всех доменов кроме москвы (в будущем сделать region->is_https)
                }

                $path = $scheme . "://" . $subdomain . \Yii::app()->region->domain . $suffix;

            }

            return $path;

        }
        return '';
    }


}