<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property bool|null $is_published
 * @property bool|null $id_trash
 * @property string|null $dt_created
 * @property string|null $dt_updated
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property string|null $url_alias
 *
 * @property ProductHasStorage[] $productHasStorages
 * @property TreeProducts[] $treeProducts
 */
class RArProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'seo_description'], 'string'],
            [['is_published', 'id_trash'], 'boolean'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['title', 'seo_title', 'seo_keywords', 'url_alias'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'is_published' => 'Is Published',
            'id_trash' => 'Id Trash',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'url_alias' => 'Url Alias',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHasStorages()
    {
        return $this->hasMany(ProductHasStorage::className(), ['products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeProducts()
    {
        return $this->hasMany(TreeProducts::className(), ['product_ref' => 'id']);
    }
}
