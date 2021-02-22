<?php

namespace frontend\modules\catalog\controllers;

use common\models\Cart;
use common\models\ElSearchFilter;
use common\models\Wish;
use yii\caching\DbDependency;
use yii\db\Command;
use \yii\helpers\Url;
use frontend\components\widgets\CatalogCardWidget\CatalogCardWidget;
use frontend\components\widgets\FilterWidget\FilterWidget;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\FrontendController;
use common\models\models\CmsTree;
use common\components\M;
use yii\web\HttpException;

/**
 * Default controller for the `cms` module
 */
class DefaultController extends FrontendController
{
    //public $layout = '@layouts/index'; //'@theme/views/layouts/index';

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionView($node_id = 200) {
        $cache = Yii::$app->cache;

        $tm1 = microtime(true);
        //берем текущую категорию
        $oCategory = CmsTree::find()->alias('tree')
            ->joinWith(['content'])
            ->where('tree.id = :id', [':id' => $node_id])
            ->one();
        $oContent = $oCategory->content;

        $is_image = false;
        $catTeaserBig = '/images/noimg_big.jpg';
        $catIllustration = '/images/noimg_big.jpg';
        $catTeaserMicro = '/images/noimg_micro.jpg';
        $category = [
            'image' => [
                'teaserBig' => '/images/noimg_big.jpg',
                'illustration' => '/images/noimg_big.jpg',
                'teaserMicro' => '/images/noimg_micro.jpg',
            ]
        ];
        $oImages = $oContent->getImages();
        if (!empty($oImages[0])) {
            $is_image = true;
            $oImg = $oImages[0];
            $oCatTeaserBig = $oImg->getCropped('ecm:teaser_big');
            $catTeaserBig = '/store' . $oCatTeaserBig->fs_alias;
            $oCatIllustration = $oImg->getCropped('ecm:illustrations');
            $catIllustration = '/store' . $oCatIllustration->fs_alias;
            $oCatTeaserMicro = $oImg->getCropped('ecm:teaser_micro');
            $catTeaserMicro = '/store' . $oCatTeaserMicro->fs_alias;
            $category = [
                'image' => [
                    'teaserBig' => $catTeaserBig,
                    'illustration' => $catIllustration,
                    'teaserMicro' => $catTeaserMicro,
                ]
            ];
        }

        //M::printr($node_id, '$node_id');
        $this->fillSeo($oContent);

        //берем категории на уровень ниже
        $oChs = $oCategory
            ->children(1)
            ->joinWith('content')
            ->orderBy('content.page_title ASC')
            ->all();
        //$this->page_title = 'Каталог';
        $this->data['oCategory'] = $oCategory;
        $this->data['oContent'] = $oContent;
        $this->data['oChs'] = $oChs;
        $this->data['config'] = ElSearchFilter::getConfig();
        $tm2 = microtime(true);
        //M::printr($tm2 - $tm1, '$tm2 - $tm1 (шаг 1)');

        //генерация breadcrumbs
        $key = "_breadcrumbs_{$node_id}";
        $duration = 3600 * 24 * 7; //1 week
        $dependency = new DbDependency(['sql' => "SELECT dt_updated FROM cms_tree WHERE id = {$node_id}"]);
        //$key, $callable, $duration = null, $dependency = null
        $_breadcrumbs = $cache->getOrSet(
            $key,
            function () use ($oCategory) {
                return $this->renderPartial('_partial/_breadcrumbs', ['oCategory' => $oCategory]);
            },
            $duration,
            $dependency
        );
        $this->data['_breadcrumbs'] = $_breadcrumbs;
        $tm3 = microtime(true);
        //M::printr($tm3 - $tm2, '$tm3 - $tm2 (_breadcrumbs)');

        if (1) {
            //M::printr($oCategory->attributes, '$oCategory->attributes');

            if (1) {
                $tm1 = microtime(true);
                //проверяем, сколько уровней есть ниже
                $oQuery = CmsTree::find();
                $oQuery->select('DISTINCT(ns_level) "d_level"');
                $oQuery->onCondition(':left < ns_left_key AND ns_left_key < :right AND ns_level > :level');
                $oQuery->params(
                    [
                        ':left' => $oCategory->ns_left_key,
                        ':right' => $oCategory->ns_right_key,
                        ':level' => $oCategory->ns_level,
                    ]
                );
                $oQuery->orderBy('d_level ASC');
                $oQuery->limit(2);
                $levels = $oQuery->all();
                $tm2 = microtime(true);
                //M::printr($tm2 - $tm1, '$tm2 - $tm1 (проверяем, сколько уровней есть ниже)'); //0.005 сек

                $product_id = !empty($_GET['product_id']) ? $_GET['product_id'] : null;
                //M::printr(count($levels), 'count($levels)');

                if (count($levels) == 2) {
                    //M::printr('2 предпредпоследняя');
                    $view = 'view';
                }

                if (count($levels) == 1) {
                    //M::printr('1 предпоследняя');
                    $view = 'prelast';
                }

                if (count($levels) > 0) {
                    //M::printr('предпредпоследняя или предпоследняя');
                    $tm1 = microtime(true);
                    $key = "_menu_catalog_{$node_id}";
                    //$duration = 60; //1 min
                    //$dependency = new DbDependency(['sql' => "SELECT dt_updated FROM cms_tree WHERE id = {$node_id}"]);
                    //$key, $callable, $duration = null, $dependency = null
                    $_menu_catalog = $cache->getOrSet(
                        $key,
                        function () use ($oCategory) {
                            return $this->renderPartial('_partial/_menu_catalog', ['oCategory' => $oCategory]);
                        },
                        $duration,
                        $dependency
                    );
                    $this->data['_menu_catalog'] = $_menu_catalog;
                    $tm2 = microtime(true);
                    //M::printr($tm2 - $tm1, '_menu_catalog');

                    /*/
                    $_filter = FilterWidget::widget(
                        [
                            'categoryId' => $oCategory->id,
                            'formName' => $this->formName,
                            'config' => [
                                'limit' => 40,
                                'offset' => 0,
                            ],
                            //'filterConfig' => $this->context->filterConfig,
                        ]
                    );
                    //*/

                    $tm1 = microtime(true);
                    $key = "_filter_{$node_id}";
                    //$duration = 3600 * 24 * 7; //1 week
                    $dependency = new DbDependency(['sql' => "SELECT dt_updated FROM cms_tree WHERE id = {$node_id}"]);
                    //$key, $callable, $duration = null, $dependency = null
                    $oCart = (new Cart())->give();
                    $oCartProducts = $oCart->cartProducts;
                    $use = ['oCategory' => $oCategory, 'formName' => $this->formName, 'cart' => $oCart];
                    //M::printr($use, '$use');
                    $_filter = $cache->getOrSet(
                        $key,
                        function () use ($use) {
                            $_filter = FilterWidget::widget(
                                [
                                    'categoryId' => $use['oCategory']->id,
                                    'formName' => $use['formName'],
                                    'config' => [
                                        'limit' => 40,
                                        'offset' => 0,
                                    ],
                                    'cart' => $use['cart'],
                                    //'filterConfig' => $this->context->filterConfig,
                                ]
                            );
                            return $_filter;
                        },
                        $duration,
                        $dependency
                    );
                    $this->data['_filter'] = $_filter;
                    $tm2 = microtime(true);
                    //M::printr($tm2 - $tm1, '_filter');

                }

                if (count($levels) == 0) {
                    //M::printr('0 последняя (товары)');

                    $tm1 = microtime(true);
                    $oParent = $oCategory->parents(1)->one();
                    $catalogs = $this->getCatalogs($oParent->getCategoryProducts());
                    $tm2 = microtime(true);
                    //M::printr($tm2 - $tm1, '$catalogs');

                    $tm1 = microtime(true);
                    $oProducts = $oCategory->getCategoryProducts();
                    //выбрать товар с минимальной ненулевой ценой
                    $oProduct = current($oProducts);
                    foreach ($oProducts as $product) {
                        if ($product->product_price > 0 && $product->product_price < $oProduct->product_price) {
                            //M::printr('>>>УРА!!!<<<');
                            $oProduct = $product;
                        }
                        if ($oProduct->product_price == 0 && $product->product_price > 0) {
                            $oProduct = $product;
                        }
                    }
                    if (!empty($product_id)) {
                        $oProduct = $oProducts[$product_id];
                    }
                    $tm2 = microtime(true);
                    //M::printr($tm2 - $tm1, '$oProduct');

                    $this->data['oProducts'] = $oProducts;

                    $products = $this->genProducts($oCategory);
                    //обойти товары, проставить флаг is_image=true у кого есть катринка
                    //проставить флаг is_image=false у кого нет катринки
                    //M::printr($products, '$products');
                    $this->data['products'] = $products;

                    //M::printr($products, '$products');

                    $_tabs = false;
                    $oComments = $oProduct->getProductComments(2);
                    $oFields = $oProduct->getProductFields();
                    $_tabs = $this->renderPartial('_partial/_tabs', ['oCategory' => $oCategory, 'oProduct' => $oProduct, 'oFields' => $oFields, 'oComments' => $oComments, 'product_id' => $product_id]);
                    $this->data['_tabs'] = $_tabs;

                    $_more_products = false;
                    if (count($catalogs) > 1) {
                        $_more_products = $this->renderPartial('_partial/_more_products', ['oCurrentCategory' => $oCategory, 'catalogs' => $catalogs]);
                    }
                    $this->data['_more_products'] = $_more_products;

                    $noImgUrl = '/images/noimg_192.jpg';
                    $this->data['noImgUrl'] = $noImgUrl;
                    $oImages = $oCategory->content->getImages();
                    $imgUrl = $noImgUrl;
                    $catImgUrl = $noImgUrl;
                    if (!empty($oImages[0])) {
                        $is_image = true;
                        $oImg = $oImages[0];
                        $oTeaserSmall = $oImg->getCropped('ecm:teaser_small');
                        $imgUrl = '/store' . $oTeaserSmall->fs_alias;
                        $catImgUrl = '/store' . $oTeaserSmall->fs_alias;
                    }
                    $this->data['imgUrl'] = $imgUrl;
                    $this->data['catImgUrl'] = $catImgUrl;

                    $productImgUrl = null;
                    $oImages = $oProduct->getImages();
                    if (!empty($oImages[0])) {
                        //если картинка категории не установлена, то поставить ее из первого товара
                        if ($category['image']['teaserBig'] == '/images/noimg_big.jpg') {
                            $oImg = $oImages[0];
                            $oCatTeaserBig = $oImg->getCropped('ecm:teaser_big');
                            $catTeaserBig = '/store' . $oCatTeaserBig->fs_alias;
                            $oCatIllustration = $oImg->getCropped('ecm:illustrations');
                            $catIllustration = '/store' . $oCatIllustration->fs_alias;
                            $oCatTeaserMicro = $oImg->getCropped('ecm:teaser_micro');
                            $catTeaserMicro = '/store' . $oCatTeaserMicro->fs_alias;
                            $category = [
                                'image' => [
                                    'teaserBig' => $catTeaserBig,
                                    'illustration' => $catIllustration,
                                    'teaserMicro' => $catTeaserMicro,
                                ]
                            ];
                        }
                        $is_image = true;
                        $oImg = $oImages[0];
                        $oTeaserBig = $oImg->getCropped('ecm:teaser_big');
                        $productImgUrl = '/store' . $oTeaserBig->fs_alias;
                    }

                    $_product = false;
                    $_product = $this->renderPartial('_partial/_product', ['oCategory' => $oCategory, 'category' => $category, 'oProducts' => $oProducts, 'oProduct' => $oProduct]);
                    $this->data['_product'] = $_product;

                    $this->data['productImgUrl'] = $productImgUrl;
                    $view = 'last';
                }

            }

        }

        //M::printr($view, '$view');
        $render = $this->render($view, $this->data);

        return $render;
    }

