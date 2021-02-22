<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "cms_node_binding".
 *
 * @property int $id
 * @property int $cms_tree_ref
 * @property string $dev_key
 * @property string $bind_key
 * @property string $data
 * @property string $mode - modes: HANDLER,WORKER, ROUTER, BRANCH, MODULE
 * @property string $description
 *
 * @property CmsTree $cmsTreeRef
 */
class RArCmsNodeBinding extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_node_binding';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cms_tree_ref'], 'required'],
            [['cms_tree_ref'], 'default', 'value' => null],
            [['cms_tree_ref'], 'integer'],
            [['data', 'description'], 'string'],
            [['dev_key', 'bind_key'], 'string', 'max' => 255],
            [['mode'], 'string', 'max' => 10],
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
            'dev_key' => 'Dev Key',
            'bind_key' => 'Bind Key',
            'data' => 'Data',
            'mode' => 'Mode',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsTreeRef()
    {
        return $this->hasOne(CmsTree::className(), ['id' => 'cms_tree_ref']);
    }
}
