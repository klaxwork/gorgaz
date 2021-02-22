<?php

use common\components\M;

?>
<style>
	.wrap {
		border: 1px solid #00f;
	}

	.left {
		border: 1px solid #0f0;
		width: 300px;
	}

	.right {
		border: 1px solid #0ff;
		width: 940px;
	}

	.top {
		border: 1px solid #f00;
	}

	.bottom {
		border: 1px solid #f0f;
	}

	.filter-displaying-chose svg {
		font-size: 24px;
	}
</style>
<script>
	filterConfig.countAll = <?= $this->context->countAll ?>;
</script>

<section class="filters-catalog">
    <?php //var_dump($filter)?>
	<div class="container clearfix">
		<form method="post" id="<?= $this->context->formName ?>" action="#">
			<input type="hidden" id="filter_offset" name="<?= $this->context->formName ?>[offset]" value="40">

			<!-- Левая панель фильтра -->
            <?= $this->render('_filter_block'); ?>
            <?php //= $this->renderPartial('_filter_left', ['formName' => $this->context->formName, 'filter' => $filter]) ?>
			<!-- /Левая панель фильтра -->

			<div class="filters-catalog__list <?= $this->context->filterDisplaying == 'block' ? 'block-items-visible' : '' ?>">

				<!-- Верхняя панель фльтра -->
                <?= $this->render('_selection_block'); ?>
                <?php //= $this->renderPartial('_filter_top', ['formName' => $this->context->formName, 'cookie' => $cookie]) ?>
				<!-- /Верхняя панель фльтра -->

                <?= $this->render('_result_block'); ?>
				<div id="preloader" class="preloader" style="text-align: center; width: 100%; display: none;">
					<svg xmlns="http://www.w3.org/2000/svg" width="64px" height="64px"
					     viewBox="0 0 128 128" xml:space="preserve"><g>
							<path fill="#c7bd00"
							      d="M109.25 55.5h-36l12-12a29.54 29.54 0 0 0-49.53 12H18.75A46.04 46.04 0 0 1 96.9 31.84l12.35-12.34v36zm-90.5 17h36l-12 12a29.54 29.54 0 0 0 49.53-12h16.97A46.04 46.04 0 0 1 31.1 96.16L18.74 108.5v-36z"/>
							<animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64"
							                  dur="1040ms" repeatCount="indefinite"></animateTransform>
						</g></svg>
				</div>

				<div id="more_product_button" class="filters-catalog__load">
					<div class="filters-catalog__load-btn">
						<div class="btn btn_load loadMore">
							<svg class="svg-icon ico-load">
								<use xmlns:xlink="http://www.w3.org/1999/xlink"
								     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-load"></use>
							</svg>
							<span>Показать еще 20</span>
						</div>
					</div>
					<div class="filters-catalog__load-number">Показано 1—<span class="offset">40</span> (всего <span
								class="countAll"><?= 0 ?></span>)
					</div>
				</div>

				<div id="end_list_product" class="filters-catalog__load" style="display: none;">
					<div class="filters-catalog__load-number">Показано <span class="countAll"></span><br> Измените
						параметры фильтра или выберите другую категорию.
					</div>
					<div class="filters-catalog__load-number mobile">Показано <span class="countAll"></span><br> <span
								class="mobile_link">Измените параметры фильтра</span> или выберите другую категорию.
					</div>
				</div>

			</div>
		</form>
	</div>
</section>

<?php if (0) { ?>
	<div class="filter">
		<h2>Блок с фильтром, шапкой фильтра и результатом фильтрации</h2>
		<div class="wrap">
			<form method="post" id="<?= $this->context->formName ?>" action="#">
				<input type="hidden" class="offset" id="filter_offset" name="<?= $this->context->formName ?>[offset]"
				       value="40"> <input type="hidden" class="limit" id="filter_limit"
				                          name="<?= $this->context->formName ?>[limit]"
				                          value="20">

				<div class="left">
                    <?= $this->render('_filter_block'); ?>
				</div>
				<div class="right">
					<div class="top">
                        <?= $this->render('_selection_block'); ?>
					</div>
					<div class="bottom">
                        <?= $this->render('_result_block'); ?>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php } ?>