    public function actionLoadMoreProducts($node_id = 200) {
        //M::printr($node_id, '$node_id');
        //M::printr($_GET, '$_GET');
        //M::printr($_POST, '$_POST');
        //M::printr($this->filterConfig, '$this->filterConfig');
        $tm1 = microtime(true);

        if (1) {
            $key = "_filter_{$node_id}";
            $duration = 60; //10 sec //1 min
            $dependency = new DbDependency(['sql' => "SELECT dt_updated FROM cms_tree WHERE id = {$node_id}"]);

            $config = ElSearchFilter::getConfig();
            //M::printr($config, '$config');
            //exit;
            //получить выборку из elasticsearch
            $response = ElSearchFilter::getElasticItems($node_id, $config);
        }
        $tm2 = microtime(true);
        //M::printr($tm2 - $tm1, '$response');
        //M::printr($response, '$response');
        $categories = $response['categories'];
        //M::printr($categories, '$categories');
        $countAll = $response['countAll'];

        if (0) {
            //сортируем по цене
            usort(
                $categories,
                function ($item1, $item2) {
                    if ($item1->price > $item2->price) return 1;
                    return -1;
                }
            );
            //M::printr($categories, '$categories');

            //разделяем положительную и нулевую цены
            $prices = [];
            $nulls = [];
            foreach ($categories as $key => $item) {
                if (!empty($item->price)) {
                    $prices[$key] = $item;
                } else {
                    $nulls[$key] = $item;
                }
            }
            //сначала идут положительные цены
            $categories = [];
            foreach ($prices as $key => $item) {
                $categories[$key] = $item;
            }
            //потом нулевые
            foreach ($nulls as $key => $item) {
                $categories[$key] = $item;
            }

            //выбираем по limit и offset
            $config['countAll'] = count($categories);
            //M::printr($config, '$config');
            $arr = [];
            $i = 0;
            foreach ($categories as $category) {
                if ($config['offset'] <= $i && $i < ($config['offset'] + $config['limit'])) {
                    $arr[] = $category;
                    //M::printr($i, '$i');
                }
                if ($i > ($config['offset'] + $config['limit'])) break;
                $i++;
            }
        }

        $html = '';
        foreach ($categories as $row) {
            $card = [
                'catalog' => $row['category_id'],
                'url' => Url::to(['/route/catalog', 'id' => $row['category_id']]),
                'imgUrl' => $row['img'],
                'name' => $row['category_name'],
                'price' => $row['price'],
                'count' => $row['count'],
            ];

            $html .= CatalogCardWidget::Widget(
                [
                    'card' => $card,
                    //'categoryId' => $oCategory->id,
                    //'formName' => $this->context->formName,
                    //'filterConfig' => $this->context->filterConfig,
                ]
            );

        }

        $tm2 = microtime(true);
        $r = $tm2 - $tm1;
        $JS = [
            'success' => true,
            'count' => count($categories),
            'config' => $config,
            'html' => $html,
            'time' => $r,
            'countAll' => $countAll,
            //'getElasticItems' => $response,
        ];
        if (Yii::$app->request->isAjax) {
            return Json::encode($JS);
        }
        throw new HttpException(404);
    }

