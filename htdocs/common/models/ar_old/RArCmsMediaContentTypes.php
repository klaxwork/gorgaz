<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "cms_media_content_types".
 *
 * @property int $id
 * @property int $cms_media_content_ref
 * @property string $content_type
 *
 * @property CmsMediaContent $cmsMediaContentRef
 * @property CmsMediaStorage[] $cmsMediaStorages
 */
class RArCmsMediaContentTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_media_content_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cms_media_content_ref', 'content_type'], 'required'],
            [['cms_media_content_ref'], 'default', 'value' => null],
            [['cms_media_content_ref'], 'integer'],
            [['content_type'], 'string', 'max' => 255],
            [['cms_media_content_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMediaContent::className(), 'targetAttribute' => ['cms_media_content_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cms_media_content_ref' => 'Cms Media Content Ref',
            'content_type' => 'Content Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaContentRef()
    {
        return $this->hasOne(CmsMediaContent::className(), ['id' => 'cms_media_content_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaStorages()
    {
        return $this->hasMany(CmsMediaStorage::className(), ['cms_media_content_types_ref' => 'id']);
    }
}
