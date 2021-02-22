<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArEcmCart;

/**
 * This is the model class for table "ecm_cart".
 *
 * @property int $id
 * @property string $dt_created
 * @property int $edi_relation_clients_ref
 * @property string $cart_key
 * @property string $dt_updated
 *
 * @property AppClients $ediRelationClientsRef
 * @property EcmCartProducts[] $ecmCartProducts
 */
class EcmCart extends RArEcmCart
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_created', 'dt_updated'], 'safe'],
            [['edi_relation_clients_ref'], 'default', 'value' => null],
            [['edi_relation_clients_ref'], 'integer'],
            [['cart_key'], 'required'],
            [['cart_key'], 'string', 'max' => 255],
            [['edi_relation_clients_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AppClients::className(), 'targetAttribute' => ['edi_relation_clients_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dt_created' => 'Dt Created',
            'edi_relation_clients_ref' => 'Edi Relation Clients Ref',
            'cart_key' => 'Cart Key',
            'dt_updated' => 'Dt Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdiRelationClientsRef()
    {
        return $this->hasOne(AppClients::className(), ['id' => 'edi_relation_clients_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartProducts()
    {
        return $this->hasMany(EcmCartProducts::className(), ['ecm_cart_ref' => 'id'])->alias('cartProducts');
    }
}
