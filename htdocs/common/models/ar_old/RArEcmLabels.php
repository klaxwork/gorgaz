<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "ecm_labels".
 *
 * @property int $id
 * @property string $label_name
 * @property string $label_key
 *
 * @property EcmProductHasLabels[] $ecmProductHasLabels
 */
class RArEcmLabels extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecm_labels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label_name', 'label_key'], 'required'],
            [['label_name', 'label_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label_name' => 'Label Name',
            'label_key' => 'Label Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductHasLabels()
    {
        return $this->hasMany(EcmProductHasLabels::className(), ['ecm_labels_ref' => 'id']);
    }
}
