<?php

namespace backend\modules\auth\controllers;

use yii\web\Controller;
use backend\components\BackendController;

/**
 * Default controller for the `auth` module
 */
class DefaultController extends BackendController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
