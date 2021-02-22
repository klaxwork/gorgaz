<?php

namespace common\models;

use yii\web\UploadedFile;

class CMSH4UploadFile extends UploadedFile
{

    public static function handle()
    {
        return self::getInstanceByName('file');
    }

}
