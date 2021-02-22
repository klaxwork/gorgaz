<?php

namespace frontend\modules\product\controllers;

use common\models\ar_inherit\OrderHistory;
use frontend\components\FrontendApiController;
use common\components\M;
use common\models\ar_inherit\EquipmentTypes;
use common\models\ar_inherit\EquipmentModels;
use common\models\ar_inherit\OrderEquipments;
use common\models\ar_inherit\Orders;
use common\models\ar_inherit\Reasons;
use common\models\ar_inherit\Statuses;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Default controller for the `cms` module
 */
class ApiController extends FrontendApiController
{
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionOrders() {

        $this->layout = false;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        \Yii::$app->response->headers->add('Content-Type', 'text/xml');

        $oOrders = Orders::find()
            ->joinWith([
                    'proxyImage',
                    'equipments.equipmentType',
                    'equipments.equipmentModel',
                    'equipments.equipmentImage',
                ]
            )
            ->where('is_order_send IS NOT TRUE')
            ->all();
        //M::printr($oOrders, '$oOrders');

        $orders = [];
        foreach ($oOrders as $oOrder) {
            $order = new \stdClass();
            $order->ИД = $oOrder->id;
            $order->ФамилияСобственника = $oOrder->second_name_owner;
            $order->ИмяСобственника = $oOrder->first_name_owner;
            $order->ОтчествоСобственника = $oOrder->third_name_owner;

            $order->ЗаявительЯвляетсяСобственником = $oOrder->is_declarant_owner ? 'Да' : 'Нет';

            $order->ФамилияДоверенногоЛица = $oOrder->second_name_agent;
            $order->ИмяДоверенногоЛица = $oOrder->first_name_agent;
            $order->ОтчествоДоверенногоЛица = $oOrder->third_name_agent;

            $order->ЛицевойСчет = $oOrder->account;
            $order->АдресОбъекта = $oOrder->address;

            $order->ПричинаОбращения = $oOrder->reason->reason_name;
            if (!empty($oOrder->reason_your)) {
                $order->ПричинаОбращения = $oOrder->reason_your;
            }
            $order->ТекстОбращения = $oOrder->reason_text;

            $equipments = [];
            foreach ($oOrder->equipments as $oEquipment) {
                //M::printr($oEquipment, '$oEquipment');
                $type = $oEquipment->equipmentType->type_name;
                $model = $oEquipment->equipmentModel->model_name;
                $other_model = $oEquipment->other_model;
                if (empty($model)) {
                    $model = $other_model;
                }
                $equipment = "{$type}({$model})";
                $equipments[] = $equipment;
            }
            $order->УстановленноеГО = implode(', ', $equipments);
            $order->ДатаСозданияЗаявки = strftime('%Y-%m-%dT%H:%M:%S', strtotime($oOrder->dt_created));
            $order->Статус = '';
            $order->ДатаСтатусаЗаявки = '';

            $phone = $oOrder->phone;
            $phone = preg_replace('/[^0-9]/', '', $phone);
            $phone = substr($phone, -10, 10);
            if (strlen($phone) == 10) {
                $phone = "+7" . $phone;
            }
            $order->КонтактныйТелефон = $phone;
            $order->Емаил = $oOrder->email;

            $order->Файлы = [];

            if (!$oOrder->is_declarant_owner && $oOrder->proxy_image_ref) {
                $order->Файлы[] = [
                    'ТипФайла' => 'Фото доверенности',
                    'ДДФайла' => '/store' . $oOrder->proxyImage->fs_saveto,
                ];
            }

            foreach ($oOrder->equipments as $oEquipment) {
                //M::printr($oEquipment, '$oEquipment');
                $type = $oEquipment->equipmentType->type_name;
                $model = $oEquipment->equipmentModel->model_name;
                $other_model = $oEquipment->other_model;
                if (empty($model)) {
                    $model = $other_model;
                }
                $equipment = "{$type}({$model})";
                $order->Файлы[] = [
                    'ТипФайла' => 'Паспорт газового оборудования',
                    'ВидОборудования' => $equipment,
                    'ДДФайла' => '/store' . $oOrder->proxyImage->fs_saveto,
                ];
            }

            $orders[] = $order;
        }
        //M::printr($orders, '$orders');


        //exit;
        return $this->renderPartial('orders', ['orders' => $orders]);
    }

    public function actionStatus() {
        $_GET['debug'] = 'console';
        M::xlog(['$_POST' => $_POST], 'status');
        //M::printr($_POST, '$_POST');

        $JS = new \stdClass();
        $JS->id = 0;
        $JS->success = true;
        $JS->errorMessage = '';
        $JS->errorMessages = [];

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            //принимаю данные
            $orderStatus = new \stdClass();
            $orderStatus->orders_ref = !empty($_POST['ИДЗаявки']) ? $_POST['ИДЗаявки'] : 0;
            $JS->id = $orderStatus->orders_ref;
            $orderStatus->order_status = !empty($_POST['СтатусЗаявки']) ? $_POST['СтатусЗаявки'] : '';
            $orderStatus->dt_created = !empty($_POST['ДатаСтатуса']) ? $_POST['ДатаСтатуса'] : strftime('%Y-%m-%d %H:%M:%S'); //07.12.2020 17:18:47
            $orderStatus->order_comment = !empty($_POST['КомментарийСтатуса']) ? $_POST['КомментарийСтатуса'] : '';
            $orderStatus->order_number = !empty($_POST['НомерЗаявки']) ? $_POST['НомерЗаявки'] : '';

            $dt_updated = strftime('%Y-%m-%d %H:%M:%S', strtotime($orderStatus->dt_created));
            $orderStatus->dt_created = $dt_updated;
            //M::printr($orderStatus, '$orderStatus');

            //найти заявку с нужным id
            $oOrder = Orders::find()->where(['id' => $orderStatus->orders_ref])->one();
            //M::printr($oOrder, '$oOrder');

            if (empty($oOrder)) {
                throw new Exception("Order not found: id = {$orderStatus->orders_ref}");
            }

            //прописать туда номер заявки для клиента
            if (empty($oOrder->order_number)) {
                $oOrder->order_number = $orderStatus->order_number;
                $oOrder->is_order_send = true;
                if (!$oOrder->save()) {
                    $JS->errorMessages = $oOrder->getErrors();
                    throw new Exception("Can`t save {$oOrder->id} (order_number  = {$orderStatus->order_number})");
                }
            }

            //записать историю изменения статуса
            $oOrderHistory = new OrderHistory();
            $oOrderHistory->orders_ref = $oOrder->id;
            $oOrderHistory->order_comment = $orderStatus->order_comment;
            $oOrderHistory->order_status = $orderStatus->order_status;
            $oOrderHistory->dt_created = $orderStatus->dt_created;

            if (!$oOrderHistory->save()) {
                $JS->errorMessages = $oOrderHistory->getErrors();
                throw new Exception('Can`t save OrderHistory');
            }

            $transaction->commit();
            //$transaction->rollback();
        } catch (Exception $e) {
            $JS->success = false;
            $JS->errorMessage = $e->getMessage();
            $transaction->rollback();
        }
        M::xlog(['JS' => $JS], 'status');
        return Json::encode($JS);
    }

}
