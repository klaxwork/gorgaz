<?php

namespace common\models;

use common\components\M;
use common\models\models\SysNotifyEvents;
use common\models\models\SysNotifyTemplates;
use yii;
use Twig;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\ArrayLoader;

class TwigNotify
{
    public $twig;

    public $from;
    //public $receivers = ['mails' => [], 'phones' => []];
    public $receiver = ['mail' => [], 'phone' => ''];
    public $subject;
    public $text;
    public $templates = [];
    public $template;
    public $data = [];

    public $order = [];
    public $products = [];
    public $client = [];
    public $timeline = [];
    public $seance = [];
    public $booking = [];
    public $comment = '';
    public $delivery_data = [];

    public function __construct($event)
    {
        if ($event) {
            $this->getEvent($event);
        }

        return $this;
    }

    public function twig()
    {
        M::xlog('twig()');
        if (empty($this->twig)) {
            //require_once Yii::getAlias('vendor.twig.twig.lib.Twig') . '/Autoloader.php';

            //Yii::registerAutoloader(['Twig_Autoloader', 'autoload']/*, true*/);

            $this->twig = new Environment(new ArrayLoader());
            //Environment(new \Twig_Loader_String());
            $this->updateFunctions();
        }
        return $this->twig;

    }

    public function updateFunctions()
    {
        // Добавляем функцию
        $twigFunctions = new TwigNotifyFunctions();
        $list = get_class_methods($twigFunctions);
        //M::printr($list, '$list');
        foreach ($list as $func) {
            $this->twig->addFunction(new TwigFunction($func, $twigFunctions));
        }
        //$this->twig->addFunction('times', new Twig_Function_Function([$twigFunctions, 'times']));
    }

    public function render($template = false, $data = false)
    {
        $this->twig();
        if (!empty($template)) {
            $oTemplate = $this->twig->createTemplate($template);
            $this->template = $oTemplate;
        }
        if (!empty($data)) {
            $this->setData($data);
        }
        $array = [
            'order' => $this->order,
            'products' => $this->products,
            'client' => $this->client,
            'timeline' => $this->timeline,
            'seance' => $this->seance,
            'comment' => $this->comment,
            'booking' => $this->booking,
            'data' => $this->data,
            'delivery_data' => $this->delivery_data,
        ];
        //$result = $this->twig()->render($this->template, $array);
        $result = $this->template->render($array);
        return $result;
    }

    public function setData($data)
    {
        if (is_array($data)) {
            if (isset($data['order'])) {
                $this->order = $data['order'];
            }
            if (isset($data['products'])) {
                $this->products = $data['products'];
            }
            if (isset($data['client'])) {
                $this->client = $data['client'];
            }
            if (isset($data['timeline'])) {
                $this->timeline = $data['timeline'];
            }
            if (isset($data['seance'])) {
                $this->seance = $data['seance'];
            }
            if (isset($data['booking'])) {
                $this->booking = $data['booking'];
            }
            if (isset($data['comment'])) {
                $this->comment = $data['comment'];
            }
        } elseif (is_object($data)) {
            $this->order = $data->order;
            $this->products = $data->products;
            $this->client = $data->client;
            $this->timeline = $data->timeline;
            $this->seance = $data->seance;
            $this->booking = $data->booking;
            $this->comment = $data->comment;
        }
        //M::printr($this->client, 'TWIG $this->client');
        $email = '';
        $email = (isset($this->client['#credentials']['identify_email'])) ? $this->client['#credentials']['identify_email'] : $email;
        $email = (isset($this->client['#contacts']['email'])) ? $this->client['#contacts']['email'] : $email;
        if (isset($this->client['email'])) {
            if (!empty($this->client['email'])) {
                $email = $this->client['email'];
            }
        }
        $this->client['email'] = $email;


        $phone = '';
        $phone = (isset($this->client['#credentials']['identify_phone'])) ? $this->client['#credentials']['identify_phone'] : $phone;
        $phone = (isset($this->client['#contacts']['phone'])) ? $this->client['#contacts']['phone'] : $phone;
        if (isset($this->client['phone'])) {
            if (!empty($this->client['phone'])) {
                $phone = $this->client['phone'];
            }
        }
        $this->client['phone'] = $phone;
        //M::printr($this->client, '$this->client');
        $this->data = $data;
    }

