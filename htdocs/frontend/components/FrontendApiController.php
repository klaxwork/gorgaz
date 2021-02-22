<?php

namespace frontend\components;

use common\models\models\CmsNodeContent;
use common\models\models\CmsTree;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\M;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\controllers;

/**
 * Site controller
 */
class FrontendApiController extends Controller
{
    public $layout = '@theme/views/layouts/main';
    public $page_title = 'public $page_title';
    public $page_keywords = '';
    public $page_description = '';
    public $page_noindexing = true;
    public $is_bot = false;
    public $is_main_page = false;

    public $data = [];

    public $formName = 'FilterForm';

    public $filterConfig = [
        'limit' => 40,
        'offset' => 0,
        'order' => 'price_up',
        'sort' => 'ASC',
        'countProducts' => 0,
        'countAll' => 0,
    ];

    /**
     * @inheritdoc
     */

    public function init() {
        $this->filterConfig = array_merge($this->filterConfig, !empty($_GET[$this->formName]) ? $_GET[$this->formName] : $_GET, !empty($_POST[$this->formName]) ? $_POST[$this->formName] : $_POST);
        //$cookies = Yii::$app->request->cookies;
        //$cookies->readOnly = false;
        //M::printr($cookies, '$cookies???');
    }

    public function behaviors() {
        if (1) {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['?'],
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
        }
        if (0) {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    //'only' => ['*'], //['logout', 'signup'],
                    'rules' => [
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            //'roles' => ['?'],
                        ],
                        /*/
                        [
                            'actions' => ['logout'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                        //*/
                    ],
                ],
                /*/
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
                //*/
            ];
        }
    }

    public function accessCheckFunction() {
        $res = [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['*'],
                        'allow' => true,
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

    public function page(CmsTree $node, $default_view = 'default') {
        M::printr('STOPPPPPP!!!!!!!!!!!');
        exit;
        $oNode = $node;
        $oContent = $oNode->content;
        //M::printr($oContent, '$oContent');

        if (1) {
            if (!$oNode->is_node_published) {
                $this->doPageNotFound();
            }
            $data = ['oNode' => $oNode, 'oContent' => $oContent];
            if (!empty($oContent->template)) {
                if (!empty($oContent->template->render_layout)) {
                    $this->layout = $oContent->template->render_layout;
                }
                $view = $oContent->template->render_view ?: $default_view;
            } else {
                $view = $default_view;
            }
        }

        if (0) {
            $page = new CmsNodeContent();
            $this->page_title = $node->seo_title ?: (isset($page->page_title) ? $page->page_title : null);
            $this->page_keywords = $page->seo_keywords ?: null;
            $this->page_description = $page->seo_description ?: null;
            $this->page_noindexing = $page->is_seo_noindexing;
        }
        if (0) {
            $page = new \CmsTree\Node\Entity($node);

            $this->page_title = $page->seo_title ?: (isset($page->page_title) ? $page->page_title : null);
            $this->pageTitle = $page->seo_title ?: (isset($page->page_title) ? $page->page_title : null);
            $this->page_keywords = $page->seo_keywords ?: null;
            $this->page_description = $page->seo_description ?: null;
            $this->page_noindexing = $page->is_seo_noindexing;

            if (!$page->is_node_published) {
                $this->doPageNotFound();
            }

            if (!empty($page->template)) {
                if (!empty($page->template->render_layout)) {
                    $this->layout = $page->template->render_layout;
                }
                $view = $page->template->render_view ?: $default_view;
                $this->render($view, ['page' => $page]);
            } else {
                $this->render($default_view, ['page' => $page]);
            }
        }

        return $this->render($view, array_merge([], $data, $this->data));
    }

    public function fillSeo($obj) {
        if (($obj instanceof CmsNodeContent)) {
            $title = null;
            if ($obj instanceof CmsNodeContent) {
                $title = $obj->seo_title ?: (isset($obj->page_title) ? $obj->page_title : $obj->node_name);
            }
            if (!empty($obj)) {
                $this->page_title = $title; //$obj->seo_title ?: (isset($obj->page_title) ? $obj->page_title : null);
                $this->page_keywords = $obj->seo_keywords ?: null;
                $this->page_description = $obj->seo_description ?: null;
                $this->page_noindexing = $obj->is_seo_noindexing;
            }
        }
    }

    public function beforeAction($action) {
        $server = $_SERVER;
        $this->genRandomKey();
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function genRandomKey() {
        $str = '1234567890qwertyuiopasdfghjklzxcvbnm';
        $key = '';
        while (1){
            for ($i = 0; $i < 32; $i++) {
                $key .= $str[rand(0, strlen($str) - 1)];
            }
            //M::printr($key, '$key');

            break;
        }

        return $key;

    }

}
