<?php
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            //'dsn' => 'pgsql:host=elastic.whdb;dbname=edi_fish_r6dev',
            'dsn' => 'pgsql:host=10.10.0.249;dbname=edi_fish_r6dev',
            'username' => 'devteam',
            'password' => '',
            'charset' => 'utf8',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
        ],
    ],
];
