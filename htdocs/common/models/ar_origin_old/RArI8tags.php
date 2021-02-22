<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "i8tags".
 *
 * @property int $id
 * @property string|null $i8key
 * @property string|null $i8tag
 *
 * @property MediaStorage[] $mediaStorages
 */
class RArI8tags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'i8tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['i8key'], 'string', 'max' => 32],
            [['i8tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'i8key' => 'I8key',
            'i8tag' => 'I8tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaStorages()
    {
        return $this->hasMany(MediaStorage::className(), ['i8tags_ref' => 'id']);
    }
}
