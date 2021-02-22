<div id="modal-panel" class="popup-basic mfp-with-anim">
    <div class="panel">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <span class="panel-icon"> <i class="fa fa-pencil"></i> </span> <span
                    class="panel-title"> <?php echo $this->pageTitle; ?></span>
        </div>
        <div class="panel-body" id="popup-container">
            <?php echo $content; ?>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-sm btn-info" type="button" onclick="$('#modal').modal('toggle');">Закрыть</button>
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
