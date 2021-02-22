<div style="margin: 20px; border: 1px solid #888;">
    <?php //=M::printr($oComment->attributes, '$oComment->attributes'); ?>
    <div class="dt_created">dt_created: <?= $oComment->dt_created ?></div>
    <?php if (!empty($oComment->relationClient)) { ?>
        <?php //= M::printr($oComment->relationClient->attributes, '$oComment->relationClient->attributes'); ?>
        <?php
        $data = \yii\helpers\Json::decode($oComment->relationClient->data);
        ?>
        <div class="dt_created">name: <?= $data['name'] ?></div>
        <div class="dt_created">email: <?= $data['email'] ?></div>
        <div class="client_message">client_message: <?= $oComment->client_message ?></div>
        <div class="admin_answer">admin_answer: <?= $oComment->admin_answer ?></div>
        <div class="positive">positive: <?= $oComment->positive ?></div>
    <?php } ?>


    <div class="negative">negative: <?= $oComment->negative ?></div>
</div>
