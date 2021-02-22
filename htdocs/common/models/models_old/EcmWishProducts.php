<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArEcmWishProducts;
use common\models\models\EcmProducts;
use common\models\models\EcmWishes;

/**
 * This is the model class for table "ecm_wish_products".
 *
 * @property int $id
 * @property int $ecm_wishes_ref
 * @property int $ecm_products_ref
 *
 * @property EcmProducts $ecmProductsRef
 * @property EcmWishes $ecmWishesRef
 */
class EcmWishProducts extends RArEcmWishProducts
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_wish_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ecm_wishes_ref', 'ecm_products_ref'], 'default', 'value' => null],
            [['ecm_wishes_ref', 'ecm_products_ref'], 'integer'],
            [['ecm_products_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmProducts::className(), 'targetAttribute' => ['ecm_products_ref' => 'id']],
            [['ecm_wishes_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmWishes::className(), 'targetAttribute' => ['ecm_wishes_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ecm_wishes_ref' => 'Ecm Wishes Ref',
            'ecm_products_ref' => 'Ecm Products Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(EcmProducts::className(), ['id' => 'ecm_products_ref'])->alias('product');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmWishesRef()
    {
        return $this->hasOne(EcmWishes::className(), ['id' => 'ecm_wishes_ref']);
    }
}
