<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "cms_media_cropped".
 *
 * @property int $id
 * @property int $cms_media_storage_original_ref
 * @property int $cms_media_storage_cropped_ref
 * @property int $image_width
 * @property int $image_height
 * @property string $data
 *
 * @property CmsMediaStorage $cmsMediaStorageOriginalRef
 * @property CmsMediaStorage $cmsMediaStorageCroppedRef
 */
class RArCmsMediaCropped extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_media_cropped';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cms_media_storage_original_ref'], 'required'],
            [['cms_media_storage_original_ref', 'cms_media_storage_cropped_ref', 'image_width', 'image_height'], 'default', 'value' => null],
            [['cms_media_storage_original_ref', 'cms_media_storage_cropped_ref', 'image_width', 'image_height'], 'integer'],
            [['data'], 'string'],
            [['cms_media_storage_original_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMediaStorage::className(), 'targetAttribute' => ['cms_media_storage_original_ref' => 'id']],
            [['cms_media_storage_cropped_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMediaStorage::className(), 'targetAttribute' => ['cms_media_storage_cropped_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cms_media_storage_original_ref' => 'Cms Media Storage Original Ref',
            'cms_media_storage_cropped_ref' => 'Cms Media Storage Cropped Ref',
            'image_width' => 'Image Width',
            'image_height' => 'Image Height',
            'data' => 'Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaStorageOriginalRef()
    {
        return $this->hasOne(CmsMediaStorage::className(), ['id' => 'cms_media_storage_original_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaStorageCroppedRef()
    {
        return $this->hasOne(CmsMediaStorage::className(), ['id' => 'cms_media_storage_cropped_ref']);
    }
}
