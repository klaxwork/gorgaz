<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArEcmCustomFields;

/**
 * This is the model class for table "ecm_custom_fields".
 *
 * @property int $id
 * @property int $ecm_catalog_ref
 * @property int $ecm_custom_field_meta_ref
 * @property string $field_key
 * @property string $field_name
 * @property string $field_description
 * @property string $field_default_value
 * @property string $field_data
 * @property bool $is_visible видимость на странице товара
 * @property bool $is_form используется ли в формах
 * @property string $field_unit единица измерения
 * @property bool $is_use_filter используется ли в фильтре
 * @property bool $is_permanently Постоянное
 *
 * @property EcmCustomFieldDictionary[] $ecmCustomFieldDictionaries
 * @property EcmCustomFieldUnit[] $ecmCustomFieldUnits
 * @property EcmCatalog $ecmCatalogRef
 * @property EcmCustomFieldMeta $ecmCustomFieldMetaRef
 * @property EcmNomenclatureFields[] $ecmNomenclatureFields
 * @property EcmProductFields[] $ecmProductFields
 * @property EcmProducts[] $ecmProductsRefs
 */
class EcmCustomFields extends RArEcmCustomFields
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_custom_fields';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ecm_catalog_ref', 'ecm_custom_field_meta_ref', 'field_key', 'field_name'], 'required'],
            [['ecm_catalog_ref', 'ecm_custom_field_meta_ref'], 'default', 'value' => null],
            [['ecm_catalog_ref', 'ecm_custom_field_meta_ref'], 'integer'],
            [['field_description', 'field_default_value', 'field_data'], 'string'],
            [['is_visible', 'is_form', 'is_use_filter', 'is_permanently'], 'boolean'],
            [['field_key', 'field_name'], 'string', 'max' => 255],
            [['field_unit'], 'string', 'max' => 30],
            [['ecm_catalog_ref', 'field_key'], 'unique', 'targetAttribute' => ['ecm_catalog_ref', 'field_key']],
            [['ecm_catalog_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmCatalog::className(), 'targetAttribute' => ['ecm_catalog_ref' => 'id']],
            [['ecm_custom_field_meta_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmCustomFieldMeta::className(), 'targetAttribute' => ['ecm_custom_field_meta_ref' => 'id']],
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
            'ecm_custom_field_meta_ref' => 'Ecm Custom Field Meta Ref',
            'field_key' => 'Field Key',
            'field_name' => 'Field Name',
            'field_description' => 'Field Description',
            'field_default_value' => 'Field Default Value',
            'field_data' => 'Field Data',
            'is_visible' => 'Is Visible',
            'is_form' => 'Is Form',
            'field_unit' => 'Field Unit',
            'is_use_filter' => 'Is Use Filter',
            'is_permanently' => 'Is Permanently',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictionary()
    {
        return $this->hasMany(EcmCustomFieldDictionary::className(), ['ecm_custom_fields_ref' => 'id'])->alias('dictionary');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCustomFieldUnits()
    {
        return $this->hasMany(EcmCustomFieldUnit::className(), ['ecm_custom_fields_ref' => 'id']);
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
    public function getCustomFieldMeta()
    {
        return $this->hasOne(EcmCustomFieldMeta::className(), ['id' => 'ecm_custom_field_meta_ref'])->alias('customFieldMeta');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmNomenclatureFields()
    {
        return $this->hasMany(EcmNomenclatureFields::className(), ['ecm_custom_fields_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductFields()
    {
        return $this->hasMany(EcmProductFields::className(), ['ecm_custom_fields_ref' => 'id'])->alias('productFields');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductsRefs()
    {
        return $this->hasMany(EcmProducts::className(), ['id' => 'ecm_products_ref'])->viaTable('ecm_product_fields', ['ecm_custom_fields_ref' => 'id']);
    }

    public static function getFieldByKey($field_key)
    {
        $oField = EcmCustomFields::find()
            ->joinWith([
                'customFieldMeta',
                'dictionary'
            ])
            ->where('field_key = :field_key', [':field_key' => $field_key])
            ->one();

        return $oField;
    }


}
