<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "cms_i8tags".
 *
 * @property int $id
 * @property string $i8key
 * @property string $i8tag
 *
 * @property CmsMediaStorage[] $cmsMediaStorages
 */
class RArCmsI8tags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_i8tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['i8key', 'i8tag'], 'required'],
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
    public function getCmsMediaStorages()
    {
        return $this->hasMany(CmsMediaStorage::className(), ['cms_i8tags_ref' => 'id']);
    }
}
