<?php
define('ROOT_DIR', realpath(__DIR__ . '/../../'));
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@storage', dirname(dirname(__DIR__)) . '/var/storage');

//*/
define(
    'PRODUCTION_MODE',
    file_exists(ROOT_DIR . '/PRODUCTION_MODE') or
    (bool)@$_ENV['PRODUCTION_MODE'] or
    (bool)@$_SERVER['PRODUCTION_MODE']
);
//if (!PRODUCTION_MODE) require(ROOT_DIR . 'common/debugmode.php');
//*/