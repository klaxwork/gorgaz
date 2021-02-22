<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "media_cropped".
 *
 * @property int $id
 * @property int|null $media_storage_original_ref
 * @property int|null $media_storage_cropped_ref
 * @property int|null $image_width
 * @property int|null $image_height
 * @property string|null $data
 *
 * @property MediaStorage $mediaStorageOriginalRef
 * @property MediaStorage $mediaStorageCroppedRef
 */
class RArMediaCropped extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_cropped';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['media_storage_original_ref', 'media_storage_cropped_ref', 'image_width', 'image_height'], 'default', 'value' => null],
            [['media_storage_original_ref', 'media_storage_cropped_ref', 'image_width', 'image_height'], 'integer'],
            [['data'], 'string'],
            [['media_storage_original_ref'], 'exist', 'skipOnError' => true, 'targetClass' => MediaStorage::className(), 'targetAttribute' => ['media_storage_original_ref' => 'id']],
            [['media_storage_cropped_ref'], 'exist', 'skipOnError' => true, 'targetClass' => MediaStorage::className(), 'targetAttribute' => ['media_storage_cropped_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'media_storage_original_ref' => 'Media Storage Original Ref',
            'media_storage_cropped_ref' => 'Media Storage Cropped Ref',
            'image_width' => 'Image Width',
            'image_height' => 'Image Height',
            'data' => 'Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaStorageOriginalRef()
    {
        return $this->hasOne(MediaStorage::className(), ['id' => 'media_storage_original_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaStorageCroppedRef()
    {
        return $this->hasOne(MediaStorage::className(), ['id' => 'media_storage_cropped_ref']);
    }
}
