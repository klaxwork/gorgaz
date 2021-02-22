<style>
    .popup-basic {
        width: 500px;
        height: 100%;
        display: table;
        vertical-align: middle;
        margin: 0 auto;
    }

    .panel{
        display: table-cell;
        width: 600px;
        margin: 0 auto;
    }

    .panel-body{
        max-height: 800px;
    }
    .text-right{
        text-align: right;
    }
</style>

<div id="modal-panel" class="popup-basic mfp-with-anim">
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-icon"> <i class="fa fa-pencil"></i> </span> <span
                class="panel-title"> <?php echo $this->pageTitle; ?></span>
        </div>
        <div class="panel-body" id="popup-container">
            <?php echo $content; ?>
        </div>
        <div class="panel-footer text-right">
            <button class="btn" type="button" onclick="$.magnificPopup.close();">Закрыть</button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(this).keydown(function (eventObject) {
            if (eventObject.which == 27) {
                $('#popup-container').empty();
                $('body > .select2-container').remove();
                $.magnificPopup.close();
            }
        });
    });
</script>
