<?php

namespace common\models;

use common\components\M;
use common\models\ar_inherit\I8tags;
use common\models\ar_inherit\MediaContentTypes;
use \common\models\models\CmsMediaContentTypes;
use common\models\models\CmsMediaFolders;
use yii\base\Exception;
use common\models\ar_inherit\MediaFolders;

class CMSH4Resource
{

    public $name;
    public $extension_name;

    public $size = 0;
    public $type; // class CmsMediaContentTypes

    public $content_name;
    public $content_type;


    public $title;
    public $description;
    public $filename;

    public $folder; // class CmsMediaFolders

    public $preload;

    private $fsumask;

    private $rsTypes = [
        'is_object' => [
            'CUploadFile' => 'yii\web\UploadedFile',
            'CMediaStorage' => 'common\models\models\CmsMediaStorage',
        ],
        'is_array' => [
            'POST_UPLOAD' => ['name', 'type', 'tmp_name', 'error', 'size'],
        ],
        'is_string' => [
            'LOCAL_FILE',
        ],
    ];


    public function __construct($resource = null) {
        //M::printr($resource, 'CMSH4Resource: __construct($resource)');
        $this->fsumask = umask(0);
        umask(002);
        if (!empty($resource)) {
            $this->load($resource);
        }
    }

    public function __destruct() {
        $this->clean();
        umask($this->fsumask);
    }

    public function setType($content_type) {
        $this->type = MediaContentTypes::find()
            ->joinWith(
                [
                    'content',
                ]
            )
            ->where(
                [
                    'content_type' => $content_type,
                ]
            )
            ->one();

        if (empty($this->type)) {
            throw new Exception(sprintf('Unknown resource type: %s', $content_type));
        }

        $this->content_name = $this->type->content->content_name;
        $this->content_type = $this->type->content_type;

        return $this;

    }

    public function setFolder($folder = null) {
        //M::xlog('setFolder', 'H4Storage');
        if (!empty($folder)) {
            $this->folder = MediaFolders::findOne(['fs_dirname' => $folder]);
        }
        //M::xlog($folder, 'H4Storage');
        if (empty($this->folder)) {
            $this->folder = MediaFolders::findOne(['is_default' => true]);
        }
        //M::xlog(['>> $this' => $this], 'upload');
        return $this;
    }


    public function clean() {
        if (file_exists($this->preload)) {
            unlink($this->preload);
        }
    }

    public function save($saveTo) {
        if (file_exists($this->preload)) {
            copy($this->preload, $saveTo);
            if (file_exists($saveTo)) {
                return true;
            }
        }
    }

    public function loadFromUrl($url) {

    }

    public function uploadedFile($resource) {
        //M::printr($resource, '$resource');
        $storage = \Yii::getAlias('@storage');
        //M::printr($storage, '$storage');
        //$checkType = $this->checkType($resource);
        //M::printr($checkType, '$checkType');
        if (!empty($resource->size)) {
            //M::printr('!empty($resource->size)');
            $this->name = $resource->name;
            $this->title = $resource->name;
            $this->filename = $resource->name;
            $this->setFolder();
            $this->setType($resource->type);
            $this->size = $resource->size;
            $pathInfo = pathinfo($resource->name);
            $extensionName = $pathInfo['extension'];
            $this->extension_name = strtolower($extensionName);
            $fs_resource = '/' . date('YmdHis') . '_' . CMSI8Tag::timestamp() . '_' . md5(serialize($this)) . '.' . $this->extension_name;
            $fs_preload = $storage . '/.preload' . $fs_resource;
            //M::printr($fs_preload, '$fs_preload');
            $resource->saveAs($fs_preload, false);
            //M::printr($resource, '$resource');
            if (file_exists($fs_preload)) {
                $this->preload = $fs_preload;
            }
        }
        //M::printr($this, '$this');
        return $this;
    }

    public function localFile($resource) {
        $storage = \Yii::getAlias('@storage');
        //$resource = '/home/devteam/workspace/hnt/htdocs/var/storage/sites/tsuyoki/images/Воблер TsuYoki AGENT 36F 001.jpg';
        //$resource = 'K:\OSPanel\domains\memory-yii2.rim\htdocs/var/storage/.preload/71f7bde4db4361b7248c9e4e59a9875f16017952725122.png';
        $pathInfo = pathinfo($resource);
        //M::printr($pathInfo, '$pathInfo');
        //$dir = "{$storage}/sites/tsuyoki/images";
        $filename = $pathInfo['basename']; //"{$dir}/{$pathInfo['basename']}"; //"{$dir}/{$pathInfo['basename']}";

        //заносим информацию о файле в объект
        $this->name = $pathInfo['basename'];
        $this->filename = $pathInfo['filename'];
        $this->setFolder();
        $this->setType(mime_content_type($resource));
        $this->size = filesize($resource);
        $this->extension_name = strtolower($pathInfo['extension']);
        $fs_resource = '/' . date('YmdHis') . '_' . CMSI8Tag::timestamp() . '_' . md5(serialize($this)) . '.' . $this->extension_name;
        $fs_preload = $storage . '/.preload' . $fs_resource;
        copy($resource, $fs_preload);
        if (file_exists($fs_preload)) {
            $this->preload = $fs_preload;
        }
        return $this;
    }

