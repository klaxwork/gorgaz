<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArStatuses;

/**
 * This is the model class for table "statuses".
 *
 * @property int $id
 * @property string|null $status_name
 */
class Statuses extends RArStatuses
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
