<?php

namespace common\models;

use \yii;
use \common\components\M;
use \common\models\models\EcmOrderProducts;
use \common\models\models\EcmOrders;
use \common\models\models\EcmProducts;
use \common\models\models\EdiBootstrap;
use \common\models\models\EdiRelationClients;
use \yii\base\Exception;
use \yii\BaseYii;
use \yii\helpers\Json;

class ProductForm extends \yii\base\Model
{
    public $id;
    public $ecm_catalog_ref;
    public $product_name = null;
    public $product_long_name = null;
    public $product_short_name = null;
    public $product_price;
    public $product_description;
    public $dt_created;
    public $dt_updated;
    public $cms_tree_ref = null;
    public $url_alias;
    public $wrs_position_weight;
    public $admin_comment;
    public $page_teaser;
    public $page_body;
    public $is_published;
    public $is_closed;
    public $seo_title;
    public $seo_keywords;
    public $seo_description;
    public $is_seo_noindexing;
    public $vendor;
    public $nomenclatureFields = [];
    public $filled_fields = 0;
    public $productFields = [];
    public $stores = [];
    public $product_teaser = null;
    public $is_trash;
    public $external_hynt_id;

    //emc_products
    //public $game_duration;
    //public $game_min_players = 0;
    //public $game_max_players = 0;
    //public $game_hardmax_players = 0;
    //public $game_hardmax_addcost = 0;
    //public $location_address;
    //public $location_metro_name;
    //public $location_data;
    //public $location_info;
    //public $contact_email;
    //public $contact_phone;
    //public $external_site_url;
    //public $external_target_url;
    //public $sms_phone;
    //public $ecm_versions_ref;
    //public $hands_orders_completed = 0;
    //public $is_use_params = false;
    //public $is_use_bonuses = false;
    //public $is_show_contact_phone = true;

    //ecm_products_has_categories
    public $ecm_categories_ref = [];

    //ecm_products_has_labels
    public $labels = [];

    //ecm_product_fields
    public $fields = [];

    public $store_teaser_image = [];

    public $image_teaser_small;
    public $images_gallery = [];
    public $images_illustrations = [];

    public $app_regions_ref;

    //параметры
    public $Params = [];
    public $commission;
    public $extraBonuses;
    public $oProduct;

    public function __construct() {
        parent::__construct();
    }

