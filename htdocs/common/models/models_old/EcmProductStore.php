<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArEcmProductStore;

/**
 * This is the model class for table "ecm_product_store".
 *
 * @property int $id
 * @property int $ecm_products_ref
 * @property int $ecm_warehouse_ref
 * @property int $quantity
 * @property int $priority приоритет относительно цены в ecm_products.product_price
 * @property double $price
 * @property string $dt_created
 * @property string $dt_updated
 * @property string $dt_relevant date of last compliance check
 *
 * @property EcmProducts $ecmProductsRef
 * @property EcmWarehouse $ecmWarehouseRef
 */
class EcmProductStore extends RArEcmProductStore
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_product_store';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ecm_products_ref', 'ecm_warehouse_ref'], 'required'],
            //[['ecm_products_ref', 'ecm_warehouse_ref', 'quantity', 'priority'], 'default', 'value' => null],
            //[['ecm_products_ref', 'ecm_warehouse_ref', 'quantity', 'priority'], 'integer'],
            //[['price'], 'number'],
            [['dt_created', 'dt_updated', 'dt_relevant'], 'safe'],
            [['ecm_products_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmProducts::className(), 'targetAttribute' => ['ecm_products_ref' => 'id']],
            [['ecm_warehouse_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmWarehouse::className(), 'targetAttribute' => ['ecm_warehouse_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ecm_products_ref' => 'Ecm Products Ref',
            'ecm_warehouse_ref' => 'Ecm Warehouse Ref',
            'quantity' => 'Quantity',
            'priority' => 'Priority',
            'price' => 'Price',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'dt_relevant' => 'Dt Relevant',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(EcmProducts::className(), ['id' => 'ecm_products_ref'])->alias('product');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(EcmWarehouse::className(), ['id' => 'ecm_warehouse_ref'])->alias('warehouse');
    }
}
