<?php
$cs = Yii::app()->clientScript;
//$cs->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/vendor/plugins/fileupload/fileupload.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/vendor/plugins/holder/holder.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/vendor/plugins/jqueryform/jquery.form.js', CClientScript::POS_END);

//$cs->registerScriptFile('/js/bootbox/bootbox.js', CClientScript::POS_END);
?>
<div id="uploadImages">
    <form action="<?= $this->createUrl('/cms/media/store') ?>" method="post" id="fileupload-form">
        <input type="hidden" name="folder_id" id="fu-folder_id" value="">
        <input type="hidden" name="order_id" id="fu-order_id" value="">
        <input type="hidden" name="fullpath" id="fu-fullpath" value="">

        <div class="fileupload fileupload-new admin-form mt20" data-provides="fileupload"
             data-name="file">
            <!--
            <div class="section mb10">
                <label for="fu-title" class="field prepend-icon">
                    <input type="text" name="title" id="fu-title" class="event-name gui-input br-light light" placeholder="Title">
                    <label for="fu-title" class="field-icon"><i class="fa fa-pencil"></i></label>
                </label>
            </div>
            -->
            <div class="section mb10">
                <span class="button btn-system btn-file btn-block ph5"> <span
                            class="fileupload-new">Выберите файл</span> <span
                            class="fileupload-exists">Изменить файл</span> <input type="file"> </span>
            </div>
            <div class="fileupload-preview thumbnail m5 mt20 mb30">
                <div style="width: 300px; height: 200px; background-color: #b9dbe8; margin: auto; display: table;">
                    <img id="image_thumb" data-src="holder.js/300x200" alt="holder">
                </div>
                <!--
                <img data-src="holder.js/300x200" alt="holder">
                -->
            </div>
            <div class="section mb25 hide">
                <button type="submit" class="btn btn-alert fileupload-exists">Загрузить</button>
            </div>
        </div>
    </form>
</div>

<style>
    .upload_delete {
        font-weight: bold;
        color: #FF0000;
        cursor: pointer;
    }
</style>

<div id="template_img" style="display: none;">
    <div class="row upload_block p5 m5" style="border: 1px solid lightgreen;">
        <input id="upload_id" type="hidden" name="<?= $formName ?>[store_teaser_image][0][id]" value="">

        <div class="col-lg-2">
            <img src="" style="max-width:100px; max-height: 100px;" class="upload_image">
        </div>
        <div class="col-lg-5">
            <span class="upload_filename">filename</span> (<span class="upload_filesize">filesize</span> bytes)
        </div>
        <div class="col-lg-3">
            <span class="btn btn-info meta_show_hide">meta (show/hide)</span>
        </div>
        <div class="col-lg-2 text-right" style="text-align: right;">
            <span class="upload_delete">X</span>
        </div>
        <div class="col-lg-12" style="">
            <textarea style="display: none;" name="<?= $formName ?>[store_teaser_image][0][data]"
                      class="form-control input-sm mt5" rows="5"></textarea>
        </div>
    </div>
</div>

<script>
    var countImages = 0;
    var store_teaser_image = <?= !empty($model->store_teaser_image) ? CJSON::encode($model->store_teaser_image) : '[]'?>;

    function addImage(response, id) {
        countImages++;
        //взять шаблон
        var $div = $('#template_img .upload_block').clone();
        var id_val = 0;
        if (id != undefined) {
            id_val = id;
        }
        $div.find('input').attr('name', '<?= $formName ?>[store_teaser_image][' + countImages + '][id]').val(id_val); //response.id
        $div.find('img').attr('src', '/store' + response.alias);
        $div.find('textarea')
            .attr('name', '<?= $formName ?>[store_teaser_image][' + countImages + '][data]')
            .attr('id', '<?= $formName ?>_store_teaser_image_' + countImages)
            .attr('rows', 5).text(JSON.stringify(response, null, "  ") + "\n");
        $div.find('.upload_filename').text(response.name);
        $div.find('.upload_filesize').text(response.size);
        $('#tab_resources').append($div);
    }

    $(document).ready(function () {

        $('#fileupload-form').ajaxForm(function (response) {
            $('.panel-tabs a[href="#tab_resources"]').tab('show');
            addImage(response);
        });

        $('#fileupload-form').on('change', 'input[type="file"]', function (e) {
            $('#fileupload-form').submit();
            console.log('Submit');
        });


        //$('.panel-tabs a[href="#tab_resources"]').tab('show');
        $('#tab_resources').on('click', '.upload_delete', function () {
            $(this).closest('.upload_block').remove();
        });
        $('#tab_resources').on('click', '.meta_show_hide', function () {
            $(this).closest('.upload_block').find('textarea').toggle();
        });

        store_teaser_image.forEach(function (item, index, store_teaser_image) {
            addImage(item.data, item.id);
        });


    });
</script>

<div style="display: none;">
    <p>при загрузке квеста загрузить в модель cms_node_properties</p>

    <p>при сохранении удалить те, которых нет в текущем списке и добавить новые</p>
</div>
<?php
//M::printr($model->store_teaser_image, '$model->store_teaser_image');

?>
