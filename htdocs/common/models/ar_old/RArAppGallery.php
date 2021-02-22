<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "app_gallery".
 *
 * @property int $id
 * @property int $edi_bootstrap_ref
 * @property int $cms_media_storage_ref
 * @property int $app_gallery_categories_ref
 * @property string $dev_key
 * @property string $tags
 * @property string $dt_created
 * @property string $dt_updated
 * @property int $on_view_position
 *
 * @property AppGalleryCategories $appGalleryCategoriesRef
 * @property CmsMediaStorage $cmsMediaStorageRef
 * @property EdiBootstrap $ediBootstrapRef
 * @property AppProductHasGallery[] $appProductHasGalleries
 * @property AppQuestHasGallery[] $appQuestHasGalleries
 * @property CmsNodeGallery[] $cmsNodeGalleries
 * @property EcmProductHasGallery[] $ecmProductHasGalleries
 */
class RArAppGallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edi_bootstrap_ref', 'cms_media_storage_ref'], 'required'],
            [['edi_bootstrap_ref', 'cms_media_storage_ref', 'app_gallery_categories_ref', 'on_view_position'], 'default', 'value' => null],
            [['edi_bootstrap_ref', 'cms_media_storage_ref', 'app_gallery_categories_ref', 'on_view_position'], 'integer'],
            [['tags'], 'string'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['dev_key'], 'string', 'max' => 255],
            [['app_gallery_categories_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AppGalleryCategories::className(), 'targetAttribute' => ['app_gallery_categories_ref' => 'id']],
            [['cms_media_storage_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMediaStorage::className(), 'targetAttribute' => ['cms_media_storage_ref' => 'id']],
            [['edi_bootstrap_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EdiBootstrap::className(), 'targetAttribute' => ['edi_bootstrap_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'edi_bootstrap_ref' => 'Edi Bootstrap Ref',
            'cms_media_storage_ref' => 'Cms Media Storage Ref',
            'app_gallery_categories_ref' => 'App Gallery Categories Ref',
            'dev_key' => 'Dev Key',
            'tags' => 'Tags',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'on_view_position' => 'On View Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppGalleryCategoriesRef()
    {
        return $this->hasOne(AppGalleryCategories::className(), ['id' => 'app_gallery_categories_ref']);
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
    public function getEdiBootstrapRef()
    {
        return $this->hasOne(EdiBootstrap::className(), ['id' => 'edi_bootstrap_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppProductHasGalleries()
    {
        return $this->hasMany(AppProductHasGallery::className(), ['app_gallery_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppQuestHasGalleries()
    {
        return $this->hasMany(AppQuestHasGallery::className(), ['app_gallery_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNodeGalleries()
    {
        return $this->hasMany(CmsNodeGallery::className(), ['app_gallery_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductHasGalleries()
    {
        return $this->hasMany(EcmProductHasGallery::className(), ['app_gallery_ref' => 'id']);
    }
}
