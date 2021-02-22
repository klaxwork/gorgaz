<form>
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <select id="select-factory" name="" class="btn" style="width: 100%;">
                <option value="">:: выберите ферму для управления ::</option>
                <?php foreach (Yii::app()->fw->list as $row) {
                    $opts = '';
                    if (isset(Yii::app()->fw->work['factory_id']) and $row['factory_id'] == Yii::app()->fw->work['factory_id']) {
                        $opts .= 'selected="on"';
                    }
                    ?>
                    <option <?php echo $opts; ?> value="<?php echo $row['factory_id']; ?>">
                        [<?php echo $row['factory_id']; ?>
                        ] <?php echo $row['factory_name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <a href="<?= $this->createUrl('listAll') ?>" class="btn btn-info">Список всех квестов</a>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#select-factory').select2();
            $('#select-factory').on('change', function () {
                console.log('???');
                location.href = '<?php echo $this->createUrl('/area/factory/use/with/__id__'); ?>'.replace(/__id__/, $(this).val());
            });
        });
    </script>
</form>
