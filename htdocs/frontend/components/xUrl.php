<?php

namespace frontend\components;

use common\components\M;
use Yii;

class Url extends \yii\helpers\Url
{
    public static function to($url = '', $scheme = false)
    {
        M::printr('MYURL');
        if ($url == 'page/catalog') {
            $params = $scheme;
            M::printr($params, '$params');
        }

        return parent::to($url, $scheme);
    }

}