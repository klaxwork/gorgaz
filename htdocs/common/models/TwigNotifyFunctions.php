<?php

namespace common\models;

use common\components\M;

class TwigNotifyFunctions
{

    public function times($tm)
    {
        return strftime('%H:%M', $tm);
    }

    public function dates($tm)
    {
        return strftime('%d.%m.%Y', $tm);
    }

    public function createProductUrl($external_hynt_id)
    {
        return \yii\helpers\Url::to(['/route/product', 'external_hynt_id' => $external_hynt_id]);
    }

}
