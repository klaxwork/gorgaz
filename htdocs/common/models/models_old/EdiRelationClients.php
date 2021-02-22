<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArEdiRelationClients;

/**
 * This is the model class for table "edi_relation_clients".
 *
 * @property int $id
 * @property int $edi_use_applications_ref
 * @property int $client_id
 * @property string $client_view_name
 * @property string $data
 * @property int $app_clients_ref
 *
 * @property AppQuestComments[] $appQuestComments
 * @property EbsSeanceBooking[] $ebsSeanceBookings
 * @property EcmOrders[] $ecmOrders
 * @property EcmWishes[] $ecmWishes
 * @property AppClients $appClientsRef
 * @property EdiUseApplications $ediUseApplicationsRef
 */
class EdiRelationClients extends RArEdiRelationClients
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edi_relation_clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['client_id', 'client_view_name'], 'required'],
            //[['edi_use_applications_ref', 'client_id', 'app_clients_ref'], 'default', 'value' => null],
            //[['edi_use_applications_ref', 'client_id', 'app_clients_ref'], 'integer'],
            //[['data'], 'string'],
            //[['client_view_name'], 'string', 'max' => 255],
            //[['app_clients_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AppClients::className(), 'targetAttribute' => ['app_clients_ref' => 'id']],
            //[['edi_use_applications_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EdiUseApplications::className(), 'targetAttribute' => ['edi_use_applications_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'edi_use_applications_ref' => 'Edi Use Applications Ref',
            'client_id' => 'Client ID',
            'client_view_name' => 'Client View Name',
            'data' => 'Data',
            'app_clients_ref' => 'App Clients Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppQuestComments()
    {
        return $this->hasMany(AppQuestComments::className(), ['edi_relation_clients_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEbsSeanceBookings()
    {
        return $this->hasMany(EbsSeanceBooking::className(), ['edi_relation_clients_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmOrders()
    {
        return $this->hasMany(EcmOrders::className(), ['edi_relation_clients_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmWishes()
    {
        return $this->hasMany(EcmWishes::className(), ['edi_relation_clients_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(AppClients::className(), ['id' => 'app_clients_ref'])->alias('client');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(EdiUseApplications::className(), ['id' => 'edi_use_applications_ref'])->alias('application');
    }
}
