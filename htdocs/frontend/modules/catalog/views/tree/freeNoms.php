<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                DEBUG
            </div>
            <div class="panel-body" id="debug">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="panel-title">Товары, загруженные с Hynt.ru</h5>
                    </div>
                    <div class="col-md-6">
                        <a class="pull-right" style="position: relative; top: 3px;" href="javascript: void(0);"
                           data-toggle="modal" data-target="#modal_small">
                            <i class="icon-question3 position-left"></i> Помощь</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control SearchString" data-key="client"
                                               id="SearchString" placeholder="Введите фрагмент текста для поиска...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default ClearSearchString"><i
                                                        class="icon-cross2"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 showAllBlock">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="showAll" value="1"
                                                       style="width: 15px; height: 15px;" class="ShowAll">
                                                Показать все
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="table-responsive table-xxs" style="height: 650px; overflow: scroll;">
                                <table class="table micro marking noms" id="NomenclaturesList">
                                    <thead>
                                    <tr>
                                        <th>Артикул</th>
                                        <th>Номенклатура</th>
                                        <th>Ед. изм.</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="preloader text-center" style="display: none;"><img
                                            src="/images/preloader.gif">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
        <span class="btn btn-warning btn-xs disabled" id="MoveNoms"
              style="width: 100%; font-size: 4em;">&gt;&gt;</span>
    </div>
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Каталог товаров</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="reload"></a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="chart-legend" style="max-height: 690px; overflow-y: scroll;">
                    <div id="viewtree" class=""></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal_small" class="modal fade" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h5 class="modal-title">Помощь</h5>
            </div>

            <div class="modal-body">
                <h6 class="text-semibold"></h6>
                <p>По умолчанию показаны товары, не распределенные по категориям.</p>
                <p><b>"Показать все"</b> -- показать ВСЕ товары (распределенные и нераспределенные).</p>
                <hr>

                <p><b>ЛКМ</b> &mdash; Левая кнопка мыши &mdash; выделяет товар/каталог</p>
                <p><b>ПКМ</b> &mdash; Правая кнопка мыши &mdash; отерывает контекстное меню</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<script type="text/template" id="NomTmpl">
    <tr class="" data-id="${id}" data-ecm_products_ref="${ecm_products_ref}" data-alias="${url_alias}">
        <td>${vendor.field_value}</td>
        <td>${product_name}</td>
        <td>${unit.field_value}</td>
    </tr>
</script>

