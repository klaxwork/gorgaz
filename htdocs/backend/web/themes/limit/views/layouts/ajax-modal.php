<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h5 class="modal-title"><?= $this->pageTitle ?></h5>
</div>

<div class="modal-body">
    <?php echo $content; ?>
</div>

<!--<div class="modal-footer">
    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
</div>-->

<script>
    $(document).ready(function () {
        $(this).keydown(function (eventObject) {
            if (eventObject.which == 27) {
                $('#modal .modal-container').empty();
                $('body > .select2-container').remove();
            }
        });
    });
</script>

