<?php

return yii\helpers\ArrayHelper::merge(
    !PRODUCTION_MODE ? require dirname(dirname(__DIR__)) . '/common/config/codeception-local.php' : [],
    require __DIR__ . '/main.php',
    !PRODUCTION_MODE ? require __DIR__ . '/main-local.php' : [],
    require __DIR__ . '/test.php',
    !PRODUCTION_MODE ? require __DIR__ . '/test-local.php' : [],
    [
    ]
);
