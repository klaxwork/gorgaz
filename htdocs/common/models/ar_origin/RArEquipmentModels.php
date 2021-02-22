<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "equipment_models".
 *
 * @property int $id
 * @property string|null $model_name
 * @property int|null $equipment_types_ref
 *
 * @property EquipmentTypes $equipmentTypesRef
 * @property OrderEquipments[] $orderEquipments
 */
class RArEquipmentModels extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_models';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_types_ref'], 'default', 'value' => null],
            [['equipment_types_ref'], 'integer'],
            [['model_name'], 'string', 'max' => 255],
            [['equipment_types_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentTypes::className(), 'targetAttribute' => ['equipment_types_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_name' => 'Model Name',
            'equipment_types_ref' => 'Equipment Types Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentTypesRef()
    {
        return $this->hasOne(EquipmentTypes::className(), ['id' => 'equipment_types_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderEquipments()
    {
        return $this->hasMany(OrderEquipments::className(), ['equipment_models_ref' => 'id']);
    }
}
