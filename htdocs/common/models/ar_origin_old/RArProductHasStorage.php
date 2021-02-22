<?php

namespace common\models\ar_origin;

use Yii;

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
class RArProductHasStorage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_has_storage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
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
    public function attributeLabels()
    {
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
    public function getMediaStorageRef()
    {
        return $this->hasOne(MediaStorage::className(), ['id' => 'media_storage_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsRef()
    {
        return $this->hasOne(Product::className(), ['id' => 'products_ref']);
    }
}
