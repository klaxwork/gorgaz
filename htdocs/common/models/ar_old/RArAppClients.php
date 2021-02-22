<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "app_clients".
 *
 * @property int $id
 * @property int $client_mirror_id
 * @property int $client_private_id
 * @property string $client_hash_key
 * @property string $client_view_name
 * @property string $data
 * @property string $dt_created
 * @property string $dt_updated
 *
 * @property AppClientHasBonusAccount[] $appClientHasBonusAccounts
 * @property EcmCart[] $ecmCarts
 * @property EdiRelationClients[] $ediRelationClients
 */
class RArAppClients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_mirror_id', 'client_private_id'], 'default', 'value' => null],
            [['client_mirror_id', 'client_private_id'], 'integer'],
            [['data'], 'string'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['client_hash_key', 'client_view_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_mirror_id' => 'Client Mirror ID',
            'client_private_id' => 'Client Private ID',
            'client_hash_key' => 'Client Hash Key',
            'client_view_name' => 'Client View Name',
            'data' => 'Data',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppClientHasBonusAccounts()
    {
        return $this->hasMany(AppClientHasBonusAccount::className(), ['app_clients_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmCarts()
    {
        return $this->hasMany(EcmCart::className(), ['edi_relation_clients_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdiRelationClients()
    {
        return $this->hasMany(EdiRelationClients::className(), ['app_clients_ref' => 'id']);
    }
}
