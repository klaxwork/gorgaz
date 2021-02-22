<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "cms_media_storage".
 *
 * @property int $id
 * @property int $cms_i8tags_ref
 * @property int $cms_media_folders_ref
 * @property int $cms_media_content_types_ref
 * @property string $title
 * @property string $description
 * @property string $data
 * @property string $fs_saveto
 * @property string $fs_alias
 * @property string $fs_filename
 * @property string $fs_md5hash
 * @property int $fs_filesize
 * @property string $dt_created
 * @property string $dt_updated
 * @property bool $is_trash
 * @property string $fs_extension
 * @property string $filename
 * @property int $app_gallery_categories_ref
 * @property int $edi_bootstrap_ref
 *
 * @property AppGallery[] $appGalleries
 * @property CmsMediaCropped[] $cmsMediaCroppeds
 * @property CmsMediaCropped[] $cmsMediaCroppeds0
 * @property AppGalleryCategories $appGalleryCategoriesRef
 * @property CmsI8tags $cmsI8tagsRef
 * @property CmsMediaContentTypes $cmsMediaContentTypesRef
 * @property CmsMediaFolders $cmsMediaFoldersRef
 * @property EdiBootstrap $ediBootstrapRef
 * @property CmsNodeGallery[] $cmsNodeGalleries
 */
class RArCmsMediaStorage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_media_storage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cms_i8tags_ref', 'cms_media_folders_ref', 'cms_media_content_types_ref', 'fs_saveto', 'fs_alias', 'fs_filename'], 'required'],
            [['cms_i8tags_ref', 'cms_media_folders_ref', 'cms_media_content_types_ref', 'fs_filesize', 'app_gallery_categories_ref', 'edi_bootstrap_ref'], 'default', 'value' => null],
            [['cms_i8tags_ref', 'cms_media_folders_ref', 'cms_media_content_types_ref', 'fs_filesize', 'app_gallery_categories_ref', 'edi_bootstrap_ref'], 'integer'],
            [['description', 'data'], 'string'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['is_trash'], 'boolean'],
            [['title', 'fs_saveto', 'fs_alias', 'fs_filename', 'filename'], 'string', 'max' => 255],
            [['fs_md5hash'], 'string', 'max' => 32],
            [['fs_extension'], 'string', 'max' => 10],
            [['app_gallery_categories_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AppGalleryCategories::className(), 'targetAttribute' => ['app_gallery_categories_ref' => 'id']],
            [['cms_i8tags_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsI8tags::className(), 'targetAttribute' => ['cms_i8tags_ref' => 'id']],
            [['cms_media_content_types_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMediaContentTypes::className(), 'targetAttribute' => ['cms_media_content_types_ref' => 'id']],
            [['cms_media_folders_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMediaFolders::className(), 'targetAttribute' => ['cms_media_folders_ref' => 'id']],
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
            'cms_i8tags_ref' => 'Cms I8tags Ref',
            'cms_media_folders_ref' => 'Cms Media Folders Ref',
            'cms_media_content_types_ref' => 'Cms Media Content Types Ref',
            'title' => 'Title',
            'description' => 'Description',
            'data' => 'Data',
            'fs_saveto' => 'Fs Saveto',
            'fs_alias' => 'Fs Alias',
            'fs_filename' => 'Fs Filename',
            'fs_md5hash' => 'Fs Md5hash',
            'fs_filesize' => 'Fs Filesize',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'is_trash' => 'Is Trash',
            'fs_extension' => 'Fs Extension',
            'filename' => 'Filename',
            'app_gallery_categories_ref' => 'App Gallery Categories Ref',
            'edi_bootstrap_ref' => 'Edi Bootstrap Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppGalleries()
    {
        return $this->hasMany(AppGallery::className(), ['cms_media_storage_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaCroppeds()
    {
        return $this->hasMany(CmsMediaCropped::className(), ['cms_media_storage_original_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaCroppeds0()
    {
        return $this->hasMany(CmsMediaCropped::className(), ['cms_media_storage_cropped_ref' => 'id']);
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
    public function getCmsI8tagsRef()
    {
        return $this->hasOne(CmsI8tags::className(), ['id' => 'cms_i8tags_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaContentTypesRef()
    {
        return $this->hasOne(CmsMediaContentTypes::className(), ['id' => 'cms_media_content_types_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaFoldersRef()
    {
        return $this->hasOne(CmsMediaFolders::className(), ['id' => 'cms_media_folders_ref']);
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
    public function getCmsNodeGalleries()
    {
        return $this->hasMany(CmsNodeGallery::className(), ['cms_media_storage_ref' => 'id']);
    }
}
