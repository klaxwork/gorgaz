<?php
$themeName = 'gorgaz';
Yii::setAlias('@theme', dirname(dirname(__DIR__)) . '/frontend/web/themes/' . $themeName);
Yii::setAlias('@layouts', '@theme/views/layouts');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        //'cart' => ['class' => 'frontend\modules\cart\cart'],
        'catalog' => ['class' => 'frontend\modules\catalog\catalog'],
        'comments' => ['class' => 'frontend\modules\comments\comments'],
        'elastic' => ['class' => 'frontend\modules\elastic\elastic'],
        'page' => ['class' => 'frontend\modules\page\page'],
        'product' => ['class' => 'frontend\modules\product\product'],

    ],
    'components' => [
        /*/
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'keyPrefix' => 'fishmen5_frontend',
            'cachePath' => '@runtime/cache',
        ],

        'cache'=>array(
            'class'=>'CRedisCache',
            'hostname'=>'redis.whdb',
            'port'=>6379,
            'database'=>7,
        ),

        'cache' => [
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'redis.whdb',
                'port' => 6379,
                'database' => 101,
            ]
        ],
        //*/
        'mymailer' => [
            //*/
            'class' => 'PHPMailer\PHPMailer\PHPMailer',
            'CharSet' => 'UTF-8',
            'From' => 'info@qw4.n2.userdev.ru',
            //'Mailer' => 'sendmail',
            //'SMTPAuth' => true,
            //'Host' => '10.10.0.8',
            //'Username' => 'postmaster@userdev.ru',
            //'Password' => 'ZdE32Df341',
            /*/
            'class' => 'PHPMailer\PHPMailer\PHPMailer',
            'CharSet' => 'UTF-8',
            'From' => 'klaxwork.dn@gmail.com',
            'FromName' => 'klaxwork.dn',
            'Mailer' => 'smtp',
            'SMTPAuth' => true,
            'Host' => 'smtp.gmail.com',
            'Port' => '25', //'465',
            'Username' => 'klaxwork@mail.ru',
            'Password' => 'Vjybnjh1',
            //*/
        ],

        /*/
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=10.10.20.1;port=5432;dbname=vh_fish5_r0pub',
            'username' => 'devteam',
            'password' => 'ufkkflhbtkm',
            'charset' => 'utf8',
        ],
        //*/
        'view' => [
            'theme' => [
                'baseUrl' => '@web/themes/' . $themeName,
                'basePath' => '@app/web/themes/' . $themeName,
                'pathMap' => [
                    '@app/views' => '@app/themes/' . $themeName,
                ],
            ],
            //'class' => 'frontend\components\view',
        ],
        'request' => [
            // COOKIE
            'cookieValidationKey' => 'jpm8d9pG_7NxRvuSp0t-ApqjmGyKpp6V',
            'enableCsrfCookie' => false,
            'enableCookieValidation' => false,

            // CSRF
            'csrfParam' => '_csrf',
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'class' => 'frontend\components\WebUser',
            'identityClass' => 'frontend\components\UserIdentity',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-frontend',
                'httpOnly' => true
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
            'suffix' => '/',
            'rules' => [
                //htdocs/frontend/modules/catalog/controllers/DefaultController.php
                'test' => 'site/index',

                'debugOn' => 'site/debug-on',
                'debugOff' => 'site/debug-off',

                //'/' => 'page/watch/view/node_id/100',
                //'/' => 'page/watch/main',
                '/' => 'page/watch/index',
                'about' => 'page/watch/about',
                'work' => 'page/watch/work',
                'blog' => 'page/watch/blog',
                'contacts' => 'page/watch/contacts',
                'form' => 'product/default/form',

                'fillbase' => 'product/default/fillbase',
                'get-models-of-type' => 'product/default/get-models-of-type',
                //'get-models-of-type/<typeId:\d+>' => 'product/default/get-models-of-type',

                'saveOrder' => 'product/default/save-order',
                'saveImage' => 'product/default/save-image',

                'api/get/orders' => 'product/api/orders',
                [
                    'pattern' => 'api/get/orders',
                    'suffix' => '',
                    'route' => 'product/api/orders',
                ],

                'api/post/status' => 'product/api/status',
                [
                    'pattern' => 'api/post/status',
                    'suffix' => '',
                    'route' => 'product/api/status',
                ],


                'product/<id:\d+>' => 'product/default/view',
                [
                    'pattern' => 'product/<id:\d+>',
                    'suffix' => '',
                    'route' => 'product/default/view',
                ],

                //'search' => 'elastic/default/search',
                [
                    'pattern' => 'search',
                    'suffix' => '',
                    'route' => 'product/default/search',
                ],
                'search' => 'product/default/search',
                [
                    'pattern' => 'search/<request:\w+>',
                    'suffix' => '',
                    'route' => 'product/default/search',
                ],
                'search/<request:\w+>' => 'product/default/search',
                //'search/<request:\w+>' => 'product/default/search',
                //'fast-search' => 'elastic/default/fast-search',
                //'search/test' => 'elastic/default/search-test',
                //'search/test/<request:\w+>' => 'elastic/default/search-test',


                //'catalog' => 'page/watch/view',
                [
                    'pattern' => 'robots.txt',
                    'route' => 'page/robots',
                    'suffix' => '',
                ],
                [
                    'pattern' => 'sitemap.xml',
                    'route' => 'page/sitemap',
                    'suffix' => '',
                ],
                'product/<id:d+>' => 'product/default/view',
                'productCreate' => 'product/default/create',
                'productEdit' => 'product/default/edit',
                'productSave' => 'product/default/save',


                'testmail' => 'site/testmail',
                'getCity' => 'page/default/get-city',
                'regions' => 'page/default/get-regions',
                'getCities/<regionId:\d+>' => 'page/default/get-cities',
                'cityReply' => 'page/default/city-reply',

                'loadMoreProducts/<node_id:\d+>' => 'catalog/default/load-more-products', //'catalog/default/loadMoreProducts',
                'getProductComments/<ecm_products_ref:\d+>' => 'catalog/products/get-product-comments',

                'loadMoreComments' => 'comments/default/load-more-comments',
                'formComments/<ecm_products_ref:\w+>' => 'comments/default/form-comments',

                'cart' => 'page/cart/index',
                'cart/getCart' => 'page/cart/get-cart',
                'cart/<action:\w+>' => 'page/cart/<action>',
                'cart/<action:\w+>/<id:\w+>' => 'page/cart/<action>',
                'cart/<action:\w+>/<id:\w+>/<quantity:\d+>' => 'page/cart/<action>',

                'cart/add-product/<id:\w+>' => 'page/cart/add-product',

                'wish' => 'page/wish',
                'wish/toggle/<id:\d+>' => 'page/wish/toggle',
                'wish/<action:\w+>' => 'page/wish/<action>',
                'wish/<action:\w+>/<id:\d+>' => 'page/wish/<action>',

                'order' => 'page/order/index',
                'order/create' => 'page/order/create',
                'order/success/<order_id:\w+>' => 'page/order/success',

                //'addToCart/<id:\w+>' => 'page/cart/add-product',
                //'cart/getCart' => 'page/cart/get-cart',
                //'cart/setProduct' => 'page/cart/set-product',
                //'cart' => 'page/cart/index',

                'sendForCallback' => 'page/modals/send-for-callback',
                'sendForRecall' => 'page/modals/send-for-recall',

                'telebot' => 'page/telebot',

                //'catalog' => 'catalog/default/view',
                //'catalog/<node_id:\d+>' => 'catalog/default/view',
                'login' => 'site/login',
                //*/
                [
                    'class' => 'frontend\components\MyUrlRule',
                    'caseSensitive' => 'i',
                ],
                //*/

                //'<action:[\w-]+>' => '<action>',
                //'<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
                //'<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>' => '<module>/<controller>/<action>',
            ],
        ],
        //*/
    ],
    'params' => $params,
];
