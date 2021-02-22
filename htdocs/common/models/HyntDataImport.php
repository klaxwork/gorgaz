<?php

namespace common\models;

use common\components\M;
use common\components\Translit;
use common\components\Vars;
use common\models\models\AppGallery;
use common\models\models\AppProducts;
use common\models\models\CmsMediaStorage;
use common\models\models\EcmCustomFieldDictionary;
use common\models\models\EcmCustomFieldMeta;
use common\models\models\EcmCustomFields;
use common\models\models\EcmProducts;
use common\models\models\EcmProductStore;
use common\models\models\EcmWarehouse;
use common\models\models\EdiBootstrap;
use yii\db\Exception;
use yii\helpers\Json;
use \yii;
use yii\db\Expression;

class HyntDataImport
{
    public $oCategory = null;

    public function __construct() {
        return $this;
    }

    public static function getHyntMetas() {
        $tm_start = microtime(true);
        M::printr($tm_start, '$tm_start');
        $url = 'http://cabinet.hynt.ru/cms/default/apiGetFieldsMeta';
        if (!PRODUCTION_MODE) {
            $url = 'http://hnt4adm.vh.nays.ru/cms/default/apiGetFieldsMeta';
            $url = 'http://cabinet.hynt.ru/cms/default/apiGetFieldsMeta';
        }
        M::printr("{$url}\n");

        $metas = file_get_contents($url);
        $metas = Json::decode($metas, false);
        print "Взял метаданные " . count($metas) . "шт.\n";
        try {
            //пройти по принятым метаданным
            foreach ($metas as $meta) {
                M::printr($meta, '$meta');
                //найти данные метаданные в базе
                $oMeta = EcmCustomFieldMeta::find()
                    ->where(['field_type' => $meta->field_type])
                    ->one();
                M::printr($oMeta->attributes, '$oMeta->attributes');
                if ($oMeta->field_meta !== $meta->field_meta) {
                    $oMeta->field_meta = $meta->field_meta;
                    if (!$oMeta->save()) {
                        return 'Can`t save meta...';
                        //throw new Exception('Can`t save meta...');
                    }
                }

            }
        } catch (Exception $e) {
            $JS['message'] = $e->getMessage();
        }

        $tm_stop = microtime(true);
        $time = $tm_stop - $tm_start;
        $JS['time'] = "{$time} сек.";
        M::printr($JS, '$JS');
        M::xlog($JS, 'categories');
        M::printr('DONE!!!');
        M::printr('');
        return true;
    }

