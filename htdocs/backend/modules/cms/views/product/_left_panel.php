<div class="panel">
    <div class="panel-heading">
        <span class="panel-title">Управление</span>
    </div>
    <?php
    $params = array(
        'quest' => isset($model->_quest->id) ? $model->_quest->id : null,
        //'filter' => 'quest',
        //'getCategory' => '2',
    );
    //M::printr($model, '$model');
    ?>
    <div class="panel-menu">
        <div class="chart-legend mb10">
            <a class="ajax-popup-link legend-item btn btn-block btn-info ph30 mr20"
               href="<?= $this->createUrl('/quest/gallery/index', array('params' => CJSON::encode($params))); ?>">Галерея</a>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <span class="panel-title">Ресурсы</span>
    </div>

    <div class="panel-menu">
        <?php $this->renderPartial('upload', compact('formName', 'model')); ?>
    </div>
</div>

<?php if (!empty($model->id)) { ?>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Actions</span>
        </div>

        <div class="panel-menu">
            <a href="<?= $this->createUrl('/quest/quest/move', ['id' => $model->id]) ?>" style="width: 100%;" class="ajax-popup-link btn-block btn btn-system btn-sm" id="MoveQuest">Переместить</a>
        </div>

        <div class="panel-menu">
            <a href="<?= $this->createUrl('/quest/quest/copy', ['id' => $model->id]) ?>" style="width: 100%;" class="ajax-popup-link btn-block btn btn-info btn-sm" id="CopyQuest">Копировать</a>
        </div>

    </div>

    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Удалить</span>
        </div>

        <div class="panel-menu" style="text-align: center;">
            <span style="" class="btn btn-warning btn-sm" id="DeleteQuest">Удалить</span>
        </div>

        <div class="panel-body hide" id="Confirm">
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <span class="btn btn-danger btn-sm" style="width: 100%;" id="DeleteYes">Да</span>
                </div>
                <div class="col-lg-6">
                    <span class="btn btn-success btn-sm" style="width: 100%;" id="DeleteNo">Нет</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script type="application/javascript">
    function galleryCallback(response, params) {
        console.log('[RESPONSE]', response);
        console.log('[PARAMS]', params);
    }

    $(document).ready(function () {
        $('.ajax-popup-link').magnificPopup({
            type: 'ajax',
            modal: true
        });

        $('#DeleteQuest').on('click', function (e) {
            e.preventDefault();
            $('#Confirm').toggleClass('hide');
        });

        $('#DeleteNo').on('click', function (e) {
            e.preventDefault();
            $('#Confirm').addClass('hide');
        });

        $('#DeleteYes').on('click', function (e) {
            e.preventDefault();
            //удалить квест
            $.ajax({
                url: '<?= $this->createUrl('/quest/quest/deleteQuest', array('id' => $model->id));?>',
                type: 'POST',
                dataType: 'json'
            }).success(function (response) {
                //console.log('[response]', response);
                if (response.success == true) {
                    location.href = '<?= $this->createUrl('/quest/quest/list');?>';
                } else {
                    alert(response.message);
                    return false;
                }
            }).error(function (data, key, value) {
                alert('Что-то пошло не так...');
                return false;
                //after_send(data);
            });
        });

        //MoveQuest

        //CopyQuest

    }); //$(document).ready();
</script>

