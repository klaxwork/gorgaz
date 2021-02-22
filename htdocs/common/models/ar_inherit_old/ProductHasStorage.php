<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArProductHasStorage;

/**
 * This is the model class for table "product_has_storage".
 *
 * @property int $id
 * @property int|null $products_ref
 * @property int|null $media_storage_ref
 * @property int|null $on_view_position
 *
 * @property MediaStorage $mediaStorageRef
 * @property Product $productsRef
 */
class ProductHasStorage extends RArProductHasStorage
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'product_has_storage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['products_ref', 'media_storage_ref', 'on_view_position'], 'default', 'value' => null],
            [['products_ref', 'media_storage_ref', 'on_view_position'], 'integer'],
            [['media_storage_ref'], 'exist', 'skipOnError' => true, 'targetClass' => MediaStorage::className(), 'targetAttribute' => ['media_storage_ref' => 'id']],
            [['products_ref'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['products_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'products_ref' => 'Products Ref',
            'media_storage_ref' => 'Media Storage Ref',
            'on_view_position' => 'On View Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorage() {
        return $this->hasOne(MediaStorage::className(), ['id' => 'media_storage_ref'])->alias('storage');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'products_ref'])->alias('product');
    }
}
