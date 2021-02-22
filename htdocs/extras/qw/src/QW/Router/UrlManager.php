<?php

namespace QW\Router;

class UrlManager extends \CUrlManager
{

    public $currentRoutePath;

    public $urlRuleClass='QW\Router\UrlRule';

    public function parseUrl($request)
    {
        $this->currentRoutePath =  parent::parseUrl($request);
        return $this->currentRoutePath;
    }


}


