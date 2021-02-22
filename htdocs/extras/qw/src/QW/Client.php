<?php

namespace QW;

use Viliot\Api\Authentication\AccessToken;

class Client
{


    protected static $instances = array();

    public static function app(\EdiBootstrap $bs)
    {

        $model = \EdiUseApplications::model()->findByAttributes([
            'edi_use_factory_ref' => $bs->edi_use_factory_ref,
            'application_key' => 'CLI0001',
        ]);

        if (empty($model)) {
            throw new \Exception("QWClient: Not found CLI0001 application in factory [{$bs->edi_use_factory_ref}] {$bs->factory->factory_name}");
        }


        if (!isset(self::$instances[$model->id])) {
            self::$instances[$model->id] = new self($model);
        }

        return self::$instances[$model->id];

    }



    protected $app;   // EdiUseApplications
    protected $client; // Viliot\Api\ApiClient

    protected $token;

    protected $options = array();


    public function __construct(\EdiUseApplications $app)
    {
        $this->app = $app;
        $data = json_decode($app->data);
        $token = md5("{$data->factory_id}:{$data->contract_id}:{$data->id}");
        $this->setToken($token);
        $this->setOption('endpoint', \Yii::app()->cli->endpoint);
    }


    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }


    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }


    public function api()
    {

        if (empty($this->client)) {
            $this->client = new \Viliot\Api\ApiClient(
                new AccessToken($this->token),
                $this->options
            );
        }

        return $this->client;


    }



    public function clients()
    {
        return $this->api()->Clients();
    }

    public function contacts()
    {
        return $this->api()->ClientContacts();
    }

    public function identify()
    {
        return $this->api()->ClientIdentify();
    }

    public function authorize()
    {
        return $this->api()->ClientAuthorize();
    }

    public function search()
    {
        return $this->api()->ClientSearch();
    }




}

