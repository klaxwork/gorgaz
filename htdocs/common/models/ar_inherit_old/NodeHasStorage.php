<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArNodeHasStorage;

/**
 * This is the model class for table "node_has_storage".
 *
 * @property int $id
 * @property int|null $node_ref
 * @property int|null $media_storage_ref
 * @property int|null $on_view_position
 *
 * @property MediaStorage $mediaStorageRef
 * @property Tree $nodeRef
 */
class NodeHasStorage extends RArNodeHasStorage
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'node_has_storage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['node_ref', 'media_storage_ref', 'on_view_position'], 'default', 'value' => null],
            [['node_ref', 'media_storage_ref', 'on_view_position'], 'integer'],
            [['media_storage_ref'], 'exist', 'skipOnError' => true, 'targetClass' => MediaStorage::className(), 'targetAttribute' => ['media_storage_ref' => 'id']],
            [['node_ref'], 'exist', 'skipOnError' => true, 'targetClass' => Tree::className(), 'targetAttribute' => ['node_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'node_ref' => 'Node Ref',
            'media_storage_ref' => 'Media Storage Ref',
            'on_view_position' => 'On View Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorage() {
        return $this->hasOne(MediaStorage::className(), ['id' => 'media_storage_ref'])->alias('storage');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNode() {
        return $this->hasOne(Tree::className(), ['id' => 'node_ref'])->alias('node');
    }
}