    public static function getHyntFields() {
        $JS = [
            'success' => true,
            'message' => null,
            'messages' => [],
        ];

        $tm_start = microtime(true);
        $url = 'http://cabinet.hynt.ru/cms/default/apiGetFields';
        if (!PRODUCTION_MODE) {
            $url = 'http://hnt4adm.vh.nays.ru/cms/default/apiGetFields';
            $url = 'http://cabinet.hynt.ru/cms/default/apiGetFields';
        }
        M::printr("{$url}\n");
        $fields = file_get_contents($url);
        $fields = Json::decode($fields, false);
        //M::printr($fields, '$fields');
        //print "Получил поля " . count($fields) . "шт.\n";        //M::printr($oCategories, '$oCategories');
        M::printr("Получил доп.поля " . count($fields) . " шт.\n");
        $transaction = Yii::$app->db->beginTransaction();
        //print "Начинаем обработку доп.полей.\n";
        M::printr("Начинаем обработку доп.полей.\n");
        try {
            foreach ($fields as $field) {
                $meta = $field->meta;
                $dictionary = $field->dictionary;
                $oField = EcmCustomFields::getFieldByKey($field->field_key);
                if (1) {
                    if (empty($oField)) {
                        //такого поля в базе нет
                        //создать
                        M::printr('создать');
                        M::printr($field, '$field');
                        $oField = new EcmCustomFields();
                        $arrMeta = (array)$meta;
                        M::printr($arrMeta, '$arrMeta');
                        $oField->setAttributes((array)$field);
                        $oField->ecm_catalog_ref = 1;
                        $newMeta = EcmCustomFieldMeta::find()
                            //->findByAttributes(['field_type' => $meta->field_type])
                            ->where(['field_type' => $meta->field_type])
                            ->one();
                        $oField->ecm_custom_field_meta_ref = $newMeta->id;
                        if (!$oField->save()) {
                            $JS['messages'] = $oField->getErrors();
                            throw new Exception('Can`t create field...');
                        }
                    }
                    //M::printr($oField, '$oField');

                    //проверить meta
                    $oMeta = $oField->customFieldMeta;
                    if ($oMeta->field_type != $meta->field_type || $oMeta->field_meta != $meta->field_meta) {
                        $newMeta = EcmCustomFieldMeta::find()
                            ->where(['field_type' => $meta->field_type])
                            ->one();
                        $oField->ecm_custom_field_meta_ref = $newMeta->id;
                        if (!$oField->save()) {
                            throw new Exception('Can`t save field...');
                        }
                    }

                    //проверить словарь
                    foreach ($dictionary as $dict) {
                        //M::printr($dict, '$value');
                        $oDict = EcmCustomFieldDictionary::find()
                            ->where(
                                [
                                    'ecm_custom_fields_ref' => $oField->id,
                                    'field_value' => $dict->field_value,
                                ]
                            )
                            ->one();
                        //M::printr($oDict, '>> $oDict');
                        if (empty($oDict)) {
                            $oDict = new EcmCustomFieldDictionary();
                            $oDict->ecm_custom_fields_ref = $oField->id;
                            $oDict->field_value = $dict->field_value;
                            $oDict->field_value_view = $dict->field_value_view;
                        }
                        $oDict->field_value_view = $dict->field_value_view;
                        if (!$oDict->save()) {
                            throw new Exception('Can`t save dict...');
                        }
                    }
                }

            }

            print "Доп.поля обработаны.\n";
            $transaction->commit();
            //$transaction->rollback();
        } catch (Exception $e) {
            $JS['message'] = $e->getMessage();
            $transaction->rollback();
        }
        $tm_stop = microtime(true);
        $time = $tm_stop - $tm_start;
        $JS['time'] = "{$time} сек.";
        M::printr($JS, '$JS');
        M::xlog($JS, 'categories');
        M::printr('DONE!!!');
        M::printr('');
    }

