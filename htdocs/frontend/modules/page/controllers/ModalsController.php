<?php

namespace frontend\modules\page\controllers;

use common\models\Clients;
use common\models\models\EcmProducts;
use common\models\TwigNotify;
use yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\FrontendController;
use common\models\models\CmsTree;
use common\components\M;
use yii\web\Cookie;
use yii\base\Exception;
use yii\validators\EmailValidator;
use yii\helpers\Url;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;

class ModalsController extends FrontendController
{
    public function actionSendForCallback()
    {
        if (!empty($_POST)) {
            //принять куда/кому отправлять уведомление
            //M::printr($_POST, '$_POST');

            $JS = ['success' => true];
            $JS['messages'] = [];

            try {
                if (empty(trim($_POST['first_name']))) {
                    throw new Exception('Не указано имя.');
                }

                if (empty(trim($_POST['phone']))) {
                    throw new Exception('Не указан телефон.');
                }

                //проверить телефон
                $phone = null;
                $is_phone = false;

                //проверить на телефон
                //M::printr($this->$attr, '$this->$attr');
                $phone = $_POST['phone'];
                $phone = preg_replace('/[^0-9]/', '', $phone);
                $phone = substr($phone, -10, 10);
                if (strlen($phone) == 10) {
                    $phone = "+7" . $phone;
                    $is_phone = true;
                }
                if (strlen($phone) == 6) {
                    $is_phone = true;
                }
                if (!$is_phone) {
                    throw new Exception('Телефон указан неверно.');
                }


                $data['first_name'] = $_POST['first_name'];
                $data['phone'] = $phone;

                if (strlen($phone) != 6) {
                    if (0) {
                        //сохранение клиента в базе
                        $oClient = new Clients();
                        $oClient->first_name = $_POST['first_name'];
                        $oClient->phone = $phone;
                        if (!$oClient->save()) {
                            throw new Exception('Can`t save new Client');
                        }
                    }
                }

                $data['uri'] = isset($_POST['uri']) ? $_POST['uri'] : '';
                //TODO Отправить уведомление о запросе товара
                $notify = new TwigNotify('Callback');
                $notify->data = $data;
                //отправить
                $notify->send();

            } catch (Exception $e) {
                $JS['success'] = false;
                $JS['message'] = $e->getMessage();
            }

            if (Yii::$app->request->isAjax) {
                print Json::encode($JS);
            }
        }
    }

    public function actionSendForRecall()
    {
        M::xlog(['public function actionSendForRecall()', '$_POST' => $_POST]);
        if (!empty($_POST)) {
            //принять id товара и куда/кому отправлять уведомление
            //M::printr($_POST, '$_POST');

            $oProduct = EcmProducts::findOne($_POST['product_id']);
            $oCategory = $oProduct->appProduct->tree;

            if (empty($oProduct)) {
                throw new Exception('Товар не найден.');
            }

            $JS = ['success' => true];
            $JS['messages'] = [];

            try {

                if (empty(trim($_POST['phoneEmail']))) {
                    throw new Exception('Не указаны контактные данные.');
                }

                //проверить, мыло это или телефон
                //Clients::
                $phone = null;
                $is_phone = false;
                $email = null;
                $is_email = false;

                //проверить на телефон
                //M::printr($this->$attr, '$this->$attr');
                $phone = $_POST['phoneEmail'];
                //$phone = str_replace('+7', '', $phone);
                $phone = preg_replace('/[^0-9]/', '', $phone);
                $phone = substr($phone, -10, 10);
                if (strlen($phone) == 10) {
                    $phone = "+7" . $phone;
                    $is_phone = true;
                }
                if (strlen($phone) == 6) {
                    $is_phone = true;
                }

                if (!$is_phone) {
                    //проверить на мыло
                    $email = $_POST['phoneEmail'];
                    $validator = new EmailValidator();
                    $is_email = $validator->validate($email);
                }

                $data = [
                    'product' => $oProduct->attributes,
                    'category' => $oCategory->attributes,
                    'url' => Url::to(['/page/catalog', 'id' => $oCategory->id]),
                ];
                if (!$is_phone && !$is_email) {
                    throw new Exception('Телефон или Email указан неверно.');
                }

                if ($is_phone) {
                    $data['phone'] = $phone;
                }
                if ($is_email) {
                    $data['email'] = $email;
                }

                //TODO Отправить уведомление о консультации по товару
                $notify = new TwigNotify('consultant');
                $notify->data = $data;
                M::xlog(['$notify = new TwigNotify("consultant");' => $notify, 'data' => $data]);
                //отправить
                $notify->send();

            } catch (Exception $e) {
                $JS['success'] = false;
                $JS['message'] = $e->getMessage();
            }

            if (Yii::$app->request->isAjax) {
                return Json::encode($JS);
            }
        }
    }

