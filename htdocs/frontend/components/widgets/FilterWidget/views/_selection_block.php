<?php

use common\components\M;

?>
<?php
//M::printr('TOP');
?>
<!-- Верхняя панель фльтра -->
<div class="filters-catalog__fast-filter clearfix" id="filter_top">
	<div class="filters-catalog__fast-filter-sorting">
		<div class="filters-catalog__fast-filter-sorting-caption">По:</div>
		<div class="filters-catalog__fast-filter-sorting-item">
			<select class="selectpicker" name="<?= $this->context->formName ?>[order]" id="sort_selection">
				<option value="price_up">Возрастанию цены</option>
				<option value="price_down">Убыванию цены</option>
				<option value="rating">Популярности</option>
				<option value="name">Наименованию</option>
			</select>
		</div>
	</div>
	<div class="filters-catalog__fast-filter-option">
		<ul class="list">
			<!--<li>
                            <div class="filters-catalog__filter-item-check-item">
                                <label> <input type="checkbox" name="<?= $this->context->formName ?>[check_discount]" id="check_discount"><span>Со скидкой</span> </label>
                            </div>
                        </li> -->
			<li>
				<div class="filters-catalog__filter-item-check-item">
					<label> <input type="checkbox" name="<?= $this->context->formName ?>[check_in_stock]"
					               id="check_in_stock" class="filter_check"><span>В наличии</span> </label>
				</div>
			</li>
			<li>
				<div class="filters-catalog__filter-item-check-item">
					<label> <input type="checkbox" name="<?= $this->context->formName ?>[check_new]" id="check_new"
					               class="filter_check"><span>Новинки</span> </label>
				</div>
			</li>
			<li>
				<div class="filters-catalog__filter-item-check-item">
					<label> <input type="checkbox" name="<?= $this->context->formName ?>[check_sale]" id="check_sale"
					               class="filter_check"><span>Распродажа %</span> </label>
				</div>
			</li>
		</ul>
	</div>
	<div class="filters-catalog__fast-filter-displaying">
		<div class="filters-catalog__fast-filter-displaying-number">
			<span class="countAll"></span>
		</div>
		<div class="filters-catalog__fast-filter-displaying-chose">
			<div class="filter-displaying-chose filter-displaying-chose_block <?= $this->context->filterDisplaying == 'block' ? 'active' : '' ?>">
				<svg class="svg-icon ico-disp1">
					<use xmlns:xlink="http://www.w3.org/1999/xlink"
					     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-disp1"></use>
				</svg>
			</div>
			<div class="filter-displaying-chose filter-displaying-chose_line <?= $this->context->filterDisplaying == 'line' ? 'active' : '' ?>">
				<svg class="svg-icon ico-disp2">
					<use xmlns:xlink="http://www.w3.org/1999/xlink"
					     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-disp2"></use>
				</svg>
			</div>
		</div>
	</div>
</div>
<!-- /Верхняя панель фльтра -->