<?php

namespace common\models\models;

use common\models\ar\RArSysVisitors;
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
class SysVisitors extends RArSysVisitors
{
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['dt_created', 'user_agent', 'request_uri', 'http_referer', 'remote_addr', 'data'], 'safe'],
            //[['user_agent', 'request_uri', 'http_referer'], 'string'],
            //[['visitor_key', 'remote_addr'], 'string', 'max' => 255],
        ];
    }

}