<script>
    var categoryId = 0;
    var nomenclatureId = 0, nomenclatureIds = [];
    var ClipBoard = {type: false, srcCategoryId: 0, dstCategoryId: null, ids: [], copyIds: [], cutIds: []}; //type="noms"
    var Current = {type: false, id: false}; // type="noms", id = false
    var CurDir = 0;
    var isCtrl = false;
    var offerId = 0, offerIds = [];
    var mode = 'view'; //[view || move]
    var isShowAll = null;
    var SearchString = '';
    var oldSearchString = '';
    var tm;
    var _COPY = 1, _PASTE = 2, _CUT = 3, _REMOVE = 4;

    $(document).ready(function () {

        $('body')
            .on('keydown', function (e) {
                //console.log('body>keyup');
                if (e.which == 17) {
                    console.log('Crtl was true');
                    isCtrl = true;
                }
                doEvent(e);
            })
            .on('keyup', function (e) {
                if (e.which == 17) {
                    console.log('Crtl was false');
                    isCtrl = false;
                }
            })
            .on('change keyup', '.SearchString', function () {
                console.log('изменили строку поиска');
                //если новая строка отличается от старой, то заменить старую на новую и отправить данные на выборку
                SearchString = $('.SearchString').val();
                console.log('SearchString', SearchString);
                clearInterval(tm);
                tm = setInterval(function () {
                    if (SearchString !== oldSearchString) {
                        oldSearchString = SearchString;
                        loadNomenclatures();
                    }
                }, 700);
            })
            .on('change keyup', '.ShowAll', function () {
                console.log('изменили галочку showAll');
                clearInterval(tm);
                oldSearchString = SearchString;
                loadNomenclatures();
            })
            .on('click', '.ClearSearchString', function (e) {
                e.preventDefault();
                $('.SearchString').val('');
                $('.SearchString').trigger('change');
            })
        ;

        //смотрим, какие кнопки нажаты
        function doEvent(event, panel) {
            console.log('doEvent(event, panel)');

            if (isCtrl) {
                switch (event.which) {
                    // Handle Ctrl-C, -X and -V
                    case 67:
                        // Ctrl-C
                        console.log('CASE 67!!!');
                        copyPaste(_COPY);
                        break;
                    case 86:
                        // Ctrl-V
                        console.log('CASE 86!!!');
                        copyPaste(_PASTE);
                        break;
                    case 88:
                        // Ctrl-X
                        console.log('CASE 88!!!');
                        //copyPaste(_CUT);
                        break;
                }
            }
        }

        //меню для узлов дерева
        $.contextMenu({
            selector: '#viewtree .fancytree-node',
            events: {
                show: function (options) {
                    console.log('');
                    console.log('show');
                    console.log('CurDir', CurDir);
                    $(this).trigger('click');
                    console.log('CurDir', CurDir);
                },
                hide: function (options) {
                    console.log('');
                    console.log('hide');
                }
            },
            callback: function (key, options) {
                //$(this).find('tbody').find('tr').removeClass('currentTr');
                //var m = "clicked: " + key;
                //window.console && console.log(m) || alert(m);
                console.log('callback!');
            },
            items: {
                "Paste": {
                    name: "(Ctrl+V) Вставить",
                    disabled: function (key, opt) {
                        if (ClipBoard.copyIds.length > 0 || ClipBoard.cutIds.length > 0)
                            return false;
                        else
                            return true;
                    },
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        //вызвать скрипт перемещения номенклатуры в категорию
                        console.log('[ClipBoard]', ClipBoard);
                        console.log('[Current]', Current);
                        copyPaste(_PASTE);
                        //if (ClipBoard.copyIds.length > 0) copyNoms();
                        //else if (ClipBoard.cutIds.length > 0) moveNoms();
                    }
                },
                "CreateNode": {
                    name: "Создать категорию",
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        console.log('');
                        console.log('CreateNode');
                        var loadurl = '<?= \yii\helpers\Url::to(['/cms/tree/create-node', 'parent' => '__ID__', 'is_tab' => 1]) ?>'
                            .replace('__ID__', CurDir);
                        console.log('loadurl', loadurl);
                        //$('#debug').append(loadurl);
                        //modal-dialog modal-sm

                        $('#modal .modal-dialog').removeClass('modal-lg').addClass('modal-sm');

                        $("#modal .modal-content").load(loadurl);
                        $('#modal').modal('show');
                        //$('#modal').show();

                        /*/
                        window.open(
                            '< ?= \yii\helpers\Url::to(['/cms/tree/editNode', 'id' => '__id__', 'is_tab' => 1]); ?>'
                                .replace('__id__', CurDir),
                            '_blank'
                        );
                        window.focus();
                        //*/
                    }
                },
                "EditNomenclature": {
                    name: "Редактировать",
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        window.open(
                            '<?= \yii\helpers\Url::to('/cms/tree/editNode', array('id' => '__id__')); ?>'
                                .replace('__id__', CurDir) + '?is_tab=1',
                            '_blank'
                        );
                        window.focus();
                    }
                }
            }
        });

        //меню для номенклатур
        $.contextMenu({
            selector: '#NomenclaturesList tbody tr',
            events: {
                show: function (options) {
                    console.log('[#NomenclaturesList tbody tr contextMenu show]');
                    var id = $(this).data('id');
                    Current = {
                        type: 'noms',
                        id: id
                    };
                    console.log('[CURRENT]', Current);
                },
                hide: function (options) {
                    console.log('[#NomenclaturesList tbody tr contextMenu hide]');
                    //$(this).removeClass('currentTr');
                }
            },
            callback: function (key, options) {
                //$(this).find('tbody').find('tr').removeClass('currentTr');
                //var m = "clicked: " + key;
                //window.console && console.log(m) || alert(m);
                console.log('callback!');
            },
            items: {
                "copy": {
                    name: "(Ctrl+C) Копировать",
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        var id = $(this).closest('tr').data('id');
                        $('body').find('tr').removeClass('currentTr');
                        $(this).addClass('currentTr');
                        Current = {
                            type: 'noms',
                            id: id
                        };
                        copyPaste(_COPY);
                        console.log('[CURRENT]', Current);
                    }
                },
                /*
                 "cut": {
                 name: "(Ctrl+X) Вырезать",
                 callback: function (itemKey, opt, rootMenu, originalEvent) {
                 var id = $(this).closest('tr').data('id');
                 $('body').find('tr').removeClass('currentTr');
                 $(this).addClass('currentTr');
                 Current = {
                 type: 'noms',
                 id: id
                 };
                 copyPaste(_COPY);
                 console.log('[CURRENT]', Current);
                 }
                 },
                 */
                /*
                 "paste": {
                 name: "Вставить",
                 callback: function (itemKey, opt, rootMenu, originalEvent) {
                 copyPaste(_PASTE);
                 }
                 },
                 */
                "remove": {
                    name: "Убрать",
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        var id = $(this).closest('tr').data('id');
                        $('body').find('tr').removeClass('currentTr');
                        $(this).addClass('currentTr');
                        //запомнить текущее
                        Current = {
                            type: 'noms',
                            id: id
                        };
                        //дать команду на действие
                        copyPaste(_REMOVE);
                        console.log('[CURRENT]', Current);
                    }
                },
                /*/
                 "openInNewFront": {
                 name: "Просмотр на фронте",
                 callback: function (itemKey, opt, rootMenu, originalEvent) {
                 console.log('[openInNewFront THIS]', this);
                 var alias = $(this).data('alias');
                 var url = 'http://hynt.ru/product/' + alias
                 window.open(url);
                 }
                 },
                 //*/
                "EditNomenclature": {
                    name: "Редактировать",
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        window.open(
                            '<?= \yii\helpers\Url::to('/product/product/edit', array('id' => '__ID__')); ?>'
                                .replace('__ID__', $(this).data('ecm_products_ref')) + '?is_tab=1',
                            '_blank'
                        );
                        window.focus();
                    }
                },
                "selectAll": {
                    name: "Выделить все",
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        //снять выделение везде
                        $('tr.activeTr').removeClass('activeTr');
                        //добавить выделение всех
                        $(this).closest('tbody').find('tr').addClass('activeTr');
                        getAll();
                    }
                },
                "deselectAll": {
                    name: "Снять выделение со всех",
                    callback: function (itemKey, opt, rootMenu, originalEvent) {
                        $(this).closest('tbody').find('tr').removeClass('activeTr');
                        getAll();
                    }
                }
            }
        });

        function getNoms() {
            console.log('getNoms()');
            //пройти по номенклатурам
            nomenclatureIds = [];
            $('#NomenclaturesList tbody tr.activeTr').each(function (index, item) {
                var id = $(item).data('id');
                nomenclatureIds.push(Number(id));
            });
            console.log('nomenclatureIds', nomenclatureIds);
        }

        function getAll() {
            getNoms();
            //getCurrent();
        }

        function copyPaste(CP) {
            console.log('ClipBoard', ClipBoard);
            console.log('Current', Current);
            if (CP == _COPY) {
                console.log('_COPY');

                var $checked = $('#NomenclaturesList tbody tr.activeTr');
                nomenclatureIds = [];
                $checked.each(function (index, item) {
                    console.log(index, item);
                    nomenclatureIds.push(Number($(item).data('id')));
                });

                ClipBoard.srcCategoryId = 0; //Number(categoryId);
                if (nomenclatureIds.length > 0) {
                    ClipBoard.type = 'noms';
                    //ClipBoard.ids = nomenclatureIds;
                    ClipBoard.copyIds = nomenclatureIds;
                    ClipBoard.cutIds = [];
                } else {
                    ClipBoard.type = Current.type;
                    //ClipBoard.ids = [Current.id];
                    ClipBoard.copyIds = [Current.id];
                    ClipBoard.cutIds = [];
                }
                console.log('ClipBoard', ClipBoard)
            }
            if (CP == _CUT) {
                console.log('_CUT');

                var $checked = $('#NomenclaturesList tbody tr.activeTr');
                nomenclatureIds = [];
                $checked.each(function (index, item) {
                    console.log(index, item);
                    nomenclatureIds.push(Number($(item).data('id')));
                });

                ClipBoard.srcCategoryId = 0; //Number(categoryId);
                if (nomenclatureIds.length > 0) {
                    ClipBoard.type = 'noms';
                    //ClipBoard.ids = nomenclatureIds;
                    ClipBoard.copyIds = [];
                    ClipBoard.cutIds = nomenclatureIds;
                } else {
                    ClipBoard.type = Current.type;
                    //ClipBoard.ids = [Current.id];
                    ClipBoard.copyIds = [];
                    ClipBoard.cutIds = [Current.id];
                }
                console.log('ClipBoard', ClipBoard)
            }
            if (CP == _PASTE) {
                console.log('_PASTE');
                ClipBoard.dstCategoryId = Number(categoryId);
                if (ClipBoard.type == 'noms') {

                    //переместить номенклатуры в ноду
                    console.log('переместить номенклатуры в ноду');
                    console.log('[ClipBoard]', ClipBoard);
                    console.log('[Current]', Current);

                    if (ClipBoard.copyIds.length > 0) copyNoms();
                    //else if (ClipBoard.cutIds.length > 0) moveNoms();
                    /*
                     if (Current.type == 'node') {
                     console.log('Current', Current);
                     if (ClipBoard.cutIds.length > 0)
                     moveNoms();
                     else if (ClipBoard.copyIds.length > 0)
                     copyNoms();
                     }
                     */
                }
            }
            if (CP == _REMOVE) {
                console.log('_REMOVE');
                //Убрать связку номенклатуры и категории
                console.log('Убрать связку номенклатуры и категории');
                console.log('[ClipBoard]', ClipBoard);
                console.log('[Current]', Current);
                ClipBoard.type = 'noms';
                ClipBoard.srcCategoryId = 0; //Number(categoryId);
                if (nomenclatureIds.length > 0)
                    ClipBoard.ids = nomenclatureIds;
                else
                    ClipBoard.ids = [Current.id];
                //Дать команду на действие
                removeNoms();
                console.log('ClipBoard', ClipBoard);
            }
        }

        //КОПИРОВАНИЕ товаров
        function copyNoms() {
            //Копировать
            console.log('[copyNoms()]');
            var Error = false;
            if (Current.type != 'node') {
                alert('Не выбрана конечная номенклатура!');
                Error = true;
            }
            if (ClipBoard.type != 'noms') {
                alert('Не выбраны товары! (!noms)');
                Error = true;
            }
            if (ClipBoard.copyIds.length == 0) {
                alert('Не выбраны товары! (length = 0)');
                Error = true;
            }
            console.log('[COPY NOMS!!!]');
            if (!Error) {
                var dataForm = {
                    //nomenclatureIds: ClipBoard.ids,
                    nomenclatureIds: ClipBoard.copyIds,
                    categoryId: Current.id,
                    srcCategoryId: 0, //ClipBoard.srcCategoryId,
                    dstCategoryId: ClipBoard.dstCategoryId
                };
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '<?php echo \yii\helpers\Url::to('/cms/default/copyNoms'); ?>',
                    data: dataForm,
                    success: function (response) {
                        console.log('[RESPONSE]', response);
                        if (response.success) {
                            nomenclatureIds.forEach(function (item, index) {
                                $('#NomenclaturesList tbody tr[data-id="' + item + '"]').remove();
                            });
                            nomenclatureIds = [];
                            //clearNomenclatures();
                            //loadNomenclatures();
                            //ClipBoard.type = false;
                            //ClipBoard.ids = false;
                            //Current.type = false;
                            //Current.id = false;
                        } else {

                        }
                    },
                    error: function (xhr) {
                        alert('ERROR: ' + xhr.responseText);
                    }
                });
            }
        }

        //ПЕРЕНОС товаров
        function moveNoms() {
            var Error = false;
            if (Current.type != 'node') {
                alert('Не выбрана конечная номенклатура!');
                Error = true;
            }
            if (ClipBoard.type != 'noms') {
                alert('Не выбраны товары! (!noms)');
                Error = true;
            }
            if (ClipBoard.cutIds.length == 0) {
                alert('Не выбраны товары! (length = 0)');
                Error = true;
            }
            console.log('[MOVE NOMS!!!]');
            if (!Error) {
                var dataForm = {
                    nomenclatureIds: ClipBoard.cutIds,
                    categoryId: Current.id,
                    srcCategoryId: 0, //ClipBoard.srcCategoryId,
                    dstCategoryId: ClipBoard.dstCategoryId
                };
                var url = '<?php echo \yii\helpers\Url::to('/cms/default/moveNoms'); ?>';
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: dataForm,
                    success: function (response) {
                        console.log('[RESPONSE]', response);
                        if (response.success) {
                            nomenclatureIds.forEach(function (item, index) {
                                $('#NomenclaturesList tbody').html('');
                            });
                            clearNomenclatures();
                            loadNomenclatures();
                            //после переноса забыть то, что перенесли
                            ClipBoard.type = false;
                            ClipBoard.cutIds = false;
                            Current.type = false;
                            Current.id = false;
                            nomenclatureIds = [];
                        } else {

                        }
                    },
                    error: function (xhr) {
                        alert('ERROR: ' + xhr.responseText);
                    }
                });
            }
        }

        //УДАЛЕННИЕ СВЯЗКИ товаров
        function removeNoms() {
            var Error = false;
            if (ClipBoard.type != 'noms') {
                alert('Не выбраны товары! (!noms)');
                Error = true;
            }
            if (ClipBoard.ids.length == 0) {
                alert('Не выбраны номенклатуры для удаления! (length = 0)');
                Error = true;
            }
            console.log('[REMOVE NOMS!!!]');
            if (!Error) {
                var dataForm = {
                    nomenclatureIds: ClipBoard.ids,
                    categoryId: categoryId
                };
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '<?php echo \yii\helpers\Url::to('/cms/default/removeNoms'); ?>',
                    data: dataForm,
                    success: function (response) {
                        console.log('[RESPONSE]', response);
                        if (response.success) {
                            nomenclatureIds.forEach(function (item, index) {
                                $('#NomenclaturesList tbody').html('');
                            });
                            clearNomenclatures();
                            loadNomenclatures();
                            //после убирания забыть то, что убрали
                            ClipBoard.type = false;
                            ClipBoard.ids = false;
                            Current.type = false;
                            Current.id = false;
                            nomenclatureIds = [];
                            //pnotify('success', 'Success', 'Успешно убрали', 3000);
                        } else {
                        }
                    },
                    error: function (xhr) {
                        alert('ERROR: ' + xhr.responseText);
                    }
                });
            }
        }

        function loadNomenclatures() {
            console.log('loadNomenclatures()');
            $('.preloader').show();
            clearNomenclatures();
            categoryId = 0;
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?= \yii\helpers\Url::to('/cms/products/get-ecm-products', ['id' => '__CATEGORY__']) ?>'.replace('__CATEGORY__', categoryId),
                data: {
                    SearchString: oldSearchString,
                    category_id: categoryId,
                    isShowAll: $(".ShowAll").prop("checked") ? 1 : 0
                },
                success: function (response) {
                    console.log('[RESPONSE]', response);
                    if (response.success) {
                        clearNomenclatures();
                        var $Template = $('#NomTmpl').tmpl(response.response_data);
                        $('#NomenclaturesList tbody').append($Template);
                        $('.preloader').hide();
                    } else {
                        $('.preloader').hide();
                    }
                },
                error: function (xhr) {
                    alert('ERROR: ' + xhr.responseText);
                }
            });
        }

        function clearNomenclatures() {
            console.log('clearNomenclatures()');
            $('#NomenclaturesList tbody').html('');
        }


        /*------------------------------------------------------------------------------*/


        $('.ClearSearchString').on('click', function (e) {
            if (e !== undefined) e.preventDefault();
            $('#SearchString').val('');
        });

        $('#SearchString').on('change keyup', function (e) {
            if (e !== undefined) e.preventDefault();
            clearInterval(tm);
            tm = setInterval(function () {
                SearchString = $('#SearchString').val();
                if (SearchString !== oldSearchString) {
                    oldSearchString = SearchString;
                    loadNomenclatures();
                }
            }, 700);
        });

        loadTree();

        function loadTree() {
            $("#viewtree").fancytree({
                clickFolderMode: 1,
                extensions: ["dnd", "filter", "edit", "childcounter"],
                filter: {
                    autoApply: true, // Re-apply last filter if lazy data is loaded
                    counter: true, // Show a badge with number of matching child nodes near parent icons
                    hideExpandedCounter: true, // Hide counter badge, when parent is expanded
                    mode: "hide"  // "dimm": Grayout unmatched nodes, "hide": remove unmatched nodes
                },
                // titlesTabbable: true,
                source: {
                    //url: '<?php echo \yii\helpers\Url::to('/cms/tree/gwDataTree'); ?>'
                    url: '<?php echo \yii\helpers\Url::to('/cms/tree/lazy-data-tree'); ?>'
                },
                lazyLoad: function (event, data) {
                    var node = data.node;
                    // Load child nodes via Ajax GET /getTreeData?mode=children&parent=1234
                    data.result = {
                        url: '<?php echo \yii\helpers\Url::to('/cms/tree/lazy-data-tree'); ?>',
                        //data: {mode: "children", parent: node.key},
                        data: {id: node.key},
                        cache: false
                    };
                },
                childcounter: {
                    deep: true,
                    hideZeros: true,
                    hideExpanded: true
                },
                dnd: {
                    //autoExpandMS: 400,
                    autoScroll: false,
                    //focusOnClick: true,
                    preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
                    preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
                    dragStart: function (node, data) {
                        /** This function MUST be defined to enable dragging for the tree.
                         *  Return false to cancel dragging of node.
                         */
                        return true;
                    },
                    dragEnter: function (node, data) {
                        /** data.otherNode may be null for non-fancytree droppables.
                         *  Return false to disallow dropping on node. In this case
                         *  dragOver and dragLeave are not called.
                         *  Return 'over', 'before, or 'after' to force a hitMode.
                         *  Return ['before', 'after'] to restrict available hitModes.
                         *  Any other return value will calc the hitMode from the cursor position.
                         */
                        return true;
                    },
                    dragDrop: function (node, data) {
                        /** This function MUST be defined to enable dropping of items on
                         *  the tree.
                         */
                        $.ajax({
                            type: 'post',
                            url: '<?php echo \yii\helpers\Url::to('/cms/tree/move-node'); ?>',
                            data: {
                                'move': JSON.stringify(data.otherNode.toDict()),
                                'to': JSON.stringify(node.toDict()),
                                'hit': data.hitMode
                            },
                            traditional: true,
                            success: function (responseText) {
                                //alert(responseText);
                                data.otherNode.moveTo(node, data.hitMode);
                            },
                            error: function (xhr) {
                                alert('ERROR: ' + xhr.responseText);
                            }
                        });
                        //console.log('dragDrop');

                        //console.log('data.otherNode.toDict()', data.otherNode.toDict());
                        //console.log('node.toDict()', node.toDict());
                        //console.log('data.hitMode', data.hitMode);
                    }
                },
                /*
                 activate: function (event, data) {
                 console.log('[activate]', event, data);
                 if (!data.node.children) {
                 categoryId = data.node.key;
                 }
                 check();
                 },
                 */
                click: function (event, data) {
                    console.log('click');
                    Current.type = false;
                    Current.id = false;
                    nomenclatureId = false;
                    CurDir = data.node.key;
                    if (!data.node.lazy) { // (!data.node.children) {
                        categoryId = data.node.key;
                        Current.type = 'node';
                        Current.id = Number(categoryId);
                        //loadNomenclatures();
                        getAll();
                        console.log('Current', Current);
                    }
                    /*
                     if (data.node.key == 7185) {
                     $('.showAllBlock').show();
                     } else {
                     $('.showAllBlock').hide();
                     }
                     categoryId = 0;
                     console.log('click');
                     //console.log('[EVENT]', event);
                     console.log('[DATA]', data);
                     if (!data.node.lazy) { //(!data.node.children) {
                     categoryId = data.node.key;
                     }
                     */
                    check();
                },
                dblclick: function (event, data) {
                    //console.log('dblclick');
                    window.open(
                        '<?= \yii\helpers\Url::to('/cms/tree/edit-node', array('id' => '__id__')); ?>'
                            .replace('__id__', data.node.key) + '?is_tab=1',
                        '_blank'
                    );
                    window.focus();
                    return true;
                    /*
                     $.magnificPopup.open({
                     type: 'ajax',
                     items: {
                     src: '< ?= \yii\helpers\Url::to('editNode', array('id' => '__id__')); ?>'.replace('__id__', data.node.key)
                     },
                     modal: true
                     });
                     */
                }
                //,
                //activate: function (event, data) {
                //console.log('activate', data);
                //}
                /*,
                 lazyLoad: function (event, data) {
                 data.result = {
                 url: "/json/ajax-sub2.json"
                 }
                 }*/
            });
        }

        $('[data-action=reload]').on('click', function (e) {
            e.preventDefault();
            loadTree();
        });

        $('#reload').on('click', function (e) {
            if (e !== undefined) e.preventDefault();
            $('form').hide();
            loadTree();
        });

        $('#NomenclaturesList')
        //выделение строки в nomenclatures
            .on('click', 'tr', function (e) {
                if (e !== undefined) e.preventDefault();
                $(this).toggleClass('activeTr');
                console.log('[nomenclatureIds]', nomenclatureIds);
                //check();
            })
            //переход на редактирование номенклатуры
            .on('dblclick', 'tr', function () {
                window.open(
                    '<?= \yii\helpers\Url::to('/product/product/edit', array('id' => '__id__')); ?>'
                        .replace('__id__', $(this).data('id')) + '?is_tab=1',
                    '_blank'
                );
                window.focus();
            })
        ;

        function createLinks() {
            var dataForm = {
                categoryId: categoryId,
                nomenclatureIds: nomenclatureIds
            };
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo \yii\helpers\Url::to('/cms/default/create-link'); ?>',
                data: dataForm,
                success: function (response) {
                    console.log('[RESPONSE]', response);
                    if (response.success) {
                        $('#NomenclaturesList tr.activeTr').remove();
                        nomenclatureIds = [];
                        check();
                        new PNotify({
                            title: 'Успешно.',
                            text: 'Номенклатуры успешно перенесены.',
                            icon: 'icon-checkmark3',
                            type: 'success',
                            delay: 2000
                        });
                    } else {

                    }
                },
                error: function (xhr) {
                    alert('ERROR: ' + xhr.responseText);
                }
            });
        }

        /*/
         function loadNomenclatures() {
         $('.preloader').show();
         clearNomenclatures();
         $.ajax({
         type: 'POST',
         dataType: 'json',
         url: '< ?php echo \yii\helpers\Url::to('/cms/default/getFreeNoms'); ?>',
         data: {
         searchString: SearchString
         },
         success: function (response) {
         console.log('[RESPONSE]', response);
         if (response.success) {
         clearNomenclatures();
         var $Template = $('#NomTmpl').tmpl(response.response_data);
         $('#NomenclaturesList tbody').append($Template);
         } else {

         }
         $('.preloader').hide();
         },
         error: function (xhr) {
         alert('ERROR: ' + xhr.responseText);
         $('.preloader').hide();
         }
         });
         }

         function clearNomenclatures() {
         $('#NomenclaturesList tbody').html('');
         }
         //*/

        function check() {
            var count = nomenclatureIds.length;
            if (nomenclatureIds.length > 0 && categoryId > 0) {
                $('#MoveNoms').removeClass('disabled btn-warning').addClass('btn-success');
            } else {
                $('#MoveNoms').removeClass('btn-success').addClass('disabled btn-warning');
            }
        }

        $('#MoveNoms')
            .on('click', function (e) {
                if (e !== undefined) e.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    //createLinks();
                    copyNoms();
                }
            })
        ;

        //раскрыть все узлы
        var tree = $("#viewtree").fancytree("getTree");
        tree.visit(function (node) {
            node.setExpanded(false);
        });

        loadNomenclatures();

        $('#viewtree .fancytree-node');//.on('');

    });

</script>
