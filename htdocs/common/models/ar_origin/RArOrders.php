<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id ID заявки в системе сайта
 * @property string $first_name_owner Имя собственника
 * @property string $second_name_owner Фамилия собственника
 * @property string $third_name_owner Отчество собственника
 * @property string $account Лицевой счет
 * @property bool|null $is_declarant_owner Заявитель является собственником
 * @property string|null $first_name_agent Имя доверенного лица
 * @property string|null $second_name_agent Фамилия доверенного лица
 * @property string|null $third_name_agent Отчество доверенного лица
 * @property int|null $proxy_image_ref Фото доверенности
 * @property string $index Индекс
 * @property string $state Область/Край
 * @property string $city Город/Населенный пункт
 * @property string $street Улица
 * @property string $house Номер дома
 * @property string $building Корпус
 * @property string $apartment Квартира
 * @property string $address Адрес объекта
 * @property int $reason_ref Причина обращения
 * @property string $reason_text Текст обращения
 * @property string $phone Контактный телефон
 * @property string $email Email
 * @property string|null $status_1c Статус в системе 1с (приходит из 1с в ответе на запрос из вебформы)
 * @property bool|null $is_order_send Принята ли заявка в системе 1С
 * @property string|null $order_uid UID заявки в системе 1С
 * @property string|null $reason_your Ваша причина обращения
 * @property string|null $order_number Номер заявки для клиента
 *
 * @property OrderHistory[] $orderHistories
 * @property Images $proxyImageRef
 * @property Reasons $reasonRef
 */
class RArOrders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['first_name_owner', 'second_name_owner', 'third_name_owner', 'account', 'index', 'state', 'city', 'street', 'house', 'building', 'apartment', 'address', 'reason_ref', 'reason_text', 'phone', 'email'], 'required'],
            [['is_declarant_owner', 'is_order_send'], 'boolean'],
            [['proxy_image_ref', 'reason_ref'], 'default', 'value' => null],
            [['proxy_image_ref', 'reason_ref'], 'integer'],
            [['address'], 'string'],
            [['first_name_owner', 'second_name_owner', 'third_name_owner', 'first_name_agent', 'second_name_agent', 'third_name_agent', 'index', 'state', 'city', 'street', 'house', 'building', 'apartment', 'reason_text', 'email', 'status_1c', 'order_uid'], 'string', 'max' => 255],
            [['account'], 'string', 'max' => 12],
            [['phone'], 'string', 'max' => 10],
            [['proxy_image_ref'], 'exist', 'skipOnError' => true, 'targetClass' => Images::className(), 'targetAttribute' => ['proxy_image_ref' => 'id']],
            [['reason_ref'], 'exist', 'skipOnError' => true, 'targetClass' => Reasons::className(), 'targetAttribute' => ['reason_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'first_name_owner' => 'First Name Owner',
            'second_name_owner' => 'Second Name Owner',
            'third_name_owner' => 'Third Name Owner',
            'account' => 'Account',
            'is_declarant_owner' => 'Is Declarant Owner',
            'first_name_agent' => 'First Name Agent',
            'second_name_agent' => 'Second Name Agent',
            'third_name_agent' => 'Third Name Agent',
            'proxy_image_ref' => 'Proxy Image Ref',
            'index' => 'Index',
            'state' => 'State',
            'city' => 'City',
            'street' => 'Street',
            'house' => 'House',
            'building' => 'Building',
            'apartment' => 'Apartment',
            'address' => 'Address',
            'reason_ref' => 'Reason Ref',
            'reason_text' => 'Reason Text',
            'phone' => 'Phone',
            'email' => 'Email',
            'status_1c' => 'Status 1c',
            'is_order_send' => 'Is Order Send',
            'order_uid' => 'Order Uid',
            'reason_your' => 'Ваша причина обращения',
            'order_number' => 'Номер заявки для клиента',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderHistories() {
        return $this->hasMany(OrderHistory::className(), ['orders_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProxyImageRef() {
        return $this->hasOne(Images::className(), ['id' => 'proxy_image_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReasonRef() {
        return $this->hasOne(Reasons::className(), ['id' => 'reason_ref']);
    }
}
