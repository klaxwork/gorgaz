<?php

namespace backend\models;

use yii\base\Model;
use common\models\models\CmsTree;

class NodeForm extends Model
{
    public $id;
    public $key;
    public $node_name;
    public $page_longtitle;
    public $page_body;
    public $page_teaser;
    public $page_description;
    public $url_alias;
    public $menu_title;
    public $menu_index;
    public $seo_title;
    public $seo_keywords;
    public $seo_description;
    public $is_menu_visible;
    public $is_seo_noindexing = true;
    public $is_node_published;
    public $is_in_markets = false;
    public $is_in_google = false;
    public $is_last_folder = false;
    public $dt_created;
    public $dt_updated;

    public $image_teaser_small;
    public $images_illustrations;

    public $ecm_nomenclature_ref = null;
    public $fields = [];

    public $root_id;

    /*/
    public function __construct()
    {
        //parent::__construct();
    }
    //*/

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['ns_root_ref', 'ns_left_key', 'ns_right_key', 'ns_level', 'menu_index'], 'default', 'value' => null],
            [['ns_root_ref', 'ns_left_key', 'ns_right_key', 'ns_level', 'menu_index'], 'integer'],
            [['node_name'], 'required'],
            [['is_menu_visible', 'is_node_published', 'is_trash', 'is_node_protected'], 'boolean'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['data_filter'], 'string'],
            [['node_name', 'menu_title'], 'string', 'max' => 255],
            [['ns_root_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsTree::className(), 'targetAttribute' => ['ns_root_ref' => 'id']],
        ];

    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'key' => 'Идентификатор категории в системе "МойСклад"',
            'node_name' => 'Название узла',
            'page_longtitle' => 'Альтернативное название узла',
            'page_body' => 'Описание',
            'page_teaser' => 'Короткое описание (Teaser)',
            'page_description' => 'Description',
            'url_alias' => 'Алиас узла',
            'menu_title' => 'Название пункта меню',
            'menu_index' => 'Сортировка',
            'seo_title' => 'SEO title',
            'seo_keywords' => 'SEO keywords',
            'seo_description' => 'SEO description',
            'is_menu_visible' => 'Показывать на главной странице',
            'is_seo_noindexing' => 'Запрет индексации роботом',
            'is_node_published' => 'Опубликовано на странице',
            'is_in_markets' => 'Показывать товары в Yandex.Market`е',
            'is_in_google' => 'Показывать товары в Google покупках и eLama',
        );
    }

    public function fromArray($array)
    {
        if (empty($array['images_illustrations'])) {
            $array['images_illustrations'] = [];
        }
        $this->setAttributes($array);

    }

    public function save()
    {
        //проверяем
        if (!$this->validate()) {
            throw new Exception('Wrong validate node');
        }
        //M::printr($this, '$this');
        //сохраняем
        if ($this->id) {
            $oTree = CmsTree::model()->with(['content', 'appNomenclature'])->findByPk($this->id);
        } else {
            $oTree = new CmsTree();
        }

        //сохранение CmsTree
        $oTree->setAttributes($this->attributes);
        $oTree->id = $this->id;
        $oTree->is_menu_visible = $this->is_menu_visible == "on" ? true : false;
        $oTree->is_seo_noindexing = $this->is_seo_noindexing == "on" ? true : false;
        $oTree->is_node_published = $this->is_node_published == "on" ? true : false;
        $oTree->is_in_markets = $this->is_in_markets == "on" ? true : false;
        $oTree->is_in_google = $this->is_in_google == "on" ? true : false;
        $oTree->dt_updated = new CDbExpression('NOW()');
        if ($this->root_id) {
            if (!$oTree->validate()) {
                $this->addErrors($oTree->getErrors());
                throw new Exception('Wrong validate node');
            }
            $root = CmsTree::model()->findByPk($this->root_id);
            if (!$oTree->appendTo($root)) {
                $this->addErrors($oTree->getErrors());
                throw new Exception('Cant add node in CmsTree');
            }
        } else {
            if (!$oTree->saveNode()) {
                $this->addErrors($oTree->getErrors());
                throw new Exception('Cant save node in CmsTree');
            }
        }
        //M::printr($oTree, '$oTree');

        //сохранение CmsNodeContent
        if (!empty($oTree->content)) {
            $oNodeContent = $oTree->content;
        } else {
            $oNodeContent = new CmsNodeContent();
            $oTemplate = CmsTemplates::getDefault();
            $oNodeContent->cms_templates_ref = $oTemplate->id;
        }
        $oNodeContent->cms_tree_ref = $oTree->id;
        if (!$this->id) {
            $oTemplate = CmsTemplates::getDefault();
            $oNodeContent->cms_templates_ref = $oTemplate->id;
        }
        $oNodeContent->page_title = $oTree->node_name;
        $oNodeContent->page_longtitle = $this->page_longtitle;
        $oNodeContent->page_body = $this->page_body;
        $oNodeContent->page_teaser = $this->page_teaser;
        $oNodeContent->page_description = $this->page_description;
        $oNodeContent->vcs_revision = (int)$oNodeContent->vcs_revision + 1;
        $oNodeContent->dt_created = new CDbExpression('now()');
        $oNodeContent->dt_updated = new CDbExpression('now()');
        if (!$oNodeContent->save()) {
            $this->addErrors($oNodeContent->getErrors());
            throw new Exception('Cant save node in CmsNodeContent');
        }

        //сохранить номенклатуру ecmNomenclature
        $oNom = new EcmNomenclature();
        if ((int)$this->ecm_nomenclature_ref > 0) {
            $oNom = EcmNomenclature::model()->findByPk($this->ecm_nomenclature_ref);
        }
        if (empty($oNom)) {
            $oNom = new EcmNomenclature();
        }
        $oNom->ecm_catalog_ref = EcmCatalog::getDefaultCatalog()->id;
        $oNom->nomenclature_name = $oTree->node_name;
        $oNom->nomenclature_alias = $oTree->url_alias;
        if (!$oNom->save()) {
            $this->addErrors($oNom->getErrors());
            throw new Exception('Cant`save nomenclature in EcmNomenclature');
        }
        //создать связку cms_tree - app_nomenclature - ecm_nomenclature
        //M::printr($oNom, '$oNom');

        $oAppNom = AppNomenclature::model()->findByAttributes(['cms_tree_ref' => $oTree->id, 'ecm_nomenclature_ref' => $oNom->id]);
        //M::printr($oAppNom, '$oAppNom');

        if (empty($oAppNom)) {
            $oAppNom = new AppNomenclature();
            $oAppNom->cms_tree_ref = $oTree->id;
            $oAppNom->ecm_nomenclature_ref = $oNom->id;
            if (!$oAppNom->save()) {
                $this->addErrors($oAppNom->getErrors());
                M::printr($oAppNom, '$oAppNom');
                throw new Exception('Can`t save data in AppNomenclature');
            }
        }

        //сохранить свойства этой номенклатуры
        foreach ($this->fields as $field) {
            //если удален
            if (isset($field['is_deleted'])) {
                //если был сохранен в базе
                if ((int)$field['id'] > 0) {
                    $EcmNomenclatureField = EcmNomenclatureFields::model()->findByPk($field['id']);
                    EcmNomenclatureFields::model()->deleteByPk($field['id']);
                }
                continue;
            }
            $oNomFields = false;
            if ((int)$field['id'] > 0) {
                $oNomFields = EcmNomenclatureFields::model()->findByPk($field['id']);
            }
            if (empty($oNomFields)) {
                $oNomFields = new EcmNomenclatureFields();
            }
            $oNomFields->ecm_nomenclature_ref = $oNom->id;
            $oNomFields->ecm_custom_fields_ref = $field['ecm_custom_fields_ref'];
            $oNomFields->is_visible_in_card = !empty($field['is_visible_in_card']);
            if (!$oNomFields->save()) {
                $this->addErrors($oNom->getErrors());
                throw new Exception('Can`t save data in EcmNomenclatureFields');
            }
        }

        $this->saveImages($oNodeContent);
        //return false;
        (new Map())->checkNode($oTree, true);
        //(new CmsTree\Site('qw'))->map();
        return true;
    }

    public function saveImages($oNodeContent)
    {
        //удалить все картинки каталога из cms_node_gallery
        CmsNodeGallery::model()->deleteAllByAttributes(array('cms_node_content_ref' => $oNodeContent->id));

        //M::xlog(['$this->images_illustrations', $this->images_illustrations], 'img');
        if (!empty($this->images_illustrations)) {
            $position = 100;
            foreach ($this->images_illustrations as $illustration) {
                //по картинке получить галерею
                $criteria = new CDbCriteria();
                $criteria->addColumnCondition(
                    array(
                        'edi_bootstrap_ref' => EdiBootstrap::getDefaultBootstrap()->id,
                        'cms_media_storage_ref' => $illustration['image_id'],
                    )
                );
                $oGallery = AppGallery::model()->find($criteria);
                if (empty($oGallery)) {
                    $oGallery = new AppGallery();
                    $oGallery->edi_bootstrap_ref = EdiBootstrap::getDefaultBootstrap()->id;
                    $oGallery->cms_media_storage_ref = $illustration['image_id'];
                }
                //M::xlog(['$oGallery', $oGallery]);
                //M::xlog(['$illustration', $illustration]);

                $oGallery->app_gallery_categories_ref = $illustration['category_id'];
                $oGallery->dt_updated = new CDbExpression('now()');
                $oGallery->on_view_position = $position;
                $position += 100;
                if (!$oGallery->save()) {
                    //M::printr($oGallery, '$oGallery');
                    $this->addErrors($oGallery->getErrors());
                    throw new Exception('Can`t save data in AppGallery');
                }

                if (!empty($oGallery->hasNode)) {
                    $oNodeHasGallery = $oGallery->hasNode;
                } else {
                    $oNodeHasGallery = new CmsNodeGallery();
                }
                $oNodeHasGallery->app_gallery_ref = $oGallery->id;
                $oNodeHasGallery->cms_node_content_ref = $oNodeContent->id;
                if (!$oNodeHasGallery->save()) {
                    $this->addErrors($oNodeHasGallery->getErrors());
                    throw new Exception('Can`t save data in CmsNodeGallery');
                }
            }
        }

        return true;
    }
}