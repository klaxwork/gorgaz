<?php

namespace frontend\modules\page\controllers;

use common\components\M;
use common\models\Cart;
use common\models\Clients;
use common\models\models\EcmProducts;
use common\models\models\EdiBootstrap;
use common\models\OrderManager;
use common\models\TwigNotify;
use yii;
use frontend\components\FrontendController;
use yii\helpers\Json;
use yii\base\Exception;
use yii\web\HttpException;

class RobotsController extends FrontendController
{
    public $layout = false;

    public function actionIndex()
    {
        //header('Content-Type: text/plain');
        //Yii::$app->getResponse()->getHeaders()->set('Content-Type', 'text/plain; charset=UTF-8');

        $this->layout = false;
        Yii::$app->response->format = yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/plain');

        //$sub = Yii::$app->region->subdomain;
        //$domain = 'fishmen.ru'; // Yii::$app->region->domain;

        $host = 'fishmen.ru'; // $sub != Yii::$app->region->{'default'} ? $sub . '.' . $domain : $domain;
        $res = $this->renderPartial('robots', ['host' => $host]);
        return $res;
        //return $this->render('robots', compact('host'));
    }

}
