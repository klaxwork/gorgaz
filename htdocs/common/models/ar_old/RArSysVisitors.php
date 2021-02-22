<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "sys_visitors".
 *
 * @property int $id
 * @property string|null $visitor_key
 * @property string|null $dt_created
 * @property string|null $user_agent
 * @property string|null $request_uri
 * @property string|null $http_referer
 * @property string|null $remote_addr
 * @property string|null $data
 */
class RArSysVisitors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_visitors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_created'], 'safe'],
            [['user_agent', 'request_uri', 'http_referer'], 'string'],
            [['visitor_key', 'remote_addr'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visitor_key' => 'Visitor Key',
            'dt_created' => 'Dt Created',
            'user_agent' => 'User Agent',
            'request_uri' => 'Request Uri',
            'http_referer' => 'Http Referer',
            'remote_addr' => 'Remote Addr',
            'data' => 'Data',
        ];
    }
}
