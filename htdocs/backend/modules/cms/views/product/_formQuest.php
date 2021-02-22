<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<style>
    #category1 {
        list-style-type: none;
        margin: 0;
        padding: 0;
        #width: 350px;
    }

    #category1 .previewx {
        margin: 3px 3px 3px 0;
        padding: 1px;
        float: left;
        width: 350px;
        #height: 90px;
        #font-size: 4em;
        text-align: center;
    }

</style>
<script>
    $(function () {
        $("#category1").sortable({
            zIndex: 9999
            //placeholder: "ui-state-highlight"
            //#items: "> previewx"
        });
        $("#category1").disableSelection();
    });
</script>

<?php $form = $this->beginWidget(
    'CActiveForm', array(
        'id' => $formName,
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )
);
?>
<style type="text/css">
    #popup {
        #position: absolute;
        margin: auto;
        width: 50%;
        height: 400px;
    }

    .wraptree {
        #position: relative;
        overflow-y: scroll;
        max-height: 500px;
    }

    .mytree {
        width: 50%;
        background-color: #fff;
        margin: auto;
        position: relative;
        padding: 20px;
    }

    .key_dots {
        cursor: pointer;
    }
</style>

<style>
    .teaser_big_clear {
        position: absolute;
        padding: 5px;
        margin: 5px;
        right: 0;
        top: 0;
        background-color: #ff8888;
        cursor: pointer;
        font-family: "Courier New";
    }

    .teaser_small_clear {
        position: absolute;
        padding: 5px;
        margin: 5px;
        right: 0;
        top: 0;
        background-color: #ff8888;
        cursor: pointer;
        font-family: "Courier New";
    }
</style>

