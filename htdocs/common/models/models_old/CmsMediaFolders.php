<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArCmsMediaFolders;

/**
 * This is the model class for table "cms_media_folders".
 *
 * @property int $id
 * @property string $folder_name
 * @property string $fs_dirname
 * @property bool $is_default
 *
 * @property CmsMediaStorage[] $cmsMediaStorages
 */
class CmsMediaFolders extends RArCmsMediaFolders
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_media_folders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['folder_name', 'fs_dirname'], 'required'],
            [['is_default'], 'boolean'],
            [['folder_name', 'fs_dirname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'folder_name' => 'Folder Name',
            'fs_dirname' => 'Fs Dirname',
            'is_default' => 'Is Default',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaStorages()
    {
        return $this->hasMany(CmsMediaStorage::className(), ['cms_media_folders_ref' => 'id']);
    }
}
