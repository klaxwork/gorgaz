<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArTreeProducts;

/**
 * This is the model class for table "tree_products".
 *
 * @property int $id
 * @property int|null $tree_ref
 * @property int|null $product_ref
 *
 * @property Product $productRef
 * @property Tree $treeRef
 */
class TreeProducts extends RArTreeProducts
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tree_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tree_ref', 'product_ref'], 'default', 'value' => null],
            [['tree_ref', 'product_ref'], 'integer'],
            [['product_ref'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_ref' => 'id']],
            [['tree_ref'], 'exist', 'skipOnError' => true, 'targetClass' => Tree::className(), 'targetAttribute' => ['tree_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree_ref' => 'Tree Ref',
            'product_ref' => 'Product Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_ref'])->alias('product');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTree()
    {
        return $this->hasOne(Tree::className(), ['id' => 'tree_ref'])->alias('tree');
    }
}