    public function genProducts($oCategory) {
        $oWish = (new Wish())->give();
        $oWishProducts = $oWish->wishProducts;
        $oCart = (new Cart())->give();
        $oCartProducts = $oCart->cartProducts;

        $is_image = false;
        $catTeaserBig = '/images/noimg_big.jpg';
        $catIllustration = '/images/noimg_big.jpg';
        $catTeaserMicro = '/images/noimg_micro.jpg';
        $oImages = $oCategory->content->getImages();
        if (!empty($oImages[0])) {
            $is_image = true;
            $oImg = $oImages[0];
            $oCatTeaserBig = $oImg->getCropped('ecm:teaser_big');
            $catTeaserBig = '/store' . $oCatTeaserBig->fs_alias;
            $oCatIllustration = $oImg->getCropped('ecm:illustrations');
            $catIllustration = '/store' . $oCatIllustration->fs_alias;
            $oCatTeaserMicro = $oImg->getCropped('ecm:teaser_micro');
            $catTeaserMicro = '/store' . $oCatTeaserMicro->fs_alias;
        }

        $oProducts = $oCategory->getCategoryProducts();
        $products = [];
        foreach ($oProducts as $oProduct) {
            $product = $oProduct->attributes;
            $product['product_price'] = (int)$product['product_price'];
            $product['product_new_price'] = (int)$product['product_new_price'];
            $oFields = $oProduct->getProductFields();
            $oVendor = $oProduct->getField('1c_product_vendor');
            $product['vendor'] = $oVendor->field_value;
            $oLabels = $oProduct->getLabels();
            $product['labels'] = [];
            foreach ($oLabels as $oLabel) {
                $product['labels'][$oLabel->label->label_key] = $oLabel->attributes;
            }

            if (1) {
                $product['is_image'] = $is_image;
                $product['image']['teaserBig'] = $catTeaserBig;
                $product['image']['illustration'] = $catIllustration;
                $product['image']['teaserMicro'] = $catTeaserMicro;
                $oImages = $oProduct->getImages();
                if (!empty($oImages[0])) {
                    $oImg = $oImages[0];
                    $product['is_image'] = true;
                    $oTeaserBig = $oImg->getCropped('ecm:teaser_big');
                    $product['image']['teaserBig'] = '/store' . $oTeaserBig->fs_alias;
                    $oIllustration = $oImg->getCropped('ecm:illustrations');
                    $product['image']['illustration'] = '/store' . $oIllustration->fs_alias;
                    $oTeaserMicro = $oImg->getCropped('ecm:teaser_micro');
                    $product['image']['teaserMicro'] = '/store' . $oTeaserMicro->fs_alias;
                }
            }

            $product['is_in_cart'] = !empty($oCartProducts[$oProduct->id]);
            $product['is_in_wish'] = !empty($oWishProducts[$oProduct->id]);
            $fields = [];
            foreach ($oFields as $oField) {
                if ($oField->customField->is_permanently) continue;
                if (!$oField->customField->is_visible) continue;
                $field['name'] = $oField->customField->field_name;
                $field['view'] = $oField->customField->field_description;
                $field['value'] = '';
                if (!empty($oField->field_value)) {
                    $field['value'] = $oField->field_value;
                } elseif (!empty($oField->ecm_custom_field_dictionary_ref)) {
                    $field['value'] = $oField->customFieldDict->field_value_view;
                }
                $field['value'] .= !empty($oField->customField->field_unit) ? " {$oField->customField->field_unit}" : '';
                $fields[] = $field;
            }
            $product['quantity'] = $oProduct->getProductCount();
            $product['fields'] = $fields;
            $products[$oProduct->id] = $product;
        }
        if (isset($_GET[strftime('%d%m%Y')])) {
            M::xlog(['$products' => $products], '_product');
        }
        return $products;
    }

