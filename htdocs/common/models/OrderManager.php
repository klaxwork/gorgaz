<?php

namespace common\models;

use common\models\models\EcmOrderHistory;
use yii;
use common\components\M;
use common\models\models\EcmOrderProducts;
use common\models\models\EcmOrders;
use common\models\models\EcmProducts;
use common\models\models\EdiBootstrap;
use common\models\models\EdiRelationClients;
use yii\base\Exception;
use yii\BaseYii;
use yii\helpers\Json;

class OrderManager extends \yii\base\Model
{
    public $ediBootstrap;
    public $client;
    public $client_data;
    public $clientExternalId;
    public $state = [];
    public $id;
    public $product;
    public $products = [];
    //public $game_players;
    public $total_discounts = 0;
    public $total_products = 0;
    public $total_positions = 0;
    public $total_summ = 0;
    public $total_paid = 0;
    public $is_paid_bonus = 0;
    public $total_paid_bonus = 0;
    public $total_paid_real = 0;
    public $ecm_order_source_ref;
    public $source_data;
    public $payment_method;
    public $admin_comment;
    public $client_comment;
    public $booking;
    public $errors;
    public $data = null;

    public $cartProducts = [];
    public $address = null;
    public $delivery_type = null;
    public $delivery = null;

    public $payment_type = null;
    public $payment = null;

    public $delivery_data;
    public $freeDelivery = 'false';

    public $EcmCart;
    public $EcmOrder;
    public $EcmProduct;
    public $EcmOrderProduct;
    public $EbsSeanceSession;
    public $EcmOrderHistory;
    public $EdiRelationClients;

    public $deliverys = [];


