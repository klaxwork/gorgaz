<?php

namespace QW\Redis;

use Predis\Client;


class RedisManager extends \CApplicationComponent
{

    /**
     * @var array|null
     */
    public $parameters = null;

    /**
     * @var array|null
     */
    public $options = null;

    /**
     * @var \Predis\Client
     */
    private $_client;


    /**
     * @return \Predis\Client
     */
    public function db($index = 0, $props = null)
    {
        $options = array_merge([
            'scheme' => 'tcp',
            'host' => 'localhost',
            'port' => 6379,
            'database' => $index,
        ], (array)$this->options, (array)$props);
        return new Client($options, (array)$this->parameters);
    }


    /**
     * @return \Predis\Client
     */
    public function getConnection()
    {
        if ($this->_client === null) {
            $this->_client = $this->db();
        }
        return $this->_client;
    }

    /**
     * @param       $name
     * @param array $params
     *
     * @return mixed
     */
    public function executeCommand($name, $params = [])
    {
        $redis = $this->getConnection();
        return call_user_func_array([$redis, $name], $params);
    }

    /**
     * {@inheritdoc}
     */
    public function __call($name, $params)
    {
        return $this->executeCommand($name, $params);
    }

}