    public function getCatalogs($oProducts) {
        $catalogs = [];
        foreach ($oProducts as $oProduct) {
            $oNode = $oProduct->appProduct->tree;
            //M::printr($oNode, '$oNode');
            $x = [];
            if (empty($catalogs[$oNode->id])) {
                if (!$oNode->is_node_published) {
                    continue;
                }
                $item = $oNode->attributes;
                $item['content'] = $oNode->content->attributes;
                $item['url'] = Url::to(['/route/catalog', 'id' => $oNode->id]);
                //$item['image'] = [];
                //$item['image']['fs_alias'] = '/images/noimg_192.jpg';
                if (!empty($oNode->content->hasGallery)) {
                    $oImages = $oNode->content->getImages();
                    if (!empty($oImages[0])) {
                        $oImage = $oImages[0];
                        $oCropped = $oImage->getCropped('ecm:teaser_small');
                        $item['image'] = $oCropped->attributes;
                    }
                }
                $item['product'] = $oProduct->attributes;
                if (!empty($oProduct->hasLabels)) {
                    foreach ($oProduct->hasLabels as $label) {
                        $item['product'][$label->label->label_key] = $label->label->attributes;
                    }
                }
                $item['product']['store'] = $oProduct->productStore->attributes;
                $item['category_name'] = $oNode->node_name;

                //по-новому берем данные для карточки
                if (0) {
                    $x['id'] = $oNode->id;
                    $x['name'] = $oNode->node_name;
                    $x['image'] = '/images/noimg_192.jpg';
                    $oImages = $oNode->getImages();
                    if (!empty($oImages)) {
                        $oImage = $oImages[0]->getCropped('ecm:teaser_small');
                        $x['image'] = 'store' . $oImage->fs_alias;
                    }
                    $x['image'] = $oNode->node_name;
                    $x['product_id'] = $oProduct->id;
                    $x['price'] = $oProduct->countProductPrice();
                    $x['count'] = $oProduct->getProductCount();
                    $x['labels'] = $oProduct->getLabels(true);
                }

                //M::printr($item, '$item');
                $catalogs[$oNode->id] = $item;
            }
        }
        return $catalogs;
    }

}

