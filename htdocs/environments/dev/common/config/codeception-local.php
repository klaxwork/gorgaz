<?php

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    !PRODUCTION_MODE ? require __DIR__ . '/main-local.php' : [],
    require __DIR__ . '/test.php',
    !PRODUCTION_MODE ? require __DIR__ . '/test-local.php' : [],
    [
        'components' => [
            'request' => [
                //'cookieValidationKey' => '', //'jpm8d9pG_7NxRvuSp0t-ApqjmGyKpp6V',
                //'csrfParam' => '_csrf',
                //'enableCsrfValidation' => false,
                //'enableCookieValidation' => false,
            ],
        ],
    ]
);