    public function loadFromPath($path) {

    }

    private function load($resource) {
        $storage = \Yii::getAlias('@storage');
        $checkType = $this->checkType($resource);
        switch ($checkType) {
            case 'CUploadFile':
                if (!empty($resource->size)) {
                    $this->name = $resource->name;
                    $this->title = $resource->name;
                    $this->filename = $resource->name;
                    $this->setFolder();
                    $this->setType($resource->type);
                    $this->size = $resource->size;
                    $pathInfo = pathinfo($resource->name);
                    $extensionName = $pathInfo['extension'];
                    $this->extension_name = strtolower($extensionName);
                    $fs_resource = '/' . date('YmdHis') . '_' . CMSI8Tag::timestamp() . '_' . md5(serialize($this)) . '.' . $this->extension_name;
                    $fs_preload = $storage . '/.preload' . $fs_resource;
                    $resource->saveAs($fs_preload, false);
                    if (file_exists($fs_preload)) {
                        $this->preload = $fs_preload;
                    }
                }
                break;
            case 'CMediaStorage':
                break;
            case 'POST_UPLOAD':
                $this->name = $resource['name'];
                $this->title = $resource['name'];
                $this->filename = $resource['name'];
                $this->setFolder();
                $this->setType($resource['type']);
                $this->size = $resource['size'];
                $info = pathinfo($resource['tmp_name']);
                //print "INFO: ";
                //print_r($info);
                //print "\n\n";
                $this->extension_name = strtolower($info['extension']);
                $fs_resource = '/' . date('YmdHis') . '_' . CMSI8Tag::timestamp() . '_' . md5(serialize($this)) . '.' . $this->extension_name;
                $fs_preload = $storage . '/.preload' . $fs_resource;
                copy($resource['tmp_name'], $fs_preload);
                if (file_exists($fs_preload)) {
                    $this->preload = $fs_preload;
                }
                break;
            case 'LOCAL_FILE':
                //$resource = '/home/devteam/workspace/hnt/htdocs/var/storage/sites/tsuyoki/images/Воблер TsuYoki AGENT 36F 001.jpg';
                $pathInfo = pathinfo($resource);
                $dir = "{$storage}/sites/tsuyoki/images";
                $filename = "{$dir}/{$pathInfo['basename']}"; //"{$dir}/{$pathInfo['basename']}";

                //заносим информацию о файле в объект
                $this->name = $pathInfo['basename'];
                $this->filename = $pathInfo['filename'];
                $this->setFolder();
                $this->setType(mime_content_type($resource));
                $this->size = filesize($filename);
                $this->extension_name = strtolower($pathInfo['extension']);
                $fs_resource = '/' . date('YmdHis') . '_' . CMSI8Tag::timestamp() . '_' . md5(serialize($this)) . '.' . $this->extension_name;
                $fs_preload = $storage . '/.preload' . $fs_resource;
                copy($resource, $fs_preload);
                if (file_exists($fs_preload)) {
                    $this->preload = $fs_preload;
                }
                break;
        }
    }


    private function checkType($resource) {
        //M::printr($resource, 'checkType($resource)');
        $type = 'is_' . gettype($resource);

        //M::printr($type, '$type');
        $rsType = $this->rsTypes[$type];
        //M::printr($rsType, '$rsType');

        if (!empty($rsType)) {
            foreach ($rsType as $key => $check) {
                //M::printr($key, '$key');
                //M::printr($check, '$check');
                switch ($type) {
                    case 'is_object':
                        if ($resource instanceof $check) {
                            return $key;
                        }
                        break;
                    case 'is_array':
                        if (is_array($check)) {
                            $test = count($check);
                            foreach ($check as $item) {
                                if (array_key_exists($item, $resource)) {
                                    if ((--$test) <= 0) {
                                        return $key;
                                    }
                                }
                            }
                        }
                        break;
                    case 'is_string':
                        return $check;
                        break;
                }
            }
        }
    }


}


