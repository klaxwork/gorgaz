<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArMediaContent;
/**
 * This is the model class for table "media_content".
 *
 * @property int $id
 * @property string $content_name
 *
 * @property MediaContentTypes[] $mediaContentTypes
 */
class MediaContent extends RArMediaContent
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
    public function getContentType()
    {
        return $this->hasMany(MediaContentTypes::className(), ['media_content_ref' => 'id'])->alias('contentType');
    }
}