    public static function getHyntTree() {
        $tm_start = microtime(true);
        $url = 'http://cabinet.hynt.ru/cms/default/apiGetTree';
        if (!PRODUCTION_MODE) {
            $url = 'http://hnt4adm.vh.nays.ru/cms/default/apiGetTree';
        }
        M::printr("{$url}\n");

        $categories = file_get_contents($url);
        $oCategories = json_decode($categories);
        M::printr("Взял категории " . count($oCategories) . "шт.");
        $root = null;
        $oRootCategory = CmsTree::model()->getRootCategory();
        $i = 0;
        $transaction = Yii::app()->db->beginTransaction();
        $JS = [
            'success' => true,
            'message' => null,
            'messages' => [],
        ];
        M::printr('Начинаем обработку категорий.');
        try {
            $criteria = new CDbCriteria();
            $criteria->addCondition('ns_root_ref = :root AND ns_left_key > 1');
            $criteria->params['root'] = $oRootCategory->id;
            CmsTree::model()->updateAll(['is_trash' => true], $criteria);

            foreach ($oCategories as $category) {
                //print "<br>\n";
                $category = (array)$category;
                if ($category['ns_level'] == 1) {
                    $root = $category;
                    continue;
                }
                $criteria = new CDbCriteria();
                if (0) {
                    //первое сталкивание hynt > fishmen
                    $criteria->addCondition('"field"."property_name" = :prop_name AND "properties"."property_value" = :group_id'); //1c_group_id
                    $criteria->params['prop_name'] = '1c_group_id';
                    $criteria->params['group_id'] = $category['1c_group_id'];
                }
                if (1) {
                    //дальнейшее сталкивание hynt > fishmen
                    $criteria->addCondition('"field"."property_name" = :prop_name AND "properties"."property_value" = :external_hynt_id'); //external_hynt_id
                    $criteria->params['prop_name'] = 'external_hynt_id';
                    $criteria->params['external_hynt_id'] = $category['external_hynt_id'];
                }
                $oCategory = CmsTree::model()
                    ->with(['properties.field', 'content'])
                    ->find($criteria);
                //M::printr($oCategory, '$oCategory LOAD');
                if (empty($oCategory)) {
                    //M::printr('CreateCategory');
                    $oCategory = new CmsTree();
                    $oCategory->url_alias = Translit::text($category['node_name']);
                    $oCategory->is_node_published = false;
                }
                $oCategory->detachBehavior('nestedSetBehavior'); //disable_ns = true;
                $oCategory->node_name = $category['node_name'];
                $oCategory->ns_root_ref = $oRootCategory->id;
                $oCategory->ns_left_key = $category['ns_left_key'];
                $oCategory->ns_right_key = $category['ns_right_key'];
                $oCategory->ns_level = $category['ns_level'];
                $oCategory->is_trash = false;
                //M::printr($oCategory, '$oCategory AFTER SAVE');
                if (!$oCategory->save()) {
                    throw new Exception('Can`t save Category');
                }

                $oNodeContent = $oCategory->content;
                if (empty($oNodeContent)) {
                    //M::printr('Create NodeContent');
                    $oNodeContent = new CmsNodeContent();
                    $oNodeContent->cms_tree_ref = $oCategory->id;
                    $oNodeContent->page_title = $oCategory->node_name;
                    $oNodeContent->cms_templates_ref = 1;
                    if (!$oNodeContent->save()) {
                        $JS['messages'] = $oNodeContent->getErrors();
                        throw new Exception('Can`t save NodeContent');
                    }
                }

                $oProps = $oCategory->properties;
                $oProp = array_filter(
                    $oProps, function ($prop) {
                    if ($prop->cms_node_properties_fields_ref == 6) {
                        return true;
                    }
                }
                );
                //M::printr($oProp, '$oProp PROPERTIES 6');
                if (empty($oProp)) {
                    //M::printr('Create Property');
                    $oProp = new CmsNodeProperties();
                    $oProp->cms_tree_ref = $oCategory->id;
                    $oProp->cms_node_properties_fields_ref = 6;
                    $oProp->property_value = $category['external_hynt_id'];
                    if (!$oProp->save()) {
                        throw new Exception('Can`t save Property');
                    }
                    //M::printr($oProp, '$oProp');
                }

                if ($category['ns_left_key'] > 53 && $category['ns_left_key'] < 60) {
                    //M::printr($category, '$category');
                    //M::printr($oCategory, '$oCategory');
                    $oNom = $oCategory->getNomenclature();
                    M::printr($oNom, '$oNom');
                    $fields = !empty($category['fields']) ? $category['fields'] : [];
                    M::printr($fields, '$fields');
                    //если номенктатуры у категории нет
                    if (empty($oNom)) {
                        //создать номенклатуру
                        $oNom = $oCategory->createNomenclature();
                        $oNom = $oCategory->getNomenclature();
                    }
                    //создать ecm_nomenclature_fields...
                    foreach ($fields as $field) {
                        M::printr($field, '$field');
                        $oField = EcmCustomFields::getFieldByKey($field->field_key);
                        $criteria = new CDbCriteria();
                        $criteria->addCondition('ecm_nomenclature_ref = :id');
                        $criteria->params['id'] = $oNom->id;
                        $criteria->addCondition('"customField"."field_key" = :field_key');
                        $criteria->params['field_key'] = $field->field_key;
                        $oEcmNomField = EcmNomenclatureFields::model()->with(['customField'])->find($criteria);
                        M::printr($oEcmNomField, '$oEcmNomField');
                        if (empty($oEcmNomField)) {
                            $oEcmNomField = new EcmNomenclatureFields();
                            $oEcmNomField->ecm_nomenclature_ref = $oNom->id;
                            $oEcmNomField->ecm_custom_fields_ref = $oField->id;
                            if (!$oEcmNomField->save()) {
                                throw new Exception('Can`t save ecmNomField');
                            }
                        }
                    }
                    //M::printr($category['fields'], '$category[fields]');
                    //M::printr($oCategory->attributes, '$oCategory->attributes');

                }


                //M::printr($i, '$i');
                $i++;
            }

            $oRootCategory->detachBehavior('nestedSetBehavior'); //disable_ns = true;
            $oRootCategory->ns_right_key = $root['ns_right_key'];
            if (!$oRootCategory->save()) {
                throw new Exception('Can`t save RootCategory');
            }

            //удалить все отмеченные удаленными (is_trash IS TRUE)
            $criteria = new CDbCriteria();
            $criteria->addCondition('ns_root_ref = :root AND ns_left_key > 1 AND is_trash IS TRUE');
            $criteria->params['root'] = $oRootCategory->id;
            $oTree = CmsTree::model();
            $oTree->detachBehavior('nestedSetBehavior');
            //$oTree->deleteAll($criteria);

            //$transaction->rollback();
            print "Категории обработаны.\n";
            $transaction->commit();
            //$transaction->rollback();
        } catch (Exception $e) {
            $JS['message'] = $e->getMessage();
            $transaction->rollback();
        }
        $tm_stop = microtime(true);
        $time = $tm_stop - $tm_start;
        $JS['time'] = "{$time} сек.";
        M::printr($JS, '$JS');
        M::xlog($JS, 'categories');
        M::printr('DONE!!!');
        M::printr('');
    }

