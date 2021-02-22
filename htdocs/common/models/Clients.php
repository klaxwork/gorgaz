<?php

namespace common\models;

use common\components\M;
use common\models\models\EdiBootstrap;
use yii\base\Model;

class Clients extends Model
{
    public $id;
    public $view_name = null;
    public $first_name = null;
    public $second_name = null;
    public $family_name = null;
    public $gender_type = null;
    public $dt_birthday = null;
    public $region_key = null;
    public $source_data = null;
    public $description = null;

    public $client = null;
    public $credentials = [];
    public $contacts = [];
    public $phone = null;
    public $email = null;
    public $response = [];

    public $bonus = [];
    //public $original = null;
    public $ediBootstrap;
    public $oClient = [];
    public $oContacts = [];
    public $ediRelationClient;

    public function __construct($ediBootstrap = false)
    {
        if ($ediBootstrap) {
            $this->ediBootstrap = $ediBootstrap;
        } else {
            $this->ediBootstrap = EdiBootstrap::getByKey('qw:mirror');
        }
        return parent::__construct();
    }

    public static function model($ediBootstrap = false)
    {
        $th = new self;
        if ($ediBootstrap) {
            $th->ediBootstrap = $ediBootstrap;
        } else {
            $th->ediBootstrap = EdiBootstrap::getByKey('qw:mirror');
        }
        return $th;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['first_name'], 'required', 'message' => '{attribute} не может быть пустым'],
            [['id', 'first_name', 'family_name', 'second_name', 'phone', 'email', 'region_key', 'source_data', 'view_name', 'second_name', 'gender_type', 'dt_birthday', 'region_key', 'source_data', 'description'], 'safe'],

        ];

        return array(
            array('first_name, family_name, phone, email, source_data', 'filter', 'filter' => 'trim'),
            array('first_name', 'required', 'message' => '{attribute} не может быть пустым'),
            //array('phone', 'checkPhone'),
            array('email', 'email', 'message' => '{attribute} указан с ошибкой'),
            array('first_name, family_name', 'checkNames'),
            //array('url_alias', 'unique', 'Url Alias must be unique'),
            //array('template_name, alias', 'length', 'max' => 255),
            //array('description', 'length', 'max' => 1000),
            array('id, first_name, family_name, second_name, phone, email, region_key, source_data, view_name, second_name, gender_type, dt_birthday, region_key, source_data, description', 'safe'),
        );

    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'first_name' => 'Имя',
            'family_name' => 'Фамилия',
            'second_name' => 'Отчество',
            'gender_type' => 'Пол',
            'phone' => 'Телефон',
            'email' => 'Email',
            'region_key' => 'Регион',
            'source_data' => 'Источник',
            'dt_birthday' => 'Дата рождения',
            'description' => 'Описание',
        );
    }

    public static function normalPhone($phone)
    {
        if (!empty($phone)) {
            $phone = preg_replace('/[^0-9]/', '', $phone);
            $phone = '+7' . substr($phone, -10);
        } else {
            $phone = null;
        }
        return $phone;
    }

    public function fromArray($array)
    {
        //if (empty($this->client->id)) {
        //$this->client = QW\Client::app($this->ediBootstrap)->identify()->create();
        //}
        $this->setAttributes($array);
        //$this->client->fromArray($array);
        //$view_name = trim(trim($this->first_name) . " " . trim($this->family_name));
        //$this->client->view_name = $view_name;
        $this->oContacts = isset($array['contacts']) ? $array['contacts'] : [];
    }

    public function getClientId()
    {
        return $this->id;
    }

    public function getClient($client_partner_id = false)
    {
        //M::printr('getClient()??', 'getClient()??');
        //M::printr($client_partner_id, '$client_partner_id');
        //получить клиента по его ID в клиентской базе (в партнерской базе)

        //M::printr($this->ediBootstrap, '$this->ediBootstrap');
        //M::printr($this->ediBootstrap->factory, '$this->ediBootstrap->factory');
        $client = QW\Client::app($this->ediBootstrap)->identify()->give($client_partner_id);
        //M::printr($client, 'getClient $client');

        $this->client = $client;
        $this->oClient = $client->toArray();
        $this->email = $this->oClient['#credentials']['identify_email'];
        $this->phone = $this->oClient['#credentials']['identify_phone'];
        //M::printr($this->oClient, '$this->oClient');

        $this->setAttributes($this->oClient);
        //M::printr($this, '$this');

        return $this;
    }

    public function getContacts($client_partner_id = false)
    {
        //M::printr('getContacts()', 'getContacts()');
        //M::printr($this, '$this');
        if (!$client_partner_id) {
            $client_partner_id = $this->client->id;
        }
        //M::printr($client_partner_id, '$client_partner_id');
        //M::printr($this->ediBootstrap, '$this->ediBootstrap');
        //M::printr($this->ediBootstrap->factory, '$this->ediBootstrap->factory');
        $contacts = QW\Client::app($this->ediBootstrap)->contacts()->all($client_partner_id);
        $this->contacts = $contacts;
        //M::printr($contacts, '$contacts');
        foreach ($contacts as $contact) {
            //M::printr($contact->toArray(), '$contact->toArray()');
            $this->oContacts[] = $contact->toArray();
        }

        return $this;
    }

    /**
     * добавление новых контактов
     *
     * @param array $contacts ['field_key' => $field_key, 'field_value' => $field_value]
     */
    public function addContacts($contacts)
    {
        foreach ($contacts as $contact) {
            $this->addContact($contact);
        }
    }

    /**
     * создание и добавление новых контактов
     *
     * @param array $contact
     * @throws Exception
     */
    public function createContact($contact = [])
    {
        //M::printr($contact, 'createContact($contact)');
        $oContact = QW\Client::app($this->ediBootstrap)->contacts()->with(['client_id' => $this->client->id])->create();
        //M::printr($oContact, '$oContact');
        if (isset($contact['field_key']) && isset($contact['field_value']) && !empty($contact['field_value'])) {
            //если это qw:mirror, то поискать в $this->contacts[n]->field_value
            //if ($this->ediBootstrap->factory->dev_key == 'qw:mirror') {
            $is_founded = false;
            foreach ($this->contacts as $thContact) {
                //M::printr($thContact, '$thContact');
                if ($thContact->field_key == $contact['field_key'] && $thContact->field_value == $contact['field_value']) {
                    $is_founded = true;
                    break;
                }
            }
            if ($is_founded) {
                //M::printr($is_founded, '$is_founded');
                //M::printr($contact, '$contact');
                return ['success' => true, 'data' => $thContact->toArray()];
            }
            //}


            $oContact->field_key = $contact['field_key'];
            $oContact->field_value = $contact['field_value'];
            //$this->addContact($oContact);
        }

        $response = $oContact->save();
        //M::printr($response, '$response');
        if (!$response['success']) {
            throw new Exception("Can`t create contact {$oContact->field_key} - {$oContact->field_value} ({$response['message']})");
        }
        return $response;
        //throw new Exception('"field_key" or "field_value" not found in contact');
    }

    /**
     * добавление новых контактов
     *
     * @param array , ClientsContact $contact
     * @throws Exception
     */
    public function addContact($contact)
    {
        //M::printr($contact, 'addContact($contact)');
        //M::printr($contact->getType(), '$contact->getType()');
        if (is_object($contact) && $contact->getType() == 'Viliot\Api\Resources\ClientContacts') {
            //M::printr($contact->getType(), '$contact->getType()');
            $this->contacts[] = $contact;
        } else {
            if (isset($contact['field_key']) && isset($contact['field_value'])) {
                $this->createContact($contact);
            }
            throw new Exception('"field_key" or "field_value" not found in contact');
        }
        //throw new Exception('Can`t add contact');
    }


    public function getGlobalClient($global_id)
    {
        //получить клиента по его ID в глобальной базе
        $client = QW\Client::app($this->ediBootstrap)->identify()->give($global_id);
        $this->oClient = $client->toArray();
        $this->client = $client;

        return $this;
    }

    public function getGlobalId($client_partner_id = false)
    {
        if ($client_partner_id) {
            $this->getClient($client_partner_id);
        }
        $oClient = $this->oClient;
        $global = $oClient['#global'];
        $globalId = $global['client_private_id'];
        return $globalId;
    }

    public function save()
    {
        $aContacts = $this->oContacts;
        //M::printr('$this', 'SAVE $this');
        if (!$this->validate() || !$this->checkPhoneOrEmail()) {
            //M::printr($this->getErrors(), '$this->getErrors()');
            return false;
            //throw new Exception('VALIDATION ERROR');
        }
        //M::printr($aContacts, '$aContacts');
        //M::printr($this->getErrors(), '$this->getErrors()');
        //M::printr($this->oClient, 'SAVE $this');
        //привести имя и фамилию к нормальному виду (убрать лишние символы и заменить множественные пробелы на одинарные)
        $this->first_name = preg_replace("/[^a-zA-Zа-яА-ЯЁё\s-]/u", '', $this->first_name);
        $this->first_name = preg_replace("/\s{2,}/", ' ', $this->first_name);

        $this->second_name = preg_replace("/[^a-zA-Zа-яА-ЯЁё\s-]/u", '', $this->second_name);
        $this->second_name = preg_replace("/\s{2,}/", ' ', $this->second_name);

        $this->family_name = preg_replace("/[^a-zA-Zа-яА-ЯЁё\s-]/u", '', $this->family_name);
        $this->family_name = preg_replace("/\s{2,}/", ' ', $this->family_name);

        $needleBootstrap = $this->ediBootstrap;
        //создать у qw:mirror
        //$this->ediBootstrap = EdiBootstrap::getByKey('qw:mirror');

        //M::printr($this->ediBootstrap, '$this->ediBootstrap');
        //M::printr($this, 'SAVE $this');
        //$this->createClient();
        //сначала сохраняем у партнера
        $this->saveClient();

        $this->saveContacts();
        //добавляем идентификационные телефон и мыло в список контактов
        if (!empty($this->phone)) {
            $item = ['field_key' => 'phone', 'field_value' => $this->phone];
            $this->oContacts[] = $item;
        }
        if (!empty($this->email)) {
            $item = ['field_key' => 'email', 'field_value' => $this->email];
            $this->oContacts[] = $item;
        }
        $this->saveContacts();

        $this->createRelation();

        //Создать бонусный счет клиента
        $this->createBonusAccount();


        //создание клиента у QW:MIRROR
        $QwBootstrap = EdiBootstrap::getByKey();
        if ($this->ediBootstrap->id != $QwBootstrap->id) {
            //клонировать объект для qw:mirror, очистить ID у контактов для qw::mirror
            $QW = clone $this;
            $QW->ediBootstrap = $QwBootstrap;
            $client = $QW->client->toArray();
            unset($client['id']);
            unset($client['#contacts']);
            unset($client['#credentials']);
            $QW->client = QW\Client::app($QW->ediBootstrap)->identify()->create();
            $QW->client->fromArray($client);

            $QW->saveClient();
            $QW->getContacts($QW->client->id);
            $QW->oContacts = $aContacts;
            foreach ($QW->oContacts as &$oContact) {
                unset($oContact['id']);
            }
            $QW->saveContacts();

            $QW->createRelation();
            //Создать бонусный счет клиента
            $QW->createBonusAccount();

        }

        return true;
    }

    public function saveClient()
    {
        if (empty($this->client->id)) {
            $this->client = QW\Client::app($this->ediBootstrap)->identify()->create();
        }
        $this->client->fromArray($this->attributes);
        //M::printr('saveClient()', 'saveClient()');
        //сохранение клиента

        $view_name = trim(trim($this->first_name) . " " . trim($this->family_name));
        $credentials = [
            'identify_email' => $this->email,
            'identify_phone' => $this->phone,
        ];
        $this->client->view_name = !empty($this->client->view_name) ? $this->client->view_name : $view_name;
        $this->client->{'#credentials'} = $credentials;
        unset($this->client->{'#contacts'});

        $response = $this->client->save();
        //M::printr($response, '$response');
        if (!$response['success']) {
            throw new Exception("Can`t save Client ({$response['message']})");
        }

        //M::printr($response, '$response');
        $this->response = $response;
        $this->client->fromArray($response['data']);
        $this->client->id = $response['data']['id'];
        $this->id = $response['data']['id'];
        $this->oClient = $response['data'];
        //M::printr($this->oClient, '$this->oClient');
        //M::printr($this->ediBootstrap, '$this->ediBootstrap');
        //M::printr($this->ediBootstrap->factory, '$this->ediBootstrap->factory');
        $this->getClient($this->client->id);
    }

    public function saveContacts()
    {
        //M::printr('saveContacts()', 'saveContacts()');
        //M::printr($this->contacts, '$this->contacts');
        //M::printr($this->oContacts, '$this->oContacts'); 
        //пройти по всем пришедшим контактам.
        foreach ($this->oContacts as $oContact) {
            if (empty($oContact['field_value'])) {
                continue;
            }
            //M::printr($oContact, '$oContact');
            //если контакт имеет id, то проверить, изменился ли он
            if (isset($oContact['id']) && $oContact['id']) {
                //найти его среди имеющихся ($this->contacts)
                foreach ($this->contacts as $contact) {
                    if ($oContact['id'] == $contact->id) {
                        //M::printr($contact, '$contact');
                        if (isset($oContact['is_delete']) && $oContact['is_delete'] == 1) {
                            $response = $contact->delete();
                            //M::printr($response, '$contact->delete()');
                            if (!$response['success']) {
                                throw new Exception("Can`t delete contact ID = {$oContact['id']}");
                            }
                            break;
                        }
                        if ($oContact['field_value'] !== $contact->field_value) {
                            //проверить, не помечен ли он как на удаление
                            //если изменился, то сохранить в этом же контакте
                            $contact->field_value = $oContact['field_value'];
                            $response = $contact->save();
                            //M::printr($response, '$contact->save()');
                            if (!$response['success']) {
                                throw new Exception("Can`t save contact {$contact->id} - {$contact->field_value}");
                            }
                            break;
                        }
                    }
                }
            } else {
                //если контакт не имеет id, то создать контакт и добавить его к клиенту
                if (isset($oContact['is_delete']) && $oContact['is_delete'] == 1) {
                    continue;
                }
                $response = $this->createContact($oContact);
                //M::printr($response, '$this->createContact($oContact)');
            }
        }

        //обновляем контакты в $this->contacts и $this->oContacts
        $this->getContacts($this->client->id);
    }

    public function createClient()
    {
        $this->saveClient();
        $this->saveContacts();
        //заполнить контакты
        //поискать мыло и телефон в контактах
        $is_find_email = false;
        $is_find_phone = false;
        foreach ($this->contacts as $contact) {
            if ($contact->field_key == 'email') {
                if ($contact->field_value == $this->email) {
                    $is_find_email = true;
                }
            }
            if ($contact->field_key == 'phone') {
                if ($contact->field_value == $this->phone) {
                    $is_find_phone = true;
                }
            }
        }

        //если нет, то добавить
        if (!$is_find_email) {
            $contact = $this->createContact(['field_key' => 'email', 'field_value' => $this->email]);
            $this->addContact($contact);
        }
        if (!$is_find_phone) {
            $contact = $this->createContact(['field_key' => 'phone', 'field_value' => $this->phone]);
            $this->addContact($contact);
        }
        //M::printr($this, '$this');

        exit;

        $e = QW\Client::app($this->ediBootstrap)->identify()->create();
        $e->view_name = $view_name;
        //M::printr($this, '$this');
        //$e->fromArray($this->oClient);
        //*/
        $e->first_name = $this->first_name;
        $e->family_name = $this->family_name;
        $e->second_name = $this->second_name;
        $e->gender_type = $this->gender_type;
        $e->dt_birthday = strftime('%Y-%m-%d', strtotime($this->dt_birthday));

        //*/
        $e->region_key = $this->region_key ?: (isset(Yii::app()->region) ? (!empty(Yii::app()->region->subdomain) ? Yii::app()->region->subdomain : Yii::app()->region->default) : '');
        //*/

        $e->source_data = $this->source_data;
        $e->{'#credentials'} = [
            'identify_email' => $this->email,
            'identify_phone' => $this->phone,//'+79139454170',
        ];
        //M::printr($e, '$e');
        exit;
        $contacts = $e->{'#contacts'};
        $contacts['email'] = $contacts['email'] ?: $this->email;
        $contacts['phone'] = $contacts['phone'] ?: $this->phone;
        $e->{'#contacts'} = $contacts;
        //M::printr($e, '$e');

        $response = $e->save();
        //M::printr($response, '$response');
        $this->response = $response;
        //M::xlog('RESPONSE: ', 'Clients');
        //M::xlog($response, 'Clients');
        if (!$response['success']) {
            //M::printr($response, '$response');
            throw new Exception($response['message']);
        }

        $this->oClient = $response->toArray();//['data'];
        $this->oClient['phone'] = $this->phone;
        $this->oClient['email'] = $this->email;
        //M::printr($this, 'SAVEING $this');
        return true;
    }

    /**
     * @param $client_private_id
     */
    public function checkBonusAccount($client_private_id)
    {
        $oAppClient = AppClients::model()
            ->with(
                [
                    'hasAccount.account'
                ]
            )
            ->findByAttributes(['client_private_id' => $client_private_id]);
        if (empty($oAppClient)) {
            return false;
        }

    }

    public function checkMirrorClient($client_partner_id)
    {
        $client = $this->getClient($client_partner_id);
        $x = AppClients::model()
            ->with(
                [
                    'hasAccount.account'
                ]
            )
            ->findByAttributes(['client_private_id' => $client['#global']['client_private_id']]);
    }

    public function createRelation()
    {
        //сохранить клиента в edi_relation_clients_ref
        $oApplication = EdiUseApplications::getApp($this->ediBootstrap);
        $oRelation = EdiRelationClients::model()
            ->findByAttributes(
                [
                    'client_id' => $this->oClient['id'],
                    'edi_use_applications_ref' => $oApplication->id,
                ]
            );

        if (empty($oRelation)) {
            $oRelation = new EdiRelationClients();
        }
        //M::printr($this->oClient, '$this->oClient');
        $oRelation->edi_use_applications_ref = $oApplication->id;
        $oRelation->client_id = $this->oClient['id'];
        $oRelation->client_view_name = $this->oClient['view_name'];
        $oRelation->data = CJSON::encode($this->oClient);
        //M::printr($oRelation, '$oRelation');
        if (!$oRelation->save()) {
            $this->addErrors($oRelation->getErrors());
            throw new Exception('Can`t save data in EdiRelationClients');
        }
        $this->ediRelationClient = $oRelation;
        //M::printr($oRelation, '$oRelation');
        return true;
    }

    public function createBonusAccount()
    {
        //взять данные клиента
        $qw = $this->oClient;
        $global = $qw['#global'];
        //M::printr($qw, '$qw');

        try {
            //найти его в AppClients
            $bonusAccount = AppClients::model()
                ->with(
                    [
                        'hasAccount.account'
                    ]
                )->findByAttributes(
                    [
                        /*'client_mirror_id' => $qw['id'],*/
                        'client_private_id' => $global['client_private_id']
                    ]
                );
            //M::printr($bonusAccount, '$bonusAccount');
            //если счет уже есть, то пропустить создание аккаунта
            if (!empty($bonusAccount) && !empty($bonusAccount->hasAccount) && !empty($bonusAccount->hasAccount->account)) {
                return false;
            }

            //создать запись в AppClients
            if (!empty($bonusAccount)) {
                $appClient = $bonusAccount;
            } else {
                $appClient = new AppClients();
            }
            $appClient->client_mirror_id = $qw['id'];
            $appClient->client_private_id = $global['client_private_id'];
            $appClient->client_hash_key = $global['client_hash_key'];
            $appClient->client_view_name = $global['client_view_name'];
            if (!$appClient->save()) {
                $this->addErrors($appClient->getErrors());
                throw new Exception('Can`t save data in AppClients');
            }
            //M::printr($appClient, '$appClient');

            //создать запись в VbsAccounts
            $vbsAccount = new VbsAccounts();
            $vbsAccount->vbs_account_types_ref = 3;
            $vbsAccount->vbs_account_states_ref = 1;
            do { //генерировать номер аккаунта до тех пор
                $acc = [];
                for ($i = 0; $i < 4; $i++) {
                    $acc[$i] = '';
                    for ($j = 0; $j < 4; $j++) {
                        $acc[$i] .= rand(0, 9);
                    }
                }
                $hasAccount = VbsAccounts::model()->findByAttributes(['account_no' => $acc]);
            } while (!empty($hasAccount)); //пока не будет уникальным
            $vbsAccount->account_no = implode('-', $acc);
            $vbsAccount->amount = 0;
            if (!$vbsAccount->save()) {
                //M::printr($oAccount, '$oAccount');
                $this->addErrors($vbsAccount->getErrors());
                throw new Exception('Can`t save data in VbsAccounts');
            }
            //M::printr($vbsAccount, '$vbsAccount');

            //создать связь слиента в таблице AppClientHasBonusAccount
            $hasBonus = new AppClientHasBonusAccount();
            $hasBonus->app_clients_ref = $appClient->id;
            $hasBonus->vbs_accounts_ref = $vbsAccount->id;
            //M::printr($hasBonus, '$hasBonus');
            if (!$hasBonus->save()) {
                $this->addErrors($hasBonus->getErrors());
                throw new Exception('Can`t save data in AppClientHasBonusAccount');
            }
            //M::printr($hasBonus, '$hasBonus');

        } catch (Exception $e) {
            throw new Exception("Can`t create bonus account. (" . $e->getMessage() . ")");
        }


        //exit;
        //M::printr($response, '$response');
    }

    public function checkPhoneOrEmail()
    {
        $phone = trim($this->phone);
        $email = trim($this->email);
        if (empty($phone) && empty($email)) {
            $this->addError('phone_email', 'Хотя бы одно из них должно быть указано');
            return false;
        }
        return true;
    }

    public function checkPhone($attr)
    {
        if (!empty($this->$attr)) {
            //M::printr($this->$attr, '$this->$attr');
            $this->$attr = str_replace('+7', '', $this->$attr);
            $this->$attr = preg_replace('/[^0-9]/', '', $this->$attr);
            $this->$attr = "+7" . substr($this->$attr, -10);
            if (strlen($this->$attr) != 12) {
                $this->addError($attr, 'Телефон указан с ошибкой');
            }
            //M::printr($this->$attr, '$this->$attr');

            if (!preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $this->$attr)) {
                //$this->addError($attr, 'Телефон указан с ошибкой');
            }


            //убрать все симсолы, кроме цифр, и взять только 10 последних
            //$phone = substr(preg_replace("/[^0-9]/", '', $this->$attr), -10);
            //если длина не 10 символов, то ошибка
            //if (strlen($phone) != 10) {
            //$this->addError($attr, 'Телефон указан с ошибкой.');
            //}
        }
    }

    public function checkNames($attr)
    {
        if (!empty($this->$attr)) {
            //M::printr($this->$attr, '$this->$attr');
            //удалить все лищние символы
            $this->$attr = preg_replace('/[^a-zA-Zа-яёА-ЯЁ\s\-]+/u', '', $this->$attr);
            $this->$attr = preg_replace('/\s{2,}/', ' ', $this->$attr);
            //M::xlog('REPLACE: ' . $attr, 'Clients');
            //M::xlog($this->$attr, 'Clients');
            //M::printr($this->$attr, '$this->$attr');
            //разрешены a-zA-Zа-яёА-Я, пробел, дефис
            if (!preg_match('/[a-zA-Zа-яёА-ЯЁ\s\-]+/u', $this->$attr)) {
                $this->addError($attr, "В {$attr} имеются запрещенные символы");
            }

            //M::xlog('PREG_MATCH', 'Clients');
            //M::xlog($this, 'Clients');
        }
        //M::printr(preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $this->$attr), $this->$attr);
    }

    public function getBonusAccount($client_private_id = false)
    {
        if (!$client_private_id) {
            if (empty($this->oClient)) {
                return false;
            }
            $client_private_id = $this->oClient['#global']['client_private_id'];
        }

        $oClient = Clients::model()->getGlobalClient($client_private_id);

        //M::printr($client_private_id, '$client_private_id');
        $oBonus = AppClients::model()
            ->with(
                [
                    'hasAccount.account'
                ]
            )
            ->findByAttributes(['client_private_id' => $client_private_id]);
        //M::printr($oBonus, '$oBonus');

        if (empty($oBonus)) {
            if (!$oBonus) {
                //создать клиента у qw:mirror, создать бонус аккаунт
                $oClient->ediBootstrap = EdiBootstrap::getByKey();
                //M::printr($oClient, '$oClient');
                if (!$oClient->save()) {
                    //M::printr($oClient->getErrors(), '$oClient->getErrors()');
                    throw new Exception('Can`t save client.');
                }
                //M::printr($oClient, '$oClient');
                //exit;
                $oBonus = AppClients::model()
                    ->with(
                        [
                            'hasAccount.account'
                        ]
                    )
                    ->findByAttributes(['client_private_id' => $client_private_id]);
                //M::printr($client_private_id, '$client_private_id');
                //M::printr($oBonus, '$oBonus');
            }
        }
        if (empty($oBonus)) {
            return $oBonus;
        }
        return $oBonus;
    }

    public static function isEmail($contact)
    {
        $is_email = false;
        if (strpos($contact, '@') !== false) {
            $is_email = true;
        }
        return $is_email;
    }

    public static function isPhone($contact)
    {
        $is_phone = false;
        $contact = preg_replace('/[^0-9]/', '', $contact);
        $contact = substr($contact, -10);
        if (strlen($contact) == 10) {
            $is_phone = true;
        }
        return $is_phone;
    }

}