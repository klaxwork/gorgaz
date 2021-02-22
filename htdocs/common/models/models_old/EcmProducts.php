<?php

namespace common\models\models;

use common\models\Cart;
use common\models\Wish;
use Yii;
use common\models\ar\RArEcmProducts;
use common\components\M;

/**
 * This is the model class for table "ecm_products".
 *
 * @property int $id
 * @property int $ecm_catalog_ref
 * @property string $product_name
 * @property double $product_price
 * @property string $dt_created
 * @property string $dt_updated
 * @property bool $is_closed
 * @property int $ecm_versions_ref Версия интеграции
 * @property string $rating
 * @property bool $is_use_params
 * @property bool $is_use_bonuses
 * @property int $wrs_position_weight
 * @property string $product_description
 * @property string $product_long_name Альтернативное название товара
 * @property int $filled_fields сколько процентов полей заполнено
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property bool $is_seo_noindexing
 * @property string $url_alias
 * @property bool $is_trash
 * @property string $product_teaser Короткое описание
 * @property string $product_short_name
 * @property string $external_hynt_id
 * @property double $product_new_price
 *
 * @property AppProducts[] $appProducts
 * @property AppQuestComments[] $appQuestComments
 * @property AppQuests[] $appQuests
 * @property EbsTimeline[] $ebsTimelines
 * @property EcmCartProducts[] $ecmCartProducts
 * @property EcmOrderProducts[] $ecmOrderProducts
 * @property EcmProductFields[] $ecmProductFields
 * @property EcmCustomFields[] $ecmCustomFieldsRefs
 * @property EcmProductHasCategories[] $ecmProductHasCategories
 * @property EcmProductHasLabels[] $ecmProductHasLabels
 * @property EcmProductStore[] $ecmProductStores
 * @property EcmCatalog $ecmCatalogRef
 * @property EcmVersions $ecmVersionsRef
 * @property EcmWishProducts[] $ecmWishProducts
 * @property VbsParamsProduct[] $vbsParamsProducts
 */
class EcmProducts extends RArEcmProducts
{