    public function actionIndex()
    {
        M::printr('OK?');

        $this->layout = '@theme/views/layouts/clear';
        $cookiesRequest = Yii::$app->request->cookies;
        $cookiesRequest->readOnly = false;
        //M::printr($cookiesRequest, '$cookiesRequest');

        if (1) {
            $city = new Cookie([
                'name' => 'city',
                'value' => 'городок',
                'expire' => time() + 60 * 60 * 24 * 7, //1 week
            ]);
            $cookiesRequest->add($city);
        }
        if (1) {
            $cookiesRequest = Yii::$app->request->cookies;
            M::printr($cookiesRequest, '$cookiesRequest');
        }
        if (1) {
            $cookiesResponse = Yii::$app->response->cookies;
            M::printr($cookiesResponse, 'Yii::$app->response->cookies');
            $cookiesResponse->add($city);
            M::printr($cookiesResponse, 'Yii::$app->response->cookies');
        }
        return $this->render('index');
    }

    public function actionView($id = 200)
    {
        $oCategory = CmsTree::find()
            ->alias('tree')
            ->joinWith(['content'])
            ->where('tree.id = :id', [':id' => $id])
            ->one();
        $oChs = $oCategory
            ->children(1)
            ->with('content')
            ->all();

        return $this->render('view', ['oCategory' => $oCategory, 'oChs' => $oChs]);
    }

    public function actionGetCity()
    {
        $JS = [
            'success' => true,
            'message' => '',
            'messages' => [],
            'city' => 'Москва',
        ];
        $cookies = Yii::$app->request->cookies;
        //$cookies2 = Yii::$app->response->cookies;
        $cookies->readOnly = false;
        //$cookies->removeAll();
        //M::printr($cookies, '$cookies');

        $ip = !empty($_GET['ip']) ? $_GET['ip'] : M::get_ip();
        $is_bot = false;

        //Найти юзерагента в списке ботов
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        //M::printr($userAgent, '$userAgent');
        $storage = Yii::getAlias('@storage');
        $botsFile = "{$storage}/logs/bots.txt";
        $bots = [];
        if (file_exists($botsFile)) {
            $bots = @file($botsFile);
        }
        foreach ($bots as $key => $bot) {
            $bots[$key] = trim($bot);
        }
        if (in_array($userAgent, $bots)) {
            //M::printr('BOT BOT BOT BOT BOT BOT BOT BOT BOT');
            $is_bot = true;

            //занести город
            $city = new Cookie([
                'name' => 'gorod',
                'value' => 'Москва',
                'expire' => time() + 60 * 60 * 24 * 7, //1 week
            ]);
            $cookies->add($city);

            //подтверждение выбора города
            $confirmCity = new Cookie([
                'name' => 'is_gorod',
                'value' => 0,
                'expire' => time() + 60 * 60 * 24 * 7, //1 week
            ]);
            $cookies->add($confirmCity);
        }
        //$is_bot = false;

        //если не бот
        if (!$is_bot) {
            //определить город
            //M::printr($cookies, '$cookies');
            $city = $cookies->getValue('gorod');
            $confirmCity = $cookies->getValue('is_gorod');

            if (!isset($city) || empty($city)) {
                //город не подтверджен
                //получить город по geoip
                //$ip = M::get_ip(); //'109.198.191.64'; //'24.48.0.1';
                $res = '';
                if (0) {
                    $url = "http://ip-api.com/json/{$ip}?lang=ru&fields=status,message,country,countryCode,region,regionName,city,district,zip,lat,lon,timezone,isp,org,as,reverse,mobile,proxy,query";
                    $res = file_get_contents($url);
                }
                //$res = $this->actionGetCity($ip);
                $arr = Json::decode($res);
                //M::printr($arr, '$arr');
                $city = 'Москва'; //!empty($arr['city']) ? $arr['city'] : 'Москва';
                //M::printr($city, '$city');
                //запоминаем город в кукисах

                //занести город
                $city = new Cookie([
                    'name' => 'gorod',
                    'value' => $city,
                    'expire' => time() + 3600 * 24 * 7, //1 week
                ]);
                //M::printr($city, '$city');
                $cookies->add($city);

                //M::printr($cookies, '$cookies');

                if (0) {
                    //получить код города по Геохелперу
                    $cities = Geo::CityReply($city);
                    M::printr($cities, '$cities');
                    exit;
                    $cookie = new CHttpCookie('city_option', $city);
                    $cookie->expire = time() + 60 * 60 * 24 * 7; //1 week
                    Yii::app()->request->cookies['city_option'] = $cookie;
                }
            }
            //подтверждение выбора города (изначально не подтверждено)
            $confirmCity = $cookies->getValue('is_gorod');
            if (empty($confirmCity)) {
                $confirmCity = new Cookie([
                    'name' => 'is_gorod',
                    'value' => 0,
                    'expire' => time() + 60 * 60 * 24 * 7, //1 week
                ]);
                $cookies->add($confirmCity);
            }
        }
        //M::printr($cookies, '$cookies');
        return Json::encode($JS);
    }

