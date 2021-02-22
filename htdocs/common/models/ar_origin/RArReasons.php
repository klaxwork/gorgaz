<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "reasons".
 *
 * @property int $id
 * @property string $reason_name
 * @property string|null $reason_code
 */
class RArReasons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reasons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason_name'], 'required'],
            [['reason_name', 'reason_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reason_name' => 'Reason Name',
            'reason_code' => 'Reason Code',
        ];
    }
}
