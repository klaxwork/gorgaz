<?php

namespace common\models;

use common\components\M;
use common\models\models\CmsAliases;
use common\models\models\CmsTree;
use yii\base\Exception;
use yii\db\Expression;

class Map
{
    public $categories;
    public $news;
    public $products;
    public $cmsAliases = [];
    public $ecmAliases = [];

    public $items = [];

    public $i = 0;

    public $oNode = null;
    public $path = '';
    public $oAlias = null;
    public $oAliases = [];
    public $oAncestors = [];
    private $defaultConfig = [
        'is_gen_children' => true,
        'is_full_path' => true,
    ];
    private $config = [
        'is_gen_children' => true,
        'is_full_path' => true,
    ];

    //'url_md5hash' => md5($path . '/' . ($node->content->url_alias ?: '~')),

    public function __construct($oNode = false, $config = []) {
        //$this->oNode = $oNode;
        //if (is_array($config)) $config = [];
        //$this->setConfig($config);
        //$this->oNode = $oNode;
        //return true;
    }

    public function setConfig(array $config) {
        $this->config = array_merge([], $this->defaultConfig, $config);
    }

    public function setNode($oNode) {
        $this->oNode = $oNode;
    }

    public function setIsGenChildren($is_gen_children) {
        $this->config['is_gen_children'] = $is_gen_children;
    }

    public function setIsFullPath($is_full_path) {
        $this->config['is_full_path'] = $$is_full_path;
    }

    public function run() {
        $tree = $this->getCategories();
        foreach ($tree as $oNode) {

        }
    }

    public function make() {
        $this->getCmsAliases();
        //$this->getEcmAliases();
        return $this->items;
    }

    public function getCmsAliases() {
        $oAliases = CmsAliases::find()->where(['is_deprecated' => false])->all();
        //M::printr($oAliases, '$oAliases');
        //exit;
        foreach ($oAliases as $oAlias) {
            $item = [];
            $item['loc'] = $oAlias->url_path . "/";
            $item['lastmod'] = strftime('%Y-%m-%d', strtotime($oAlias->dt_created));
            $item['frequency'] = 'weekly';
            $item['priority'] = '0.5';
            $item['cms_tree_ref'] = $oAlias->cms_tree_ref;
            $this->items[] = $item;
        }

    }

    public function getEcmAliases() {
        $oAliases = EcmAliases::model()->findAllByAttributes(['is_deprecated' => false]);
        //M::printr($oAliases, '$oAliases');
        //exit;
        foreach ($oAliases as $oAlias) {
            $item = [];
            $item['loc'] = $oAlias->url_path . "/";
            $item['lastmod'] = strftime('%Y-%m-%d', strtotime($oAlias->dt_created));
            $item['frequency'] = 'weekly';
            $item['priority'] = '0.5';
            $item['ecm_products_ref'] = $oAlias->ecm_products_ref;
            $this->items[] = $item;
        }

    }

    public function getProducts($item) {
        //M::printr($item, '$item');
        //exit;
        $criteria = new CDbCriteria();
        $criteria->addCondition('"tree"."is_node_published" IS TRUE AND "tree"."ns_root_ref" = 200 AND "tree"."id" = :tree_id');
        $criteria->params['tree_id'] = $item['cms_tree_ref'];
        $criteria->addCondition('t.is_trash IS FALSE AND t.is_closed IS FALSE AND t.is_seo_noindexing IS TRUE');
        $oProducts = EcmProducts::model()
            ->with(
                [
                    'appProduct.tree',
                ]
            )
            ->findAll($criteria);
        return $oProducts;
    }

    public function checkProducts($oProducts, $is_gen_children = false) {
        foreach ($oProducts as $oProduct) {
            $this->checkProduct($oProduct, $is_gen_children);
        }
    }

