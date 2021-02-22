<?php

namespace frontend\modules\page\controllers;

use common\components\M;
use common\models\Cart;
use common\models\Wish;
use yii;
use frontend\components\FrontendController;
use yii\helpers\Json;
use yii\base\Exception;

class WishController extends FrontendController
{
    public function returnUrl()
    {
        $url = parse_url($_SERVER['HTTP_REFERER']);
        return $url['path'];
    }

    public function actionIndex()
    {
        $formName = 'Wish';
        $Wish = (new Wish())->give();
        if (!($Wish instanceof Wish) || !$Wish->save()) {
            return false;
        }
        return $this->render('index', ['formName' => $formName]);
    }

    //переключение товара в желаниях
    public function actionToggle($id)
    {
        $JS = ['success' => true];
        $JS['id'] = $id;
        $oWish = (new Wish())->give();
        //M::printr($oWish, '$oWish');
        $is_exist = false;
        foreach ($oWish->wishProducts as $oWishProducts) {
            //M::printr($oWishProducts, '$oWishProducts');
            if ($oWishProducts->ecm_products_ref == $id) {
                $is_exist = true;
            }
        }
        if ($is_exist) {
            $JS['action'] = 'remove';
            if (!$oWish->removeProduct($id)) {
                $JS['success'] = false;
                $JS['message'] = "Can`t delete product " . $id;
            }
        } else {
            $JS['action'] = 'add';
            $oWish->addProduct($id);
        }
        //M::printr($oWish, '$oWish');

        if (Yii::$app->request->isAjax) {
            $oWish = (new Wish())->give();
            $JS['wishProducts'] = $oWish->wishProducts;
            $JS['count'] = count($oWish->wishProducts);
            return Json::encode($JS);
        }
        return Json::encode($JS);
    }

}

