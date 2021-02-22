<?php

namespace QW\Router;

class RouteMeta
{

    public $object = '@RouteMeta/fmt:json';

    public $md5sign;

    public $module_id = 'default';
    public $module_class = 'DefaultModule';

    public $controller_id = 'default';
    public $controller_class = 'DefaultController';

    public $action_id = 'index';
    public $action_class = 'CInlineAction';

    public $layout;
    public $namespace;
    public $route = '@default/undefined';

    public $backtrace_md5hash;
    public $backtrace = array();



    public function __construct(\CController $c)
    {
        $this->init($c);
    }


    private function init(\CController $c)
    {

        if (!empty($c->module)) {
            $this->module_id = $c->module->id;
            $this->module_class = get_class($c->module);
            if (isset($c->module->defaultController) && !$c->id) {
                $this->controller_id = $c->module->defaultController;
            }
        }

        if (!empty($c->action)) {
            $this->action_id = $c->action->id;
            $this->action_class = get_class($c->action);
            if (isset($c->defaultAction) && !$c->action->id) {
                $this->action_id = $c->defaultAction;
            }
        }

        $this->controller_id = $c->id;
        $this->controller_class = get_class($c);
        $this->layout = $c->layout;

        $this->namespace = "@frontend/{$this->module_id}.{$this->controller_id}.{$this->action_id}";
        if (isset(\Yii::app()->urlManager) && isset(\Yii::app()->urlManager->currentRoutePath)) {
            $this->route = \Yii::app()->urlManager->currentRoutePath;
        }

        $this->md5sign();

    }

    private function md5sign()
    {
        $this->md5sign = md5(print_r($this, true));
    }


    public function setBacktrace(array $backtrace)
    {
        $this->backtrace_md5hash = md5(print_r($backtrace, true));
        $this->backtrace = $backtrace;
        return $this;
    }


    public function toJson()
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }

    public function toObject()
    {
        return json_decode($this->toJson());
    }


}

