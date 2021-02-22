<?php

namespace backend\modules\cms\controllers;

use common\models\ar_inherit\MediaStorage;
use common\models\ar_inherit\ProductHasStorage;
use common\models\CMSH4Resource;
use common\models\CMSH4Storage;
use common\models\ElSearch;
use PHPUnit\Runner\Exception;
use yii;
use common\models\models\AppProducts;
use common\models\models\CmsNodeContent;
use common\models\Translit;
use yii\db\Connection;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use common\components\M;
use \common\models\models\CmsTree;
use \common\models\models\EcmProducts;
use \common\models\ar_inherit\Product;
use \common\models\ProductForm;
use backend\components\BackendController;
use yii\web\Response;
use yii\elasticsearch\ElasticsearchTarget;
use backend\assets\BackAsset;

class ProductController extends BackendController
{
    public $text = '';

    //public $layout = '//layouts/ct-default';

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function behaviors() {
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

    public function init() {
        /*/
        if (Yii::app()->request->isAjaxRequest) {
            $this->layout = '//layouts/ajax-popup';
        }
        $cs = Yii::app()->clientScript;
        $themePath = Yii::app()->theme->baseUrl;
        $cs->registerScriptFile($themePath . '/assets/js/keymaster-master/keymaster.js', CClientScript::POS_END);
        //*/
    }

    public function actionIndex() {
        M::printr('ProductController/actionIndex()');
        $this->render('index');
    }

    public function actionList() {

        if (0) {
            $query = ElSearch::find();
            $query->index = ElSearch::index();
            $query->type = ElSearch::type();
            //M::printr($query, '$query');
            $query->limit(100);
            //$query->with(['category.content']);
            $query->query([
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                //'query' => $request,
                                'fields' => [
                                    'title',
                                    'description^2',
                                    //'id^3',
                                    //'product_id^4',
                                ],
                            ],
                        ],
                    ],
                ]
            );
            M::printr($query, '$query');
            //exit;