<div class="panel">
    <div class="panel-heading">
        <?= $oCompany->company_name ?> - <?= $model->product_name ?>
        <ul class="nav panel-tabs-border panel-tabs">
            <li class="active">
                <a href="#tab_General" data-toggle="tab" aria-expanded="true">Основные</a>
            </li>
            <li class="">
                <a href="#tab_Params" data-toggle="tab" aria-expanded="false">Параметры квеста</a>
            </li>
            <li>
                <a href="#tab_Images" data-toggle="tab" aria-expanded="false">Изображения</a>
            </li>
            <li>
                <a href="#tab_resources" data-toggle="tab">Ресурсы</a>
            </li>
            <li>
                <a href="#tab_Bonus" data-toggle="tab">Бонусы</a>
            </li>
            <li>
                <a href="#tab_SEO" data-toggle="tab">SEO</a>
            </li>
        </ul>
    </div>
    <div class="panel-body Form admin-form">
        <div class="tab-content pn br-n">
            <div id="tab_General" class="tab-pane active">
                <?php $name = 'app_companies_ref' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>

                    <div class="input-group">
                        <div class="form-control input-sm"
                             id="<?= $form->id ?>_<?= $name ?>_text"><?= $oCompany->company_name ?></div>
                        <span class="input-group-addon input-sm key_dots"> ... </span> <input
                            type="hidden" name="<?= $form->id ?>[<?= $name ?>]"
                            id="<?= $form->id ?>_<?= $name ?>"
                            value="<?= $model->$name ?>">
                    </div>
                </div>

                <?php $name = 'product_name' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                           name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                </div>

                <div class="formField mb10" data-type="text">
                    <button id="toTranslit"
                            class="col-md-12 btn btn-sm btn-info mb10"><?= $model->getAttributeLabel('product_name') ?>
                        >> <?= $model->getAttributeLabel('url_alias') ?>
                    </button>
                </div>

                <?php $name = 'url_alias' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <input type="text" class="form-control input-sm"
                           id="<?= $form->id ?>_<?= $name ?>"
                           name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                </div>

                <?php $name = 'page_longtitle' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                           name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                </div>

                <?php $name = 'cms_templates_ref' ?>
                <?php
                $oTemplates = CmsTemplates::model()->findAll(array('order' => 't.template_name ASC'));
                ?>
                <div class="formField mb10">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <select id="<?= $form->id ?>_<?= $name ?>" name="<?= $form->id ?>[<?= $name ?>]"
                            class="form-control input-sm" data-type="select">
                        <?php foreach ($oTemplates as $oTemplate) { ?>
                            <option
                                value="<?= $oTemplate->id ?>" <?= $oTemplate->id == $model->cms_templates_ref ? 'selected' : '' ?>><?= $oTemplate->template_name ?></option>
                        <?php } ?>
                    </select>
                </div>

                <?php $name = 'app_regions_ref' ?>
                <?php
                $oRegions = AppRegions::model()->findAll(array('order' => 't.region_name ASC'));
                ?>
                <div class="formField mb10">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <select id="<?= $form->id ?>_<?= $name ?>" name="<?= $form->id ?>[<?= $name ?>]"
                            class="form-control input-sm" data-type="select">
                        <?php foreach ($oRegions as $oRegion) { ?>
                            <option
                                value="<?= $oRegion->id ?>" <?= $oRegion->id == $model->app_regions_ref ? 'selected' : '' ?>><?= $oRegion->region_name ?></option>
                        <?php } ?>
                    </select>
                </div>

                <?php $name = 'ecm_versions_ref' ?>
                <?php
                $oVersions = EcmVersions::model()->findAll(array('order' => 'id ASC'));
                ?>
                <div class="formField mb10">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <select id="<?= $form->id ?>_<?= $name ?>" name="<?= $form->id ?>[<?= $name ?>]"
                            class="form-control input-sm" data-type="select">
                        <?php foreach ($oVersions as $oVersion) { ?>
                            <option
                                value="<?= $oVersion->id ?>" <?= $oVersion->id == $model->ecm_versions_ref ? 'selected' : '' ?>><?= $oVersion->version_name ?></option>
                        <?php } ?>
                    </select>
                </div>

                <?php $name = 'wrs_position_weight' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                           name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                </div>

                <?php $name = 'admin_comment' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <textarea rows="10" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                              name="<?= $form->id ?>[<?= $name ?>]" data-type="text"><?= $model->$name ?></textarea>
                </div>

                <?php $name = 'page_teaser' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <textarea rows="10" maxlength="3000" class="form-control input-sm"
                              id="<?= $form->id ?>_<?= $name ?>"
                              name="<?= $form->id ?>[<?= $name ?>]" data-type="text"><?= $model->$name ?></textarea>
                </div>

                <?php $name = 'page_body' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <textarea rows="10" maxlength="3000" class="form-control input-sm"
                              id="<?= $form->id ?>_<?= $name ?>"
                              name="<?= $form->id ?>[<?= $name ?>]"><?= $model->$name ?></textarea>
                </div>

                <?php $name = 'ecm_categories_ref' ?>
                <?php
                $oCategories = EcmCategories::model()->findAll(array('order' => 't.category_name ASC'));
                ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <select name="<?= $form->id ?>[<?= $name ?>][]" id="<?= $form->id ?>_<?= $name ?>"
                            class="quest_create_category-multiple form-control select-primary js-states"
                            multiple="multiple">
                        <?php foreach ($oCategories as $oCategory) { ?>
                            <option
                                value="<?= $oCategory->id ?>" <?= !empty($model->ecm_categories_ref) ? (in_array($oCategory->id, $model->ecm_categories_ref) ? 'selected' : '') : '' ?>><?= $oCategory->category_name ?></option>
                        <?php } ?>
                    </select>
                </div>

                <?php $name = 'is_published' ?>
                <div class="formField mb10" data-type="text">
                    <label class="field option mt10"> <input type="checkbox" name="<?= $form->id ?>[<?= $name ?>]"
                                                             class="checkbox" <?= $model->$name ? 'checked' : '' ?>>
                        <span class="checkbox"></span><?= $model->getAttributeLabel($name) ?></label>
                </div>

                <?php $name = 'is_closed' ?>
                <div class="formField mb10" data-type="text">
                    <label class="field option mt10"> <input type="checkbox" name="<?= $form->id ?>[<?= $name ?>]"
                                                             class="checkbox" <?= $model->$name ? 'checked' : '' ?>>
                        <span class="checkbox"></span><?= $model->getAttributeLabel($name) ?></label>
                </div>

            </div>
            <!-- tab_Params -->
            <div id="tab_Params" class="tab-pane">
                <div class="row">
                    <?php $name = 'ecm_catalog_ref' ?>
                    <?php
                    $oCatalogs = EcmCatalog::model()->findAll(array('order' => 't.catalog_name ASC'));
                    ?>
                    <div class="formField hide mb10 col-md-12" data-type="text">
                        <label class=""
                               for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                        <select name="<?= $form->id ?>[<?= $name ?>]" id="<?= $form->id ?>_<?= $name ?>"
                                class="quest_create_category form-control select-primary">
                            <?php foreach ($oCatalogs as $oCatalog) { ?>
                                <option
                                    value="<?= $oCatalog->id ?>" <?= $oCatalog->catalog_key == 'quests' ? 'selected' : '' ?>><?= $oCatalog->catalog_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <?php $name = 'product_price' ?>
                    <div class="formField mb10 col-md-12" data-type="text">
                        <div class="col-md-2">
                            <label class="control-label"
                                   for="<?= $form->id ?>_<?= $name ?>">Цена квеста, руб.</label>
                        </div>
                        <div class="col-md-1">
                            <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                   name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                        </div>

                        <div class="col-md-1"></div>

                        <?php $name = 'game_duration' ?>
                        <div class="col-md-2 ">
                            <label class="pull-right control-label"
                                   for="<?= $form->id ?>_<?= $name ?>">Продолжительность квеста, мин.</label>
                        </div>
                        <div class="col-md-1">
                            <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                   name="<?= $form->id ?>[<?= $name ?>]" data-type="text"
                                   value="<?= $model->$name ? $model->$name : 60 ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php $name = 'game_min_players' ?>
                    <div class="formField col-md-12" data-type="text">
                        <label class=""
                               for="<?= $form->id ?>_<?= $name ?>">Количество игроков (min - max)</label>
                    </div>

                    <div class="formField" data-type="text">
                        <div class="col-md-1">
                            <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                   name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                        </div>

                        <div class="col-md-1">
                            -
                        </div>

                        <?php $name = 'game_max_players' ?>
                        <div class="col-md-1 mb10">
                            <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                   name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                        </div>
                    </div>
                </div>

                <div class="formField" data-type="text">
                    <div class="row">
                        <?php $name = 'game_hardmax_players' ?>
                        <div class="col-lg-1 mb10">
                            <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                   name="<?= $form->id ?>[<?= $name ?>]" data-type="text"
                                   value="<?= $model->$name ?>">
                        </div>
                        <div class="col-lg-11 pl5">
                            <span class="help-block mt5 text-primary"> <i class="fa fa-bell"></i> Указывается
                                максимальное количество игроков, которое может придти на сеанс</span>
                        </div>
                    </div>

                    <div class="row">
                        <?php $name = 'game_hardmax_addcost' ?>
                        <div class="col-lg-2 col-md-2 mb10">
                            <div class="input-group">
                                <input type="text" class="form-control input" id="<?= $form->id ?>_<?= $name ?>"
                                       name="<?= $form->id ?>[<?= $name ?>]" data-type="text"
                                       value="<?= $model->$name ?>"> <span class="input-group-addon"> <i
                                        class="fa fa-rub"></i> </span>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10 pl5">
                            <span class="help-block mt5 text-primary"> <i class="fa fa-bell"></i> Указывается цена за
                                каждого дополнительного игрока</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php $name = 'hands_orders_completed' ?>
                    <div class="col-lg-1 mb10">
                        <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                               name="<?= $form->id ?>[<?= $name ?>]" data-type="text"
                               value="<?= $model->$name ?>">
                    </div>
                    <div class="col-lg-11 pl5">
                        <span class="help-block mt5 text-primary"> <i class="fa fa-bell"></i> Указывается количество
                            игр, которые были проведены </span>
                    </div>
                </div>

                <div class="row">
                    <?php $name = 'location_address' ?>
                    <div class="formField mb10 col-md-12" data-type="text">
                        <label class=""
                               for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                        <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                               name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                    </div>
                </div>

                <div class="row">
                    <?php $name = 'location_metro_name' ?>
                    <div class="formField mb10 col-md-12" data-type="text">
                        <label class=""
                               for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                        <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                               name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                    </div>
                </div>

                <div class="row">
                    <?php $name = 'location_data' ?>
                    <div class="formField mb10 col-md-12" data-type="text">
                        <label class=""
                               for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                        <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                               name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                    </div>
                </div>

                <div class="row">
                    <?php $name = 'location_info' ?>
                    <div class="formField mb10 col-md-12" data-type="text">
                        <label class=""
                               for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                        <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                               name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                    </div>
                </div>

                <div class="row">
                    <?php $name = 'contact_email' ?>
                    <div class="formField mb10 col-md-12" data-type="text">
                        <label class=""
                               for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                        <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                               name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                    </div>
                </div>

                <div class="row">
                    <?php $name = 'contact_phone' ?>
                    <div class="formField mb10 col-md-12" data-type="text">
                        <label class=""
                               for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                        <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                               name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                    </div>
                </div>

                <?php $name = 'is_show_contact_phone' ?>
                <div class="formField mb10" data-type="text">
                    <label class="field option mt10"> <input type="checkbox" name="<?= $form->id ?>[<?= $name ?>]"
                                                             class="checkbox" <?= $model->$name ? 'checked' : '' ?>>
                        <span class="checkbox"></span><?= $model->getAttributeLabel($name) ?> (если снята, то будет
                        показан московский номер)</label>
                </div>

                <div class="row">
                    <?php $name = 'sms_phone' ?>
                    <div class="formField mb10 col-md-12" data-type="text">
                        <label class=""
                               for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?> (Формат
                            номера: 79012345678)</label> <input type="text" class="form-control input-sm"
                                                                id="<?= $form->id ?>_<?= $name ?>"
                                                                name="<?= $form->id ?>[<?= $name ?>]" data-type="text"
                                                                value="<?= $model->$name ?>"
                                                                placeholder="">
                    </div>
                </div>

                <div class="row">
                    <?php $name = 'external_site_url' ?>
                    <div class="formField mb10 col-md-12" data-type="text">
                        <label class=""
                               for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                        <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                               name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                    </div>
                </div>

                <div class="row">
                    <?php $name = 'external_target_url' ?>
                    <div class="formField mb10 col-md-12" data-type="text">
                        <label class=""
                               for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                        <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                               name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                    </div>

                </div>
            </div>

            <div id="tab_Images" class="tab-pane">
                <?php /* ?>
				<?php $name = 'image_teaser_big' ?>
				<div class="formField mb10 big_teaser" data-type="text">
					<label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>

					<div style="padding: 0; width: 590px; position: relative;">
						<?php
						$params = array(
							'quest' => isset($model->_quest->id) ? $model->_quest->id : null,
							'category' => 2,
							'callback' => 'setTeaser',
						);
						?>
						<a class="ajax-popup-link" id="category2"
						   href="<?= $this->createUrl('/quest/gallery/index', array('params' => CJSON::encode($params))); ?>">
							<div
								style="width: 590px; height: 580px; background-color: #b9dbe8; margin: auto; display: table;">
								<img class="image_thumb" data-src="holder.js/590x580" alt="holder"
									 style="width: 590px; height: 580px;">
							</div>
							<input type="hidden" id="<?= $form->id ?>_<?= $name ?>"
								   name="<?= $form->id ?>[<?= $name ?>]"
								   value="<?= $model->$name ?>"> </a>

						<div class="teaser_big_clear">X</div>

					</div>
				</div>
				<?php //*/ ?>

                <?php $name = 'image_teaser_small' ?>
                <div class="formField mb10 small_teaser" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>

                    <div style="padding: 0; width: 285px; position: relative;">
                        <?php
                        $params = array(
                            'quest' => isset($model->_quest->id) ? $model->_quest->id : null,
                            'category' => 3,
                            'callback' => 'setTeaser',
                        );
                        ?>
                        <a class="ajax-popup-link" id="category3"
                           href="<?= $this->createUrl('/quest/gallery/index', array('params' => CJSON::encode($params))); ?>">
                            <div
                                style="width: 285px; height: 350px; background-color: #b9dbe8; margin: auto; display: table;">
                                <img class="image_thumb" data-src="holder.js/285x350" alt="holder"
                                     style="width: 285px; height: 350px;">
                            </div>
                            <input type="hidden" id="<?= $form->id ?>_<?= $name ?>"
                                   name="<?= $form->id ?>[<?= $name ?>]"
                                   value="<?= $model->$name ?>"> </a>

                        <div class="teaser_small_clear">X</div>
                    </div>
                </div>

                <?php $name = 'image_teaser_top' ?>
                <div class="formField mb10 small_teaser" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>

                    <div style="padding: 0; width: 285px; position: relative;">
                        <?php
                        $params = array(
                            'quest' => isset($model->_quest->id) ? $model->_quest->id : null,
                            'category' => 4,
                            'callback' => 'setTeaser',
                        );
                        ?>
                        <a class="ajax-popup-link" id="category4"
                           href="<?= $this->createUrl('/quest/gallery/index', array('params' => CJSON::encode($params))); ?>">
                            <div
                                style="width: 1000px; height: 335px; background-color: #b9dbe8; margin: auto; display: table;">
                                <img class="image_thumb" data-src="holder.js/1000x335" alt="holder"
                                     style="width: 1000px; height: 335px;">
                            </div>
                            <input type="hidden" id="<?= $form->id ?>_<?= $name ?>"
                                   name="<?= $form->id ?>[<?= $name ?>]"
                                   value="<?= $model->$name ?>"> </a>

                        <div class="teaser_top_clear">X</div>
                    </div>
                </div>

                <?php $name = 'images_illustrations' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>

                    <div>
                        <?php
                        $params = array(
                            'quest' => isset($model->_quest->id) ? $model->_quest->id : null,
                            'category' => 1,
                            'multiple' => true,
                            'callback' => 'setIllustration',
                        );
                        ?>
                        <a class="ajax-popup-link legend-item btn btn-info ph30 mr20"
                           href="<?= $this->createUrl('/quest/gallery/index', array('params' => CJSON::encode($params))); ?>">...
                            (выбрать)</a>
                    </div>

                    <span>(Иллюстрации можно менять местами с помощью перетаскивания мышью.)</span>

                    <div id="category1" class="previews">
                    </div>
                </div>

            </div>

            <div id="tab_resources" class="tab-pane">
                <?php
                ?>
            </div>

            <div id="tab_Bonus" class="tab-pane">
                <?php
                $params = EcmProducts::model()->getParams($model->product_id);
                $param = $params['commission'];
                $extra = $params['extra-bonus'];
                //M::printr($param, '$param');
                //M::printr($extra, '$extra');
                ?>

                <div class="row">
                    <div class="col-lg-4">
                        <?php $name = 'is_use_bonuses' ?>
                        <?php //var_dump($model->$name); ?>
                        <div class="formField mb10" data-type="text">
                            <div class="checkbox-custom mb5">
                                <input
                                    type="checkbox" <?= $model->$name ? 'checked' : '' ?>
                                    id="<?= $form->id ?>_<?= $name ?>"
                                    name="<?= $form->id ?>[<?= $name ?>]"> <label
                                    for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="extraBonuses" style="display: block;">
                    <div class="row">
                        <div class="col-lg-4" data-type="text" style="text-align: center;">
                            <label class="" for="<?= $form->id ?>_<?= $name ?>"></label>
                        </div>
                        <div class="col-lg-2" data-type="text" style="text-align: center;">
                            <label class="" for="<?= $form->id ?>_<?= $name ?>">Значение</label>
                        </div>
                        <div class="col-lg-2" data-type="text" style="text-align: center;">
                            <label class="" for="<?= $form->id ?>_<?= $name ?>">Единица измерения</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4" data-type="text">
                            <label class="" for="<?= $form->id ?>_<?= $name ?>">Назначить экстра бонусы в размере:</label>
                        </div>
                        <div class="col-lg-2" data-type="text">
                            <?php $name = 'extraBonuses' ?>
                            <div class="formField" data-type="text">
                                <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                       name="<?= $form->id ?>[<?= $name ?>]" data-type="text"
                                       value="<?= $model->extraBonuses ?>">
                            </div>
                        </div>
                        <div class="col-lg-2" data-type="text">
                            <?php $name = 'unit' ?>
                            <div class="formField" data-type="text">
                                <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                       name="<?= $form->id ?>[<?= $name ?>]" data-type="text"
                                       value="шт.<?php //= $extra['unit']['unit_expr'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-4">
                        <?php $name = 'is_use_params' ?>
                        <?php //var_dump($model->$name); ?>
                        <div class="formField mb10" data-type="text">
                            <div class="checkbox-custom mb5">
                                <input
                                    type="checkbox" <?= $model->$name ? 'checked' : '' ?>
                                    id="<?= $form->id ?>_<?= $name ?>"
                                    name="<?= $form->id ?>[<?= $name ?>]"> <label
                                    for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="nowParams" style="display: block;">
                    <div class="row">
                        <div class="col-lg-12" data-type="text">
                            Глобальные настройки
                            комиссии: <?= $param['vbs_params_value'] ?> <?= $param['unit']['unit_expr'] ?>
                        </div>
                    </div>
                </div>

                <div id="Params" style="display: none;">
                    <div class="row">
                        <div class="col-lg-4" data-type="text" style="text-align: center;">
                            <label class="" for="<?= $form->id ?>_<?= $name ?>"></label>
                        </div>
                        <div class="col-lg-2" data-type="text" style="text-align: center;">
                            <label class="" for="<?= $form->id ?>_<?= $name ?>">Значение</label>
                        </div>
                        <div class="col-lg-2" data-type="text" style="text-align: center;">
                            <label class="" for="<?= $form->id ?>_<?= $name ?>">Единица измерения</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4" data-type="text">
                            <label class="" for="<?= $form->id ?>_<?= $name ?>">Комиссия системе c заказа</label>
                        </div>
                        <div class="col-lg-2" data-type="text">
                            <?php $name = 'commission' ?>
                            <div class="formField" data-type="text">
                                <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                       name="<?= $form->id ?>[<?= $name ?>]" data-type="text"
                                       value="<?= $model->commission ?>">
                            </div>
                        </div>
                        <div class="col-lg-2" data-type="text">
                            <?php $name = 'unit' ?>
                            <div class="formField" data-type="text">
                                <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                       name="<?= $form->id ?>[<?= $name ?>]" data-type="text"
                                       value="%" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function () {
                        var is_use_params = <?= $model->is_use_params ? 'true' : 'false' ?>;
                        if (is_use_params) {
                            $('#Params').show();
                            $('#nowParams').hide();
                        } else {
                            $('#Params').hide();
                            $('#nowParams').show();
                        }
                        $('#<?= $form->id ?>_is_use_params').on('change', function () {
                            if ($(this).prop('checked') == true) {
                                $('#Params').show();
                                $('#nowParams').hide();
                            } else {
                                $('#Params').hide();
                                $('#nowParams').show();
                            }

                        });

                        var is_use_bonuses = <?= $model->is_use_bonuses ? 'true' : 'false' ?>;
                        if (is_use_bonuses) {
                            $('#extraBonuses').show();
                        } else {
                            $('#extraBonuses').hide();
                        }
                        $('#<?= $form->id ?>_is_use_bonuses').on('change', function () {
                            if ($(this).prop('checked') == true) {
                                $('#extraBonuses').show();
                            } else {
                                $('#extraBonuses').hide();
                            }

                        });
                    });
                </script>

            </div>

            <div id="tab_SEO" class="tab-pane">
                <?php $name = 'seo_title' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <input type="text" class="form-control input-sm quotes" id="<?= $form->id ?>_<?= $name ?>"
                           name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                </div>

                <?php $name = 'seo_keywords' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                           name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                </div>

                <?php $name = 'seo_description' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <textarea rows="10" class="form-control input-sm quotes" id="<?= $form->id ?>_<?= $name ?>"
                              name="<?= $form->id ?>[<?= $name ?>]"><?= $model->$name ?></textarea>
                </div>

                <?php $name = 'is_seo_noindexing' ?>
                <div class="formField mb10" data-type="text">
                    <div class="checkbox-custom mb5">
                        <input
                            type="checkbox" <?= $model->$name ? 'checked' : '' ?>
                            id="<?= $form->id ?>_<?= $name ?>"
                            name="<?= $form->id ?>[<?= $name ?>]"> <label
                            for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    </div>
                </div>

                <?php $name = 'dt_created' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>" disabled
                           name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                </div>

                <?php $name = 'dt_updated' ?>
                <div class="formField mb10" data-type="text">
                    <label class="" for="<?= $form->id ?>_<?= $name ?>"><?= $model->getAttributeLabel($name) ?></label>
                    <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>" disabled
                           name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                </div>

            </div>
        </div>
    </div>

    <div class="panel-body Form admin-form">
        <button id="submit" class="btn btn-success btn-sm">Сохранить</button>
    </div>
