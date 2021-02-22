<?php

namespace common\models;

use common\models\models\EcmWishes;
use common\models\models\EcmWishProducts;
use yii\base\Exception;
use yii\base\Model;
use yii\web\Cookie;
use yii;
use common\components\M;

class Wish extends Model
{
    public $wishProducts = [];
    private $oWish;

    public function __construct()
    {
        //удалить все записи старше 5 дней
        $this->delete();
        $this->oWish = new EcmWishes();
        return parent::__construct();
    }

    public function attributeNames()
    {
        return [
            'wishProducts' => 'Список товаров',
            'oWish' => 'Модель желания',
        ];
    }

    /*public static function model()
    {
        $oEcmWishes = new EcmWishes();
        $th = new self;
        $th->oWish = $oEcmWishes;
        //$th->oWish->wish_key = Yii::app()->user->getWish_key();
        return $th;
    }*/

    public function create()
    {
        //создать новую закладку
        $this->oWish = new EcmWishes();
        $this->oWish->wish_key = $this->genKey();

        $cookies = Yii::$app->response->cookies;
        $wishCookie = new Cookie([
            'name' => 'wish_key',
            'value' => $this->oWish->wish_key,
            'expire' => time() + 60 * 60 * 24 * 365,
        ]);
        $cookies->add($wishCookie);

        if (!$this->oWish->save()) {
            throw new Exception('Can`t save...');
        }
        return $this;
    }

    public function give($wish_key = null)
    {
        //M::printr($wish_key, '$wish_key');
        if (empty($wish_key)) {
            $wish_key = \Yii::$app->user->getWish_key();
        }

        //получить закладки с товарами из БД

        $this->oWish = EcmWishes::find()
            ->joinWith(['wishProducts.product'])
            ->where(['wish_key' => $wish_key])
            ->one();
        if (empty($this->oWish)) {
            $this->create();
        }

        //добавить товары в модель корзины
        foreach ($this->oWish->wishProducts as $wishProduct) {
            $this->wishProducts[$wishProduct->ecm_products_ref] = $wishProduct;
        }

        $cookies = Yii::$app->request->cookies;
        $cookies->readOnly = false;
        $wishesCountCookie = new Cookie([
            'name' => 'wishesCount',
            'value' => count($this->wishProducts),
            'expire' => time() + 60 * 60 * 24 * 365,
        ]);
        $cookies->add($wishesCountCookie);

        return $this;
    }

    public static function genKey()
    {
        //сгенерировать ключ
        do {
            $salt = '';
            for ($i = 0; $i < 5; $i++) {
                $salt .= rand(0, 9);
            }
            $wish_key = md5(microtime() . ' ' . $salt);
            $oWish = EcmWishes::find()->where(['wish_key' => $wish_key])->one();
            //генерировать пока не будет уникальным (в базе)
        } while (!empty($oWish));
        return $wish_key;
    }

    public function getWish_key()
    {
        return $this->oWish->wish_key;
    }

    //создание товара в корзине
    public function createProduct($ecm_products_ref)
    {
        //создать товар
        $oWishProduct = new EcmWishProducts();
        $oWishProduct->ecm_wishes_ref = $this->oWish->id;
        $oWishProduct->ecm_products_ref = $ecm_products_ref;
        //M::printr($oWishProduct, '$oWishProduct');
        if (!$oWishProduct->save()) {
            //M::printr($oWishProduct, '$oWishProduct->save()');
            throw new Exception('Can`t create wishProduct');
        }
        $this->wishProducts[$ecm_products_ref] = $oWishProduct;
        $this->wishProducts[$ecm_products_ref]->save();
        return true;
    }

    //установка количества товара в корзине
    public function setProduct($ecm_products_ref)
    {
        //если товара в корзине нет
        if (!isset($this->wishProducts[$ecm_products_ref])) {
            $this->createProduct($ecm_products_ref);
        }
        //если количество выставляем в 0
        return true;
    }

    //добавление товара в корзину
    public function addProduct($ecm_products_ref)
    {

        //если товара в корзине нет
        if (empty($this->wishProducts[$ecm_products_ref])) {
            $this->createProduct($ecm_products_ref);
        }
        $this->wishProducts[$ecm_products_ref]->save();

        return true;
    }

    //удаление товара из корзины
    public function removeProduct($ecm_products_ref)
    {
        if (isset($this->wishProducts[$ecm_products_ref])) {
            $this->wishProducts[$ecm_products_ref]->delete();
            unset($this->wishProducts[$ecm_products_ref]);
        }
        return true;
    }

    public function clear()
    {
        //очистить существующую корзину
        //удалить все товары из существующей корзины
        foreach ($this->wishProducts as $key => $wishProduct) {
            $wishProduct->delete();
            unset($this->wishProducts[$key]);
        }
        return true;
    }

    public function save()
    {
        return $this->oWish->save();
    }

    public function delete()
    {
        EcmWishes::deleteAll("dt_updated < now()-'1 week'::interval");
    }
}

?>