    public function checkProduct(EcmProducts $oProduct, $is_gen_children = false) {
        //M::printr('checkNode(CmsTree $oNode, $is_gen_children = false)');
        //взять все до корня или корень
        $oTree = $oProduct->appProduct->tree;
        if (!$oTree->is_node_published) {
            $this->deprecateProductAlias($oProduct->id);
            return false;
        }
        //M::printr($oTree, '$oTree');
        $oAncestors = $oTree->ancestors()->findAll();
        //M::printr($oProduct, '$oProduct');
        //M::printr($oAncestors, '$oAncestors');
        $path = [];
        if ($is_gen_children) {
            //получить путь типа /catalog/folder1/folder2/product-name
            foreach ($oAncestors as $oAncestor) {
                if (!empty($oAncestor->content->url_alias)) {
                    if (!$oAncestor->is_node_published) {
                        $this->deprecateProductAlias($oProduct->id);
                        return false;
                    }
                    $path[] = $oAncestor->content->url_alias;
                }
            }
            $path[] = $oTree->content->url_alias;
            //M::printr($path, '$path');
        } else {
            //получить путь типа /product/product-name
            $path[] = 'product';
        }
        $path[] = $oProduct->url_alias;
        //M::printr($path, '$path');
        $newPath = implode('/', $path);
        //M::printr([$oProduct->id, $newPath], '>> [$oProduct->id, $newPath]');

        $this->createProductAlias($oProduct->id, $newPath);
    }

    public function createProductAlias($product_id, $path) {
        //M::printr('createNodeAlias($node_id, $path)');
        $is_create = true;
        //если путь пустой, то не создавать
        if (empty($path)) {
            $is_create = false;
        } else if ($path !== '/') {
            $path = '/' . $path;
        }
        //M::printr($path, '$path');

        //найти этот id в ecm_aliases
        $oAlias = EcmAliases::model()->findByAttributes(['ecm_products_ref' => $product_id, 'is_deprecated' => false]);

        //если алиас не найден в EcmAliases, то пропускаем этот шаг
        if (!empty($oAlias)) {
            //M::printr($oAlias->url_path, '$oAlias->url_path');
            //если путь отличается, то отметить его как устаревший
            if ($oAlias->url_path != $path) {
                $this->deprecateProductAlias($product_id);
            } else {
                $is_create = false;
            }
        }

        if ($is_create && strlen($path) < 254) {
            $oAlias = new EcmAliases();
            $oAlias->ecm_products_ref = $product_id;
            $oAlias->url_md5hash = md5($path);
            $oAlias->url_path = $path;
            if (!$oAlias->save()) {
                M::xlog(['$oAlias' => $oAlias, '$oAlias->getErrors()' => $oAlias->getErrors()], 'MoySklad');
                throw new Exception('Can`t save new alias...');
            }
        }
    }

    public function null() {
        $this->oAncestors = [];
        $this->oAlias = null;
        $this->path = null;
    }

    public function checkNodes($oNodes = [], $config = []) {
        //$this->setConfig($config);
        foreach ($oNodes as $oNode) {
            $this->oNode = $oNode;
            $this->null();
            $this->checkNode();
        }
    }