</div>

<div id="alert" class="alert alert-warning alert-dismissable" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="fa fa-warning pr10"></i>

    <div id="errors"></div>
</div>

<?php $this->endWidget(); ?>

<?php $name = 'images_illustrations' ?>
<div id="templateIllustration" style="display: none;">
    <div class="previewx">
        <input class="image_id" type="hidden" name="<?= $form->id ?>[<?= $name ?>][]" value="">

        <div class="panel panel-tile text-center">
            <div class="panel-body">
                <div style="position: relative; height: 100px;" class="mb15">
                    <img src="" class="upload_image" style="max-width: 100%; max-height: 100px;">
                </div>
                <span class="upload_name" style="font-weight: bold;">fileName</span><br> <span class="upload_size">fileSize</span>
                bytes<br> (<span
                    class="upload_dimension_width">fileDimensionWidth</span>x<span class="upload_dimension_height">fileDimensionHeight</span>)
            </div>
            <div class="panel-footer bg-light dark br-t br-light p12">
                <span class="fs11"> <span class="btn btn-xs btn-info editImage"><i class="fa fa-edit"> </i></span> <span
                        class="btn btn-xs btn-info"><i class="fa fa-search-plus"> </i></span> <span
                        class="btn btn-xs btn-danger delete"><i class="fa fa-trash-o"></i></span> </span>
            </div>
        </div>
    </div>
