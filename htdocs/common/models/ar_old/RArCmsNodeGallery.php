<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "cms_node_gallery".
 *
 * @property int $id
 * @property int $cms_node_content_ref
 * @property int $app_gallery_ref
 * @property int $cms_media_storage_ref
 * @property int $on_view_position
 *
 * @property AppGallery $appGalleryRef
 * @property CmsMediaStorage $cmsMediaStorageRef
 * @property CmsNodeContent $cmsNodeContentRef
 */
class RArCmsNodeGallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_node_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cms_node_content_ref', 'app_gallery_ref', 'cms_media_storage_ref', 'on_view_position'], 'default', 'value' => null],
            [['cms_node_content_ref', 'app_gallery_ref', 'cms_media_storage_ref', 'on_view_position'], 'integer'],
            //[['app_gallery_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AppGallery::className(), 'targetAttribute' => ['app_gallery_ref' => 'id']],
            //[['cms_media_storage_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMediaStorage::className(), 'targetAttribute' => ['cms_media_storage_ref' => 'id']],
            //[['cms_node_content_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsNodeContent::className(), 'targetAttribute' => ['cms_node_content_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cms_node_content_ref' => 'Cms Node Content Ref',
            'app_gallery_ref' => 'App Gallery Ref',
            'cms_media_storage_ref' => 'Cms Media Storage Ref',
            'on_view_position' => 'On View Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppGalleryRef()
    {
        return $this->hasOne(AppGallery::className(), ['id' => 'app_gallery_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaStorageRef()
    {
        return $this->hasOne(CmsMediaStorage::className(), ['id' => 'cms_media_storage_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNodeContentRef()
    {
        return $this->hasOne(CmsNodeContent::className(), ['id' => 'cms_node_content_ref']);
    }
}
