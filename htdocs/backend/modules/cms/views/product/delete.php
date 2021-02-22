<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-menu">
                <div class="chart-legend">
                    <span class="btn btn-sm btn-danger" id="delete">Удалить</span><!-- -->
                    <span class="btn btn-sm btn-warning" id="cancel">Отмена</span><!-- -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#cancel').on('click', function (e) {
            window.location = '<?= $this->createUrl('list') ?>';
        });
        $('#delete').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?= $this->createUrl('delete', ['id' => $id, 'confirm' => 'yes']) ?>',
                type: 'post',
                dataType: 'json'
            }).success(function (response) {
                console.log('[RESPONSE]', response);
                if (response.success) {
                    setTimeout(function () {

                    }, 4000);
                    window.location = '<?= $this->createUrl('list') ?>';
                } else {
                }
            });

        });
    });
</script>