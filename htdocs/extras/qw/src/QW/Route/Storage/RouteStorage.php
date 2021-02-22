<?php

namespace QW\Route\Storage;

use QW\Route\Model\RouteModel;
use QW\Route\Observer\ObservableInterface;


class RouteStorage
{

    private $db;

    private $routes = array();

    private $notifier;

    private $is_force = false;

    public function __construct()
    {
        $this->db = \Yii::app()->rdb->db(3);
    }

    public function setNotifier(ObservableInterface $notifier)
    {
        $this->notifier = $notifier;
        return $this;
    }

    public function setForce($is_force)
    {
        $this->is_force = $is_force;
        return $this;
    }

    public function push($item)
    {
        if ($item instanceof RouteModel) {
            $this->routes[] = $item;
        }
        elseif (is_array($item) || $item instanceof \Traversable){
            $this->routes = $item;
        }
        return $this;
    }

    public function fetch()
    {
        return (array) $this->routes;
    }



    // build pipeline
    public function build()
    {
        $pipe = $this->db->pipeline();
        foreach ($this->routes as $item) {

            $rkey = $item->region_key ?: 'all';
            $hkey = "route:data:". $item->url_md5hash;
            $pipe->hset($hkey, "@". $rkey ."~". $item->url_path, $item->json);
            $pipe->expire($hkey, 86400);

            if (!$item->is_deprecated || $this->is_force) {
                $zkey = "route:node:id". $item->node_id;
                $d = new \DateTime(substr($item->dt_created, 0, 19));
                $pipe->hset($zkey, $d->getTimestamp(), $item->json);
                $pipe->expire($zkey, 86400);
                if (!empty($this->notifier)) {
                    $this->notifier->notify($item);
                }
            }

        }
        $pipe->execute();
        return $this;
    }


    public function getNode($id)
    {
        $hkey = "route:node:id". $id;
        $all = $this->db->hgetall($hkey);
        if (count($all) > 1) {
            ksort($all, SORT_NUMERIC);
        }
        $json = current(array_reverse($all));
        $model = (new RouteModel)->setJson($json);
        return $model;
    }

    public function find($url_path, $region_key = null)
    {
        $rkey = $region_key ?: 'all';
        $hkey = "route:data:". md5($url_path);
        $json = $this->db->hget($hkey, "@". $rkey ."~". $url_path);
        $model = (new RouteModel)->setJson($json);
        return $model;
    }

}
