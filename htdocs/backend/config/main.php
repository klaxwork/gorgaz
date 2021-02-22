<?php
$themeName = 'memory';

Yii::setAlias('@theme', '@backend/web/themes/' . $themeName);
Yii::setAlias('@layouts', '@theme/views/layouts');
Yii::setAlias('@webtheme', '/themes/' . $themeName);


$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            // регулируйте в соответствии со своими нуждами
            'allowedIPs' => ['*', '::1', '192.168.0.*', '192.168.178.20', '127.0.0.1']
        ],
        'auth' => [
            'class' => 'backend\modules\auth\auth',
        ],
        'cms' => [
            'class' => 'backend\modules\cms\cms',
        ],
        'scripts' => [
            'class' => 'backend\modules\scripts\scripts',
        ],
        'images' => [
            'class' => 'backend\modules\images\images',
        ],
    ],
    'components' => [
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/' . $themeName,
                'baseUrl' => '@web/themes/' . $themeName,
                'pathMap' => [
                    '@app/views' => '@app/themes/' . $themeName,
                ],
            ],
        ],
        'user' => [
            'class' => 'backend\components\WebUser',
            'identityClass' => 'backend\components\UserIdentity',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true
            ],
        ],
        'request' => [
            'enableCookieValidation' => false,
            'cookieValidationKey' => 'jpm8d9pG_7NxRvuSp0t-ApqjmGyKpp6V',
            'csrfParam' => '_csrf-backend',
            'enableCsrfValidation' => false,
            //''
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        //*/
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                //'' => 'site/index',
                //'<action>' => 'site/<action>',

                //'debugOn' => 'site/debug-on',
                //'debugOff' => 'site/debug-off',

                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
        //*/
    ],
    'params' => $params,
];
