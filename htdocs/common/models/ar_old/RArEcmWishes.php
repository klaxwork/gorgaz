<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "ecm_wishes".
 *
 * @property int $id
 * @property int $edi_relation_clients_ref
 * @property string $wish_key
 * @property string $dt_created
 * @property string $dt_updated
 *
 * @property EcmWishProducts[] $ecmWishProducts
 * @property EdiRelationClients $ediRelationClientsRef
 */
class RArEcmWishes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_wishes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edi_relation_clients_ref'], 'default', 'value' => null],
            [['edi_relation_clients_ref'], 'integer'],
            [['wish_key'], 'required'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['wish_key'], 'string', 'max' => 255],
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
            'wish_key' => 'Wish Key',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmWishProducts()
    {
        return $this->hasMany(EcmWishProducts::className(), ['ecm_wishes_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdiRelationClientsRef()
    {
        return $this->hasOne(EdiRelationClients::className(), ['id' => 'edi_relation_clients_ref']);
    }
}