    public function actionGetRegions()
    {
        //$this->cache_opts['duration'] = 86400 * 7;
        //\CmsTree\Cache\Dependency::instance();
        if (1) { //($this->beginCache('frontend_getRegions', $this->cache_opts)) {
            $JS['success'] = true;
            $arr_city_id = [];
            $client = new \Geohelper\ApiClient(
                'CBq9zuWG4uu8rPFQMWHz6qK9gbcDPOrM'
            );
            $filter = [
                'countryIso' => 'RU',
            ];
            $locale = ['lang' => 'ru'];
            $page = 1;
            $order = ['by' => 'name', 'dir' => 'asc'];
            $oRegions = [];
            try {
                do {
                    $pagination = ['page' => $page, 'limit' => 20];
                    $response = $client->regionsList($filter, $locale, $pagination, $order);
                    $regions = $response->result;
                    //M::printr($regions, '$regions');
                    foreach ($regions as $region) {
                        $item = [
                            'id' => $region['id'],
                            'name' => $region['name'],
                        ];
                        //$oRegions[] = $item;
                        $oRegions[$region['id']] = $item;
                    }
                    $page++;
                } while (!empty($regions));

                $regionsHtml = $this->renderPartial('regions', ['oRegions' => $oRegions], true);
                $JS['regionsHtml'] = $regionsHtml;
                $JS['regions'] = $oRegions;
                //M::printr($JS, '$JS');
            } catch (\Geohelper\Exception\CurlException $e) {
                $JS['success'] = false;
                $JS['message'] = "Ошибка соединения с GeoHelper: " . $e->getMessage();
            }
            return Json::encode($JS);
        }
    }