            $resAll = $query->all();
            M::printr($resAll, '$resAll');
            return $this->render('list', ['resAll' => $resAll]);
        }

        return $this->render('list');
    }

    public function actionGetEcmProducts($id = 200) {
        //M::printr(/$_POST, '$_POST');
        //$oParent = CmsTree::findOne($id);
        //M::printr($oParent, '$oParent');

        //*/
        if (0) {
            $oQuery = EcmProducts::find()->alias('product');
            $_POST['SearchString'] = '';
            //'CLASSIC 3 / 30mm';
            $oQuery->joinWith(
                [
                    //'fields',
                    //'appProduct', //.tree',
                    //'productStore.warehouse',
                ]
            );
            if (!empty($_POST['SearchString'])) {
                M::printr($_POST['SearchString'], '$_POST[\'SearchString\']');
                exit;
                $oQuery->joinWith(
                    [
                        'fields.customField',
                        'appProduct', //.tree',
                        //'productStore.warehouse',
                    ]
                );

                $oQuery->andWhere(
                    'product.product_name ILIKE :searchString OR ("customField"."field_key" = :field_key AND "fields"."field_value" ILIKE :searchString)',
                    [
                        'searchString' => "%{$_POST['SearchString']}%",
                        'field_key' => '1c_product_vendor',
                    ]
                );
            }


            $oQuery->asArray();
            $oProducts = $oQuery->all();
            M::printr(count($oProducts), 'count($oProducts)');
            exit;
        }
        //*/
        $oQuery = EcmProducts::find()->alias('product');
        $oQuery->joinWith(
            [
                'fields.customField',
                'appProduct', //.tree',
                //'productStore.warehouse',
            ]
        );

        if (!empty($_POST['SearchString'])) {
            $oQuery->andWhere(
                'product.product_name ILIKE :searchString OR ("customField"."field_key" = :field_key AND "fields"."field_value" ILIKE :searchString)',
                [
                    ':searchString' => "%{$_POST['SearchString']}%",
                    ':field_key' => '1c_product_vendor',
                ]
            );
        }

        if (empty($_POST['isShowAll'])) {
            $oQuery->andWhere('"appProduct"."cms_tree_ref" IS NULL');
        }

        $oQuery->limit(1000);
        //$oQuery->orderBy('"appProduct"."cms_tree_ref" ASC');
        $oQuery->orderBy('"product"."product_name" ASC');

        //$oQuery->asArray();

        //M::printr($oQuery, '$oQuery');

        $oProducts = $oQuery->all();
        //M::printr(count($oProducts), 'count($oProducts)');
        //M::printr($oProducts[0], '$oProducts[0]');
        //exit;

        $arr = [];
        if (!empty($oProducts)) {
            foreach ($oProducts as $oProduct) {
                $item = $oProduct->attributes;
                //array
                if (0) {
                    $vendor = '';
                    $unit = '';
                    foreach ($oProduct['fields'] as $field) {
                        if ($field['ecm_custom_fields_ref'] == 5) {
                            $vendor = $field;
                        }
                        if ($field['ecm_custom_fields_ref'] == 75) {
                            $unit = $field;
                        }
                    }


                    //  $item['ecm_product'] = $oProduct;
                    $item['ecm_products_ref'] = $oProduct['id'];
                    $item['images'] = 0;
                    if (!empty($oProduct['hasGallery'])) {
                        $item['images'] = count($oProduct['hasGallery']);
                    }
                    //$item['countOffers'] = $oProduct->getCountOffers();
                    $item['unit'] = $unit; //$oProduct->getField('unit');
                    //M::printr($item['unit'], '$item[\'unit\']');
                    $item['vendor'] = $vendor; //$oProduct->getField('1c_product_vendor');
                }
                //object
                if (1) {
                    $item = $oProduct->attributes;
                    //$oVendor = $oProduct->getField('1c_product_vendor');
                    $oUnit = $oProduct->getField('unit');

                    foreach ($oProduct->fields as $oField) {
                        if ($oField->customField->field_key == '1c_product_vendor') {
                            $oVendor = $oField;
                        }
                        if ($oField->customField->field_key == 'unit') {
                            $oUnit = $oField;
                        }
                    }

                    $item['ecm_products_ref'] = $oProduct->id;
                    $item['images'] = 0;
                    $item['unit'] = $oUnit;
                    $item['vendor'] = $oVendor;
                }
                $arr[] = $item;
            }
        }

        $JS = [
            'success' => true,
            'message' => '',
            'messages' => [],
            'response_data' => $arr,
            'countProducts' => count($arr),
        ];

        if (\Yii::$app->request->isAjax) {
            return Json::encode($JS);
        }
    }

    public function actionCreate($node_id = false) {
        $formName = 'Product';

        $oProduct = new Product();
        //M::printr($oProduct, '$oProduct');
        $oStores = [];

        return $this->render('create', ['oProduct' => $oProduct, 'formName' => $formName, 'oStores' => $oStores]);
    }

    public function actionEdit($product_id) {
        $formName = 'Product';

        //$oProduct = Product::find()->alias('product')->joinWith(['hasStorages.storage'])->orderBy('hasStorages.on_view_position ASC')->where(['product.id' => $product_id])->one();
        $oProduct = Product::find()->where(['product.id' => $product_id])->one();
        //M::printr($oProduct, '$oProduct');

        $oStores = MediaStorage::find()->alias('store')->joinWith(['productHasStorages'])->orderBy('productHasStorages.on_view_position ASC')->where(['productHasStorages.products_ref' => $product_id])->all();
        //M::printr($oStorages, '$oStorages');

        return $this->render('edit', ['oProduct' => $oProduct, 'formName' => $formName, 'oStores' => $oStores]);
    }

    public function actionSave() {
        $formName = 'Product';
        //M::printr($_GET, '$_GET');
        //M::printr($_POST, '$_POST');

        $JS = [
            'success' => true,
            'message' => '',
            'messages' => [],
            '$_GET' => $_GET,
            '$_POST' => $_POST,
        ];

        if (empty($_POST[$formName])) {
            $JS['success'] = false;
            $JS['message'] = 'В форме пусто.';
            throw new yii\base\Exception('Пусто...');
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $is_new = true;
            $oProduct = new Product();
            if (!empty($_POST[$formName]['id'])) {
                $is_new = false;
                $oProduct = Product::find()->where(['id' => $_POST[$formName]['id']])->one();
                if (empty($oProduct)) {
                    $oProduct = new Product();
                }
            }

            $oProduct->setAttributes($_POST[$formName]);
            //M::printr($oProduct, '$oProduct');

            $oProduct->save();

            //картинки
            $images = [];
            if (!empty($_POST[$formName]['images'])) {
                $images = $_POST[$formName]['images'];
            }

            //картинки base64
            if (1) {
                if (strlen($oProduct->description) > 100000) {
                    $description = $oProduct->description;
                    //M::printr(htmlspecialchars($description), 'htmlspecialchars($description)');
                    $posBase64 = strpos($description, ';base64,');
                    if ($posBase64 !== false) {
                        $oStores = $this->saveImagesFromText($description);

                    }
                    //M::printr($oStores, '$oStores');
                    $oProduct->description = $description;
                    $oProduct->save();

                    foreach ($oStores as $oStore) {
                        $image = [
                            'image_id' => $oStore->id,
                            'is_delete' => 0,
                        ];
                        $images[] = $image;
                    }
                }
            }

            $on_view_position = 100;
            //пройти по всем картинкам
            foreach ($images as $image) {
                //M::printr($image, '$image');
                if (empty($image['image_id'])) continue;

                $image_id = $image['image_id'];
                $oStore = MediaStorage::find()
                    ->alias('storage')
                    ->joinWith(['productHasStorage'])
                    ->where(['storage.id' => $image_id])
                    ->one();
                //если картинка на удаление, то удалить ее и привязку к товару
                if (!empty($image['is_delete'])) {
                    //M::printr('DELETE');
                    $oStore = MediaStorage::find()
                        ->alias('storage')
                        ->joinWith(['productHasStorage'])
                        ->where(['storage.id' => $image_id])
                        ->one();
                    $res = $oStore->unbindFromProduct();
                    continue;
                }
                //привязать картинку к товару
                $res = $oStore->bindToProduct($oProduct->id, $on_view_position);
                $on_view_position += 100;
            }

            if (0) {
                //стоп
                exit;
            }

            if (1) {
                $elastic = $this->checkElasticItem($oProduct);
                $JS['elastic'] = $elastic;
            }
            $JS['result'] = $oProduct->attributes;
            if (1) {
                $transaction->commit();
            } else {
                $transaction->rollback();
            }
        } catch (yii\base\Exception $e) {
            $JS['success'] = false;
            $JS['messages'] = $e;
            M::printr($e, '$e');
            $transaction->rollback();
        }


        return Json::encode($JS);
    }

    public function actionSearchProduct($request) {
        //M::printr($request, '$request');
        $JS = [
            'success' => true,
            'message' => '',
            'messages' => [],
        ];

        try {
            $query = ElSearch::find();
            $query->index = ElSearch::index();
            $query->type = ElSearch::type();
            //M::printr($query, '$query');
            //$query->limit(100);
            //$query->with(['category.content']);
            $query->query([
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                'query' => $request,
                                'fields' => [
                                    'title',
                                    'description^2',
                                    //'id^3',
                                    //'product_id^4',
                                ],
                            ],
                        ],
                    ],
                ]
            );
            //M::printr($query, '$query');
            $JS['query'] = $query;

            $oItems = $query->all();
            //M::printr($oItems, '$oItems');
            $JS['oItems'] = $oItems;

            if (1) {
                $products = [];
                foreach ($oItems as $oItem) {
                    $score = $oItem->getScore();
                    //M::printr($score, '$score');
                    $oProduct = $oItem->product;
                    //M::printr($oProduct, '$oProduct');
                    $product = $oItem->product->attributes;
                    $product['score'] = $oItem->getScore();
                    $product['is_fotos'] = !empty($oItem->product->hasStorages) ? 1 : 0;
                    $products[] = $product;
                }
                $JS['products'] = $products;
            }


        } catch (yii\base\Exception $e) {
            //M::printr($e, '$e');
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
        }
        //$oProducts = Product::find()->orderBy('dt_created ASC')->all();
        //$JS['result'] = $oProducts;

        return Json::encode($JS);
    }

    public function saveImages($images) {

    }

    public function saveImagesFromText(&$text) {
        //M::printr('cutImagesFromText($text) ');
        $storage = Yii::getAlias('@storage');
        $oStores = [];
        //$text = '<para data-info="trkjh"><note>простое примечание</note><p>riuhiou<iMg Src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAbCAYAAACJISRoAAAA9klEQVRIDe3SzQqCQBAHcK/5GCk9iVD0Cl7E1/CNugQdOpRlHxfFDDpFRXXJHmP+rYXQYVd3OkgHB5Z1l2F+7IwGGgijAQMtwuryH7UrSUBBAHLdzxLfEHe6Uf2SxwM0GACGSJMsGg6B57PWUiN5Dup2pcW/QbKsWkiJkOPUAiVG/X7la+RIGGoDJYQoUkJShDyPjZDvMxHb5iO9HhPpdPiIafIQVfY6mqNY3JDORFWkRX5u12Gfas+HhWw3Cyxn0/fIsjRGcdYJFnI+HTEZj7ASf1ixX8RZJ1gIEeF2vSDbxbiLvTjrBAvRKSjLaRFZV5R3jbTrBYz8x4SxD0vZAAAAAElFTkSuQmCC" data-filename="image.png" style="width: 25px;">afterimagetext<br></p></para>';
        //M::printr(htmlspecialchars($text), 'htmlspecialchars($text)');

        if (1) {
            $dom = new \DOMDocument();
            //$dom->loadHTML($oProduct->description);
            $dom->loadHTML($text);
            //M::printr($dom, '$dom');
            $images = $dom->getElementsByTagName('img');
            foreach ($images as $k => $image) {
                $src = $image->getAttribute('src');
                //M::printr($src, '$src');

                $is_base64 = strpos($src, ';base64,');
                //var_dump($is_base64);
                if ($is_base64 === false) {
                    continue;
                }

                $originalFilename = $image->getAttribute('data-filename');
                //M::printr($originalFilename, '$originalFilename');

                $data = explode(',', $src);
                $imageType = $data[0];
                //M::printr($imageType, '$imageType');
                $base64 = $data[1];

                $fileImage = base64_decode($base64);

                //получить расширение по mime типу
                //data:image/png;base64
                //найти :
                $pos1 = strpos($imageType, ':');
                //найти ;
                $pos2 = strpos($imageType, ';') - 1;
                $r = $pos2 - $pos1;
                //взять все между : и ;
                $type = substr($imageType, $pos1 + 1, $r);
                //M::printr($type, '$type');
                $ext = 'png';
                if ($type == 'image/gif') $ext = 'gif';
                if ($type == 'image/jpg' || $type == 'image/jpeg') $ext = 'jpg';
                if ($type == 'image/png') $ext = 'png';

                $filename = md5($fileImage) . str_replace('.', '', microtime(true)) . '.' . $ext;
                //M::printr($filename, '$filename');
                $output_file = "{$storage}/.preload/{$filename}";
                //M::printr($output_file, '$output_file');

                if (1) {
                    $ifp = fopen($output_file, 'w');
                    fwrite($ifp, $fileImage);
                    fclose($ifp);

                    //сохранить картинку в базу
                    $resource = (new CMSH4Resource())->localFile($output_file);
                    $resource->filename = $originalFilename;
                    //M::printr($resource, '$resource');

                    $h4 = new CMSH4Storage();
                    $oStore = $h4->store($resource);
                    //M::printr($oStore, '$oStore');
                    $oStore->save();
                    $oStores[] = $oStore;
                    //M::printr($oStores, '$oStores');

                    //привязать $store к статье

                    if (0) {
                        $ProductHasStorage = new ProductHasStorage();
                    }

                    //заменить в тексте base64 на "/store/{$oStore->fs_alias}"
                    $text = str_replace($src, "/store{$oStore->fs_alias}", $text);
                    //M::printr(htmlspecialchars($text), 'htmlspecialchars($text)');

                    //unlink($output_file);
                }


                $image->setAttribute('src', "/store{$oStore->fs_alias}");
                //M::printr($src, '$src');

                $text = str_replace($src, "/store{$oStore->fs_alias}", $text);
                //M::printr(htmlspecialchars($text), 'htmlspecialchars ($text)');
                //M::printr('');
            }
            //M::printr(htmlspecialchars($text), 'htmlspecialchars ($text)');
        }
        //M::printr($oStores, 'IN $oStores');
        return $oStores;
    }

    public function checkElasticItem($oProduct) {
        //искать $oProduct в ElasticSearch
        $params = [
            'match' => [
                'product_id' => $oProduct->id
            ]
        ];
        $model = ElSearch::find()->query($params)->one();

        if (!empty($model)) {
            //если найден
            //обновить $oProduct в ElasticSearch
            $this->updateElasticItem($oProduct, $model);
            return $model;
        } else {
            //если не найден
            //добавить $oProduct в ElasticSearch
            return $this->createElasticItem($oProduct);
        }
    }

    public function deleteElasticItem($oProduct) {
        ElSearch::find()->where(['product_id' => $oProduct->id])->delete();
    }

    public function createElasticItem($oProduct) {
        $model = new ElSearch();
        $model->attributes = [
            'id' => $oProduct->id,
            'product_id' => $oProduct->id,
            'title' => strip_tags($oProduct->title),
            'description' => strip_tags($oProduct->description),
        ];
        $model->save();
        //M::printr($model, '$model');
        return $model;
    }

    public function updateElasticItem($oProduct, $model = false) {
        if (empty($model)) {
            return $this->createElasticItem($oProduct);
        }
        $model->attributes = [
            'id' => $oProduct->id,
            'product_id' => $oProduct->id,
            'title' => strip_tags($oProduct->title),
            'description' => strip_tags($oProduct->description),
        ];
        $model->save();
        //M::printr($model, '$model');
        return $model;
    }

    public function actionGetById($id = false) {
        $request = 'test';
        if ($id) {
            $index = ElSearch::index();
            $type = ElSearch::type();
            $query = ElSearch::find();
            $query->index = $index;
            $query->type = $type;
            $query->limit(100);
            //$query->with(['category.content']);
            $query->query([
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                'query' => $request,
                                'fields' => [
                                    'title',
                                    'description^2',
                                    //'id^3',
                                    //'product_id^4',
                                ],
                            ],
                        ],
                    ],
                ]
            );
            M::printr($query, '$query');

            $resAll = $query->all();
        }
    }

    public function actionFindByRequest($request) {
        if (1) {
            $query = ElSearch::find();
            $query->index = ElSearch::index();
            $query->type = ElSearch::type();
            //M::printr($query, '$query');
            $query->limit(100);
            //$query->with(['category.content']);
            $query->query([
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                'query' => $request,
                                'fields' => [
                                    'title',
                                    'description^2',
                                    //'id^3',
                                    //'product_id^4',
                                ],
                            ],
                        ],
                    ],
                ]
            );
            M::printr($query, '$query');
            //exit;

            $resAll = $query->all();
            M::printr($resAll, '$resAll');
            return $this->render('list', ['resAll' => $resAll]);
        }

        return $this->render('list');
    }

    public function actionListAll() {
        return $this->render('list');
    }

    public function actionRenewElasticIndex() {
        //ElSearch::deleteIndex();
        //ElSearch::createIndex();
        ElSearch::gen3();
    }

}


