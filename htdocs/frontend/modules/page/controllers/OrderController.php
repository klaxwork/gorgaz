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

class OrderController extends FrontendController
{
    public function actionIndex()
    {
        $formName = 'Order';

        $client = new \RetailCrm\ApiClient(
            Yii::$app->params['retail']['address'],
            Yii::$app->params['retail']['key'],
            \RetailCrm\ApiClient::V5
        );

        try {
            $filter = array();
            $limit = 50;
            $page = 1;

            $response = $client->request->deliveryTypesList($filter, $page, $limit);

            /*echo "<pre>";
            print_r($response);
            echo "</pre>";*/

            $deliveryList = $response->deliveryTypes;
            //var_dump($deliveryList); exit;

        } catch (\RetailCrm\Exception\CurlException $e) {
            echo "Connection error: " . $e->getMessage();
            exit;
        }


        return $this->render('index', ['formName' => $formName, 'deliveryList' => $deliveryList]);
    }

    public function actionOrder()
    {
        return $this->render('order');
    }

    public function actionCreate()
    {
        $formName = 'Order';
        //print_r($_POST);
        //return false;
        /** Пример массива $_POST
         * Array
         * (
         * [Order] => Array
         * (
         * [delivery_type] => transport
         * [delivery] => sdek
         * [first_name] => Имяtest
         * [family_name] => Тестовый Заказ
         * [second_name] =>
         * [phone] => +7 (900) 123-12-33
         * [email] =>
         * [cityID] => 4981
         * [city] => Ярославль
         * [street] => Ленина
         * [building] => 1
         * [flat] => 2
         * [post_index] => 150001
         * [client_comment] => Тестовый заказ
         * [payment_type] => kvitancija
         * [is_agree] => on
         * )
         *
         * )
         *
         * city_id
         * city_name
         *
         */

        //M::printr($_GET, '$_GET');
        //M::printr($_POST, '$_POST');
        if (!empty($_POST)) {
            //принять способы оплаты и доставки и цену доставки
            //M::printr($_POST, '$_POST');
            $JS = [
                'success' => true,
                '_POST' => $_POST,
                'message' => null,
                'messages' => [],
            ];

            $oOrder = OrderManager::create();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $_POST[$formName]['phone'] = Clients::normalPhone($_POST[$formName]['phone']);
                $oOrder->fromArray($_POST[$formName]);
                $oOrder->data = Json::encode($_POST[$formName]);
                $oOrder->ediBootstrap = EdiBootstrap::getDefaultBootstrap();
                //добавить клиента
                //$oOrder->setClient($_POST[$formName]);
                //M::printr($oOrder->EdiRelationClients, '$oOrder->EdiRelationClients');

                //добавить товары из корзины
                $oOrder->addCart();
                /** старая версия работы корзины, с сохранением заказа только в базу */
                /*
                $oOrder->saveOrder();
                $JS['order_id'] = $oOrder->id;

                //получить все данные по заказу в одной переменной
                $notifyOrder = EcmOrders::model()
                    ->with(
                        [
                            'ediRelationClient',
                            'orderProducts.product',
                        ]
                    )
                    ->findByPk($oOrder->EcmOrder->id);
                //M::xlog("\n", 'system', 'w');
                //Отправить уведомление о создании заказа
                $notify = new TwigNotify('OrderCreate');
                $notify->order = $notifyOrder->attributes;
                foreach ($notifyOrder->orderProducts as $oOrderProduct) {
                    $oProduct = $oOrderProduct->product;
                    $item = $oProduct->attributes;
                    $item['quantity'] = $oOrderProduct->quantity;
                    $notify->products[] = $item;
                }
                //
                $notify->client = CJSON::decode($notifyOrder->ediRelationClient->data);
                $notify->delivery_data = CJSON::decode($notifyOrder->delivery_data);
                $notify->data['delivery'] = $notifyOrder->delivery_data;
                $notify->data['delivery_data'] = CJSON::decode($notifyOrder->delivery_data);

                //отправить
                $notify->send();
                //*/

                /** новая версия сохранение заказа в RetailCRM */
                $JS = $oOrder->saveOrderInRetail();

                //Отправить уведомление о создании заказа
                $client = new \RetailCrm\ApiClient(
                    Yii::$app->params['retail']['address'],
                    Yii::$app->params['retail']['key'],
                    \RetailCrm\ApiClient::V5
                );
                try {
                    $response = $client->request->ordersGet($JS['order_id'], 'id');
                    $notifyOrder = $response->order;
                    //M::xlog(['$notifyOrder', $notifyOrder]);
                    if (empty($notifyOrder['delivery']['code'])) {
                        $notifyOrder['delivery']['code'] = 'Способ доставки не выбран';
                    }
                    //$id_custom_field_1c = 4; //ID поля "ключь 1С" в таблице ecm_custom_fields
                    foreach ($notifyOrder['items'] as &$product) {
                        //$criteria = new CDbCriteria();
                        //$criteria->addColumnCondition(['external_hynt_id' => $product['offer']['externalId']]);
                        $oProduct = EcmProducts::find()
                            ->where(['external_hynt_id' => $product['offer']['externalId']])
                            ->one();
                        $product['offer']['id_in_database'] = $oProduct->id;
                        $product['offer']['url'] = yii\helpers\Url::to(['/route/product', 'id' => $oProduct->id]);
                    }
                    //M::xlog(['$notifyOrder[\'items\']' => $notifyOrder['items']]);
                    //TODO Отправить уведомление о создании заказа
                    $notify = new TwigNotify('OrderCreate');
                    $notify->data = $notifyOrder;
                    $notify->client['email'] = $notifyOrder['customer']['email'];
                    //M::xlog(['$notify->data' => $notify->data]);
                    //отправить//*/
                    $notify->send();
                } catch (\RetailCrm\Exception\CurlException $e) {
                    echo "Connection error: " . $e->getMessage();
                    return false;
                }

                (new Cart())->create();
                $transaction->commit();
            } catch (Exception $e) {
                //M::printr($e->getMessage(), '$e->getMessage()');
                //$oOrder->getErrors();
                //M::xlog(M::printr($oOrder, 'Error: $oOrder', true), 'OrderController');
                $JS['success'] = false;
                $JS['message'] = $e->getMessage();
                $JS['messages'] = $oOrder->getErrors();
                if (isset($transaction)) {
                    $transaction->rollback();
                }
            }

            if ($JS['success']) {
                //$this->redirect($this->createUrl('/order/order/success', array('order_id' => $oOrder->id)));
            }
            if (Yii::$app->request->isAjax) {
                return Json::encode($JS);
            }

        }
    }

    public function actionSuccess($order_id)
    {
        //$oOrder = EcmOrders::model()->findByPk($order_id);
        $client = new \RetailCrm\ApiClient(
            'https://fishmen.retailcrm.ru',
            'XzyNfS7yG3usu1ESCZy7l0nTAWl7qI15',
            \RetailCrm\ApiClient::V5
        );
        try {
            $response = $client->request->ordersGet($order_id, 'id');
            /*
            $notifyOrder = $response->order;
            if (empty($notifyOrder['delivery']['code'])) {
                $notifyOrder['delivery']['code'] = 'Способ доставки не выбран';
            }
            if (empty($notifyOrder[''][''])) {
                $notifyOrder[''][''] = 'Способ оплаты не указан';
            }
            $id_custom_field_1c = 4; //ID поля "ключь 1С" в таблице ecm_custom_fields
            foreach ($notifyOrder['items'] as &$product) {
                $criteria = new CDbCriteria();
                $criteria->addColumnCondition(array(
                    'field_value' => $product['offer']['externalId'],
                    'ecm_custom_fields_ref' => $id_custom_field_1c,
                ));
                $productFields = EcmProductFields::model()->find($criteria);
                $product['offer']['id_in_database'] = $productFields->ecm_products_ref;
            }
            foreach ($notifyOrder['items'] as &$product) {
                //$criteria = new CDbCriteria();
                //$criteria->addColumnCondition(['external_hynt_id' => $product['offer']['externalId']]);
                $oProduct = EcmProducts::model()->findByAttributes(['external_hynt_id' => $product['offer']['externalId']]);
                $product['offer']['id_in_database'] = $oProduct->id;
            }
            */
            //var_dump($notifyOrder);
            //exit;
            //Отправка уведомления перенесена в ActionCreate.
            //$notify = new TwigNotify('OrderCreate');
            //$notify->data = $notifyOrder;
            //отправить
            //$notify->send();
        } catch (\RetailCrm\Exception\CurlException $e) {
            echo "Connection error: " . $e->getMessage();
            return false;
        }
        if ($response->isSuccessful()) {
            return $this->render('success', ['oOrder' => $response->order]);
        } else {
            throw new HttpException(404, 'Заказ не найден.');
        }
    }

}
