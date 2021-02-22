<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArCmsNodeProperties;

/**
 * This is the model class for table "cms_node_properties".
 *
 * @property int $id
 * @property int $cms_tree_ref
 * @property int $cms_node_properties_fields_ref
 * @property string $property_value
 *
 * @property CmsNodePropertiesFields $cmsNodePropertiesFieldsRef
 * @property CmsTree $cmsTreeRef
 */
class CmsNodeProperties extends RArCmsNodeProperties
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_node_properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cms_tree_ref', 'cms_node_properties_fields_ref'], 'required'],
            [['cms_tree_ref', 'cms_node_properties_fields_ref'], 'default', 'value' => null],
            [['cms_tree_ref', 'cms_node_properties_fields_ref'], 'integer'],
            [['property_value'], 'string'],
            [['cms_node_properties_fields_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsNodePropertiesFields::className(), 'targetAttribute' => ['cms_node_properties_fields_ref' => 'id']],
            [['cms_tree_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsTree::className(), 'targetAttribute' => ['cms_tree_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cms_tree_ref' => 'Cms Tree Ref',
            'cms_node_properties_fields_ref' => 'Cms Node Properties Fields Ref',
            'property_value' => 'Property Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(CmsNodePropertiesFields::className(), ['id' => 'cms_node_properties_fields_ref'])->alias('field');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTree()
    {
        return $this->hasOne(CmsTree::className(), ['id' => 'cms_tree_ref']);
    }
}
