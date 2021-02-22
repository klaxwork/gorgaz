<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "app_comments".
 *
 * @property int $id
 * @property string $dt_created
 * @property int $ecm_products_ref
 * @property int $edi_relation_clients_ref
 * @property bool $is_published
 * @property string $dt_updated
 * @property string $client_message
 * @property string $admin_answer
 * @property bool $is_notify_client
 * @property string $positive
 * @property string $negative
 * @property int $rate
 * @property bool $is_trash
 *
 * @property EcmProducts $ecmProductsRef
 */
class RArAppComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_created', 'dt_updated'], 'safe'],
            [['ecm_products_ref', 'edi_relation_clients_ref', 'rate'], 'default', 'value' => null],
            [['ecm_products_ref', 'edi_relation_clients_ref', 'rate'], 'integer'],
            [['is_published', 'is_notify_client', 'is_trash'], 'boolean'],
            [['client_message', 'admin_answer', 'positive', 'negative'], 'string'],
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
            'dt_created' => 'Dt Created',
            'ecm_products_ref' => 'Ecm Products Ref',
            'edi_relation_clients_ref' => 'Edi Relation Clients Ref',
            'is_published' => 'Is Published',
            'dt_updated' => 'Dt Updated',
            'client_message' => 'Client Message',
            'admin_answer' => 'Admin Answer',
            'is_notify_client' => 'Is Notify Client',
            'positive' => 'Positive',
            'negative' => 'Negative',
            'rate' => 'Rate',
            'is_trash' => 'Is Trash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductsRef()
    {
        return $this->hasOne(EcmProducts::className(), ['id' => 'ecm_products_ref']);
    }
}
