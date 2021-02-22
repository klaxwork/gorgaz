<?php

use common\components\M;

?>
<div class="row">
	<div class="form-group">
		<div class="col-lg-10">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-sm-9 col-xs-12">
					<div class="form-group has-feedback has-feedback-left">
						<input type="text" class="form-control" id="SearchString" placeholder="Search string">
						<div class="form-control-feedback">
							<i class="icon-search4 text-size-base"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-flat">
	<div class="panel-heading">
		<h6 class="panel-title"><?= $oProduct->title ?></h6>
	</div>

	<div class="panel-body">
        <?= $oProduct->description ?>
	</div>
	<div class="panel-footer">
        <?php foreach ($oStores as $oStore) { ?>
            <?php
            $oCropped = $oStore->getCropped('dev:main');
            ?>
			<a href="/store<?= $oStore->fs_alias ?>" target="_blank"><img src="/store<?= $oCropped->fs_alias ?>"></a>
        <?php } ?>
	</div>
</div>