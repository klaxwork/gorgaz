<?php if (0) { ?>
	<div class="row">
		<div class="col-md-12">
            <?= $this->renderPartial('_formProduct', compact('formName', 'oProduct')); ?>
		</div>
	</div>
<?php } ?>

<div class="row">
	<div class="col-md-12">
        <?= $this->context->renderPartial('_formProduct', ['formName' => $formName, 'oProduct' => $oProduct, 'oStores' => $oStores]); ?>
	</div>
</div>