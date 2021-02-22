<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "equipment_types".
 *
 * @property int $id
 * @property string|null $type_name
 *
 * @property EquipmentModels[] $equipmentModels
 * @property OrderEquipments[] $orderEquipments
 */
class RArEquipmentTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Type Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentModels()
    {
        return $this->hasMany(EquipmentModels::className(), ['equipment_types_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderEquipments()
    {
        return $this->hasMany(OrderEquipments::className(), ['equipment_types_ref' => 'id']);
    }
}
