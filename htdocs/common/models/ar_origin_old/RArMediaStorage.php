<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "media_storage".
 *
 * @property int $id
 * @property int|null $media_folders_ref
 * @property int|null $media_content_types_ref
 * @property string|null $title
 * @property string|null $description
 * @property string|null $data
 * @property string $fs_saveto
 * @property string $fs_alias
 * @property string $fs_filename
 * @property string $fs_md5hash
 * @property int $fs_filesize
 * @property string|null $dt_created
 * @property string|null $dt_updated
 * @property string|null $fs_extension
 * @property string|null $filename
 * @property int|null $app_gallery_categories_ref
 * @property int|null $edi_bootstrap_ref
 * @property bool|null $is_trash
 * @property int|null $i8tags_ref
 * @property int|null $storage_category_ref
 *
 * @property MediaCropped[] $mediaCroppeds
 * @property MediaCropped[] $mediaCroppeds0
 * @property I8tags $i8tagsRef
 * @property MediaContentTypes $mediaContentTypesRef
 * @property MediaFolders $mediaFoldersRef
 * @property MediaStorageCategory $storageCategoryRef
 * @property NodeContentHasStorage[] $nodeContentHasStorages
 * @property NodeHasStorage[] $nodeHasStorages
 * @property ProductHasStorage[] $productHasStorages
 */
class RArMediaStorage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_storage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['media_folders_ref', 'media_content_types_ref', 'fs_filesize', 'app_gallery_categories_ref', 'edi_bootstrap_ref', 'i8tags_ref', 'storage_category_ref'], 'default', 'value' => null],
            [['media_folders_ref', 'media_content_types_ref', 'fs_filesize', 'app_gallery_categories_ref', 'edi_bootstrap_ref', 'i8tags_ref', 'storage_category_ref'], 'integer'],
            [['description', 'data'], 'string'],
            [['fs_saveto', 'fs_alias', 'fs_filename', 'fs_md5hash', 'fs_filesize'], 'required'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['is_trash'], 'boolean'],
            [['title', 'fs_saveto', 'fs_alias', 'fs_filename', 'fs_md5hash', 'fs_extension', 'filename'], 'string', 'max' => 255],
            [['i8tags_ref'], 'exist', 'skipOnError' => true, 'targetClass' => I8tags::className(), 'targetAttribute' => ['i8tags_ref' => 'id']],
            [['media_content_types_ref'], 'exist', 'skipOnError' => true, 'targetClass' => MediaContentTypes::className(), 'targetAttribute' => ['media_content_types_ref' => 'id']],
            [['media_folders_ref'], 'exist', 'skipOnError' => true, 'targetClass' => MediaFolders::className(), 'targetAttribute' => ['media_folders_ref' => 'id']],
            [['storage_category_ref'], 'exist', 'skipOnError' => true, 'targetClass' => MediaStorageCategory::className(), 'targetAttribute' => ['storage_category_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'media_folders_ref' => 'Media Folders Ref',
            'media_content_types_ref' => 'Media Content Types Ref',
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
            'fs_extension' => 'Fs Extension',
            'filename' => 'Filename',
            'app_gallery_categories_ref' => 'App Gallery Categories Ref',
            'edi_bootstrap_ref' => 'Edi Bootstrap Ref',
            'is_trash' => 'Is Trash',
            'i8tags_ref' => 'I8tags Ref',
            'storage_category_ref' => 'Storage Category Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaCroppeds()
    {
        return $this->hasMany(MediaCropped::className(), ['media_storage_original_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaCroppeds0()
    {
        return $this->hasMany(MediaCropped::className(), ['media_storage_cropped_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI8tagsRef()
    {
        return $this->hasOne(I8tags::className(), ['id' => 'i8tags_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaContentTypesRef()
    {
        return $this->hasOne(MediaContentTypes::className(), ['id' => 'media_content_types_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaFoldersRef()
    {
        return $this->hasOne(MediaFolders::className(), ['id' => 'media_folders_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorageCategoryRef()
    {
        return $this->hasOne(MediaStorageCategory::className(), ['id' => 'storage_category_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNodeContentHasStorages()
    {
        return $this->hasMany(NodeContentHasStorage::className(), ['media_storage_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNodeHasStorages()
    {
        return $this->hasMany(NodeHasStorage::className(), ['media_storage_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHasStorages()
    {
        return $this->hasMany(ProductHasStorage::className(), ['media_storage_ref' => 'id']);
    }
}
