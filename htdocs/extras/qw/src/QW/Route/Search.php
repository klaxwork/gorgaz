<?php

namespace QW\Route;

use QW\Route\Source\RouteSource;
use QW\Route\Storage\RouteStorage;


class Search
{

    public function lookup($url_path, $region_key = null)
    {
        $storage = new RouteStorage;
        return $storage->find($url_path, $region_key);
    }

    public function node($id)
    {
        $source = new RouteSource;
        $storage = new RouteStorage;

        // request in redis
        $node = $storage->getNode($id);
        if (!empty($node->id)) {
            return $node;
        }

        // request in db
        $node = $source->getNode($id);
        if (!empty($node->id)) {
            $storage->push($node)->setForce(true)->build();
            return $node;
        }
    }

}
