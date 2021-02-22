<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "ecm_product_fields".
 *
 * @property int $id
 * @property int $ecm_products_ref
 * @property int $ecm_custom_fields_ref
 * @property int $ecm_custom_field_unit_ref
 * @property int $ecm_custom_field_dictionary_ref
 * @property string $field_value
 * @property string $field_prepare_data
 * @property string $dt_created
 * @property string $dt_updated
 * @property string $field_unit
 *
 * @property EcmCustomFieldDictionary $ecmCustomFieldDictionaryRef
 * @property EcmCustomFieldUnit $ecmCustomFieldUnitRef
 * @property EcmCustomFields $ecmCustomFieldsRef
 * @property EcmProducts $ecmProductsRef
 */
class RArEcmProductFields extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_product_fields';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ecm_products_ref', 'ecm_custom_fields_ref'], 'required'],
            [['ecm_products_ref', 'ecm_custom_fields_ref', 'ecm_custom_field_unit_ref', 'ecm_custom_field_dictionary_ref'], 'default', 'value' => null],
            [['ecm_products_ref', 'ecm_custom_fields_ref', 'ecm_custom_field_unit_ref', 'ecm_custom_field_dictionary_ref'], 'integer'],
            [['field_value', 'field_prepare_data'], 'string'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['field_unit'], 'string', 'max' => 30],
            [['ecm_products_ref', 'ecm_custom_fields_ref'], 'unique', 'targetAttribute' => ['ecm_products_ref', 'ecm_custom_fields_ref']],
            [['ecm_custom_field_dictionary_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmCustomFieldDictionary::className(), 'targetAttribute' => ['ecm_custom_field_dictionary_ref' => 'id']],
            [['ecm_custom_field_unit_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmCustomFieldUnit::className(), 'targetAttribute' => ['ecm_custom_field_unit_ref' => 'id']],
            [['ecm_custom_fields_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmCustomFields::className(), 'targetAttribute' => ['ecm_custom_fields_ref' => 'id']],
            [['ecm_products_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmProducts::className(), 'targetAttribute' => ['ecm_products_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ecm_products_ref' => 'Ecm Products Ref',
            'ecm_custom_fields_ref' => 'Ecm Custom Fields Ref',
            'ecm_custom_field_unit_ref' => 'Ecm Custom Field Unit Ref',
            'ecm_custom_field_dictionary_ref' => 'Ecm Custom Field Dictionary Ref',
            'field_value' => 'Field Value',
            'field_prepare_data' => 'Field Prepare Data',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'field_unit' => 'Field Unit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCustomFieldDictionaryRef()
    {
        return $this->hasOne(EcmCustomFieldDictionary::className(), ['id' => 'ecm_custom_field_dictionary_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCustomFieldUnitRef()
    {
        return $this->hasOne(EcmCustomFieldUnit::className(), ['id' => 'ecm_custom_field_unit_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCustomFieldsRef()
    {
        return $this->hasOne(EcmCustomFields::className(), ['id' => 'ecm_custom_fields_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductsRef()
    {
        return $this->hasOne(EcmProducts::className(), ['id' => 'ecm_products_ref']);
    }
}
