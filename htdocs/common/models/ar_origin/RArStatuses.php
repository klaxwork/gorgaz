<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "statuses".
 *
 * @property int $id
 * @property string|null $status_name
 */
class RArStatuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_name' => 'Status Name',
        ];
    }
}
