<form action="<?= \yii\helpers\Url::to(['/cms/tree/createNode', 'parent' => $parent]) ?>" id="<?= $formName ?>">
    <div class="panel panel-default">
        <div class="panel-body Form admin-form">
            <div class="tab-content pn br-n">
                <div id="tab_general" class="tab-pane active">
                    <div id="General">

                        <div class="row formField mb10">
                            <div class="col-md-12">
                                <label class=""
                                       for="<?= $formName ?>_page_title">Название категории</label>

                                <input type="text" id="<?= $formName ?>_page_title" class="form-control input-sm"
                                       name="<?= $formName ?>[page_title]" data-type="text"
                                       value="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body Form admin-form">
            <button id="SaveBtn" class="btn btn-success btn-sm saveBtn">Сохранить</button>
        </div>
        <div class="panel-body Form admin-form" style="display: none;">
            <div id="success" class="btn btn-info btn-sm">Сохранено успешно!</div>
        </div>

    </div>

</form>

<div id="templates" style="display: none;">
    <div class="stringField col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="formField mb10" data-type="text">
            <label class="" for=""></label><!-- -->
            <input type="text" class="field form-control input-sm"
                   name="" value="">
        </div>
    </div>

    <div class="textField col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="formField mb10" data-type="text">
            <label class="" for=""></label><!-- -->
            <textarea class="form-control field input-sm" rows="3"
                      name=""></textarea>
        </div>
    </div>
</div>

<script type="application/javascript">
    /**
     * @param type [success, warning, danger]
     * @param title
     * @param text
     */
    function notify(type, title, text) {
        // Create new Notification
        new PNotify({
            title: title,
            text: text,
            shadow: true,
            opacity: 1,
            addclass: 'stack_top_right',
            type: type,
            /*
             stack: {
             "dir1": "down",
             "dir2": "left",
             "push": "top",
             "spacing1": 10,
             "spacing2": 10
             },
             */
            width: '300px',
            delay: 3000
        });

    }

    function saveButton() {
        $('#SaveBtn').prop('disabled', true);
        //отправить данные
        var parent = <?= $parent ?>; //$currentBtn.data('id');
        console.log('parent', parent);

        $.ajax({
            url: '<?= \yii\helpers\Url::To(['/cms/tree/create-node', 'parent' => '__PARENT__']) ?>'
                .replace('__PARENT__', parent),
            type: 'POST',
            dataType: 'json',
            data: $('#<?= $formName ?>').serialize(),
            success: function (response) {
                console.log('[response]', response);
                if (response.success) {

                }
                $('#SaveBtn').prop('disabled', false);
                if (0) {
                    if (response.errorz == false) {
                        //ошибок нет
                        if (is_tab == 1) {
                            //alert('сохранено');
                            setTimeout(
                                function () {
                                    window.close();
                                },
                                1000
                            );
                        } else {
                            location.reload();
                        }

                    } else {
                        //ошибки есть
                        $('#errors').empty().append(printrErrors(response.error));
                        console.log('[MESSAGES]', response.messages);
                        $('#submit').prop('disabled', false);
                    }
                }
            },
            error: function (data, key, value) {
                $('#SaveBtn').prop('disabled', false);
                return false;
                //after_send(data);
            }
        });
    }

    $(document).ready(function () {
        $('#SaveBtn')
            .on('click', function () {
                saveButton();
            })
        ;
    });
</script>

