<?php
/*/
$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;

$cs->registerCssFile($themePath . '/assets/admin-tools/admin-forms/css/admin-forms.css');
$cs->registerCssFile($themePath . '/vendor/plugins/magnific/magnific-popup.css');
$cs->registerScriptFile($themePath . '/vendor/plugins/magnific/jquery.magnific-popup.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/jquerymask/jquery.maskedinput.min.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/jquery/jquery_ui/jquery-ui.min.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/liTranslit/js/jquery.liTranslit.js', CClientScript::POS_END);
//*/

?>

<div class="row">
    <div class="col-md-3">

        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Управление</span>
            </div>

            <div class="panel-menu">
                <div class="chart-legend">
                    <a class="ajax-popup-link legend-item btn btn-block btn-info ph30 mr20"
                       href="<?= \yii\helpers\Url::to(['createNode']); ?>">Создать корень</a>
                </div>
            </div>
        </div>
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
                <span class="panel-title">Корни</span>
            </div>
            <div class="panel-menu">
                <div class="chart-legend">
                    <table class="table">
                        <thead>
                        <tr class="dark">
                            <td>#</td>
                            <td>Node name</td>
                            <td>Menu title</td>
                            <td>Is visible?</td>
                            <td>Is published?</td>
                            <td>Actions</td>
                        </tr>
                        </thead>
                        <?php foreach ($roots as $root) { ?>
                            <tr>
                                <td><?= $root->id ?></td>
                                <td><?= $root->node_name ?></td>
                                <td><?= $root->menu_title ?></td>
                                <td>
                                    <div class="checkbox-custom fill checkbox-disabled mb10">
                                        <input type="checkbox" <?= $root->is_menu_visible ? 'checked' : '' ?>
                                               disabled="" id="checkboxDefault11"> <label
                                                for="checkboxDefault11"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox-custom fill checkbox-disabled mb10">
                                        <input type="checkbox" <?= $root->is_node_published ? 'checked' : '' ?>
                                               disabled="" id="checkboxDefault11"> <label
                                                for="checkboxDefault11"></label>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group text-right">
                                        <a class="btn btn-success btn-xs fs12 ajax-popup-link" title=""
                                           href="<?php echo \yii\helpers\Url::to(['editNode', 'id' => $root->id]); ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-success btn-xs fs12 dropdown-toggle"
                                                data-toggle="dropdown" aria-expanded="false"><span
                                                    class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdownMenuRight0" role="menu">
                                            <li><!--  class="active" -->
                                                <?php if ($root->url_alias == 'news') { ?>
                                                    <a class=""
                                                       href="<?= \yii\helpers\Url::to(['news']) ?>">Управлять</a>
                                                <?php } else { ?>
                                                    <a class=""
                                                       href="<?= \yii\helpers\Url::to(['watch', 'id' => $root->id]) ?>">Управлять</a>
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <a class="ajax-popup-link"
                                                   href="<?= \yii\helpers\Url::to(['editNode', 'id' => $root->id]) ?>">Изменить</a>
                                            </li>
                                            <li>
                                                <a href="<?= \yii\helpers\Url::to(['deleteNode', 'id' => $root->id]) ?>">Удалить</a>
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
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