    public static function getHyntProducts($limit = 500, $offset = 0, $lastUpdate = false) {
        $_GET['debug'] = 'console';
        $tm_start = microtime(true);
        M::xlog($tm_start, 'products');
        $storage = Yii::getAlias('storage');


        if (!$lastUpdate) {
            $LastHyntUpdate = Vars::getVar('LastHyntUpdate');
            $lastUpdate = $LastHyntUpdate;
        }

        //$limit = 500;
        //$offset = 0;
        /*
        TODO поставить таймаут в функции file_get_contents() на 300 секунд (5 минут)
        https://stackoverflow.com/questions/10236166/does-file-get-contents-have-a-timeout-setting
        */
        $oWarehouse = EcmWarehouse::find()
            ->where(['dev_key' => 'ecm:defaultstore'])
            //->params(['dev_key' => 'ecm:defaultstore'])
            ->one();

        $c = $offset;
        do {
            $url = 'http://cabinet.hynt.ru/cms/default/apiGetProducts?limit=' . $limit . '&offset=' . $offset . '&lastUpdate=' . $lastUpdate;
            $domain = 'http://cabinet.hynt.ru';
            if (!PRODUCTION_MODE) {
                M::printr('NOT PRODUCTION_MODE');
                $url = 'http://cabinet.hynt.ru/cms/default/apiGetProducts?limit=' . $limit . '&offset=' . $offset . '&lastUpdate=' . $lastUpdate;
                $domain = 'http://cabinet.hynt.ru';
                $url = 'http://hnt4adm.vh.nays.ru/cms/default/apiGetProducts?limit=' . $limit . '&offset=' . $offset . '&lastUpdate=' . $lastUpdate;
                $domain = 'http://hnt4adm.vh.nays.ru';
                $url = 'http://cabinet.hynt.ru/cms/default/apiGetProducts?limit=' . $limit . '&offset=' . $offset . '&lastUpdate=' . $lastUpdate;
                $domain = 'http://cabinet.hynt.ru';
            }
            //M::printr("{$url}\n");
            M::printr($url, '$url');

            $ctx = stream_context_create(['http' => ['timeout' => 300]]);
            //M::printr($ctx, '$ctx');
            $products = file_get_contents($url, false, $ctx);
            //M::printr($products, '$products');
            $products = Json::decode($products, false);
            //M::printr($products, '$products');
            if (count($products) == 0) {
                break;
            }

            print "Взял товаров - " . count($products) . " шт.\n";
            $offset += count($products);
            //print "Всего товаров - " . $offset . " шт.\n";

            $JS = [
                'success' => true,
                'message' => null,
                'messages' => [],
            ];
            print "Начинаем обработку товаров.\n";
            //$transaction = Yii::app()->db->beginTransaction();
            try {
                $z = 0;
                foreach ($products as $product) {
                    M::printr($product, '$product');

                    //if ($z > 10) exit;
                    $z++;
                    M::printr($c + 1 . ' - [' . $product->id . '] ' . $product->product_name);
                    //M::printr($z, 'Номер товара');

                    //берем категорию, куда должен быть привязан данный товар
                    if (0) {
                        M::printr('Берем категорию, куда должен быть привязан данный товар');
                        //M::printr($product, '$product');
                        $criteria = new CDbCriteria();
                        $criteria->addCondition('"field"."property_name" = :field AND "properties"."property_value" = :value');
                        $criteria->params['field'] = 'external_hynt_id';
                        //$criteria->params['value'] = $product->category_external_hynt_id;
                        $oCategory = CmsTree::model()
                            ->with(
                                [
                                    'properties.field'
                                ]
                            )
                            ->find($criteria);
                        if (empty($oCategory)) {
                            M::xlog(
                                [
                                    $product,
                                    'Не найдена категория с таким external_hynt_id',
                                ],
                                'products'
                            );
                        }
                        if (empty($oCategory)) continue;
                    } else {
                        M::printr('Отключено...');
                    }

                    $oProduct = EcmProducts::find()
                        ->joinWith(
                            [
                                'fields.customField',
                                'productStore',
                                'appProduct',
                            ]
                        )
                        ->where(['external_hynt_id' => $product->product_external_hynt_id])
                        //->params(['product_external_hynt_id' => $product->product_external_hynt_id])
                        ->one();


                    //M::printr('найти или создать товар - EcmProducts');
                    //найти или создать товар - EcmProducts
                    if (1) {
                        M::printr('Найти или создать товар - EcmProducts');
                        if (empty($oProduct)) {
                            $oProduct = new EcmProducts();
                            $oProduct->external_hynt_id = $product->product_external_hynt_id;
                            $oProduct->url_alias = Translit::text($product->product_name);
                        }
                        $oProduct->product_price = $product->retail_price;
                        if ($oProduct->product_price == 0) $oProduct->product_price = null;
                        if ($oProduct->product_new_price == 0) $oProduct->product_new_price = null;
                        $oProduct->product_name = $product->product_name;
                        $oProduct->product_description = $product->product_description;
                        $oProduct->product_long_name = !empty($oProduct->product_long_name) ? $oProduct->product_long_name : $product->product_long_name;
                        if (!$oProduct->save()) {
                            M::printr($oProduct, '$oProduct');
                            $JS['messages'] = $oProduct->getErrors();
                            throw new Exception('Can`t save Product');
                        }
                        //$oProduct = EcmProducts::model()->findByPk($oProduct->id);
                        //M::printr($oProduct, '$oProduct');
                    } else {
                        M::printr('Отключено...');
                    }

                    //M::printr('найти или создать связку товар-категория - AppProducts');
                    //найти или создать связку товар-категория - AppProducts
                    if (1) {
                        M::printr('Найти или создать связку товар-категория - AppProducts...');
                        $oAppProduct = $oProduct->appProduct;
                        //M::printr($oAppProduct, '$oAppProduct');
                        if (empty($oProduct->appProduct)) {
                            $oAppProduct = new AppProducts();
                            $oAppProduct->edi_bootstrap_ref = EdiBootstrap::getDefaultBootstrap()->id;
                            $oAppProduct->ecm_products_ref = $oProduct->id;
                            //$oAppProduct->cms_tree_ref = 200; //$oCategory->id;
                            if (!$oAppProduct->save()) {
                                $JS['messages'] = $oAppProduct->getErrors();
                                throw new Exception('Can`t save AppProduct');
                            }
                        }
                    } else {
                        M::printr('Отключено...');
                    }

                    //M::printr('сохранение количества на складе');
                    //сохранение количества на складе
                    if (1) {
                        M::printr('Сохранение количества на складе...');
                        //M::printr($oProduct, '$oProduct');
                        $oProductStore = $oProduct->productStore;
                        //M::printr($oProductStore, '1 $oProductStore');
                        //M::printr($oWarehouse, '$oWarehouse');
                        if (empty($oProductStore)) {
                            $oProductStore = new EcmProductStore();
                            $oProductStore->ecm_products_ref = $oProduct->id;
                            $oProductStore->ecm_warehouse_ref = $oWarehouse->id;
                        }
                        //M::printr($oProductStore, '2 $oProductStore');
                        $oProductStore->quantity = $product->quantity;
                        if (!$oProductStore->save()) {
                            $JS['messages'] = $oProductStore->getErrors();
                            M::printr($oProductStore, '$oProductStore');
                            throw new Exception('Can`t save Product Store');
                        }
                        //M::printr($oProductStore, '3 $oProductStore');
                    } else {
                        M::printr('Отключено...');
                    }

                    //найти или создать артикул - Vendor
                    if (0) {
                        $oVendor = $oProduct->getField('1c_product_vendor');
                        //$oVendor->ecm_products_ref = $oProduct->id;
                        //$oVendor->ecm_custom_fields_ref = 5;
                        $oVendor->field_value = $product->vendor;
                        if (!$oVendor->save()) {
                            $JS['messages'] = $oVendor->getErrors();
                            throw new Exception('Can`t save Vendor');
                        }
                    }

                    //M::printr('сохранить свойства');
                    //сохранить свойства
                    if (1) {
                        M::printr('Сохранить свойства...');
                        //получить свойства, пришедшие с хинта
                        $fields = $product->fields;

                        //получить свойства локального товара и привести их в нужный вид массива
                        $oFields = $oProduct->fields;
                        $arr = [];
                        foreach ($oFields as $oField) {
                            $arr[$oField->customField->field_key] = $oField;
                        }
                        $oFields = $arr;

                        //обработать свойства, пришедшие с хинта
                        foreach ($fields as $key => $field) {
                            //изменить свойство локального товара
                            $oField = $oProduct->getField($field->field_key);
                            $oField->field_value = $field->field_value;
                            $oField->ecm_custom_field_dictionary_ref = $field->ecm_custom_field_dictionary_ref;
                            $oField->save();
                            //исключить обработанное свойство
                            unset($oFields[$field->field_key]);
                        }

                        //удалить оставшиеся свойства с локального товара
                        foreach ($oFields as $oField) {
                            $oField->delete();
                        }
                    } else {
                        M::printr('Отключено...');
                    }

                    //сохранить картинки
                    if (1) {
                        M::printr('Сохранить картинки...');
                        //M::printr(count($oImgs), 'count($oImgs)');
                        //M::printr($oImgs, '$oImgs');
                        if (!empty($product->images)) {
                            $oImgs = $oProduct->getImages();
                            foreach ($oImgs as $oImg) {
                                M::printr($oImg->attributes, '$oImg->attributes');
                                //проверить файл на существование
                                //если нет, то удалить связку
                                if (!is_file($storage . $oImg->fs_saveto)) {
                                    M::printr('Delete...');
                                    $oImg->delete();
                                }
                            }
                            $oImgs = $oProduct->getImages();
                            $oImage = false;
                            M::printr($product->images, '$product->images');
                            foreach ($product->images as $image) { //присланная картинка
                                foreach ($oImgs as $oImg) { //локальная картинка
                                    //если нет md5, то записать его
                                    if (empty($oImg->fs_md5hash)) {
                                        $oImg->fs_md5hash = md5_file($storage . $oImg->fs_saveto);
                                        $oImg->dt_updated = new Expression('NOW()');
                                        $oImg->save();
                                    }
                                    //M::printr($oImg->fs_md5hash, '$oImg');

                                    if ($oImg->fs_md5hash == $image->fs_md5hash) {
                                        $oImage = $oImg;
                                        M::printr('Такое фото уже есть...');
                                        break;
                                    }
                                }
                            }

                            //такой картинки нет
                            if (!$oImage) {
                                //скачать
                                M::printr("Скачать {$domain}/store{$image->fs_alias}");
                                $oStorage = CmsMediaStorage::addImage($domain . '/store' . $image->fs_alias, 'ecm:illustrations');
                                if (!empty($oStorage)) {
                                    //привязать картинку к товару
                                    $oStorage->bindToProduct($oProduct, 'ecm:illustrations');
                                }
                            }
                        }
                    } else {
                        M::printr('Отключено...');
                    }

                    $c++;
                    if ($c > 0 && ($c % $limit) == 0) {
                        print "Обработано {$c} товаров.\n";
                    }
                }
                //$transaction->rollback();
                //$transaction->commit();
            } catch (Exception $e) {
                $JS['success'] = false;
                $JS['message'] = $e->getMessage();
                //$JS['e'] = $e;
                //$transaction->rollback();
                M::printr($JS, '$JS');
            }
        } while (1);
        $tm_stop = microtime(true);
        M::xlog($tm_stop, 'products');
        $time = $tm_stop - $tm_start;
        $JS['total'] = "Всего " . count($products);
        //$JS['c'] = "Обработано " . $c;
        $JS['time'] = "{$time} сек.";
        M::printr($JS, '$JS');
        M::xlog($JS, 'products');
    }

