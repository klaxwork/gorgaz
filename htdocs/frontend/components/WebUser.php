<?php

namespace frontend\components;

use common\models\Cart;
use common\models\Wish;
use Yii;
use yii\base\Component;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\components\M;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class WebUser extends yii\web\User
{
    public function getCart_key()
    {
        $cookies = Yii::$app->request->cookies;
        $cart_key = $cookies->getValue('cart_key');
        //M::printr($cookies, '$cookies');
        //M::printr($cart_key, '$cart_key');

        if (empty($cart_key)) {
            //если ключа корзины еще нет, то создать новую корзину в БД
            $Cart = (new Cart())->create();
            $cart_key = $Cart->cart_key;
            //M::printr($cart_key, '$cart_key');
        }

        return $cart_key;
    }

    public function getWish_key()
    {

        $cookies = Yii::$app->request->cookies;
        $wish_key = $cookies->getValue('wish_key', '');

        if (empty($wish_key)) {
            //если ключа закладок еще нет, то создать новую закладку в БД
            $Wish = (new Wish())->create();
            $wish_key = $Wish->wish_key;
        }

        return $wish_key;
    }

    public function getCurrency()
    {
        $rouble = '<span style="font-weight: normal; font-size:14pt;font-family:Arial;background-color:transparent;vertical-align:baseline;white-space:pre-wrap;">₽</span>';
        $rouble = '<i class="rouble">a</i>';
        $rouble = '<i style="font-style: normal; font-family: Arial;">&#8381;</i>';
        return $rouble;
    }

}
