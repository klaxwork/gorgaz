<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArCmsNodeGallery;

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
class CmsNodeGallery extends RArCmsNodeGallery
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(AppGallery::className(), ['id' => 'app_gallery_ref'])->alias('gallery');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleries()
    {
        return $this->hasMany(AppGallery::className(), ['id' => 'app_gallery_ref'])->alias('galleries');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(CmsNodeContent::className(), ['id' => 'cms_node_content_ref'])->alias('content');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorage()
    {
        return $this->hasOne(CmsMediaStorage::className(), ['id' => 'cms_media_storage_ref'])->alias('storage');
    }

}