</div>

<div id="popup" class="mfp-hide">
    <div class="mytree">
        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
        <div class="row mb10">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                Найти
            </div>
        </div>

        <div class="row mb10">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <input type="text" id="search" class="form-control input-sm">
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <span class="btn btn-sm btn-info addCompany">Добавить</span>
            </div>

            <div class="row mb10">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="wraptree mt10">
                        <div id="viewtree"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="btn btn-success btn-sm pull-right selectCompany">OK</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    var image_teaser_big = '<?= $model->image_teaser_big ?>';
    var image_teaser_small = '<?= $model->image_teaser_small ?>';
    var image_teaser_top = '<?= $model->image_teaser_top ?>';
    var images_illustrations = <?= CJSON::encode($model->images_illustrations) ?>;
    console.log('[images_illustrations]', images_illustrations);
    var company = {};
    var quest = <?= isset($model->_quest->id) ? $model->_quest->id : "''" ?>;

    //вывод ошибок
    function printrErrors(errors) {
        $('#alert').show();
        //console.log('[ERRORS]', errors);
        var $ul = $('<ul>');
        var $li = $('<li>');
        for (var index in errors) {
            $('<li>').append(index + '...');
            var $ul2 = $('<ul>');
            for (var index2 in errors[index]) {
                $ul2.append($('<li>').text(errors[index][index2]));
            }
            $li.append($ul2.clone());
            $ul.append($li);
        }
        $('#errors').empty().append($ul);
    }

    function translit(src, dest) {
        var name = $(src).val();
        //console.log('[name]', name);
        var res = liTranslit(name);
        //console.log('[res]', res);
        $(dest).val(res);
    }

    function galleryCallback(response, params) {
        if (response == '') {
            return;
        }
        //console.log('[response] >', response);
        getImages(response, params);
    }

    function setIllustrations(images, params) {
        //console.log('images ??????', images);
        images.forEach(function (item, index) {
            var $template = $('#templateIllustration .previewx').clone();
            $template.find('.image_id').val(item.id);
            $template.find('img').attr('src', '/store' + item.fs_alias);
            $template.find('.upload_name').text(item.fs_filename);
            $template.find('.upload_size').text(item.fs_filesize);

            var dimension = JSON.parse(item.data);
            $template.find('.upload_dimension_width').text(dimension.width);
            $template.find('.upload_dimension_height').text(dimension.height);
            $('#category' + params.category).append($template);
        });
    }

    function setImages(response, params) {
        //console.log('response', response);
        //console.log('response.images', response.images);
        if (params.category == 1) {
            setIllustrations(response.images, params);
        }
        if (params.category == 2 || params.category == 3 || params.category == 4) {
            $('#category' + params.category + ' .image_thumb').attr('src', '/store' + response.images[0].fs_alias);
            $('#category' + params.category + ' input').val(response.images[0].id);
        }
    }

    function setTeaser(response, params) {
        //console.log('response >>>', response);
        //console.log('params >>>', params);
        getImages(response, params);

        //console.log('Callback is working!!!');
    }

    //запрашивает данные о картинках по их id в cms_media_storage
    function getImages(ids, params) {
        console.log('[IDS]', ids);
        if (typeof ids != 'object') {
            ids = [ids];
        }
        $.ajax({
            url: '<?= $this->createUrl('/quest/gallery/getImage') ?>',
            type: 'POST',
            dataType: 'json',
            data: {'ids': ids}
        }).success(function (response) {
            console.log('[response]', response);
            if (response.errors == false) {
                //ошибок нет
                //console.log('response', response);
                //console.log('params', params);
                setImages(response, params);
                //location.reload();
                //window.location = '<?= $this->createUrl('list') ?>';
            } else {
                //ошибки есть
                $('#errors').empty().append(printrErrors(response.error));
                $('#submit').prop('disabled', false);
            }
        }).error(function (data, key, value) {
            return false;
            //after_send(data);
        });
    }

    $(document).ready(function () {
        //инициализация select2
        $(".quest_create_category, .quest_create_category-multiple").select2();

        $('.teaser_big_clear').on('click', function (e) {
            e.preventDefault();
            $('#<?= $form->id ?>_image_teaser_big').val('');
            $('.big_teaser .image_thumb').prop('src', 'holder.js/590x580');
        });
        $('.teaser_small_clear').on('click', function (e) {
            e.preventDefault();
            $('#<?= $form->id ?>_image_teaser_small').val('');
            $('.small_teaser .image_thumb').prop('src', 'holder.js/285x350');
        });
        $('.teaser_top_clear').on('click', function (e) {
            e.preventDefault();
            $('#<?= $form->id ?>_image_teaser_top').val('');
            $('.top_teaser .image_thumb').prop('src', 'holder.js/2000x670');
        });

        //добавить существующие картинки на экран
        galleryCallback(
            image_teaser_big,
            {
                'quest': quest,
                'category': 2
            }
        );
        galleryCallback(
            image_teaser_small,
            {
                'quest': quest,
                'category': 3
            }
        );
        galleryCallback(
            image_teaser_top,
            {
                'quest': quest,
                'category': 4
            }
        );
        console.log('images_illustrations', images_illustrations);
        galleryCallback(
            images_illustrations,
            {
                'quest': quest,
                'category': 1,
                'multiple': true
            }
        );


        $('#category1').on('click', '.delete', function (e) {
            $(this).closest('div.previewx').remove();
        });

        if ($.isFunction($.fn.summernote)) {
            $('.summernote').summernote({
                height: 700, //set editable area-s height
                focus: false, //set focus editable area after Initialize summernote
                oninit: function () {
                },
                onChange: function (contents, $editable) {
                    $('textarea.summernote').html(contents);
                }
            });
        }

        //отправка данных на сохранение
        $('#submit').on('click', function (e) {
            e.preventDefault();
            $('#alert').hide();
            $('#submit').prop('disabled', true);

            $.ajax({
                url: '<?= $this->createUrl($this->action->id, array('id' => $model->id)) ?>',
                type: 'POST',
                dataType: 'json',
                data: $('#<?= $form->id ?>').serialize()
            }).success(function (response) {
                //console.log('[response]', response);
                $('#submit').prop('disabled', false);
                if (response.errors == false) {
                    //ошибок нет
                    //location.reload();
                    window.location = '<?= $this->createUrl('list') ?>';
                } else {
                    //ошибки есть
                    $('#errors').empty().append(printrErrors(response.error));
                    $('#submit').prop('disabled', false);
                }
            }).error(function (data, key, value) {
                $('#submit').prop('disabled', false);
                return false;
                //after_send(data);
            });

        });

        $('form').on('click', '#toTranslit', function (e) {
            e.preventDefault();
            translit('#<?= $form->id ?>_product_name', '#<?= $form->id ?>_url_alias');
        });


        //нажали на точки - открыть дерево
        $('.key_dots').on('click', function (e) {
            //alert('...');
            var attr = $(this).data('ref');
            //console.log('[attr]', attr);
            getCompanies();
            e.preventDefault();
            $.magnificPopup.open({
                items: {
                    src: '#popup',
                    type: 'inline'
                }
            });
        });

        //отправить компанию на добавление в список
        $('.addCompany').on('click', function (e) {
            e.preventDefault();
            var data = {};
            data.company_name = $('#search').val();
            data.company_alias = liTranslit(data.company_name);

            //alert(data);

            $.ajax({
                url: '<?= CHtml::normalizeUrl(array('/area/companies/addCompany')) ?>',
                type: 'POST',
                dataType: 'json',
                data: data
            }).success(function (response) {
                //console.log('[response]', response);
                if (response.success) {
                    //добавить компанию в скрытое и текстовое поля
                    company = response.company;
                    selectCompany();
                    $('.mfp-close').trigger('click');
                }
                companies = response.companies;
                var tree = $("#viewtree").fancytree("getTree");
                tree.reload(companies);
            }).error(function (data, key, value) {
                alert('Что-то пошло не так...');
                return false;
                //after_send(data);
            });
        });


    });

    var companies = [];

    function getCompanies() {
        $.ajax({
            url: '<?= CHtml::normalizeUrl(array('/quest/quest/getCompanies')) ?>',
            type: 'POST',
            dataType: 'json',
            data: {}
        }).success(function (response) {
            //console.log('[response]', response);
            companies = response.companies;
            var tree = $("#viewtree").fancytree("getTree");
            tree.reload(companies);
        }).error(function (data, key, value) {
            alert('Что-то пошло не так...');
            return false;
            //after_send(data);
        });
    }
