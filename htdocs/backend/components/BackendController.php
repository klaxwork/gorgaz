<?php

namespace backend\components;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\M;
use common\models\LoginForm;
use backend\controllers;

/**
 * Site controller
 */
class BackendController extends Controller
{
    public $layout =
        //'@theme/views/layouts/ct-default'//
        '@theme/views/layouts/main'//
        //'@theme/views/layouts/assets'//
    ;
    //public $layout = '@theme/views/layouts/assets';


    public $breadcrumbs = [];
    /*/
    public function filters() {
        return [
            'accessControl',
        ];
    }
    //*/

    /**
     * @inheritdoc
     */
    public function behaviors() {
        //M::printr(Yii::$app->controller->id, 'Yii::$app->controller->id');
        //M::printr(Yii::$app->controller->module->id, 'Yii::$app->controller->module->id');
        //M::printr(Yii::$app->controller->action->id, 'Yii::$app->controller->action->id');

        $res = [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'logout'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [Yii::$app->controller->action->id], //['index', 'index2', 'logout'], //, 'index'
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
        return $res;
    }

    public function accessCheckFunctions() {
        M::printr('accessCheckFunctions()');
        $res = [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['*'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['*'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
        return $res;
        /*/
        //M::printr(Yii::app()->user->returnUrl, 'Yii::app()->user->returnUrl');
        //exit;
        if (Yii::app()->region->domain == "2fs.ru") {
            //return true;
        }
        $module = $this->module ? $this->module->id . '.' : '';
        $controller = $this->id;
        $action = $this->action->id;

        //M::printr($module, '$module');
        //M::printr($controller, '$controller');
        //M::printr($action, '$action');

        $routes = array();
        $routes[] = $module . $controller . '.' . $action;
        $routes[] = $module . $controller . '.*';
        $routes[] = $module . '*';
        $routes[] = '*';
        //M::printr($routes, '$routes');

        $auth = [
            'cabinet.cabinet.*',
        ];
        $allow = [
            '*',
        ];

        //найти адрес среди требующих авторизацию
        $is_allow = true;
        foreach ($routes as $route) {
            if (in_array($route, $auth)) {
                if (!Yii::app()->user->id) {
                    $is_allow = false;
                    $this->redirect(array('/cabinet/auth/login'));
                }
            }
        }
        return $is_allow;
        //*/

    }
}
