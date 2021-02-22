<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "ecm_warehouse".
 *
 * @property int $id
 * @property string $warehouse_name
 * @property string $description
 * @property string $data
 * @property string $location_address
 * @property bool $is_store_default
 * @property string $identify_key
 * @property string $dev_key
 *
 * @property EcmProductStore[] $ecmProductStores
 */
class RArEcmWarehouse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_warehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['warehouse_name'], 'required'],
            [['description', 'data', 'location_address'], 'string'],
            [['is_store_default'], 'boolean'],
            [['warehouse_name', 'dev_key'], 'string', 'max' => 255],
            [['identify_key'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'warehouse_name' => 'Warehouse Name',
            'description' => 'Description',
            'data' => 'Data',
            'location_address' => 'Location Address',
            'is_store_default' => 'Is Store Default',
            'identify_key' => 'Identify Key',
            'dev_key' => 'Dev Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductStores()
    {
        return $this->hasMany(EcmProductStore::className(), ['ecm_warehouse_ref' => 'id']);
    }
}
