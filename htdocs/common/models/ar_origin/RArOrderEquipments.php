<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "order_equipments".
 *
 * @property int $id
 * @property int|null $equipment_types_ref
 * @property int|null $equipment_models_ref
 * @property string|null $other_model
 * @property int|null $image_ref
 * @property int|null $orders_ref
 *
 * @property EquipmentModels $equipmentModelsRef
 * @property EquipmentTypes $equipmentTypesRef
 * @property Images $imageRef
 */
class RArOrderEquipments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_equipments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_types_ref', 'equipment_models_ref', 'image_ref'], 'default', 'value' => null],
            [['equipment_types_ref', 'equipment_models_ref', 'image_ref'], 'integer'],
            [['other_model'], 'string', 'max' => 255],
            [['equipment_models_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentModels::className(), 'targetAttribute' => ['equipment_models_ref' => 'id']],
            [['equipment_types_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentTypes::className(), 'targetAttribute' => ['equipment_types_ref' => 'id']],
            [['image_ref'], 'exist', 'skipOnError' => true, 'targetClass' => Images::className(), 'targetAttribute' => ['image_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipment_types_ref' => 'Equipment Types Ref',
            'equipment_models_ref' => 'Equipment Models Ref',
            'other_model' => 'Other Model',
            'image_ref' => 'Image Ref',
            'orders_ref' => 'orders_ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentModelsRef()
    {
        return $this->hasOne(EquipmentModels::className(), ['id' => 'equipment_models_ref']);
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
    public function getImageRef()
    {
        return $this->hasOne(Images::className(), ['id' => 'image_ref']);
    }
}
