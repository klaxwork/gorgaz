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
    <div class="col-md-3 col-lg-2">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Фильтр товаров</span>
            </div>

            <div class="panel-menu">
                <div class="chart-legend mb10">
                    <?php $form = $this->beginWidget(
                        'CActiveForm', array(
                            'id' => $formName,
                            //'action' => $this->createUrl('listAll'),
                            'enableAjaxValidation' => false,
                        )
                    );
                    ?>
                    <!--div class="row mt10">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php $name = 'app_regions_ref' ?>
                            <div class="formField mb10" data-type="text">
                                <label for="select_region">Город</label> <select
                                    id="select_region" name="<?= $form->id ?>[<?= $name ?>]"
                                    class="select2 form-control input-sm" style="width: 100%;">
                                    <option value="">- Выберите город -</option>
                                    <?php $oRegions = AppRegions::model()->cache(7200, \CmsTree\Cache\Dependency::instance())->findAll(array('order' => 'region_name ASC')); ?>
                                    <?php foreach ($oRegions as $oRegion) { ?>
                                        <option value="<?= $oRegion->id ?>"><?= $oRegion->region_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div-->

                    <div class="row mt10">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php $name = 'product_name' ?>
                            <div class="formField mb10" data-type="text">
                                <label class="" for="<?= $form->id ?>_<?= $name ?>">Название</label> <input
                                        type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                        name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row mt10">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php $name = 'category' ?>
                            <div class="formField mb10" data-type="text">
                                <label for="select_quest">Категория</label> <select
                                        id="select_quest" name="<?= $form->id ?>[<?= $name ?>]"
                                        class="select2 form-control input-sm"
                                        style="width: 100%;">
                                    <option value="">- Выберите категорию -</option>
                                    <?php
                                    $criteria = new CDbCriteria();
                                    $criteria->addCondition('"ns_root_ref" = :root AND "is_trash" IS FALSE');
                                    $criteria->params[':root'] = 200;
                                    $criteria->order = "node_name";
                                    $categories = CmsTree::model()->cache(7200, \CmsTree\Cache\Dependency::instance())->findAll($criteria); ?>
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?= $category->id ?>"><?= $category->node_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!--div class="row mt10">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <?php $name = 'product_price_from' ?>
                            <div class="formField mb10" data-type="text">
                                <label class="" for="<?= $form->id ?>_<?= $name ?>">Цена, от</label> <input
                                    type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                    name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <?php $name = 'product_price_to' ?>
                            <div class="formField mb10" data-type="text">
                                <label class="" for="<?= $form->id ?>_<?= $name ?>">Цена, до</label> <input
                                    type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                                    name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="">
                            </div>
                        </div>
                    </div-->

                    <?php $this->endWidget(); ?>
                </div>
            </div>

            <div class="panel-footer">
                <span class="btn btn-sm btn-system" id="FilterQuests">Выбрать</span>
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

    </div>

    <div class="col-md-9 col-lg-10">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Все товары</span>
            </div>
            <div class="panel-menu">
                <div class="chart-legend">
                    <div class="notFound" style="display: none;">
                        По вашему запросу ничего не найдено
                    </div>
                    <div class="preloader" style="display: none;">
                        <img src="/images/preloader.gif">
                    </div>
                    <table class="table">
                        <thead>
                        <tr class="primary">
                            <td width="50">ID</td>
                            <!--#ID 	Название товара 	is_closed 	is_trash 	Категория-->
                            <td>Название товара</td>
                            <td>Артикул</td>
                            <td>Фотографии</td>
                            <td>Категория</td>
                            <td>Closed?</td>
                            <td>Цена</td>
                            <td style="width: 67px;">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody class="quests">
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

        $('.select2, .select2-multiple').select2();

        $('body')
            .on('click', '#FilterQuests', function (e) {
                //показать отфильтрованные товары
                if (e !== undefined) e.preventDefault();
                $('.quests').empty();
                $('.table').hide();
                $('.preloader').show();
                $.ajax({
                    url: '<?= $this->createUrl($this->action->id) ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#<?= $form->id ?>').serialize(),
                    success: function (response) {
                        console.log('[response]', response);
                        if (response.success == true) {
                            //ошибок нет
                            $('.preloader').hide();
                            //console.log('response', response);
                            if (response.count > 0) {
                                $('.notFound').hide();
                                $('.table').show();
                                $('.quests').append(response.quests);
                            } else {
                                $('.notFound').show();
                            }

                            //console.log('params', params);
                            //location.reload();
                            //window.location = '<?= $this->createUrl('list') ?>';
                        } else {
                            //ошибки есть

                        }
                    },
                    error: function (data, key, value) {
                        return false;
                        //after_send(data);
                    }
                });
            })
            .on('submit', '#<?= $formName ?>', function (e) {
                //показать отфильтрованные товары
                if (e !== undefined) e.preventDefault();
                $('#FilterQuests').trigger('click');
            })
            .on('change', '#select_region', function (e) {
                //$('#region').submit();
            })
            .on('click', '.is_', function (e) {
                //скрыть все поля ввода, показать кнопки
                $('.input').hide();
                $('.buttons').show();

                var $this = $(this);
                var $tr = $this.closest('tr');
                var id = $tr.data('id');
                var label = $(this).data('label');
                var product_new_price = 0;
                console.log('id, label', id, label);
                if (label == 'is_sale') {
                    console.log('STOP! Return false;');
                    return;
                    //если выбрали is_sale
                    //проверить, что есть в input
                    console.log('label => is_sale');
                    product_new_price = $tr.find('input').val();
                    console.log('product_new_price', product_new_price);
                    if (product_new_price > 0) {
                        //если в input что-то есть
                        //то обнулить цену
                        $tr.find('input').val(0);
                        setLabels(id, label, 0);
                    } else {
                        //скрыть кнопки, показать поле input
                        console.log('//скрыть кнопки, показать поле input');
                        $tr.find('.buttons').hide();
                        $tr.find('.input').show().find('input').focus();
                    }
                } else {
                    setLabels(id, label, product_new_price);
                }

            })
            .on('keyup change', 'input', function (e) {
                //отслеживаем нажатие клавиш в поле ввода
                if (e.keyCode == 13) {
                    //если нажали Enter, то true
                    console.log("Ура нажали Enter");
                    var $tr = $(this).closest('tr');
                    var id = $tr.data('id');
                    var label = 'is_sale';
                    var product_new_price = $(this).val();
                    console.log('Enter product_new_price:', product_new_price);
                    if (product_new_price || product_new_price > 0) {
                        setLabels(id, label, product_new_price);
                    } else {
                        $tr.find('.buttons').show();
                        $tr.find('.input').hide();
                    }
                }
            })
        ;
        function setLabels(id, label, product_new_price) {
            $.ajax({
                url: '<?= $this->createUrl('/cms/product/toggleLabel') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    label: label,
                    product_new_price: product_new_price
                },
                success: function (response) {
                    console.log('[response]', response);
                    if (response.success) {
                        var $tr = $('body').find('tr[data-id="' + id + '"]');

                        //скрыть iunput, показать кнопки
                        $tr.find('.input').hide();
                        $tr.find('.buttons').show();

                        //проставить в input новую цену
                        $tr.find('input').val(response.product_new_price);

                        //обновить цену в ячейке таблицы
                        var $price = $tr.find('.price');
                        $price.text(response.product_price);

                        if (response.label_id > 0) {
                            //показать label
                            $tr.find('.' + label).show();
                        } else {
                            //спрятать label
                            $tr.find('.' + label).hide();
                        }

                        //есть ли новая цена
                        if (response.product_new_price > 0) {
                            //добавить новую цену в .price
                            $price.append($('<br>'));
                            $price.append($('<span>').addClass('label label-warning').text(response.product_new_price));
                        }
                    }
                }
                ,
                error: function (data, key, value) {
                    return false;
                }
            });
        }

    });
</script>

