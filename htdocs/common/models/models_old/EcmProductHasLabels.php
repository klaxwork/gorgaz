<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArEcmProductHasLabels;

/**
 * This is the model class for table "ecm_product_has_labels".
 *
 * @property int $id
 * @property int $ecm_products_ref
 * @property int $ecm_labels_ref
 *
 * @property EcmLabels $ecmLabelsRef
 * @property EcmProducts $ecmProductsRef
 */
class EcmProductHasLabels extends RArEcmProductHasLabels
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_product_has_labels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ecm_products_ref'], 'required'],
            [['ecm_products_ref', 'ecm_labels_ref'], 'default', 'value' => null],
            [['ecm_products_ref', 'ecm_labels_ref'], 'integer'],
            [['ecm_labels_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmLabels::className(), 'targetAttribute' => ['ecm_labels_ref' => 'id']],
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
            'ecm_products_ref' => 'Ecm Products Ref',
            'ecm_labels_ref' => 'Ecm Labels Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabel()
    {
        return $this->hasOne(EcmLabels::className(), ['id' => 'ecm_labels_ref'])->alias('label');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(EcmProducts::className(), ['id' => 'ecm_products_ref'])->alias('product');
    }
}
