<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "ecm_order_products".
 *
 * @property int $id
 * @property int $edi_bootstrap_ref
 * @property int $ecm_orders_ref
 * @property int $ecm_products_ref
 * @property int $ecm_product_attributes_ref
 * @property int $quantity
 * @property string $data - тех.параметры продукта на момент создания заказа
 * @property double $product_price
 *
 * @property EbsSeanceSessions[] $ebsSeanceSessions
 * @property EcmOrders $ecmOrdersRef
 * @property EcmProductAttributes $ecmProductAttributesRef
 * @property EcmProducts $ecmProductsRef
 * @property EdiBootstrap $ediBootstrapRef
 */
class RArEcmOrderProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_order_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edi_bootstrap_ref', 'ecm_orders_ref', 'ecm_products_ref'], 'required'],
            [['edi_bootstrap_ref', 'ecm_orders_ref', 'ecm_products_ref', 'ecm_product_attributes_ref', 'quantity'], 'default', 'value' => null],
            [['edi_bootstrap_ref', 'ecm_orders_ref', 'ecm_products_ref', 'ecm_product_attributes_ref', 'quantity'], 'integer'],
            [['data'], 'string'],
            [['product_price'], 'number'],
            [['ecm_orders_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmOrders::className(), 'targetAttribute' => ['ecm_orders_ref' => 'id']],
            [['ecm_product_attributes_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmProductAttributes::className(), 'targetAttribute' => ['ecm_product_attributes_ref' => 'id']],
            [['ecm_products_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmProducts::className(), 'targetAttribute' => ['ecm_products_ref' => 'id']],
            [['edi_bootstrap_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EdiBootstrap::className(), 'targetAttribute' => ['edi_bootstrap_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'edi_bootstrap_ref' => 'Edi Bootstrap Ref',
            'ecm_orders_ref' => 'Ecm Orders Ref',
            'ecm_products_ref' => 'Ecm Products Ref',
            'ecm_product_attributes_ref' => 'Ecm Product Attributes Ref',
            'quantity' => 'Quantity',
            'data' => 'Data',
            'product_price' => 'Product Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEbsSeanceSessions()
    {
        return $this->hasMany(EbsSeanceSessions::className(), ['ecm_order_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmOrdersRef()
    {
        return $this->hasOne(EcmOrders::className(), ['id' => 'ecm_orders_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductAttributesRef()
    {
        return $this->hasOne(EcmProductAttributes::className(), ['id' => 'ecm_product_attributes_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductsRef()
    {
        return $this->hasOne(EcmProducts::className(), ['id' => 'ecm_products_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdiBootstrapRef()
    {
        return $this->hasOne(EdiBootstrap::className(), ['id' => 'edi_bootstrap_ref']);
    }
}
