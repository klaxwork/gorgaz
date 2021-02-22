<?php

namespace QW\Route\Observer;

use QW\Route\Model\RouteModel;


interface ObserverInterface
{

    public function update(ObservableInterface $instance, RouteModel $item);

}