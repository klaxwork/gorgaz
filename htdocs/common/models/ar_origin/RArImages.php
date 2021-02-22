<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $meta_data
 * @property string|null $fs_saveto
 * @property string|null $fs_alias
 * @property string|null $fs_filename
 * @property string|null $fs_md5hash
 * @property float|null $fs_filesize
 * @property string|null $dt_created
 * @property string|null $dt_updated
 * @property bool|null $is_trash
 * @property string|null $fs_extension
 * @property string|null $filename
 *
 * @property OrderEquipments[] $orderEquipments
 * @property Orders[] $orders
 */
class RArImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meta_data'], 'string'],
            [['fs_filesize'], 'number'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['is_trash'], 'boolean'],
            [['title', 'fs_saveto', 'fs_alias', 'fs_filename', 'fs_md5hash', 'fs_extension', 'filename'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'meta_data' => 'Meta Data',
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderEquipments()
    {
        return $this->hasMany(OrderEquipments::className(), ['image_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['proxy_image_ref' => 'id']);
    }
}
