<?php

namespace QW\Route;

use QW\Route\Observer\ObservableInterface;
use QW\Route\Observer\ObserverInterface;
use QW\Route\Model\RouteModel;


abstract class ObservableAbstract implements ObservableInterface
{

    const STATUS_NONE = 0;
    const STATUS_SUCCESS = 1;

    private $observers = array();


    public function attach(ObserverInterface $instance)
    {
        // attach observer instance
        foreach ($this->observers as $observer) {
            if ($instance === $observer) {
                // throw
                return false;
            }
        }
        $this->observers[] = $instance;
        return $this;
    }

    public function detach(ObserverInterface $instance)
    {
        // detach observer instance
        foreach ($this->observers as $key => $observer) {
            if ($instance === $observer) {
                unset($this->observers[$key]);
            }
        }
        return $this;
    }

    public function notify(RouteModel $item)
    {
        foreach ($this->observers as $observer) {
            $observer->update($this, $item);
        }
        return $this;
    }

}
