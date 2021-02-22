<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "ecm_cart_products".
 *
 * @property int $id
 * @property int $ecm_cart_ref
 * @property int $ecm_products_ref
 * @property int $ecm_product_attributes_ref
 * @property int $quantity
 *
 * @property EcmCart $ecmCartRef
 * @property EcmProducts $ecmProductsRef
 */
class RArEcmCartProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_cart_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ecm_cart_ref', 'ecm_products_ref'], 'required'],
            [['ecm_cart_ref', 'ecm_products_ref', 'ecm_product_attributes_ref', 'quantity'], 'default', 'value' => null],
            [['ecm_cart_ref', 'ecm_products_ref', 'ecm_product_attributes_ref', 'quantity'], 'integer'],
            [['ecm_cart_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmCart::className(), 'targetAttribute' => ['ecm_cart_ref' => 'id']],
            [['ecm_products_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmProducts::className(), 'targetAttribute' => ['ecm_products_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ecm_cart_ref' => 'Ecm Cart Ref',
            'ecm_products_ref' => 'Ecm Products Ref',
            'ecm_product_attributes_ref' => 'Ecm Product Attributes Ref',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCartRef()
    {
        return $this->hasOne(EcmCart::className(), ['id' => 'ecm_cart_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductsRef()
    {
        return $this->hasOne(EcmProducts::className(), ['id' => 'ecm_products_ref']);
    }
}
