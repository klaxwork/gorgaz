<?php

namespace common\models;

use common\components\M;
use common\models\models\EcmCart;
use common\models\models\EcmCartProducts;
use yii\base\Exception;
use yii\web\Cookie;
use yii\base\Model;
use yii;

class Cart extends Model
{
    public $cartProducts = [];
    private $oCart;

    public function __construct()
    {
        //удалить все записи старше 5 дней
        $this->delete();
        $this->oCart = new EcmCart();
        //$this->oCart->cart_key = Yii::app()->user->getCart_key();
        //return $this;
        return parent::__construct();
    }

    public function attributeNames()
    {
        return [
            'cartProducts' => 'Список товаров',
            'oCart' => 'Модель корзины',
        ];
    }

    /*public static function model()
    {
        $oEcmCart = new EcmCart();
        $th = new self;
        $th->oCart = $oEcmCart;
        //$th->oCart->cart_key = Yii::app()->user->getCart_key();
        return $th;
    }*/

    public function create()
    {
        //создать новую корзину
        $this->oCart = new EcmCart();
        $this->oCart->cart_key = $this->genKey();

        $cookies = Yii::$app->response->cookies;
        $cartCookie = new Cookie([
            'name' => 'cart_key',
            'value' => $this->oCart->cart_key,
            'expire' => time() + 60 * 60 * 24 * 7,
        ]);
        $cookies->add($cartCookie);

        if (!$this->oCart->save()) {
            throw new Exception('Can`t save...');
        }
        return $this;
    }

    public function give($cart_key = null)
    {
        //удалить все записи старше 5 дней
        $this->delete();

        if (empty($cart_key)) {
            $cart_key = Yii::$app->user->getCart_key();
        }

        //получить корзину с товарами из БД
        $this->oCart = EcmCart::find()
            ->where(['cart_key' => $cart_key])
            ->one();
        //M::printr($this->oCart, '$this->oCart');
        if (empty($this->oCart)) {
            $this->create();
        }

        //добавить товары в модель корзины
        foreach ($this->oCart->cartProducts as $cartProduct) {
            $this->cartProducts[$cartProduct->ecm_products_ref] = $cartProduct;
        }

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
            $cart_key = md5(microtime() . ' ' . $salt);
            $oCart = EcmCart::find()->where(['cart_key' => $cart_key])->one();
            //генерировать пока не будет уникальным (в базе)
        } while (!empty($oCart));
        return $cart_key;
    }

    public function getCart_key()
    {
        return $this->oCart->cart_key;
    }

    //создание товара в корзине
    public function createProduct($ecm_products_ref, $quantity = 1)
    {
        //создать товар
        $oCartProduct = new EcmCartProducts();
        $oCartProduct->ecm_cart_ref = $this->oCart->id;
        $oCartProduct->ecm_products_ref = $ecm_products_ref;
        $oCartProduct->quantity = $quantity;
        //M::printr($oCartProduct, '$oCartProduct');
        if (!$oCartProduct->save()) {
            //M::printr($oCartProduct, '$oCartProduct->save()');
            throw new Exception('Can`t create cartProduct');
        }
        $this->cartProducts[$ecm_products_ref] = $oCartProduct;
        $this->cartProducts[$ecm_products_ref]->save();
        return true;
    }

    //установка количества товара в корзине
    public function setProduct($ecm_products_ref, $quantity = 1)
    {
        //если товара в корзине нет
        if (!isset($this->cartProducts[$ecm_products_ref])) {
            $this->createProduct($ecm_products_ref);
        }
        $this->cartProducts[$ecm_products_ref]->quantity = $quantity;
        //если количество выставляем в 0
        if ($quantity == 0) {
            //удалить товар из корзины
            $this->removeProduct($ecm_products_ref);
        } else {
            $this->cartProducts[$ecm_products_ref]->save();
        }
        return true;
    }

    //добавление товара в корзину
    public function addProduct($ecm_products_ref, $quantity = 1)
    {
        //если товара в корзине нет
        if (empty($this->cartProducts[$ecm_products_ref])) {
            $this->createProduct($ecm_products_ref);
        }
        $this->cartProducts[$ecm_products_ref]->quantity = $quantity;
        $this->cartProducts[$ecm_products_ref]->save();
        //M::printr($this->cartProducts, '$this->cartProducts');
        return true;
    }

    //удаление товара из корзины
    public function removeProduct($ecm_products_ref)
    {
        if (isset($this->cartProducts[$ecm_products_ref])) {
            $this->cartProducts[$ecm_products_ref]->delete();
            unset($this->cartProducts[$ecm_products_ref]);
        }
        return true;
    }

    //увеличение количества товаров на 1
    public function incProduct($ecm_products_ref, $quantity = 1)
    {
        //если товара в корзине нет
        if (!isset($this->cartProducts[$ecm_products_ref])) {
            //создать товар в корзине
            $this->createProduct($ecm_products_ref, $quantity);
        } else {
            //инкремент количества товаров
            $this->cartProducts[$ecm_products_ref]->quantity += $quantity;
        }
        $this->cartProducts[$ecm_products_ref]->save();
        return true;
    }

    //увеличение количества товаров на 1
    public function decProduct($ecm_products_ref, $quantity = 1)
    {
        //если товара в корзине нет
        if (!isset($this->cartProducts[$ecm_products_ref])) {
            //создать товар в корзине
            $this->createProduct($ecm_products_ref);
        } else {
            //декремент количества товаров
            $this->cartProducts[$ecm_products_ref]->quantity -= $quantity;
            $this->cartProducts[$ecm_products_ref]->save();
            if ($this->cartProducts[$ecm_products_ref]->quantity < 1) {
                //удалить из БД
                $this->removeProduct($ecm_products_ref);
            }
        }
        return true;
    }

    //уменьшение количества товаров на 1
    public function decProductx($ecm_products_ref)
    {
        if (!isset($this->cartProducts[$ecm_products_ref])) {
            throw new Exception('Can`t decrement product #' . $ecm_products_ref);
        }
        //если в корзине больше одного
        if ($this->cartProducts[$ecm_products_ref]->quantity > 1) {
            //декремент
            $this->cartProducts[$ecm_products_ref]->quantity--;
            $this->cartProducts[$ecm_products_ref]->save();
        } else {
            //удалить из БД
            $this->removeProduct($ecm_products_ref);
        }
        return true;
    }

    public function clear()
    {
        //очистить существующую корзину
        //удалить все товары из существующей корзины
        foreach ($this->cartProducts as $key => $cartProduct) {
            $cartProduct->delete();
            unset($this->cartProducts[$key]);
        }
        return true;
    }

    public function save()
    {
        return $this->oCart->save();
    }

    public function delete()
    {
        EcmCart::deleteAll("dt_updated < now()-'1 week'::interval");
    }
}

?>