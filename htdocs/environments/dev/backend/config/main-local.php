<?php

$config = [
    'components' => [
        'request' => [
            //'cookieValidationKey' => '', //'jpm8d9pG_7NxRvuSp0t-ApqjmGyKpp6V',
            //'csrfParam' => '_csrf',
            //'enableCsrfValidation' => false,
            //'enableCookieValidation' => false,
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