    public function getEvent($event)
    {
        $oQuery = SysNotifyEvents::find()
            ->alias('events')
            ->joinWith(
                [
                    'hasTemplates.template.service',
                    'hasTemplates.template.type',
                ]
            );
        if (is_integer($event)) {
            $oQuery->where(['events.id' => (int)$event]);
        } else {
            $oQuery->where(['events.event_alias' => $event]);
        }
        $oEvent = $oQuery->one();
        //M::printr($oEvent, '$oEvent');
        //M::xlog('$oEvent', 'Notify');
        //M::xlog($oEvent, 'Notify');
        if (!empty($oEvent->hasTemplates)) {
            foreach ($oEvent->hasTemplates as $template) {
                $this->templates[] = $template;
            }
        }
    }

    public function getTemplates($template)
    {
        $oTemp = null;
        $oQuery = SysNotifyTemplates::find()
            ->alias('templates')
            ->joinWith(
                [
                    'type',
                    'service',
                ]
            );

        if (is_integer($template)) {
            $oQuery->where(['templates.id' => (int)$template]);
        } else {
            $oQuery->where(['templates.alias' => $template]);
        }
        //M::printr($criteria, '$criteria');

        $oTemplate = $oQuery->one();
        if (empty($oTemplate)) {
            throw new yii\base\Exception("Can`t find Template '{$template}'");
        }
        $this->template = $oTemplate->template_body;
    }

    public function getSource($order_id)
    {
        $source = new NotifyOrderSource($order_id);
        $this->setData($source);
    }

    public function send()
    {
        //приводим данные клиента в порядок
        $this->clientPhone();
        $this->clientEmail();

        foreach ($this->templates as $template) {
            //M::printr($template, '$template');
            $service = $template->template->service->notify_service;
            $this->$service($template);
            $this->receiver['mail'] = [];
            $this->receiver['phone'] = '';
        }
    }

    public function EMAIL($template)
    {
        //M::printr('EMAIL', 'EMAIL');
        //отправка email
        $type = $template->template->type->notify_type;
        $this->$type();

        //взять тему (название шаблона)
        //M::xlog(['$template->template->subject' => $template->template->subject]);
        $this->subject = $this->render($template->template->subject);
        //M::xlog(['$this->subject' => $this->subject]);

        //взять текст шаблона и применить шаблонизатор
        //M::xlog(['$template->template->template_body' => $template->template->template_body]);
        $this->text = $this->render($template->template->template_body);
        //M::xlog(['$this->text' => $this->text]);

        //M::xlog('$this->receiver[mail] EMAIL: ' . $this->receiver['mail'], 'Notify');
        $result = '';
        //M::printr($this->receiver, 'EMAIL $this->receiver');
        //M::xlog(['$this->receiver EMAIL', $this->receiver], 'Notify');
        //M::xlog(['$this->client EMAIL', $this->client], 'Notify');
        if (!empty($this->receiver['mail'])) {
            //M::xlog($this->receiver['mail'], 'Notify');
            //todo раскомментировать отправку Email
            $arr = explode('\n', $this->text);
            $str = strtolower(str_replace(' ', '', $arr[0]));
            if (strpos($str, '<!--html-->') === false) {
                $this->text = nl2br($this->text);
            }
            $result = M::sendEmail($this->receiver['mail'], $this->text, $this->subject);
            //M::xlog($result, 'Notify');
        }

    }

    public function SMS($template)
    {
        //отправка sms
        //M::xlog('SMS', 'Notify');
        //M::printr($template, '$template');
        //M::printr('SMS', 'SMS');
        $type = $template->template->type->notify_type;
        $this->$type();
        //взять текст шаблона и применить шаблонизатор
        $this->text = $this->render($template->template->template_body);
        //M::printr($this->text, '$this->text');
        //M::xlog('$this->receiver[phone] SMS: ' . $this->receiver['phone'], 'Notify');
        //отправить sms...
        //M::printr($this->receiver, 'SMS $this->receiver');
        //todo раскомментировать отправку SMS
        //M::xlog('$this->receiver SMS', 'Notify');
        //M::xlog($this->receiver, 'Notify');
        $result = M::sendSms($this->receiver['phone'], $this->text);
        //M::printr($result, '$result');
        //M::xlog($result, 'Notify');
        return $result;

    }

    public function TELEGA($template)
    {

    }

