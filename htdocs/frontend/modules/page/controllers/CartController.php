<?php

namespace frontend\modules\page\controllers;

use common\components\M;
use common\models\Cart;
use yii;
use frontend\components\FrontendController;
use yii\helpers\Json;
use yii\base\Exception;

class CartController extends FrontendController
{
    public function returnUrl()
    {
        $url = parse_url($_SERVER['HTTP_REFERER']);
        return $url['path'];
    }

    public function actionIndex()
    {
        $formName = 'Cart';
        $Cart = (new Cart())->give();
        if (!($Cart instanceof Cart) || !$Cart->save()) {
            return false;
        }
        return $this->render('index', ['formName' => $formName]);
    }

    public function actionGetCart()
    {
        //получить всю корзину и вернуть ее в виде JSON
        $Cart = (new Cart())->give();
        //M::printr($Cart, '$Cart');

        //привести все в нормальный массив
        $JS = [
            'success' => true,
            'cartProducts' => [],
            'countItems' => 0,
        ];

        foreach ($Cart->cartProducts as $oCartProduct) {
            $item = $oCartProduct->attributes;
            $item['oProduct'] = $oCartProduct->product;
            $JS['cartProducts'][] = $item;
            $JS['countItems'] += $oCartProduct->quantity;
        }
        $JS['countProducts'] = count($Cart->cartProducts);

        //M::printr($JS, '$JS');
        if (Yii::$app->request->isAjax) {
            return Json::encode($JS);
        }
        return Json::encode($JS);
    }

    public function actionAddProduct($id = null)
    {
        //M::printr($id, '$id');
        //M::printr($_POST, '$_POST');

        $JS = [
            'success' => true,
            'message' => null,
            'messages' => [],
        ];
        $Cart = (new Cart())->give();

        $quantity = !empty($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        try {
            //M::printr($Cart, '$Cart');
            if (!$Cart->addProduct($id, $quantity)) {
                $JS['messages'] = $Cart->getErrors();
            }
            //M::printr($Cart, '$Cart');
        } catch (Exception $e) {
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
            $JS['messages'] += $Cart->getErrors();
        }
        //M::xlog(['[ADD PRODUCT] ($JS)', $JS]);
        //M::printr(['[ADD PRODUCT] ($JS)', $JS]);

        if (Yii::$app->request->isAjax) {
            return Json::encode($JS);
        }

        $url = $this->returnUrl();
        if (!empty($url)) {
            return $this->redirect($this->returnUrl());
        }
    }

    public function actionRemoveProduct($id)
    {
        $JS['success'] = true;
        $JS['messages'] = [];
        $Cart = (new Cart())->give();
        try {
            $Cart->removeProduct($id);
        } catch (Exception $e) {
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
            $JS['messages'] += $Cart->getErrors();
        }

        if (Yii::$app->request->isAjaxRequest) {
            return Json::encode($JS);
        }

        $url = $this->returnUrl();
        if (!empty($url)) {
            return $this->redirect($this->returnUrl());
        }
    }

    public function actionClearCart()
    {
        $JS['success'] = true;
        $JS['messages'] = [];
        $Cart = (new Cart())->give();
        try {
            $Cart->clear();
        } catch (Exception $e) {
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
            $JS['messages'] += $Cart->getErrors();
        }

        if (Yii::app()->request->isAjaxRequest) {
            print CJSON::encode($JS);
            Yii::app()->end();
        }

        $url = $this->returnUrl();
        if (!empty($url)) {
            $this->redirect($this->returnUrl());
        }
    }

    public function actionSetProduct($id, $quantity = 1)
    {
        //M::printr($id, '$id');
        //M::printr($_POST, '$_POST');
        $JS['success'] = true;
        $JS['messages'] = [];
        $Cart = (new Cart())->give();
        try {

            if (!$Cart->setProduct($id, $quantity)) {
                $JS['messages'] = $Cart->getErrors();
            }
        } catch (Exception $e) {
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
            $JS['messages'] += $Cart->getErrors();
        }

        if (Yii::$app->request->isAjax) {
            return Json::encode($JS);
        }

        $url = $this->returnUrl();
        if (!empty($url)) {
            return $this->redirect($this->returnUrl());
        }
    }

    public function actionIncProduct($id)
    {
        //M::printr($id, '$id');
        //M::printr($_POST, '$_POST');
        $JS['success'] = true;
        $JS['messages'] = [];
        $Cart = (new Cart())->give();
        try {
            if (!$Cart->incProduct($id)) {
                $JS['messages'] = $Cart->getErrors();
            }
            //$JS['quantity'] = $Cart->cartProducts[$id]->quantity;

        } catch (Exception $e) {
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
            $JS['messages'] += $Cart->getErrors();
        }

        if (Yii::app()->request->isAjaxRequest) {
            print CJSON::encode($JS);
            Yii::app()->end();
        }

        $url = $this->returnUrl();
        if (!empty($url)) {
            $this->redirect($this->returnUrl());
        }
    }

    public function actionDecProduct($id, $quantity = 1)
    {
        //M::printr($id, '$id');
        //M::printr($_POST, '$_POST');
        $JS['success'] = true;
        $JS['messages'] = [];
        $Cart = (new Cart())->give();
        try {
            if (!$Cart->decProduct($id, $quantity)) {
                $JS['messages'] = $Cart->getErrors();
            }

        } catch (Exception $e) {
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
            $JS['messages'] += $Cart->getErrors();
        }

        if (Yii::app()->request->isAjaxRequest) {
            print CJSON::encode($JS);
            Yii::app()->end();
        }

        $url = $this->returnUrl();
        if (!empty($url)) {
            $this->redirect($this->returnUrl());
        }
    }

}

