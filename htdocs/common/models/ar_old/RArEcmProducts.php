<?php

namespace common\models\ar;

use Yii;

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
class RArEcmProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ecm_catalog_ref', 'ecm_versions_ref', 'wrs_position_weight', 'filled_fields'], 'default', 'value' => null],
            [['ecm_catalog_ref', 'ecm_versions_ref', 'wrs_position_weight', 'filled_fields'], 'integer'],
            [['product_name'], 'required'],
            [['product_price', 'rating', 'product_new_price'], 'number'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['is_closed', 'is_use_params', 'is_use_bonuses', 'is_seo_noindexing', 'is_trash'], 'boolean'],
            [['product_description', 'product_long_name', 'seo_description'], 'string'],
            [['product_name', 'seo_title', 'seo_keywords', 'url_alias', 'product_teaser', 'product_short_name', 'external_hynt_id'], 'string', 'max' => 255],
            [['ecm_catalog_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmCatalog::className(), 'targetAttribute' => ['ecm_catalog_ref' => 'id']],
            [['ecm_versions_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmVersions::className(), 'targetAttribute' => ['ecm_versions_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
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
    public function getAppProducts()
    {
        return $this->hasMany(AppProducts::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppQuestComments()
    {
        return $this->hasMany(AppQuestComments::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppQuests()
    {
        return $this->hasMany(AppQuests::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEbsTimelines()
    {
        return $this->hasMany(EbsTimeline::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCartProducts()
    {
        return $this->hasMany(EcmCartProducts::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmOrderProducts()
    {
        return $this->hasMany(EcmOrderProducts::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductFields()
    {
        return $this->hasMany(EcmProductFields::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCustomFieldsRefs()
    {
        return $this->hasMany(EcmCustomFields::className(), ['id' => 'ecm_custom_fields_ref'])->viaTable('ecm_product_fields', ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductHasCategories()
    {
        return $this->hasMany(EcmProductHasCategories::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductHasLabels()
    {
        return $this->hasMany(EcmProductHasLabels::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductStores()
    {
        return $this->hasMany(EcmProductStore::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCatalogRef()
    {
        return $this->hasOne(EcmCatalog::className(), ['id' => 'ecm_catalog_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmVersionsRef()
    {
        return $this->hasOne(EcmVersions::className(), ['id' => 'ecm_versions_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmWishProducts()
    {
        return $this->hasMany(EcmWishProducts::className(), ['ecm_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVbsParamsProducts()
    {
        return $this->hasMany(VbsParamsProduct::className(), ['ecm_products_ref' => 'id']);
    }
}
