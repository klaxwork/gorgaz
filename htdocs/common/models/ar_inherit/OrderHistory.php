<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArOrderHistory;
/**
 * This is the model class for table "order_history".
 *
 * @property int $id
 * @property int $orders_ref
 * @property string|null $order_comment
 * @property string|null $order_status
 * @property string|null $dt_created
 *
 * @property Orders $ordersRef
 */
class OrderHistory extends RArOrderHistory
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orders_ref'], 'required'],
            [['orders_ref'], 'default', 'value' => null],
            [['orders_ref'], 'integer'],
            [['order_comment'], 'string'],
            [['dt_created'], 'safe'],
            [['order_status'], 'string', 'max' => 255],
            [['orders_ref'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['orders_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orders_ref' => 'Orders Ref',
            'order_comment' => 'Order Comment',
            'order_status' => 'Order Status',
            'dt_created' => 'Dt Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersRef()
    {
        return $this->hasOne(Orders::className(), ['id' => 'orders_ref']);
    }
}