</script>

<script type="text/javascript">

    function selectCompany() {
        $('#<?= $form->id ?>_app_companies_ref_text').text(company.company_name);
        $('#<?= $form->id ?>_app_companies_ref').val(company.id);
    }

    jQuery(document).ready(function () {

        "use strict";

        // Init Theme Core
        //Core.init();

        // Init Demo JS
        //Demo.init();

        // Init FancyTree - w/Drag and Drop Functionality
        $("#viewtree").fancytree({
            extensions: ["filter", "edit", "childcounter"],
            filter: {
                autoApply: true, // Re-apply last filter if lazy data is loaded
                counter: true, // Show a badge with number of matching child nodes near parent icons
                hideExpandedCounter: true, // Hide counter badge, when parent is expanded
                mode: "hide"  // "dimm": Grayout unmatched nodes, "hide": remove unmatched nodes
            },
            // titlesTabbable: true,
            source: [{title: '-', key: 0}],
            childcounter: {
                deep: true,
                hideZeros: true,
                hideExpanded: true
            },
            click: function (event, data) {
                //console.log(data);
                company.company_name = data.node.title;
                company.id = data.node.key;
            },
            dblclick: function (event, data) {
                //console.log('DBLClick', data);
                if (data.node.folder == true) {
                    return;
                }
                //добавить компанию в форму квеста
                company.company_name = data.node.title;
                company.id = data.node.key;
                selectCompany(company);

                //закрыть дерево
                $('.mfp-close').trigger('click');
            },
            activate: function (event, data) {
                //console.log('activate', data);
            }
            /*,
             lazyLoad: function (event, data) {
             data.result = {
             url: "/json/ajax-sub2.json"
             }
             }*/
        });

        $('.selectCompany').on('click', function () {
            selectCompany(company);
            //закрыть дерево
            $('.mfp-close').trigger('click');
        });

        $("#search").on('keyup', function () {
            var value = $(this).val();
            $("#viewtree").fancytree("getTree").filterNodes(value, {autoExpand: true, leavesOnly: false});
        });

    });
</script>
