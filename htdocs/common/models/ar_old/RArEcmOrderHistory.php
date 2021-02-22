<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "ecm_order_history".
 *
 * @property int $id
 * @property int $ecm_orders_ref
 * @property int $ecm_order_statuses_ref
 * @property int $ecm_payment_statuses_ref
 * @property string $admin_comment
 * @property string $notify_message
 * @property bool $is_notify
 * @property string $dt_created
 * @property string $dt_notified
 * @property string $client_comment
 *
 * @property EcmOrderStatuses $ecmOrderStatusesRef
 * @property EcmOrders $ecmOrdersRef
 * @property EcmPaymentStatuses $ecmPaymentStatusesRef
 */
class RArEcmOrderHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_order_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ecm_orders_ref', 'ecm_order_statuses_ref', 'ecm_payment_statuses_ref'], 'required'],
            [['ecm_orders_ref', 'ecm_order_statuses_ref', 'ecm_payment_statuses_ref'], 'default', 'value' => null],
            [['ecm_orders_ref', 'ecm_order_statuses_ref', 'ecm_payment_statuses_ref'], 'integer'],
            [['admin_comment', 'notify_message', 'client_comment'], 'string'],
            [['is_notify'], 'boolean'],
            [['dt_created', 'dt_notified'], 'safe'],
            [['ecm_order_statuses_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmOrderStatuses::className(), 'targetAttribute' => ['ecm_order_statuses_ref' => 'id']],
            [['ecm_orders_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmOrders::className(), 'targetAttribute' => ['ecm_orders_ref' => 'id']],
            [['ecm_payment_statuses_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmPaymentStatuses::className(), 'targetAttribute' => ['ecm_payment_statuses_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ecm_orders_ref' => 'Ecm Orders Ref',
            'ecm_order_statuses_ref' => 'Ecm Order Statuses Ref',
            'ecm_payment_statuses_ref' => 'Ecm Payment Statuses Ref',
            'admin_comment' => 'Admin Comment',
            'notify_message' => 'Notify Message',
            'is_notify' => 'Is Notify',
            'dt_created' => 'Dt Created',
            'dt_notified' => 'Dt Notified',
            'client_comment' => 'Client Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmOrderStatusesRef()
    {
        return $this->hasOne(EcmOrderStatuses::className(), ['id' => 'ecm_order_statuses_ref']);
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
    public function getEcmPaymentStatusesRef()
    {
        return $this->hasOne(EcmPaymentStatuses::className(), ['id' => 'ecm_payment_statuses_ref']);
    }
}
