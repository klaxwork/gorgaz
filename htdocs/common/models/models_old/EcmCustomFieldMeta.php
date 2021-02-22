<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArEcmCustomFieldMeta;

/**
 * This is the model class for table "ecm_custom_field_meta".
 *
 * @property int $id
 * @property string $field_type
 * @property string $field_meta
 *
 * @property EcmCustomFields[] $ecmCustomFields
 */
class EcmCustomFieldMeta extends RArEcmCustomFieldMeta
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_custom_field_meta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_type'], 'required'],
            [['field_type', 'field_meta'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_type' => 'Field Type',
            'field_meta' => 'Field Meta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCustomFields()
    {
        return $this->hasMany(EcmCustomFields::className(), ['ecm_custom_field_meta_ref' => 'id']);
    }
}