    public function checkNode($oNode = false, array $config = []) {
        if (!empty($config)) {
            $this->setConfig($config);
        }
        if (!empty($oNode)) {
            $this->setNode($oNode);
        }
        //M::printr($this->oNode->node_name);
        $this->null();

        //собрать нужную инфу
        $this->i++;
        if (!empty($_GET['debug']) && $_GET['debug'] == 'console') {
            //M::printr("{$this->i}\t{$this->oNode->id}\t{$this->oNode->node_name}");
        }

        if (0) {
            //M::printr($this->i, '$this->i');
            $this->i++;
            if ($this->i > 10) exit;
        }

        //M::printr("Найти живой алиас категории {$this->oNode->node_name} ({$this->oNode->id})");
        $this->getLiveAlias();

        //1. проверить узел и его родителей на публикацию.
        $is_publish = $this->checkPublish();

        //M::printr('2. Если опубликовано');
        //2. Если опубликовано, то проверить url на изменение.
        if ($is_publish) {
            //M::printr('PUBLISHED');
            //M::printr('Проверить url на изменение');
            //M::printr('$this->getLiveAlias();');

            $this->getPath();
            //M::printr($this->path);
            //M::printr('');
            //M::printr($this->oAlias, '$this->oAlias');

            if (!empty($this->oAlias)) {
                //M::printr($this->oAlias->attributes, '>> Не пустое');
                if ($this->oAlias->url_path != $this->path) {
                    //M::printr('Изменился URL');
                    //состарить живой
                    $this->deprecateNodeAlias();
                }
            }
            if (empty($this->oAlias)) {
                //M::printr('Создать');
                //создать новый живой
                $this->createNodeAlias();
                $this->getLiveAlias();
                //M::printr($this->oAlias->attributes, '$this->oAlias->attributes');
                //exit;
            }
        }
        //exit;

        //обработать дочерние
        //M::printr($this->config['is_gen_children'], '$this->config[\'is_gen_children\']');
        if ($this->config['is_gen_children']) {
            $oChs = $this->oNode->children(1)->all();
            //M::printr(count($oChs), 'count($oChs)');
            if (!empty($oChs)) {
                $this->checkNodes($oChs, $this->config);
            }
        }
        return true;

        if (0) {
            if ($is_publish) {
                //M::printr('PUBLISHED');
            }
            $this->getLiveAlias();

            //проверить, опубликован ли узел
            if (!$oNode->is_node_published) {
                //M::printr((int)$oNode->is_node_published, '$oNode->is_node_published');
                //M::printr('Отметить, что URL узла устарел.');
                $this->deprecateNodeAlias($oNode->id);
                //return false;
            }

            //взять все до корня или корень
            //M::printr('Проверяем узел и родителей на публикацию.');
            $path = [];
            $is_publish = $this->checkPublish();
            if (!$is_publish) {
                $this->deprecateNodeAlias($oNode->id);
                //M::printr('NOT PUBLISHED');
                //return false;
            }
            //M::printr($is_publish, '$is_publish');

            $path = $is_publish;
            if (!is_array($path)) {
                $path = [];
            }

            //M::printr($is_gen_children, '$is_gen_children');
            if ($is_gen_children) {
                //получить дочерние и пойти по ним
                $oChs = $oNode->children(1)->all();
                //M::printr(count($oChs), 'count($oChs)');
                $this->checkNodes($oChs, $is_gen_children);
            } else {
                //взять только корень
                if (!empty($oAncestors)) {
                    if (!empty($oAncestors[0]->content->url_alias)) {
                        $path[] = $oAncestors[0]->content->url_alias;
                    }
                }
            }
            //M::printr($path, '$path');

            if (0) {
                $oAncestors = $oNode->parents()->joinWith(['content'])->all();
                //M::printr($oAncestors, '$oAncestors');

                $path = [];
                //M::printr((int)$is_gen_children, '$is_gen_children');
                if ($is_gen_children) {
                    //взять все до корня включительно
                    foreach ($oAncestors as $oAncestor) {
                        if (!empty($oAncestor->content->url_alias)) {
                            if (!$oAncestor->is_node_published) {
                                //M::printr($oAncestor->node_name, 'NOT_PUBLISHED');
                                $this->deprecateNodeAlias($oNode->id);
                                break;
                                return false;
                            }
                            $path[] = $oAncestor->content->url_alias;
                            //M::printr($path, '$path');
                        }
                    }
                } else {
                    //взять только корень
                    if (!empty($oAncestors)) {
                        if (!empty($oAncestors[0]->content->url_alias)) {
                            $path[] = $oAncestors[0]->content->url_alias;
                        }
                    }
                }
            }

            if (!empty($oNode->content)) {
                $path[] = $oNode->content->url_alias;
                //M::printr($path, '$path');
            }
            $newPath = implode('/', $path);
            //M::printr($newPath, '$newPath');

            if ($oNode->id == 1 && empty($newPath)) {
                $newPath = '/';
            }
            if ($oNode->ns_root_ref == 200 && $oNode->id != 200) {
                $newPath = 'catalog/' . $newPath;
            }

            if ($is_publish) {
                //M::printr($newPath, '$newPath');
                $this->createNodeAlias($oNode->id, $newPath);
            }
            exit;

            if ($is_gen_children) {
                //получить дочерние элементы
                $oChs = $oNode
                    ->children(1)
                    //->andWhere(['is_node_published' => true])
                    ->joinWith(['content'])->all();
                //M::printr(count($oChs), 'count($oChs)');
                foreach ($oChs as $oCh) {
                    if (!empty($oCh)) {
                        //M::printr($oCh->attributes, '$oCh->attributes');
                    }
                    $this->checkNode($oCh, $is_gen_children);
                }
                //$oProducts = $oNode->getProducts(true);
                //$this->checkProducts($oProducts, $is_gen_children);
            }
        }

    }

