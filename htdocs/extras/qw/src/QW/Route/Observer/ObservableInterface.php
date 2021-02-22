<?php

namespace QW\Route\Observer;

use QW\Route\Model\RouteModel;


interface ObservableInterface
{

    public function attach(ObserverInterface $instance);

    public function detach(ObserverInterface $instance);

    public function notify(RouteModel $item);

}
