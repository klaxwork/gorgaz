<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "ecm_orders".
 *
 * @property int $id
 * @property int $edi_relation_clients_ref
 * @property string $client_view_name
 * @property string $source_data
 * @property double $total_discounts
 * @property int $total_products
 * @property double $total_paid
 * @property double $total_paid_real
 * @property int $ecm_payment_methods_ref
 * @property string $dt_created
 * @property string $dt_updated
 * @property int $ecm_order_source_ref
 * @property double $total_paid_bonus
 * @property string $client_comment
 * @property string $delivery_data
 *
 * @property EcmOrderHistory[] $ecmOrderHistories
 * @property EcmOrderProducts[] $ecmOrderProducts
 * @property EcmOrderSource $ecmOrderSourceRef
 * @property EcmPaymentMethods $ecmPaymentMethodsRef
 * @property EdiRelationClients $ediRelationClientsRef
 * @property EcmOrdersHasTransactions[] $ecmOrdersHasTransactions
 * @property EcmVerifyCodes[] $ecmVerifyCodes
 */
class RArEcmOrders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edi_relation_clients_ref'], 'required'],
            [['edi_relation_clients_ref', 'total_products', 'ecm_payment_methods_ref', 'ecm_order_source_ref'], 'default', 'value' => null],
            [['edi_relation_clients_ref', 'total_products', 'ecm_payment_methods_ref', 'ecm_order_source_ref'], 'integer'],
            [['source_data', 'client_comment', 'delivery_data'], 'string'],
            [['total_discounts', 'total_paid', 'total_paid_real', 'total_paid_bonus'], 'number'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['client_view_name'], 'string', 'max' => 255],
            [['ecm_order_source_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmOrderSource::className(), 'targetAttribute' => ['ecm_order_source_ref' => 'id']],
            [['ecm_payment_methods_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmPaymentMethods::className(), 'targetAttribute' => ['ecm_payment_methods_ref' => 'id']],
            [['edi_relation_clients_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EdiRelationClients::className(), 'targetAttribute' => ['edi_relation_clients_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'edi_relation_clients_ref' => 'Edi Relation Clients Ref',
            'client_view_name' => 'Client View Name',
            'source_data' => 'Source Data',
            'total_discounts' => 'Total Discounts',
            'total_products' => 'Total Products',
            'total_paid' => 'Total Paid',
            'total_paid_real' => 'Total Paid Real',
            'ecm_payment_methods_ref' => 'Ecm Payment Methods Ref',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'ecm_order_source_ref' => 'Ecm Order Source Ref',
            'total_paid_bonus' => 'Total Paid Bonus',
            'client_comment' => 'Client Comment',
            'delivery_data' => 'Delivery Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmOrderHistories()
    {
        return $this->hasMany(EcmOrderHistory::className(), ['ecm_orders_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmOrderProducts()
    {
        return $this->hasMany(EcmOrderProducts::className(), ['ecm_orders_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmOrderSourceRef()
    {
        return $this->hasOne(EcmOrderSource::className(), ['id' => 'ecm_order_source_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmPaymentMethodsRef()
    {
        return $this->hasOne(EcmPaymentMethods::className(), ['id' => 'ecm_payment_methods_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdiRelationClientsRef()
    {
        return $this->hasOne(EdiRelationClients::className(), ['id' => 'edi_relation_clients_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmOrdersHasTransactions()
    {
        return $this->hasMany(EcmOrdersHasTransactions::className(), ['ecm_orders_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmVerifyCodes()
    {
        return $this->hasMany(EcmVerifyCodes::className(), ['ecm_orders_ref' => 'id']);
    }
}
