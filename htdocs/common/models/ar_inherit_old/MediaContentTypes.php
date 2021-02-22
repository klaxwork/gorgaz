<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArMediaContentTypes;

/**
 * This is the model class for table "media_content_types".
 *
 * @property int $id
 * @property int $media_content_ref
 * @property string $content_type
 *
 * @property MediaContent $mediaContentRef
 * @property MediaStorage[] $mediaStorages
 */
class MediaContentTypes extends RArMediaContentTypes
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'media_content_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['media_content_ref', 'content_type'], 'required'],
            [['media_content_ref'], 'default', 'value' => null],
            [['media_content_ref'], 'integer'],
            [['content_type'], 'string', 'max' => 255],
            [['media_content_ref'], 'exist', 'skipOnError' => true, 'targetClass' => MediaContent::className(), 'targetAttribute' => ['media_content_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'media_content_ref' => 'Media Content Ref',
            'content_type' => 'Content Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent() {
        return $this->hasOne(MediaContent::className(), ['id' => 'media_content_ref'])->alias('content');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaStorages() {
        return $this->hasMany(MediaStorage::className(), ['media_content_types_ref' => 'id']);
    }
}
