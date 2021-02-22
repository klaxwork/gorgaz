<?php

namespace backend\modules\scripts\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\components\BackendController;

/**
 * Default controller for the `scripts` module
 */
class DefaultController extends BackendController
{
    /*/
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['*'],
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
    //*/

    public function actionIndex() {
        return $this->render('index');
    }

}
