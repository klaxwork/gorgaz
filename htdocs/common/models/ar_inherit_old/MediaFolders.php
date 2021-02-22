<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArMediaFolders;
/**
 * This is the model class for table "media_folders".
 *
 * @property int $id
 * @property string $folder_name
 * @property string $fs_dirname
 * @property bool $is_default
 *
 * @property MediaStorage[] $mediaStorages
 */
class MediaFolders extends RArMediaFolders
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_folders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['folder_name', 'fs_dirname', 'is_default'], 'required'],
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
    public function getMediaStorages()
    {
        return $this->hasMany(MediaStorage::className(), ['media_folders_ref' => 'id']);
    }
}
