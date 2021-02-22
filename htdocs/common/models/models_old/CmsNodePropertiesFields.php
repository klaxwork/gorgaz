<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArCmsNodePropertiesFields;

/**
 * This is the model class for table "cms_node_properties_fields".
 *
 * @property int $id
 * @property string $property_name
 * @property string $property_default_value
 * @property bool $is_visible
 * @property bool $is_preload
 *
 * @property CmsNodeProperties[] $cmsNodeProperties
 */
class CmsNodePropertiesFields extends RArCmsNodePropertiesFields
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_node_properties_fields';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_name'], 'required'],
            [['property_default_value'], 'string'],
            [['is_visible', 'is_preload'], 'boolean'],
            [['property_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_name' => 'Property Name',
            'property_default_value' => 'Property Default Value',
            'is_visible' => 'Is Visible',
            'is_preload' => 'Is Preload',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNodeProperties()
    {
        return $this->hasMany(CmsNodeProperties::className(), ['cms_node_properties_fields_ref' => 'id']);
    }

    public static function getFieldByKey($property_name)
    {
        $oProp = CmsNodePropertiesFields::find()
            ->where(['property_name' => $property_name])
            ->one();
        return $oProp;
    }
}
