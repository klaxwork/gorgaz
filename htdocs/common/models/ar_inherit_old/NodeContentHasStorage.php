<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArNodeContentHasStorage;

/**
 * This is the model class for table "node_content_has_storage".
 *
 * @property int $id
 * @property int|null $node_content_ref
 * @property int|null $media_storage_ref
 * @property int|null $on_view_position
 *
 * @property MediaStorage $mediaStorageRef
 * @property NodeContent $nodeContentRef
 */
class NodeContentHasStorage extends RArNodeContentHasStorage
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'node_content_has_storage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['node_content_ref', 'media_storage_ref', 'on_view_position'], 'default', 'value' => null],
            [['node_content_ref', 'media_storage_ref', 'on_view_position'], 'integer'],
            [['media_storage_ref'], 'exist', 'skipOnError' => true, 'targetClass' => MediaStorage::className(), 'targetAttribute' => ['media_storage_ref' => 'id']],
            [['node_content_ref'], 'exist', 'skipOnError' => true, 'targetClass' => NodeContent::className(), 'targetAttribute' => ['node_content_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'node_content_ref' => 'Node Content Ref',
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
    public function getNodeContent() {
        return $this->hasOne(NodeContent::className(), ['id' => 'node_content_ref'])->alias('nodeContent');
    }
}
