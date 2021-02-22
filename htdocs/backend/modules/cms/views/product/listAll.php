<?php
$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;

$cs->registerCssFile($themePath . '/assets/admin-tools/admin-forms/css/admin-forms.css');
$cs->registerCssFile($themePath . '/vendor/plugins/magnific/magnific-popup.css');
$cs->registerScriptFile($themePath . '/vendor/plugins/magnific/jquery.magnific-popup.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/jquerymask/jquery.maskedinput.min.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/jquery/jquery_ui/jquery-ui.min.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/liTranslit/js/jquery.liTranslit.js', CClientScript::POS_END);
$cs->registerCssFile($themePath . '/vendor/plugins/fancytree/skin-win8/ui.fancytree.min.css');
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/jquery.fancytree-all.min.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.childcounter.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.columnview.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.dnd.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.edit.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.filter.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);

?>

<div class="row">
    <div class="col-md-3">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Управление</span>
            </div>

            <div class="panel-menu">
                <div class="chart-legend mb10">
                    <a class="legend-item btn btn-block btn-info ph30 mr20"
                       href="<?= $this->createUrl('create'); ?>">Создать квест</a>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Выбор города</span>
            </div>

            <div class="panel-menu">
                <div class="chart-legend mb10">
                    <form action="<?= $this->createUrl('listAll'); ?>" method="post" id="region">
                        <select id="select_region" name="select_region" class="form-control">
                            <option value="">- Выберите город -</option>
                            <?php $oRegions = AppRegions::model()->findAll(array('order' => 'region_name ASC')); ?>
                            <?php foreach ($oRegions as $oRegion) { ?>
                                <option value="<?= $oRegion->id ?>"><?= $oRegion->region_name ?></option>
                            <?php } ?>
                        </select>
                    </form>
                    <script>
                        $('#select_region').on('change', function(e){
                            $('#region').submit();
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="modal fade testButton">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Название модали</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <script type="application/javascript">
            $(document).ready(function () {
                $('.ajax-popup-link').magnificPopup({
                    type: 'ajax',
                    modal: true
                });
            });
        </script>
    </div>

    <div class="col-md-9">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Все квесты</span>
            </div>
            <div class="panel-menu">
                <div class="chart-legend">
                    <table class="table">
                        <thead>
                        <tr class="primary">
                            <td>Вес</td>
                            <td>Название квеста / ID</td>
                            <td>Город</td>
                            <td>Партнер / Бренд</td>
							<td>Версия</td>
                            <td>Закрыт</td>
                            <td>Опубликован</td>
                            <td>Запрет<br/> индексации</td>
                            <td style="width: 67px;">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($oQuests as $oQuest) { ?>
                            <tr>
                                <td><?= $oQuest->ecmProduct->wrs_position_weight ?></td>
                                <td><a href="<?= $this->createUrl('edit', array('id' => $oQuest->id, 'factory_id' => $oQuest->ediBootstrap->factory->factory_id)) ?>" title="ID=<?= $oQuest->id ?>"><?= $oQuest->ecmProduct->product_name ?></a></td>
                                <td><?= $oQuest->hasRegion->region->region_name ?></td>

                                <td>
                                    <a href="<?= $this->createUrl('/quest/quest/list', array('factory_id' => $oQuest->ediBootstrap->factory->factory_id)) ?>"><?= $oQuest->ediBootstrap->factory->factory_name ?></a><br><?= empty($oQuest->company) ? '-' : $oQuest->company->company_name ?>
                                </td>
								<td><?= $oQuest->ecmProduct->version->version_name ?></td>
								<td>
                                    <div class="checkbox-custom fill checkbox-disabled mb10">
                                        <input type="checkbox" <?= $oQuest->ecmProduct->is_closed ? 'checked' : '' ?>
                                               disabled="" id="checkboxDefault11"> <label
                                            for="checkboxDefault11"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox-custom fill checkbox-disabled mb10">
                                        <input
                                            type="checkbox" <?= $oQuest->tree->is_node_published ? 'checked' : '' ?>
                                            disabled="" id="checkboxDefault11"> <label
                                            for="checkboxDefault11"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox-custom fill checkbox-disabled mb10">
                                        <input
                                            type="checkbox" <?= $oQuest->tree->is_seo_noindexing ? 'checked' : '' ?>
                                            disabled="" id="checkboxDefault11"> <label
                                            for="checkboxDefault11"></label>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group text-right">

                                        <a class="btn btn-success btn-xs fs12" title=""
                                           href="<?= $this->createUrl('edit', array('id' => $oQuest->id, 'factory_id' => $oQuest->ediBootstrap->factory->factory_id)) ?>">
                                            <i class="fa fa-edit"></i> </a>
                                        <button type="button" class="btn btn-success br2 btn-xs fs12 dropdown-toggle"
                                                data-toggle="dropdown" aria-expanded="false"><span
                                                class="caret"></span>
                                        </button>

                                        <ul class="dropdown-menu dropdownMenuRight0" role="menu">
                                            <li>
                                                <a href="<?= $this->createUrl('edit', array('id' => $oQuest->id, 'factory_id' => $oQuest->ediBootstrap->factory->factory_id)) ?>">Изменить</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="#">Archive</a>
                                            </li>
                                            <li>
                                                <a href="#">Complete</a>
                                            </li>
                                            <li>
                                                <a href="#">Pending</a>
                                            </li>
                                            <li>
                                                <a href="#">Canceled</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function () {
        "use strict";
        // Init Theme Core
        //Core.init();
        // Init Demo JS
        //Demo.init();
    });
</script>