    public function __construct()
    {
        parent::__construct();
        $this->EcmOrder = new EcmOrders();
        $this->EcmOrderProduct = new EcmOrderProducts();
        //$this->EbsSeanceSession = new EbsSeanceSessions();
        $this->EcmOrderHistory = new EcmOrderHistory();
        $this->EdiRelationClients = new EdiRelationClients();
        $this->EcmProduct = new EcmProducts();

    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('product_name, url_alias, cms_templates_ref', 'required'),
            //array('url_alias', 'unique', 'Url Alias must be unique'),
            //array('page_title', 'length', 'max' => 255),
            array('id, seance_id, ecm_order_source_ref', 'safe'),
        );

    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
        );
    }

    public function fromArray($array)
    {
        //$array['is_published'] = isset($array['is_published']) ? true : false;
        //$array['is_closed'] = isset($array['is_closed']) ? true : false;
        //$this->ecm_categories_ref = array();

        $this->setAttributes($array);
        $this->client_data['first_name'] = $array['first_name'];
        $this->client_data['second_name'] = $array['second_name'];
        $this->client_data['family_name'] = $array['family_name'];
        $this->client_data['phone'] = $array['phone'];
        $this->client_data['email'] = $array['email'];

        $this->address['city'] = $array['city'];
        //$this->address['cityId'] = $array['cityId'];

        $this->address['city'] = $array['city'];
        //$this->address['cityId'] = $array['cityId'];
        $this->address['street'] = $array['street'];
        $this->address['building'] = $array['building'];
        $this->address['flat'] = $array['flat'];
        $this->address['index'] = $array['post_index'];

        $this->client_comment = $array['client_comment'];

        if (empty($array['delivery_type'])) {
            $array['delivery_type'] = null;
        }

        $this->delivery_type = empty($array['delivery_type']) ? null : $array['delivery_type'];
        $this->freeDelivery = $array['freeDelivery'];
        $this->payment_type = empty($array['payment_type']) ? null : $array['payment_type'];

        $this->delivery = (empty($array['delivery'])) ? $array['delivery_type'] : $array['delivery'];


        //M::printr($array, '$array');

        //$this->dt_updated = new CDbExpression('now()');
    }

    public static function create()
    {
        return new self;
    }

    public function give($id)
    {

        return false;
    }

    public function takeEcmProduct($seance_id)
    {
        if (empty($this->EcmProduct->id)) {
            $oSeance = EbsSeance::model()->with(
                [
                    'timeline.product'
                ]
            )->findByPk($seance_id);
            $this->EcmProduct = $oSeance->timeline->product;
        }
    }

    public function addCart()
    {
        $oCart = (new Cart())->give();
        $this->EcmCart = $oCart;
        if (empty($oCart->cartProducts)) {
            throw new Exception('В корзине нет товаров');
        }
        foreach ($oCart->cartProducts as $oCartProduct) {
            $this->cartProducts[] = $oCartProduct;
            $this->total_products++;
        }
    }

    //сохраняем товары в таблицу ecm_order_products
    public function saveProducts()
    {
        $oCart = (new Cart())->give();
        foreach ($this->cartProducts as $oCartProduct) {
            $oProduct = $oCartProduct->product;
            $oEcmOrderProduct = new EcmOrderProducts();
            $oEcmOrderProduct->edi_bootstrap_ref = EdiBootstrap::getDefaultBootstrap()->id;
            $oEcmOrderProduct->ecm_orders_ref = $this->id;
            $oEcmOrderProduct->ecm_products_ref = $oProduct->id;
            $oEcmOrderProduct->quantity = $oCartProduct->quantity;
            $oEcmOrderProduct->product_price = $oProduct->product_price;
            if (!$oEcmOrderProduct->save()) {
                throw new Exception('Can`t save EcmOrderProduct.');
            }
            $this->total_paid += $oProduct->product_price * $oCartProduct->quantity;
        }
        $this->EcmOrder->total_paid = $this->total_paid;
        if (!$this->EcmOrder->save()) {
            $this->addErrors($this->EcmOrder->getErrors());
            throw new Exception('Can`t save new total_paid in EcmOrders');
        }
    }

    public function setClient($PostClient)
    {
        if (empty($this->ediBootstrap)) {
            throw new Exception('ediBootstrap is EMPTY');
        }

        //сохранить клиента
        $oClient = new Clients();
        $oClient->ediBootstrap = $this->ediBootstrap;
        $oClient->fromArray($PostClient);
        //M::printr($oClient, '$oClient');
        if (!$oClient->save()) {
            //$JS['messages'] = $oClient->getErrors();
            //M::printr($oClient->getErrors(), '$oClient->getErrors()');
            $this->addErrors($oClient->getErrors());
            throw new Exception('Can`t save Client');
        }
        //M::printr($oClient, '$oClient');
        $this->client = $oClient->oClient;
        $global = !empty($this->client['#global']) ? $this->client['#global'] : [];
        $this->clientExternalId = !empty($global['client_private_id']) ? $global['client_private_id'] : null;

        //$this->clientExternalId =
        $this->EdiRelationClients = $oClient->ediRelationClient;
    }

    //сохранение заказа в БД
    public function saveOrder()
    {
        $oRel = EdiRelationClients::find()
            ->where(['client_id' => $this->client['id']])
            ->one();


        //Создать запись заказа
        $oOrder = new EcmOrders();
        //Получить edi_relation_clients_ref
        $oOrder->edi_relation_clients_ref = $this->EdiRelationClients->id;
        $oOrder->client_view_name = $this->EdiRelationClients->client_view_name;
        $oOrder->source_data = Json::encode([$this->client]);
        $oOrder->total_discounts = 0;
        $oOrder->total_products = $this->total_products;
        $oOrder->total_paid = $this->total_paid;
        $oOrder->total_paid_real = $this->total_paid_real;
        $oOrder->total_paid_bonus = $this->total_paid_bonus;
        $oOrder->ecm_payment_methods_ref = $this->payment_method;
        $oOrder->ecm_order_source_ref = $this->ecm_order_source_ref;
        $oOrder->client_comment = $this->client_comment;
        $oOrder->delivery_data = $this->data;
        //M::printr($oOrder, '$oOrder');
        if (!$oOrder->save()) {
            $this->addErrors($oOrder->getErrors());
            throw new Exception('Can`t create order record');
        }
        $this->EcmOrder = $oOrder;
        $this->id = $oOrder->id;

        //Сохранить товары из корзины
        $this->saveProducts();

    }

    public function saveOrderInRetail()
    {
        //M::xlog(['saveOrderInRetail', '$this' => $this], false, 'w');
        $client = new \RetailCrm\ApiClient(
            Yii::$app->params['retail']['address'],
            Yii::$app->params['retail']['key'],
            \RetailCrm\ApiClient::V5
        );
        try {
            $filter = array();

            $filter['name'] = $this->client_data['phone'];
            $response = $client->request->customersList($filter, 1, 100);
            $id = null;
            if ($response->isSuccessful() && ($response->pagination['totalCount'] > 0)) {
                foreach ($response->customers as $customer) {
                    if (empty($customer['email'])) {
                        $id = $customer['id'];
                        $customer['email'] = '';
                    }
                    if (mb_strtolower($customer['email']) == mb_strtolower($this->client_data['email'])) {
                        $id = $customer['id'];
                        break;
                    }
                }
            }
            $order = [];
            if ($id === null) {
                /*/
                $customer = [
                    'firstName' => $this->client['first_name'],
                    'lastName' => $this->client['family_name'],
                    'patronymic' => $this->client['second_name'],
                    'phone' => $this->client['phone'],
                    'email' => $this->client['email'],
                    'externalId' => $this->client['id'],
                ];
                $response = $client->request->customersCreate($customer);
                if ($response->isSuccessful()) {
                    $order['customer']['id'] = $response->id;
                    //$order['customer']['externalId'] = $this->clientExternalId;
                }
                //*/
            } else {
                $order['customer']['id'] = $id;
                //$order['customer']['externalId'] = $this->clientExternalId;
            }
            $order['firstName'] = $this->client_data['first_name'];
            $order['lastName'] = $this->client_data['family_name'];
            $order['patronymic'] = $this->client_data['second_name'];

            /*
            $phone = !empty($this->client['phone']) ? $this->client['phone'] : null;
            if (empty($phone) && !empty($this->client['#credentials'])) {
                $credentials = $this->client['#credentials'];
                $phone = $credentials['identify_phone'];
            }
            $phone = substr($phone, -11);
            $order['phone'] = $phone;
            */

            $order['phone'] = $this->client_data['phone'];
            //$order['email'] = !empty($this->client['email']) ? $this->client['email'] : null;
            $order['email'] = $this->client_data['email'];
            //$order['customer']['id'] = 30; //ID для тестов

            //данные о товарах
            $id_custom_field_1c = 4; //ID поля "ключ 1С" в таблице ecm_custom_fields
            $i = 0;
            foreach ($this->cartProducts as $oCartProduct) {
                /*/
                $criteria = new CDbCriteria();
                $criteria->addColumnCondition(array(
                    'ecm_products_ref' => $oCartProduct->ecm_products_ref,
                    'ecm_custom_fields_ref' => $id_custom_field_1c
                ));
                //*/
                $oProduct = $oCartProduct->product;
                //$oField = $oProduct->getField('1c_product_id'); //EcmProductFields::model()->find($criteria);
                //print_r($id_1c_product);
                $order['items'][$i]['offer']['externalId'] = $oCartProduct->product->external_hynt_id; //$id_1c_product->field_value;
                $order['items'][$i]['quantity'] = $oCartProduct->quantity;
                $i++;
            }

            //Данные об адресе:
            $order['delivery']['address']['index'] = $this->address['index'];
            $order['delivery']['address']['city'] = $this->address['city'];
            //$order['delivery']['address']['cityId'] = $this->address['cityId'];
            $order['delivery']['address']['street'] = $this->address['street'];
            $order['delivery']['address']['building'] = $this->address['building'];
            $order['delivery']['address']['flat'] = $this->address['flat'];
            //var_dump($this->address);

            //комментарий клиента
            $order['customerComment'] = $this->client_comment;

            //доставка
            $order['delivery']['code'] = $this->delivery;//тип доставки
            if ($this->freeDelivery == 'true') {
                $order['delivery']['cost'] = 0;
            }

            //оплата
            if ($this->payment_type !== null) {
                $order['payments'][0]['type'] = $this->payment_type;//тип оплаты
            }
            M::xlog(['$order' => $order]);
            //$response="ТЕST_DEFINED";
            $response = $client->request->ordersCreate($order);
            M::xlog(['$response' => $response]);
            /*echo "<pre>";
            print_r($response);
            //print_r($order);
            echo "</pre>";//*/
            $result['success'] = $response->isSuccessful();
            if ($response->isSuccessful()) {
                $result['message'] = 'OK!';
                $result['order_id'] = $response->id;
            } else {
                $result['message'] = $response->errorMsg;
                $result['order_id'] = null;
            }
            return $result;


        } catch (\RetailCrm\Exception\CurlException $e) {
            echo "Connection error: " . $e->getMessage();
        }

    }


    public function save()
    {
        $this->saveOrder();

        //создать ecm_order_product записи
        //пройти по всем товарам
        foreach ($this->products as $oProduct) {
            $this->product = $oProduct;
            $this->seanceBooking($this->product);
            $x = EbsSeanceBooking::model()->findByPk($this->booking->id);
            //M::printr($x, '$x');
            $this->requestOrder($this->product, $this->booking);
            $this->saveOrderProduct($oProduct);
        }
        $this->createOrderHistory();

        //M::printr($this, '$this >> save');
        throw new Exception('STOP');
        return true;
    }

    /*
    //создание записи о бронировании сеанса
    public function seanceBooking($oSeance)
    {
        $oRel = EdiRelationClients::model()->findByAttributes(array('client_id' => $this->client['id']));

        $oBooking = new EbsSeanceBooking();
        $oBooking->edi_relation_clients_ref = $oRel->id;
        $oBooking->ebs_seance_ref = $oSeance->id;
        //$oBooking->request_token = '';
        $oBooking->first_name = $this->client['first_name'];
        $oBooking->family_name = $this->client['family_name'] ?: '-';
        $oBooking->phone = isset($this->client['#credentials']['identify_phone']) ? $this->client['#credentials']['identify_phone'] : null;
        $oBooking->email = isset($this->client['#credentials']['identify_email']) ? $this->client['#credentials']['identify_email'] : null;
        $oBooking->comment = $this->client_comment;
        $oBooking->description = $this->admin_comment;
        $oBooking->players = $this->game_players;
        $this->takeEcmProduct($oSeance->id);
        $max = $this->EcmProduct->game_max_players;
        $hardmax = $this->EcmProduct->game_hardmax_players;
        $price = $oSeance->price;
        if ($this->game_players > $max) {
            $hardplayers = $this->game_players - $max;
            $price += $hardplayers * $this->EcmProduct->game_hardmax_addcost;
        }
        $oBooking->price = $price;
        $oBooking->price -= $this->total_paid_bonus;
        if (!$oBooking->save()) {
            $this->addErrors($oBooking->getErrors());
            throw new Exception('Can`t save data in EbsSeanceBooking');
        }
        $this->booking = $oBooking;
        //M::xlog('$this:', 'Notify');
        //M::xlog($this, 'Notify');
    }
    */

    //создание записи о бронировании сеанса
    public function seanceBookingUpdate()
    {
        $oRel = EdiRelationClients::model()->findByAttributes(array('client_id' => $this->client['id']));

        $oBooking = new EbsSeanceBooking();
        $oBooking->edi_relation_clients_ref = $oRel->id;
        $oBooking->ebs_seance_ref = $oProduct->id;
        $oBooking->request_token = '';
        $oBooking->first_name = $this->client['first_name'];
        $oBooking->family_name = $this->client['family_name'];
        $oBooking->phone = '';
        $oBooking->email = '';
        $oBooking->comment = '';
        $oBooking->description = '';
        $oBooking->data = '';
        $oBooking->is_success = '';
        $oBooking->is_expired = '';
        if (!$oBooking->save()) {
            $this->addErrors($oBooking->getErrors());
            throw new Exception('Can`t save data in EbsSeanceBooking');
        }
    }

    public function saveOrderProduct($oItem = false)
    {
        $oOrderProduct = new EcmOrderProducts();
        //получить ediBootstrap продукта
        if ($oItem) {
            $ediBootstrap = $oItem->getBootstrap();
        } else {
            $ediBootstrap = $this->EcmProduct->getBootstrap();
        }

        //M::printr($ediBootstrap, '$ediBootstrap');
        $oOrderProduct->edi_bootstrap_ref = $ediBootstrap->id;
        $oOrderProduct->ecm_orders_ref = $this->id;
        $oOrderProduct->ecm_products_ref = $oItem ? $oItem->getEcmProduct()->id : $this->EcmProduct->id;
        $oOrderProduct->quantity = 1;
        //$oOrderProduct->data = CJSON::encode([]);
        //M::printr($oOrderProduct, '$oOrderProduct');
        if (!$oOrderProduct->save()) {
            $this->addErrors($oOrderProduct->getErrors());
            throw new Exception('Can`t save data in EcmOrderProducts');
        }
        $this->EcmOrderProduct = $oOrderProduct;

        if ($oItem instanceof EbsSeance) {
            $this->saveSeanceSession($oItem, $oOrderProduct);
        }
    }

    public function saveSeanceSession($oSeance, $oOrderProduct)
    {
        $oSession = new EbsSeanceSessions();
        $oSession->ebs_seance_ref = $oSeance->id;
        $oSession->ecm_order_products_ref = $oOrderProduct->id;
        $oSession->dt_seance_start = "{$oSeance->timeline->dt_seance} {$oSeance->tm_seance_start}";
        if (!$oSession->save()) {
            $this->addErrors($oSession->getErrors());
            throw new Exception('Can`t save data in EbsSeanceSessions');
        }
        $oSeance->is_busy = true;
        if (!$oSeance->save()) {
            $this->addErrors($oSeance->getErrors());
            throw new Exception('Can`t save data in EbsSeance');
        }
        $this->product = $oSeance;
        $oSession->data = $this->state['data']['origin'];
        $this->EbsSeanceSession = $oSession;

    }

    /**
     * Отправка заказа партнеру
     * @param $oSeance
     * @throws Exception
     */
    public function requestOrder($oSeance, $oBooking, $test = false)
    {
        $data = [
            'do' => 'booking',
            'seance_id' => $oSeance->id,
            'booking_id' => $oBooking->id,
        ];
        //M::printr($data, '$data');

        if ($test) {
            $state = [
                'success' => true,
                'data' => [
                    'booking' => true,
                    'message' => 'none',
                    'origin' => '{"success": true}',
                ],
            ];
        } else {
            $state = (new SeanceAlive)->request($data);
        }
        //M::printr($state, '$state');
        //exit;
        if (!$state['success']) {
            throw new Exception($state['error']);
        }
        if (isset($state['data']['origin'])) {
            $this->state = $state;
        }
        if (!$state['data']['booking']) {
            throw new Exception($state['data']['message']);
        }

        $this->state = $state;
    }


    public function createOrderHistory()
    {
        $oOrderHistory = new EcmOrderHistory();
        $oOrderHistory->ecm_orders_ref = $this->id;
        $oOrderHistory->ecm_order_statuses_ref = 1;
        $oOrderHistory->ecm_payment_statuses_ref = 1;
        $oOrderHistory->admin_comment = $this->admin_comment;
        //$oOrderHistory->client_comment = $this->client_comment;
        //M::xlog(M::printr($oOrderHistory, '$oOrderHistory', true), 'OrderController');
        if (!$oOrderHistory->save()) {
            //M::xlog(M::printr($oOrderHistory, '$oOrderHistory->save()', true), 'OrderController');
            //M::printr($oOrderHistory, '$oOrderHistory');
            $this->addErrors($oOrderHistory->getErrors());
            throw new Exception('Can`t save data in EcmOrderHistory');
        }
        $this->EcmOrderHistory = $oOrderHistory;
    }

}

