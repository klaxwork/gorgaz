<?php

namespace QW\Route;

use QW\Route\Source\RouteSource;
use QW\Route\Storage\RouteStorage;


class Indexer extends ObservableAbstract
{

    public function run()
    {

        $source = new RouteSource;

        $storage = (new RouteStorage)
            ->setNotifier($this)
            ->push($source->getCollection())
            ;

        $storage->build();

    }

}