    public function getAncestors() {
        //взять все до корня или корень
        $this->oAncestors = $this->oNode->parents()->all();
    }

    public function checkPublish() {
        //проверить на опубликованность
        //если корень, то устарело
        if (1) {
            if ($this->oNode->isRoot()) {
                $this->path = null;
                $this->deprecateNodeAlias();
                return false;
            }
        }

        //проверить узел на опубликованность
        //M::printr('Проверить узел');
        if (!$this->oNode->is_node_published) {
            $this->deprecateNodeAlias();
            return false;
        }

        //проверить родителей на опубликованность
        //M::printr('Проверить родителей');
        $this->getAncestors();
        foreach ($this->oAncestors as $oAncestor) {
            if (!$oAncestor->is_node_published) {
                $this->deprecateNodeAlias();
                return false;
            }
        }
        return true;
    }

    //составить полный url
    public function getPath() {
        $arrPath = [];
        //если нужно взять полный путь с родителями
        if ($this->config['is_full_path']) {
            if ($this->oNode->ns_root_ref == 200) { // && $this->oNode->id != 200
                $arrPath[] = 'catalog';
            }

            foreach ($this->oAncestors as $oAncestor) {
                if (!empty($oAncestor->url_alias)) {
                    $arrPath[] = $oAncestor->url_alias;
                }
            }
        }

        if (!empty($this->oNode->url_alias)) {
            $arrPath[] = $this->oNode->url_alias;
        }

        //M::printr(count($arrPath), 'count($arrPath)');

        $this->path = '/' . implode('/', $arrPath);

        if ($this->oNode->id == 1) {
            $this->path = '/';
        }
        if ($this->oNode->id == 200) {
            //$this->path = '/catalog';
            $this->path = null;
        }

        if (strlen($this->path) > 254) {
            $this->path = substr($this->path, 0, 254);
        }
        return $this->path;
        //M::printr($this->path, 'Путь для cms_aliases');

    }

    public function getLiveAlias() {
        //M::printr('Получить');
        $this->oAlias = CmsAliases::findOne(
            [
                'cms_tree_ref' => $this->oNode->id,
                'is_deprecated' => false,
            ]
        );
    }

    public function getAliases() {
        $this->oAliases = CmsAliases::find()->where(['cms_tree_ref' => $this->oNode->id])->orderBy(['dt_created' => 'ASC'])->all();
    }