    public function getProduct($oFishmenProduct) {
        $tm_start = microtime(true);
        M::xlog($tm_start, 'product');
        $storage = Yii::getPathOfAlias('storage');

        $JS = [
            'success' => true,
            'message' => null,
            'messages' => [],
        ];
        //$transaction = Yii::app()->db->beginTransaction();
        try {
            $oCategory = $this->oCategory;
            $oContent = $oCategory->content;
            $oCategoryImages = $oCategory->getImages();

            if (empty($oCategoryImages)) {
                //получить товар и картинки с хинта
                $product = $this->getHyntProduct($oFishmenProduct->external_hynt_id);
                if (empty($product)) {
                    exit;
                }
                M::printr('[' . $product->id . '] ' . $product->product_name);

                $productImages = $product->images;
                //M::printr($productImages, '$productImages');
                $productImage = null;
                if (!empty($productImages)) {
                    $productImage = $productImages[0];
                }
                if (!empty($productImage)) {
                    M::printr($productImage->fs_alias, '$productImage->fs_alias');
                    $domain = 'http://cabinet.hynt.ru';
                    if (!PRODUCTION_MODE) {
                        $domain = 'http://hnt4adm.vh.nays.ru';
                    }
                    $oStorage = CmsMediaStorage::addImage($domain . '/store' . $productImage->fs_alias);

                    if (!empty($oStorage)) {
                        $appGallery = AppGallery::addImage($oStorage->id); //создали галерею с картинкой

                        //привязать картинку к категории
                        $oNodeGallery = new CmsNodeGallery();
                        $oNodeGallery->cms_node_content_ref = $oContent->id;
                        $oNodeGallery->app_gallery_ref = $appGallery->id;
                        $oNodeGallery->save();
                        M::printr('');
                        return true;
                    }

                } else {
                    M::printr('Картинок у товара нет.');
                    M::printr('');
                }
            }

            //$transaction->rollback();
            //$transaction->commit();
        } catch (Exception $e) {
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
            //$transaction->rollback();
        }
        $tm_stop = microtime(true);
        //M::printr($JS, '$JS');
        M::xlog($JS, 'products');
    }

    public function getHyntProduct($hynt_id) {
        $url = 'http://cabinet.hynt.ru/cms/default/apiGetProduct?ecm_product=' . $hynt_id;
        $domain = 'http://cabinet.hynt.ru';
        if (!PRODUCTION_MODE) {
            $url = 'http://hnt4adm.vh.nays.ru/cms/default/apiGetProduct?ecm_product=' . $hynt_id;
            $domain = 'http://hnt4adm.vh.nays.ru';
            M::printr('NOT PRODUCTION_MODE');
        }
        M::printr($url, '$url');
        $ctx = stream_context_create(['http' => ['timeout' => 300]]);
        //M::printr($ctx, '$ctx');
        $response = file_get_contents($url, false, $ctx);
        //M::printr($products, '$products');
        $product = json_decode($response);
        return $product;
    }

}

?>
