<?php

namespace QW\Route;


class ModelAbstract extends \CFormModel
{

    private $ar;

    public function setORM(\CActiveRecord $ar)
    {
        $this->ar = $ar;
        return $this;
    }

    public function getORM()
    {
        return $this->ar;
    }


    public function populate(\CActiveRecord $ar)
    {
        if (empty($this->ar)) {
            $this->setORM($ar);
        }
        if (property_exists($this, 'id') && empty($this->id)) {
            $this->id = $ar->getAttribute('id');
        }
        // populate property data
        $this->attributes = array_filter($ar->getAttributes($this->getSafeAttributeNames()), function ($item) {
            return $item !== null; // не обрабатываем пустые значения.
        });
        return $this;
    }

    // загрузка свойств
    public function load($item)
    {
        if ($item instanceof \CActiveRecord) {
            $this->populate($item);
        }
        elseif (is_array($item) || $item instanceof \Traversable) {
            foreach ($item as $ar) {
                $this->populate($ar);
            }
        }
        else {
            // other
        }
        return $this;
    }


    // setter
    public function setAttr($key, $value)
    {
        if (property_exists($this, $key)) {
            $this->{$key} = $value;
        }
        return $this;
    }


    // json data export
    public function getJson()
    {
        return json_encode($this->attributes, JSON_PRETTY_PRINT);
    }

    // json data import
    public function setJson($json)
    {
        $data = json_decode($json, true);
        if (is_array($data)) {
            foreach ($data as $key => $item) {
                $this->setAttr($key, $item);
            }
        }
        return $this;
    }

}
