<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

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
<div class="panel">
    <div class="panel-heading">
        <?= $model->is_copy == true ? 'Копировать' : 'Переместить' ?>
    </div>
    <div class="panel-body Form admin-form">

        <div class="row mb10">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <select id="select-factory" name="<?= $form->id ?>[factory_id]" class="btn " style="width: 100%;">
                    <option value="">:: выберите ферму для переноса квеста ::</option>
                    <?php foreach (Yii::app()->fw->list as $row) {
                        $opts = '';
                        if (isset(Yii::app()->fw->work['factory_id']) and $row['factory_id'] == Yii::app()->fw->work['factory_id']) {
                            $opts .= 'selected="on"';
                        }
                        ?>
                        <option <?= $opts ?> value="<?= $row['factory_id'] ?>">
                            [<?= $row['factory_id'] ?>] <?= $row['factory_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <?php if ($model->is_copy) { ?>
            <div class="tab-content pn br-n">
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
                    <input type="text" class="form-control input-sm" id="<?= $form->id ?>_<?= $name ?>"
                           name="<?= $form->id ?>[<?= $name ?>]" data-type="text" value="<?= $model->$name ?>">
                </div>

            </div>
        <?php } ?>

    </div>

    <div class="panel-body Form admin-form">
        <button id="submit" class="btn btn-success btn-sm">Сохранить</button>
    </div>
</div>

<?php $this->endWidget(); ?>

<div id="alert" class="alert alert-warning alert-dismissable" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="fa fa-warning pr10"></i>

    <div id="errors"></div>
</div>



<script type="application/javascript">

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

    $(document).ready(function () {
        //инициализация select2
        $('#select-factory').select2();

        //отправка данных на сохранение
        $('#submit').on('click', function (e) {
            e.preventDefault();
            $('#alert').hide();
            //$('#submit').prop('disabled', true);

            $.ajax({
                url: '<?= $this->createUrl($this->action->id, array('id' => $model->id)) ?>',
                type: 'POST',
                dataType: 'json',
                data: $('#<?= $form->id ?>').serialize()
            }).success(function (response) {
                //console.log('[response]', response);
                if (response.success == true) {
                    //ошибок нет
                    //location.reload();
                    window.location = '<?= $this->createUrl('list') ?>';
                } else {
                    //ошибки есть
                    $('#errors').empty().append(printrErrors(response.message));
                    $('#submit').prop('disabled', false);
                }
            }).error(function (data, key, value) {
                return false;
                //after_send(data);
            });

        });

        $('#<?= $form->id ?>').on('click', '#toTranslit', function (e) {
            e.preventDefault();
            translit('#<?= $form->id ?>_product_name', '#<?= $form->id ?>_url_alias');
        });

    });

</script>
