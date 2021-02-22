<?php

use \common\components\M;

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

<?php
M::printr($oProducts, '$oProducts');
M::printr($oStores, '$oStores');
?>