    public function clientPhone()
    {
        $phone = '';
        //получить телефон из #credentials
        $phone = (isset($this->client['#credentials']['identify_phone'])) ? $this->client['#credentials']['identify_phone'] : $phone;
        //получить телефон из #contacts
        if (isset($this->client['#contacts'])) {
            foreach ($this->client['#contacts'] as $contact) {
                if (isset($contact['field_key']) && $contact['field_key'] == 'phone') {
                    $phone = $contact['field_value'];
                }
            }
        }
        //M::printr($phone, '$phone');
        if (isset($this->client['phone'])) {
            if (!empty($this->client['phone'])) {
                $phone = $this->client['phone'];
            }
        }
        $this->client['phone'] = $phone;
        //M::printr($phone, '$phone');
        //M::xlog(['$this->client[phone]', $this->client, $phone], 'Notify');
    }

    public function getClientPhone()
    {
        if (isset($this->client['phone']) && !empty($this->client['phone'])) {
            $this->receiver['phone'] = $this->client['phone'];
        } elseif (!empty($this->client['#credentials']['identify_phone'])) {
            $this->receiver['phone'] = $this->client['#credentials']['identify_phone'];
        }
        //M::printr($this->receiver, '$this->receiver');
        //M::xlog('getClientPhone: ' . $this->receiver['phone'], 'Notify');
    }

    public function clientEmail()
    {
        $email = '';
        //получить мыло из #credentials
        $email = (isset($this->client['#credentials']['identify_email'])) ? $this->client['#credentials']['identify_email'] : $email;
        //получить мыло из #contacts
        if (isset($this->client['#contacts'])) {
            foreach ($this->client['#contacts'] as $contact) {
                if (isset($contact['field_key']) && $contact['field_key'] == 'email') {
                    $email = $contact['field_value'];
                }
            }
        }
        if (isset($this->client['email'])) {
            if (!empty($this->client['email'])) {
                $email = $this->client['email'];
            }
        }
        $this->client['email'] = $email;
    }

    public function getClientEmail()
    {
        if (!empty($this->client['email'])) {
            $this->receiver['mail'] = $this->client['email'];
        } elseif (!empty($this->client['#credentials']['identify_email'])) {
            $this->receiver['mail'] = $this->client['#credentials']['identify_email'];
        }
    }

    public function getQuestPhone()
    {
        /*
        if (is_array($this->products)) {
            $this->receiver['phone'] = $this->products['sms_phone'];
        } else {
            $this->receiver['phone'] = $this->products->sms_phone;
        }
        //M::xlog('getQuestPhone: ' . $this->receiver['phone'], 'Notify');
        */
    }

    public function getQuestEmail()
    {
        /*
        if (is_array($this->products)) {
            $this->receiver['mail'] = $this->products['contact_email'];
        } else {
            $this->receiver['mail'] = $this->products->contact_email;
        }
        //$this->receiver['mail'] = !empty($this->products) ? (isset($this->products->contact_email) ? $this->products->contact_email : '') : '';
        //M::xlog('getQuestEmail: ' . $this->receiver['mail'], 'Notify');
        */
    }

    public function getAdminsEmail()
    {
        $this->receiver['mail'] = Yii::$app->params['emails'];

        //$this->receiver['mail'] = !empty($this->products) ? (isset($this->products->contact_email) ? $this->products->contact_email : '') : '';
        //M::xlog('getQuestEmail: ' . $this->receiver['mail'], 'Notify');
    }

    public function getAdminsPhone()
    {
        $this->receiver['phone'] = '';
        //M::xlog('getQuestEmail: ' . $this->receiver['mail'], 'Notify');
    }

    public function SYSTEM()
    {
        $this->getClientEmail();
        $this->getClientPhone();
    }

    public function SERVICE()
    {
        $this->getQuestEmail();
        $this->getQuestPhone();
    }

    public function APPDEVS()
    {
        $this->getQuestEmail();
        $this->getQuestPhone();
    }

    public function APPADMS()
    {
        $this->getAdminsEmail();
        $this->getAdminsPhone();
    }

    public function APPOPS()
    {
        //M::printr($this->client, 'APPOPS $this->client');
        $this->getQuestEmail();
        $this->getQuestPhone();
    }

    public function APPCLT()
    {
        //M::printr('APPCLT', 'APPCLT');
        //M::printr($this->client, 'APPCLT $this->client');
        $this->getClientEmail();
        $this->getClientPhone();
    }

    public function getSpool()
    {
        return [];
    }

    public function putSpool($post)
    {
        //M::printr($post, '$post');
    }

}
