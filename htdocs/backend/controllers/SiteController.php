<?php

namespace backend\controllers;

use common\models\Map;
use common\models\models\CmsTree;
use common\models\models\EcmProducts;
use common\models\Scripts;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\components\M;
use backend\components\BackendController;
use yii\web\Cookie;

/**
 * Site controller
 */
class SiteController extends BackendController
{
    /**
     * @inheritdoc
     */

    /*/
    public function behaviors() {
        $res = [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'index2', 'logout'], //, 'index'
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
        return $res;
    }
    //*/

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {

        $storage = Yii::getAlias('@storage');
        M::printr($storage, '$storage');

        $target = "..\..\..\.rawdata\\fd\\26\\duQh9h0Ux8E.png";
        M::printr($target, '$target');

        $link = "{$storage}/private/fd/26/duQh9h0Ux8E.png";
        M::printr($link, '$link');


        $alias = symlink(
            $target,
            $link
        );
        M::printr($alias, '$alias');


        exit;

        $storage = Yii::getAlias('@storage');
        M::printr($storage, '$storage');

        $target = "{$storage}/x1.php";
        $link = "{$storage}/x2.php";
        symlink($target, $link);
        M::printr(readlink($link), 'readlink($link)');

        $target = "{$storage}/public";
        $link = "{$storage}/public2";
        symlink($target, $link);
        M::printr(readlink($link), 'readlink($link)');

        exit;


        if (isset($_GET['chmod'])) {
            $res = system('chmod -R 0777 /srv/vhosts/fishmen/fs.test/htdocs/var/storage/.rawdata/* > /srv/vhosts/fishmen/fs.test/htdocs/var/storage/chmod-rawdata.txt', $x);
            $res = system('chmod -R 0777 /srv/vhosts/fishmen/fs.test/htdocs/var/storage/private/* > /srv/vhosts/fishmen/fs.test/htdocs/var/storage/chmod-private.txt', $x);
        }
        return $this->render('index');
        exit;

        $tm1 = microtime(true);
        Scripts::generateCats();
        $tm2 = microtime(true);
        M::printr($tm2 - $tm1, '$tm2 - $tm1');
        exit;

        $oProduct = EcmProducts::findOne(454);
        $oVendor = $oProduct->getField('1c_product_vendor');
        M::printr($oVendor, '$oVendor');
        $oFields = $oProduct->getProductFields();
        M::printr($oFields, '$oFields');
        exit;

        return $this->render('index');
    }

    public function actionTest() {
        print "actionTest()";
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {

        $this->layout = '@theme/views/layouts/main-external';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', ['model' => $model]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionIndex2() {
        return $this->render('index2');
    }

    public function actionDashboard() {
        return $this->render('dashboard');
    }

    public function actionRemap() {
        $oNode = CmsTree::findOne(['id' => 1648]);
        (new Map())->checkNode($oNode, ['is_gen_children' => true, 'is_full_path' => true]);
    }

    public function actionHash($pass = 'Zsadrety20') {
        M::printr($pass, '$pass');

        $username = 'admin';

        $oUserIdentity = UserIdentity::findByUsername($username);
        M::printr($oUserIdentity->attributes, '$oUserIdentity->attributes');

        $oUserIdentity->setPassword($pass);

        M::printr($oUserIdentity->attributes, '$oUserIdentity->attributes');
        exit;

    }

    public function actionDebugOn() {
        $cookies = Yii::$app->response->cookies;
        $debugCookie = new Cookie(
            [
                'name' => 'debug',
                'value' => true,
                'expire' => time() + 60 * 60 * 24 * 365,
            ]
        );
        $cookies->add($debugCookie);
        M::printr($cookies, '$cookies');
        exit;


        $cookie = new Cookie('debug');
        $cookie->expire = time() + 60 * 60 * 24 * 365; //1 year
        Yii::$app->request->cookies['debug'] = $cookie;
        if (isset(Yii::$app->request->cookies['debug'])) {
            $cookie = Yii::$app->request->cookies['debug']->value;
        } else {
            $cookie = new Cookie('debug');
            $cookie->expire = time() + 60 * 60 * 24 * 365; //1 year
            Yii::$app->request->cookies['debug'] = $cookie;
        }
    }

    public function actionDebugOff() {
        $cookies = Yii::$app->response->cookies;
        $debugCookie = new Cookie(
            [
                'name' => 'debug',
                'value' => false,
                'expire' => time() + 60 * 60 * 24 * 365,
            ]
        );
        $cookies->add($debugCookie);
        M::printr($cookies, '$cookies');

        exit;
        $cookie = new Cookie('debug');
        $cookie->expire = time() + 60 * 60 * 24 * 365; //1 year
        Yii::$app->request->cookies['debug'] = $cookie;
    }

}