    public $cms_tree_ref = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ecm_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            //[['ecm_versions_ref', 'filled_fields'], 'default', 'value' => null],
            //[['ecm_catalog_ref', 'ecm_versions_ref', 'wrs_position_weight', 'filled_fields'], 'integer'],
            [['product_name'], 'required'],
            [['product_price', 'rating', 'product_new_price'], 'number'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['is_closed', 'is_use_params', 'is_use_bonuses', 'is_seo_noindexing', 'is_trash'], 'boolean'],
            [['product_description', 'product_long_name', 'seo_description'], 'string'],
            [['product_name', 'seo_title', 'seo_keywords', 'url_alias', 'product_teaser', 'product_short_name'], 'string', 'max' => 255],
            //[['ecm_catalog_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmCatalog::className(), 'targetAttribute' => ['ecm_catalog_ref' => 'id']],
            //[['ecm_versions_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmVersions::className(), 'targetAttribute' => ['ecm_versions_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ecm_catalog_ref' => 'Ecm Catalog Ref',
            'product_name' => 'Product Name',
            'product_price' => 'Product Price',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'is_closed' => 'Is Closed',
            'ecm_versions_ref' => 'Ecm Versions Ref',
            'rating' => 'Rating',
            'is_use_params' => 'Is Use Params',
            'is_use_bonuses' => 'Is Use Bonuses',
            'wrs_position_weight' => 'Wrs Position Weight',
            'product_description' => 'Product Description',
            'product_long_name' => 'Product Long Name',
            'filled_fields' => 'Filled Fields',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'is_seo_noindexing' => 'Is Seo Noindexing',
            'url_alias' => 'Url Alias',
            'is_trash' => 'Is Trash',
            'product_teaser' => 'Product Teaser',
            'product_short_name' => 'Product Short Name',
            'external_hynt_id' => 'External Hynt ID',
            'product_new_price' => 'Product New Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppProduct() {
        return $this->hasOne(AppProducts::className(), ['ecm_products_ref' => 'id'])->alias('appProduct');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppProducts() {
        return $this->hasMany(AppProducts::className(), ['ecm_products_ref' => 'id'])->alias('appProducts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments() {
        return $this->hasMany(AppComments::className(), ['ecm_products_ref' => 'id'])->alias('comments');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppQuestComments() {
        return $this->hasMany(AppQuestComments::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppQuests() {
        return $this->hasMany(AppQuests::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEbsTimelines() {
        return $this->hasMany(EbsTimeline::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCartProducts() {
        return $this->hasMany(EcmCartProducts::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmOrderProducts() {
        return $this->hasMany(EcmOrderProducts::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFields() {
        return $this->hasMany(EcmProductFields::className(), ['ecm_products_ref' => 'id'])->alias('fields');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCustomFieldsRefs() {
        return $this->hasMany(EcmCustomFields::className(), ['id' => 'ecm_custom_fields_ref'])->viaTable('ecm_product_fields', ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductHasCategories() {
        return $this->hasMany(EcmProductHasCategories::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHasLabels() {
        return $this->hasMany(EcmProductHasLabels::className(), ['ecm_products_ref' => 'id'])->alias('hasLabels');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductStore() {
        return $this->hasOne(EcmProductStore::className(), ['ecm_products_ref' => 'id'])->alias('productStore');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCatalogRef() {
        return $this->hasOne(EcmCatalog::className(), ['id' => 'ecm_catalog_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmVersionsRef() {
        return $this->hasOne(EcmVersions::className(), ['id' => 'ecm_versions_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmWishProducts() {
        return $this->hasMany(EcmWishProducts::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVbsParamsProducts() {
        return $this->hasMany(VbsParamsProduct::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHasGallery() {
        return $this->hasOne(EcmProductHasGallery::className(), ['ecm_products_ref' => 'id'])->alias('hasGallery');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHasGalleries() {
        return $this->hasMany(EcmProductHasGallery::className(), ['ecm_products_ref' => 'id'])->alias('hasGalleries');
    }

    public function getProductFields($id = false) {
        $in_db = false;
        if (!empty($this->fields)) {
            $oFields = $this->fields;
            usort($oFields, function ($item1, $item2) {
                return strcmp($item1->customField->field_name, $item2->customField->field_name) > 0;
            }
            );
            return $oFields;
        }
        if (empty($this->fields)) {
            $in_db = true;
        }
        if (!$id) {
            $id = $this->id;
        }
        M::printr($in_db, '$in_db');
        if ($in_db) {
            $oProduct = $this->find()
                ->alias('product')
                ->joinWith(
                    [
                        'fields.customField.customFieldMeta',
                        'fields.customFieldDict',
                        //'fields.customFieldUnit',
                    ]
                )
                ->where(
                    [
                        'product.id' => $id,
                        //'product.is_published' => true
                    ]
                )
                ->orderBy('customField.field_name ASC')
                ->one();
            //M::printr($oProduct, '$oProduct');

            if (0) {
                $criteria = new CDbCriteria();
                $criteria->addCondition('t.id = :id');
                $criteria->params['id'] = $id;
                $criteria->order = 'customField.field_name ASC';
                $criteria->with = [
                    'fields.customField.customFieldMeta',
                    'fields.customFieldDict',
                    //'fields.customFieldUnit',
                    //'appProduct.nomenclature.fields',
                ];
                $oProduct = $this->find($criteria);
            }
            return $oProduct->fields;
        } else {
            return $this->fields;
        }
    }

    public function getField($field_key) {
        $oFields = $this->getProductFields();
        foreach ($oFields as $oField) {
            if (!empty($oField->customField) && $oField->customField->field_key == $field_key) {
                return $oField;
            }
        }

        $oCustomField = EcmCustomFields::getFieldByKey($field_key);
        //$oField = EcmProductFields::model()->findByAttributes(['ecm_products_ref' => $this->id, 'ecm_custom_fields_ref' => $oCustomField->id]);
        $oField = EcmProductFields::find()
            ->where(
                [
                    'ecm_products_ref' => $this->id,
                    'ecm_custom_fields_ref' => $oCustomField->id
                ]
            )->one();

        if (!empty($oField)) {
            return $oField;
        }

        $oCustomField = EcmCustomFields::getFieldByKey($field_key);
        //$oField = EcmProductFields::model()->findByAttributes(['ecm_products_ref' => $this->id, 'ecm_custom_fields_ref' => $oCustomField->id]);
        $oField = EcmProductFields::find()->where(
            [
                'ecm_products_ref' => $this->id,
                'ecm_custom_fields_ref' => $oCustomField->id
            ]
        )
            ->one();
        if (!empty($oField)) {
            return $oField;
        }
        $oField = new EcmProductFields();
        $oField->ecm_products_ref = $this->id;
        $oField->ecm_custom_fields_ref = $oCustomField->id;
        $oField->save();
        return $oField;
    }

    public function getImages() {
        //выбираем все картинки данного контента
        $query = EcmProductHasGallery::find()
            ->alias('productHasGalleries')
            ->where('ecm_products_ref = :id', [':id' => $this->id])
            ->joinWith(
                [
                    'storage', //.croppeds.cropped.category',
                ]
            )
            ->orderBy(['on_view_position' => SORT_ASC]);

        $oHasGalleries = $query->all();
        //M::printr($oHasGalleries, '$oHasGalleries');

        if (empty($oHasGalleries)) {
            return [];
        }

        //вносим их в один массив
        $images = [];
        foreach ($oHasGalleries as $oHasGallery) {
            //M::printr($oHasGallery, '$oHasGallery');
            if (!empty($oHasGallery->storage)) {
                //$oStorage = $oHasGallery->storage;
                $images[] = $oHasGallery->storage;
            }

            if (0) {
                if (empty($oHasGallery->cms_media_storage_ref) && !empty($oHasGallery->gallery)) {
                    $oGal = $oHasGallery->gallery;
                    $oHasGallery->cms_media_storage_ref = $oGal->cms_media_storage_ref;
                    if (!$oHasGallery->save()) {
                        M::printr($oHasGallery, '$oHasGallery');
                    }
                }
            }
            //M::printr($oStorage, '$oStorage');
        }
        return $images;
    }

    public function getImages2() {
        $oImages = $this->afterFind()
            ->alias('product')
            ->with(
                [
                    'hasGallery.gallery.storage.croppeds.cropped',
                    'hasGallery.gallery.category',
                ]
            )
            ->where('product.id = :id', [':id' => $this->id])
            ->all();

        M::printr($oImages, '$oImages');
        exit;

        if (0) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('"t"."id" = ' . $this->id);
            $criteria->addCondition('"gallery"."app_gallery_categories_ref" IS NOT NULL');
            $oImages = $this->with(
                [
                    'hasGallery.gallery.storage.croppeds.cropped',
                    'hasGallery.gallery.category',
                ]
            )->find($criteria);
            if (!empty($oImages->hasGallery)) {
                $images = [];
                foreach ($oImages->hasGallery as $oGallery) {
                    //M::printr($oGallery->gallery->category->dev_key, '$oGallery->gallery->category->dev_key');
                    if ($oGallery->gallery->category->is_multiple) {
                        if (!isset($images[$oGallery->gallery->category->dev_key])) {
                            $images[$oGallery->gallery->category->dev_key] = [];
                        }
                        $images[$oGallery->gallery->category->dev_key][] = $oGallery->gallery;
                    } else {
                        $images[$oGallery->gallery->category->dev_key] = $oGallery->gallery;
                    }
                }
                //M::printr($images, '$images');
                return $images;
            }
        }

        return [];
    }

    public function getImgs() {
        M::printr($this, '$this');
        $oImages = $this->find()
            ->alias('product')
            ->with(
                [
                    'hasGallery.gallery.storage.croppeds.cropped',
                    'hasGallery.gallery.category',
                ]
            )
            ->where('product.id = :id', [':id' => $this->id])
            ->all();
        M::printr($oImages, '$oImages');
        exit;

        M::printr($oImages, '$oImages');
        exit;
        if (0) {
            //$oGalleryCategory = AppGalleryCategories::model()->findByAttributes(['dev_key' => $key]);
            $storages = [];
            if (!empty($this->hasGallery)) {
                foreach ($this->hasGallery as $hasGallery) {
                    $storages[] = $hasGallery->gallery->storage;
                }
                return $storages;
            }


            $criteria = new CDbCriteria();
            //M::xlog(['ecmProguct'=> $this]);
            if (empty($this)) {
                //return array();
            }
            $criteria->addCondition('"t"."id" = ' . $this->id);
            //$criteria->addCondition('"category"."dev_key" = :key');
            //$criteria->params[':key'] = $key;
            //M::printr($criteria, '$criteria');
            $oImages = $this->with(
                [
                    'hasGallery.gallery.storage.croppeds.cropped',
                    'hasGallery.gallery.category',
                ]
            )->find($criteria);

            $images = [];
            if (!empty($oImages)) {
                $oGallery = $oImages->hasGallery;
                //M::printr($oGallery, '$oGallery');

                foreach ($oGallery as $Gal) {
                    $images[] = $Gal->gallery->storage;
                }
                //M::printr($images, '$images');
            }
            return $images;
        }
    }

    public function getProductComments($limit = false, $offset = 0) {
        $oQuery = AppComments::find()
            ->alias('comment')
            ->with(
                [
                    //'relationClient',
                    'relationClient.client',
                ]
            )
            ->where(
                [
                    'ecm_products_ref' => $this->id,
                    'comment.is_published' => true,
                ]
            )
            ->orderBy('comment.dt_created ASC')
            ->limit($limit)
            ->offset($offset);
        $oComments = $oQuery->all();

        return $oComments;
    }

    public function getCommentsCount($ecm_products_ref = null) {
        if (empty($ecm_products_ref)) {
            $ecm_products_ref = $this->id;
        }

        $oCountComments = AppComments::find()
            ->where(['ecm_products_ref' => $ecm_products_ref, 'is_published' => true, 'is_trash' => false])
            ->count();
        return $oCountComments;

        return AppQuestComments::model()
            ->cache(7200, \CmsTree\Cache\Dependency::instance())
            ->count($criteria);
    }

    public function getLabels($from_base = false) {
        $oHasLabels = [];
        if ($from_base) {
            $oHasLabels = EcmProductHasLabels::find()
                ->joinWith(['label'])
                ->where(['ecm_products_ref' => $this->id])
                ->all();
        } else {
            if (empty($this->hasLabels)) {
                $oHasLabels = $this->hasLabels;
            } else {
                $oHasLabels = EcmProductHasLabels::find()
                    ->joinWith(['label'])
                    ->where(['ecm_products_ref' => $this->id])
                    ->all();
            }
        }
        //$hasLabels = $this->hasLabels;
        $labels = [];
        if (!empty($oHasLabels)) {
            foreach ($oHasLabels as $oHasLabel) {
                $labels[$oHasLabel->label->label_key] = $oHasLabel;
            }
        }
        return $labels;
    }

    public function getProductCount() {
        if (!empty($this->productStore)) {
            $oStore = $this->productStore;
        } else {
            $oProduct = $this->find()
                ->joinWith(['productStore'])
                ->where(['id' => $this->id])
                ->one();
            $oStore = $oProduct->productStore;
        }
        return $oStore->quantity;
    }

    public function countProductPrice() {
        $price = $this->product_price;
        $oLabels = $this->getLabels(true);
        $is_sale = !empty($oLabels['is_sale']) ? 1 : 0;
        if ($is_sale) {
            $price = ceil($this->product_new_price);
        }

        return $price;
    }

    public function genProducts($oCategory) {
        $oWish = (new Wish())->give();
        $oWishProducts = $oWish->wishProducts;
        $oCart = (new Cart())->give();
        $oCartProducts = $oCart->cartProducts;
        $oProducts = $oCategory->getProducts();
        $products = [];
        foreach ($oProducts as $oProduct) {
            $product = $oProduct->attributes;
            $product['product_price'] = (int)$product['product_price'];
            $product['product_new_price'] = (int)$product['product_new_price'];
            $oFields = $oProduct->getFields();
            $oVendor = $oProduct->getField('1c_product_vendor');
            $product['vendor'] = $oVendor->field_value;
            $oLabels = $oProduct->getLabels();
            $product['labels'] = [];
            foreach ($oLabels as $oLabel) {
                $product['labels'][$oLabel->label->label_key] = $oLabel->attributes;
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

}