    public function createNodeAlias() {
        //M::printr('Создать алиас узла');

        //M::printr('createNodeAlias($node_id, $path)');
        //M::printr($this->path);

        $this->getLiveAlias();
        if (!empty($this->oAlias)) {
            //M::printr($this->oAlias->attributes, 'Перед созданием');
        }
        if (empty($this->oAlias)) {
            //M::printr('+Пусто -> создать');
            $this->oAlias = new CmsAliases();
            $this->oAlias->cms_site_ref = 1;
            $this->oAlias->cms_tree_ref = $this->oNode->id;
            $this->oAlias->url_md5hash = md5($this->path);
            $this->oAlias->url_path = $this->path;
            if (!$this->oAlias->save()) {
                M::xlog($this->oAlias->getErrors(), 'map');
                throw new Exception('Can`t save new alias...');
            }
            //M::printr($this->oAlias->attributes, 'Создали');
        }
        return true;


        if (empty($this->path)) {
            $is_create = false;
        } else if ($this->path !== '/') {
            $path = '/' . $this->path;
        }

        if (!empty($this->oAlias)) {
            //M::printr($oAlias->url_path, '$oAlias->url_path');
            //если путь отличается, то отметить его как устаревший
            if ($this->oAlias->url_path != $path) {
                $this->deprecateNodeAlias();
            } else {
                $is_create = false;
            }
        }
        exit;
        //если путь пустой, то не создавать
        $oAlias = CmsAliases::find()->where(['cms_tree_ref' => $this->oNode->id, 'is_deprecated' => false])->one();
        //если алиас не найден в CmsAliases, то пропускаем этот шаг
        if (!empty($oAlias)) {
            //M::printr($oAlias->url_path, '$oAlias->url_path');
            //если путь отличается, то отметить его как устаревший
            if ($oAlias->url_path != $path) {
                $this->deprecateNodeAlias();
            } else {
                $is_create = false;
            }
        }

        if ($is_create && strlen($path) < 254) {
            $oAlias = new CmsAliases();
            $oAlias->cms_site_ref = 1;
            $oAlias->cms_tree_ref = $node_id;
            $oAlias->url_md5hash = md5($path);
            $oAlias->url_path = $path;
            if (!$oAlias->save()) {
                M::xlog($oAlias->getErrors(), 'MoySklad');
                throw new Exception('Can`t save new alias...');
            }
        }
    }

    public function genCmsAlias($oNode, $is_gen_descendants = false) {
        //'url_md5hash' => md5($path . '/' . ($node->url_alias ?: '~')),
        $path = [];
        $ancestors = $oNode->ancestors()->findAll();
        if ($is_gen_descendants) {
            //взять все до корня включительно
            foreach ($ancestors as $oAncestor) {
                $path[] = $oAncestor->content->url_alias;
            }
        } else {
            $path[] = $ancestors[0]->content->url_alias;
        }
        $newPath = implode('/', $path);
        //$newPath = $path . $oNode->content->url_alias;
        //$newPath = '/catalog/' . $oNode->content->url_alias;
        if (empty($newPath)) $newPath = '/';
        //M::printr($newPath, '$newPath');

        $this->createNodeAlias($oNode->id, $newPath);

        return true;
    }

    //генерация нового CmsAliases
    public function genCmsAliases($oNodes, $is_gen_descendants = false) {
        //print 'public function genCmsAliases($oNode, $is_gen_descendants = false)';
        foreach ($oNodes as $oNode) {
            $this->genCmsAlias($oNode, $is_gen_descendants);
            if ($is_gen_descendants) {
                $oSubNodes = $oNode->descendants()->alive()->findAll();
                foreach ($oSubNodes as $oSubNode) {
                    $this->genCmsAlias($oSubNode, $is_gen_descendants);
                }
            }
        }
    }

    public function deprecateNodeAlias() {

        $this->getLiveAlias();
        //M::printr('проверить');

        //если алиас не пусто, то состарить
        if (!empty($this->oAlias)) {
            //M::printr('oAlias не пустое');
            M::printr("Состарить алиас узла {$this->oNode->node_name}");
            $this->oAlias->is_deprecated = true;
            $this->oAlias->dt_updated = new Expression('NOW()');
            if (!$this->oAlias->save()) {
                M::xlog(['Can`t save alias...' => $this->oAlias], 'map');
                throw new Exception('Can`t save old alias...');
            }
            //M::printr($this->oAlias->attributes, '$this->oAlias->attributes');
            $this->oAlias = null;
        }
    }

    public function deprecateProductAlias($product_id) {
        $oAlias = EcmAliases::model()->findByAttributes(['ecm_products_ref' => $product_id, 'is_deprecated' => false]);
        if (!empty($oAlias)) {
            $oAlias->is_deprecated = true;
            $oAlias->dt_updated = new CDbExpression('NOW()');
            if (!$oAlias->save()) {
                M::xlog(['Can`t save old alias...' => $oAlias], 'MoySklad');
                throw new Exception('Can`t save old alias...');
            }
        }
    }


}
