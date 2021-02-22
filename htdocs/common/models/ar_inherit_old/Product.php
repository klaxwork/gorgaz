<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArProduct;

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
class Product extends RArProduct
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            //[['description', 'seo_description'], 'string'],
            //[['is_published', 'id_trash'], 'boolean'],
            [['title', 'description', 'is_published', 'id_trash', 'dt_created', 'dt_updated', 'seo_title', 'seo_keywords', 'seo_description', 'url_alias'], 'safe'],
            //[['title', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
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
    public function getHasStorages() {
        return $this->hasMany(ProductHasStorage::className(), ['products_ref' => 'id'])->alias('hasStorages');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeProduct() {
        return $this->hasOne(TreeProducts::className(), ['id' => 'product_ref'])->alias('treeProduct');
    }

    public function getImages() {
        $oStores = MediaStorage::find()
            ->alias('storage')
            ->joinWith(['productHasStorages', 'croppeds.cropped'])
            ->where(['products_ref' => $this->id])
            ->orderBy('productHasStorages.on_view_position ASC')
            ->all();
        return $oStores;
    }
}
