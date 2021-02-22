<?php

namespace QW\Route\Model;

use QW\Route\ModelAbstract as Model;


class RouteModel extends Model
{

    // const namespaces

    const NS_ROOT = "ROOT_NODE";
    const NS_CURRENT = "CURRENT_NODE";


    // model properties

    public $id;

    public $root_id;
    public $node_id;
    public $node_name;

    public $region_key;
    public $region_name;

    public $url_alias;
    public $url_path;
    public $url_md5hash;

    public $is_deprecated;
    public $is_deleted;

    public $is_seo_noindexing;
    public $is_node_published;
    public $is_node_protected;
    public $is_trash;

    public $dt_created;
    public $dt_updated;


    public function rules()
    {
        return array(
            // required
            ['node_name', 'required'],
            // safe
            ['node_name, region_key, region_name, url_alias, url_path, url_md5hash, is_deprecated, is_deleted, is_seo_noindexing, is_node_published, is_node_protected, is_trash, dt_created, dt_updated', 'safe'],
        );
    }

}
