<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArAppGalleryCategories;

/**
 * This is the model class for table "app_gallery_categories".
 *
 * @property int $id
 * @property string $category_name
 * @property string $dev_key
 * @property string $data
 * @property bool $is_multiple
 *
 * @property AppGallery[] $appGalleries
 */
class AppGalleryCategories extends RArAppGalleryCategories
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_gallery_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_name'], 'required'],
            [['data'], 'string'],
            [['is_multiple'], 'boolean'],
            [['category_name', 'dev_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'dev_key' => 'Dev Key',
            'data' => 'Data',
            'is_multiple' => 'Is Multiple',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppGalleries()
    {
        return $this->hasMany(AppGallery::className(), ['app_gallery_categories_ref' => 'id']);
    }
}
