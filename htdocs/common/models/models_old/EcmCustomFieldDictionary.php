<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArEcmCustomFieldDictionary;

/**
 * This is the model class for table "ecm_custom_field_dictionary".
 *
 * @property int $id
 * @property int $ecm_custom_fields_ref
 * @property string $field_value
 * @property string $field_value_view
 * @property string $field_expand_data
 *
 * @property EcmCustomFields $ecmCustomFieldsRef
 * @property EcmNomenclatureFields[] $ecmNomenclatureFields
 * @property EcmProductFields[] $ecmProductFields
 */
class EcmCustomFieldDictionary extends RArEcmCustomFieldDictionary
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_custom_field_dictionary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ecm_custom_fields_ref'], 'required'],
            [['ecm_custom_fields_ref'], 'default', 'value' => null],
            [['ecm_custom_fields_ref'], 'integer'],
            [['field_value', 'field_value_view', 'field_expand_data'], 'string'],
            [['ecm_custom_fields_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmCustomFields::className(), 'targetAttribute' => ['ecm_custom_fields_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ecm_custom_fields_ref' => 'Ecm Custom Fields Ref',
            'field_value' => 'Field Value',
            'field_value_view' => 'Field Value View',
            'field_expand_data' => 'Field Expand Data',
        ];
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
    public function getEcmNomenclatureFields()
    {
        return $this->hasMany(EcmNomenclatureFields::className(), ['ecm_custom_field_dictionary_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductFields()
    {
        return $this->hasMany(EcmProductFields::className(), ['ecm_custom_field_dictionary_ref' => 'id']);
    }
}
