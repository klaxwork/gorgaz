<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "cms_media_content".
 *
 * @property int $id
 * @property string $content_name
 *
 * @property CmsMediaContentTypes[] $cmsMediaContentTypes
 */
class RArCmsMediaContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_media_content';
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
    public function getCmsMediaContentTypes()
    {
        return $this->hasMany(CmsMediaContentTypes::className(), ['cms_media_content_ref' => 'id']);
    }
}
