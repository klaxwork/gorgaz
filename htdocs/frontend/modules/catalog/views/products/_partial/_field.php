<?php

use common\components\M;
use \yii\helpers\Json;

?>
<?php if (1) { ?>
    <div style="">
        <?php //= M::printr($oField, '$oFields'); ?>
        <div class="field">
            <?= $oField->customField->field_name ?>
            => <?= !empty($oField->customFieldDict) ? $oField->customFieldDict->field_value_view : $oField->field_value ?>

        </div>
    </div>
<?php } ?>

