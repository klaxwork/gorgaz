<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "media_content".
 *
 * @property int $id
 * @property string $content_name
 *
 * @property MediaContentTypes[] $mediaContentTypes
 */
class RArMediaContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_name'], 'required'],
            [['content_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_name' => 'Content Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaContentTypes()
    {
        return $this->hasMany(MediaContentTypes::className(), ['media_content_ref' => 'id']);
    }
}