    public function actionGetCities($regionId)
    {
        $JS = [
            'success' => true,
            'regionId' => $regionId,
            'message' => null,
            'messages' => [],
        ];


        //$this->cache_opts['duration'] = 86400 * 7;
        //\CmsTree\Cache\Dependency::instance();
        if (1) { //($this->beginCache('frontend_getCities_' . $regionId, $this->cache_opts)) {
            $arr_city_id = [];
            $client = new \Geohelper\ApiClient(
                'CBq9zuWG4uu8rPFQMWHz6qK9gbcDPOrM'
            );
            $page = 1;
            $filter = [];
            $locale = ['lang' => 'ru'];
            $order = array('by' => 'population', 'dir' => 'desc');
            $filter['countryIso'] = 'RU';
            $filter['regionId'] = $regionId;
            $oCities = [];
            try {
                //do {
                $pagination = array('page' => $page, 'limit' => 100);
                //$response="";
                //$filter['name'] = $request;
                $response = $client->citieslist($filter, $locale, $pagination, $order);
                $cities = $response->result;
                //M::printr($cities, '$cities');
                foreach ($cities as $city) {
                    if (empty($city['localityType'])) continue;
                    if (empty($city['localityType']['localizedNamesShort'])) continue;
                    if ($city['localityType']['localizedNamesShort']['ru'] !== 'г.') continue;
                    $item = [];
                    $item['id'] = $city['id'];
                    $item['name'] = $city['name'];
                    //$item['type_view'] = $city['type_view'];
                    //$item['regionId'] = $city['regionId'];
                    $oCities[$city['name']] = $item;
                }
                //$page++;
                //$cities = [];
                //} while (!empty($cities));
                ksort($oCities);
                //M::printr($oCities, '$oCities');
                $citiesHtml = $this->renderPartial('cities', ['oCities' => $oCities]);
                $JS['citiesHtml'] = $citiesHtml;
                $JS['cities'] = $oCities;

            } catch (\Geohelper\Exception\CurlException $e) {
                $JS['success'] = false;
                $JS['message'] = "Ошибка соединения с GeoHelper: " . $e->getMessage();
            }
            //$this->endCache();
        }
        return Json::encode($JS);
    }

    public function actionCityReply($request = 'Ярославль')
    {
        $JS['success'] = true;
        $JS['request'] = $request;
        $arr_city_id = array();
        $client = new \Geohelper\ApiClient(
            'CBq9zuWG4uu8rPFQMWHz6qK9gbcDPOrM'
        );
        $filter = array();
        $locale = array('lang' => 'ru');
        $pagination = array('page' => 1, 'limit' => 20);
        $order = array('by' => 'population', 'dir' => 'desc');
        //$response="";
        $filter['countryIso'] = 'RU';
        $filter['name'] = $request;
        try {
            $response = $client->citieslist($filter, $locale, $pagination, $order);
            $city = $response->result;
            $JS['city'] = array();
            $i = 0;
            $j = 0;
            while ($i < 10 && $j < count($city)) {
                preg_match('|\d+|', $city[$j]['name'], $number);
                if (empty($number)) {
                    $JS['city'][$i]['id'] = $city[$j]['id'];
                    $JS['city'][$i]['name'] = $city[$j]['name'];
                    $JS['city'][$i]['type_code'] = $city[$j]['localityType']['code'];
                    $JS['city'][$i]['type_name'] = $city[$j]['localityType']['name'];
                    if (!empty($city[$j]['localityType']['localizedNamesShort']['ru'])) {
                        $JS['city'][$i]['type_view'] = $city[$j]['localityType']['localizedNamesShort']['ru'];
                    } elseif (!empty($city[$j]['localityType']['localizedNames']['ru'])) {
                        $JS['city'][$i]['type_view'] = $city[$j]['localityType']['localizedNames']['ru'];
                    } else {
                        $JS['city'][$i]['type_view'] = "";
                    }
                    $arr_city_id[$i] = $city[$j]['regionId'];
                    $i++;
                }
                $j++;
            }
            $JS['count'] = count($JS['city']);
            $filter = array();
            $filter['ids'] = $arr_city_id;
            $response = $client->regionslist($filter, $locale, $pagination, $order);
            $regions = $response->result;
            for ($i = 0; $i < $JS['count']; $i++) {
                foreach ($regions as $region) {
                    if ($region['id'] == $arr_city_id[$i]) {
                        $JS['city'][$i]['region'] = $region['name'];
                        break;
                    }
                }
            }
        } catch (\Geohelper\Exception\CurlException $e) {
            $JS['success'] = true;
            $JS['message'] = "Ошибка соединения с GeoHelper: " . $e->getMessage();
        }
        echo json_encode($JS);
        //echo "<pre>";
        //print_r($response);
        //echo "</pre>";
    }

}