    public static function model() {
        return new self;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ecm_catalog_ref, product_name, product_price, product_description', 'required'),
            //array('factory_id', 'unique'),
            array('product_name, product_long_name, product_short_name, product_teaser', 'length', 'max' => 255),
            array('id, ecm_catalog_ref, product_name, product_price, dt_created, dt_updated, product_description, url_alias, wrs_position_weight, admin_comment, product_long_name, product_short_name, vendor, nomenclatureFields, cms_tree_ref, seo_title, seo_keywords, seo_description, is_seo_noindexing, stores, image_teaser_small, images_illustrations, product_teaser, is_closed, is_trash, external_hynt_id', 'safe'),
        );

    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'ecm_catalog_ref' => 'Каталог',
            'product_name' => 'Название',
            'product_price' => 'Цена',
            'dt_created' => 'Дата создания',
            'dt_updated' => 'Дата обновления',
            'product_description' => 'Описание товара',
            'url_alias' => 'Алиас',
            'cms_tree_ref' => 'Категория',
            'product_long_name' => 'Альтернативное название',
            'product_short_name' => 'Короткое название',
            'vendor' => 'Артикул',
            'is_seo_noindexing' => 'Запрет индексирования',
            'product_teaser' => 'Короткое описание',
            'is_closed' => 'Закрыт',
            'is_trash' => 'Удален',
            'external_hynt_id' => 'Внешний ключ',
        );
    }

    public function fromArray($array) {
        //M::printr($array, '$array');
        $this->labels = [];
        $array['is_closed'] = isset($array['is_closed']) ? true : false;
        $array['is_trash'] = isset($array['is_trash']) ? true : false;
        $array['is_seo_noindexing'] = isset($array['is_seo_noindexing']) ? true : false;

        if (empty($array['nomenclatureFields'])) {
            $array['nomenclatureFields'] = [];
        }
        if (empty($array['images_illustrations'])) {
            $array['images_illustrations'] = [];
        }
        if (isset($array['labels'])) {
            $this->labels = $array['labels'];
        }

        $this->setAttributes($array);

        if (isset($array['labels'])) {
            $this->labels = $array['labels'];
        }
        //$this->images_gallery = $array['images_gallery'];

        //M::printr($array, '$array');
        //M::printr($this, '$this');
    }

    public function save() {
        $oProduct = new \common\models\models\EcmProducts();
        if ((int)$this->id > 0) {
            $oProduct = EcmProducts::model()->with(
                [
                    'appProduct.hasGallery.gallery.category',
                    'appProduct.hasGallery.gallery.storage.contentType',
                    'appProduct.tree',

                ]
            )->findByPk($this->id);

            if (empty($oProduct)) {
                $oProduct = new EcmProducts();
            }
        }
        if (empty($oProduct->ecm_catalog_ref)) {
            $oCatalog = EcmCatalog::model()->find('catalog_key = :value', [':value' => 'default']);
            $oProduct->ecm_catalog_ref = $oCatalog->id;
        }
        $oProduct->setAttributes($this->attributes);
        $this->oProduct = $oProduct;

        if ($oProduct->product_price == 0) $oProduct->product_price = null;
        if ($oProduct->product_new_price == 0) $oProduct->product_new_price = null;
        if (!$oProduct->save()) {
            //M::printr($oProduct->getErrors(), '!$oProduct->save() => $oProduct->getErrors()');
            $this->addErrors($oProduct->getErrors());
            throw new Exception('Не удается сохранить данные товара.'); //EcmProducts;
        }
        $this->id = $oProduct->id;
        //M::printr($this->id, '$this->id');

        $appProduct = $oProduct->appProduct;
        //M::printr($appProduct, '$appProduct');

        $appProduct->cms_tree_ref = !empty($this->cms_tree_ref) ? $this->cms_tree_ref : null;
        if (!$appProduct->save()) {
            $this->addErrors($appProduct->getErrors());
            throw new Exception('Can`t save data in AppProducts');
        }

        //сохранить метки
        if (!$this->saveLabels()) {
            throw new Exception('Can`t save labels...');
        }

        //M::printr($oProduct, '$oProduct');
        if (!$this->saveFields()) {
            $this->addErrors($oProduct->getErrors());
            throw new Exception('Can`t save Fields');
        }
        $percent = 0;
        if (count($this->nomenclatureFields) > 0) {
            $percent = 100 * $this->filled_fields / count($this->nomenclatureFields);
        }
        $oProduct->filled_fields = $percent;
        $oProduct->save();
        //M::printr($oProduct, '$oProduct');

        //сохранить артикул
        $oField = $this->getFieldValue('1c_product_vendor')->productField;
        //M::printr($oField, '$oField');
        $oField->field_value = $this->vendor;
        $oField->save();

        //сохранить склады
        if (!$this->saveStores($oProduct->productStores)) {
            throw new Exception('Some problems in saveStores');
        }

        //сохранить картинки галереи
        //M::printr($oProduct, '$oProduct');
        if (!$this->saveImages($oProduct->appProduct)) {
            throw new Exception('Some problems in saveImages');
        }
        return true;
    }

    public function saveLabels() {

        $oProductLabels = $this->oProduct->getLabels();
        //M::xlog(['$this->labels', $this->labels]);
        //пройтись по новым меткам
        foreach ($this->labels as $key => $value) {
            //если метки нет в товаре
            if (empty($oProductLabels[$key])) {
                //создать
                $oLabel = EcmLabels::getLabelByKey($key);
                $oHasLabel = new EcmProductHasLabels();
                $oHasLabel->ecm_products_ref = $this->id;
                $oHasLabel->ecm_labels_ref = $oLabel->id;
                if (!$oHasLabel->save()) {
                    throw new Exception('Can`t save label...');
                }
            } else {
                //убрать из списка $oProductLabels
                unset($oProductLabels[$key]);
            }
        }
        //оставшиеся в $oProductLabels удалить
        foreach ($oProductLabels as $oProductLabel) {
            $oProductLabel->delete();
        }

        return true;
    }

    public function saveImages($oAppProduct) {
        //удалить все картинки квеста из app_product_has_gallery
        AppProductHasGallery::model()->deleteAllByAttributes(array('app_products_ref' => $oAppProduct->id));

        if (!empty($this->image_teaser_small)) {
            //сохранить $this->image_teaser_small
            //M::printr($oImages, '$oImages');
            //по картинке получить галерею
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(
                array(
                    'edi_bootstrap_ref' => EdiBootstrap::getDefaultBootstrap()->id,
                    'cms_media_storage_ref' => $this->image_teaser_small,
                )
            );
            $oGallery = AppGallery::model()->with(
                [
                    'hasProducts'
                ]
            )->find($criteria);
            //если галереи нет
            if (empty($oGallery)) {
                //создать
                $oGallery = new AppGallery();
                $oGallery->edi_bootstrap_ref = EdiBootstrap::getDefaultBootstrap()->id;
                $oGallery->cms_media_storage_ref = $this->image_teaser_small;
            }

            $oImageCategory = AppGalleryCategories::model()->findByAttributes(['dev_key' => 'ecm:teaser_small']);
            //заполнить новыми данными
            $oGallery->app_gallery_categories_ref = $oImageCategory->id;
            $oGallery->dt_updated = new CDbExpression('now()');
            if (!$oGallery->save()) {
                $this->addErrors($oGallery->getErrors());
                throw new Exception('Can`t save data in AppGallery');
            }

            //получить продукты
            if (!empty($oGallery->hasProducts)) {
                $oProductHasGallery = $oGallery->hasProducts;
            } else {
                //если у галереи нет пользователей
                $oProductHasGallery = new AppProductHasGallery();
            }
            $oProductHasGallery->app_gallery_ref = $oGallery->id;
            $oProductHasGallery->app_products_ref = $oAppProduct->id;
            if (!$oProductHasGallery->save()) {
                $this->addErrors($oProductHasGallery->getErrors());
                throw new Exception('Can`t save data in AppProductHasGallery');
            }
        }

        //M::xlog(['$this->images_illustrations', $this->images_illustrations], 'img');
        if (!empty($this->images_illustrations)) {
            $position = 100;
            foreach ($this->images_illustrations as $illustration) {
                //по картинке получить галерею
                $criteria = new CDbCriteria();
                $criteria->addColumnCondition(
                    array(
                        'edi_bootstrap_ref' => EdiBootstrap::getDefaultBootstrap()->id,
                        'cms_media_storage_ref' => $illustration['image_id'],
                    )
                );
                $oGallery = AppGallery::model()->find($criteria);
                if (empty($oGallery)) {
                    $oGallery = new AppGallery();
                    $oGallery->edi_bootstrap_ref = EdiBootstrap::getDefaultBootstrap()->id;
                    $oGallery->cms_media_storage_ref = $illustration['image_id'];
                }
                //M::xlog(['$oGallery', $oGallery]);
                //M::xlog(['$illustration', $illustration]);

                $oGallery->app_gallery_categories_ref = $illustration['category_id'];
                $oGallery->dt_updated = new CDbExpression('now()');
                $oGallery->on_view_position = $position;
                $position += 100;
                if (!$oGallery->save()) {
                    //M::printr($oGallery, '$oGallery');
                    $this->addErrors($oGallery->getErrors());
                    throw new Exception('Can`t save data in AppGallery');
                }

                if (!empty($oGallery->hasProducts)) {
                    $oProductHasGallery = $oGallery->hasProducts;
                } else {
                    $oProductHasGallery = new AppProductHasGallery();
                }
                $oProductHasGallery->app_gallery_ref = $oGallery->id;
                $oProductHasGallery->app_products_ref = $oAppProduct->id;
                if (!$oProductHasGallery->save()) {
                    $this->addErrors($oProductHasGallery->getErrors());
                    throw new Exception('Can`t save data in AppProductHasGallery');
                }
            }
        }

        return true;
    }

    public function saveStores($oStores) {
        //M::printr($oProduct->productStores, '$oProduct');
        foreach ($oStores as $oStore) {
            $oStore->quantity = $this->stores[$oStore->id]['quantity'];
            if (!$oStore->save()) {
                $this->addErrors($oStore->getErrors());
                throw new Exception('Can`t save data in EcmProductStore');
            }
        }
        return true;
    }

    public function saveFields() {
        //M::printr($this->nomenclatureFields, '$this->nomenclatureFields');
        /**
         *этот кусок кода загадочного предназначения оставлен в назидание потомкам.
         *
         * $criteria = new CDbCriteria();
         * $criteria->addCondition('"customField"."is_permanently" IS FALSE');
         * $criteria->addCondition('"t"."ecm_products_ref" = ' . $this->id);
         * $oFields = EcmProductFields::model()
         * ->with(['customField'])
         * //->deleteAll($criteria);
         * ->findAll($criteria);
         * foreach ($oFields as $oField) {
         * $oField->delete();
         * }*/
        //M::printr($oFields, 'DELETED $oFields');
        //M::printr($this->nomenclatureFields, '$this->nomenclatureFields');
        foreach ($this->nomenclatureFields as $field) {
            //M::printr($field, '$field');
            $field['value'] = trim($field['value']);
            if (empty($field['value'])) {
                //var_dump($field);
                $criteria = new CDbCriteria();
                $criteria->addCondition('ecm_products_ref = :product_id');
                $criteria->addCondition('"t"."ecm_custom_fields_ref" = :field_type');
                $criteria->params = array(
                    ':product_id' => $this->id,
                    ':field_type' => $field['ecm_custom_fields_ref']
                );
                $oField = EcmProductFields::model()->find($criteria);
                //var_dump($oField);
                if (!empty($oField)) {
                    $oField->delete();
                }
            } else {
                $this->saveField($field);
            }
        }
        return true;
    }

    public function saveField($field) {
        $dbFields = EcmCustomFields::model()
            ->with(
                [
                    'customFieldMeta',
                    'dictionary',
                ]
            )
            ->findByPk($field['ecm_custom_fields_ref']);
        $criteria = new CDbCriteria;
        $criteria->addCondition('ecm_products_ref = :product_id');
        $criteria->addCondition('ecm_custom_fields_ref = :field_type');
        $criteria->params = array(
            ':product_id' => $this->id,
            ':field_type' => $field['ecm_custom_fields_ref']
        );
        $oField = EcmProductFields::model()->find($criteria);
        if (empty($oField)) {
            $oField = new EcmProductFields();
            $oField->ecm_products_ref = $this->id;
            $oField->ecm_custom_fields_ref = $field['ecm_custom_fields_ref'];
        }
        if ($dbFields->field_key == "manufacture") {
            /*if($oField->ecm_custom_field_dictionary_ref != $field['value']){
                $this->rewriteFilter($oField->ecm_custom_field_dictionary_ref, $field['value']);
            }*/
            $oField->ecm_custom_field_dictionary_ref = (int)$field['value'];
            //var_dump($oField);
        } elseif ($dbFields->customFieldMeta->field_meta == 'dictionary/list') {
            $oField->ecm_custom_field_dictionary_ref = $field['value'];
        } elseif ($dbFields->customFieldMeta->field_meta == 'variable/range') {
            if (strpos($field['value'], ':') !== false) {
                $oField->field_value = "{$field['value']}";
            } else {
                $oField->field_value = "{$field['value']}:{$field['value']}";
            }
        } else {
            $oField->field_value = $field['value'];
        }
        if (!$oField->save()) {
            $this->addErrors($oField->getErrors());
            throw new Exception('Can`t save data in EcmProductFields');
        }
        //M::printr($oField, '$oField');
        $this->filled_fields++;

        return true;
    }

    /*public function rewriteFilter($old_id_brand, $new_id_brand)
    {
        //echo "ID старого бренда $old_id_brand ||| ID нового бренда $new_id_brand <br>";

    }*/

    public function getProduct($ecm_product_ref) {
        //M::printr($ecm_product_ref, '$ecm_product_ref');

        $oProduct = EcmProducts::find()
            //->with([])
            ->where(['id' => $ecm_product_ref])
            ->one();
        //M::printr($oProduct, '$oProduct');

        if (empty($oProduct)) {
            return false;
        }

        $model = new self;
        //взять только нужные данные и занести в модель
        $model->setAttributes($oProduct->attributes, true);
        //M::printr($model, '$model');
        $model->getProductFields();
        $model->cms_tree_ref = $oProduct->appProduct->cms_tree_ref;

        //заполнить image_teaser_small
        //относительно hasGallery->gallery->storage->category
        $images = $oProduct->appProduct->hasGallery;

        $model->labels = $oProduct->getLabels();
        //M::printr($model->labels, '$model->labels');

        //получить картинки тизеров и иллюстраций
        //$this->image_teaser_big
        $x = '1';
        foreach ($oProduct->appProduct->hasGallery as $oImage) {
            if ($oImage->gallery->category->dev_key == 'qw:teaser_big') {
                $model->image_teaser_big = $oImage->gallery->storage->id;
            }
            if ($oImage->gallery->category->dev_key == 'ecm:teaser_small') {
                $model->image_teaser_small = $oImage->gallery->storage->id;
            }
            if ($oImage->gallery->category->dev_key == 'qw:teaser_top') {
                $model->image_teaser_top = $oImage->gallery->storage->id;
            }
            if ($oImage->gallery->category->dev_key == 'ecm:illustrations') {
                $model->images_illustrations['x' . $x] = $oImage->gallery->storage->id;
            }
            $x++;
        }


        return $model;
    }

    public function getProductFields() {
        //M::printr($this, '$this');
        $this->productFields = EcmProducts::model()
            ->with(['fields.customField', 'fields.customFieldDict'])
            ->findByPk($this->id)->fields;
    }

    public function getNomenclatureFields() {
        $criteria = new CDbCriteria();
        $oProps = EcmProducts::model()
            ->with(
                [
                    //'appProduct.tree.appNomenclature.ecmNomenclature.fields.customField',
                    'appProduct.tree.appNomenclature.ecmNomenclature.fields.customField.customFieldMeta',
                    'appProduct.tree.appNomenclature.ecmNomenclature.fields.customField.dictionary',
                ]
            )
            ->findByPk($this->id);
        //M::printr($oProps, '$oProps');
        if (empty($oProps->appProduct->tree->appNomenclature)) {
            return [];
        }
        return $oProps->appProduct->tree->appNomenclature->ecmNomenclature->fields;
    }

    public function getPropValues() {

    }

    public function getFieldValue($field_key) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('"productField"."ecm_products_ref" = :id');
        $criteria->addCondition('"t"."field_key" = :field_key');
        $criteria->params = [':id' => $this->id, ':field_key' => $field_key];
        $oField = EcmCustomFields::model()->with(['customFieldMeta', 'productField', 'dictionary'])->find($criteria);
        return $oField;
    }

    public function getPrice() {
        $criteria = new CDbCriteria();
        $oField = EcmProductFields::model()->with(['customFieldMeta', 'productField', 'dictionary'])->find($criteria);
        return $oField;
    }

    public function getCategory() {
        //M::printr($this, '$this');
        $oCategory = EcmProducts::model()
            ->with(
                [
                    'appProduct.tree',
                ]
            )
            ->findByPk($this->id);
        //M::printr($oCategories, '$oCategories ???');
        return $oCategory->appProduct->tree;
    }


}