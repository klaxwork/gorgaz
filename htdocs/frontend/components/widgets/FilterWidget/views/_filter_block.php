<?php

use common\components\M;

//M::printr('FILTER');

?>

<!-- Левая панель фильтра -->
<div class="filters-catalog__filter">
    <div class="filters-catalog__filter-wr">
        <div class="filters-catalog__filter-btn">Фильтр товаров</div>
        <div class="filters-catalog__filter-items">

            <!--<div class="filters-catalog__filter-item">
                            <div class="filters-catalog__filter-item-title filters-catalog__filter-item-title_r-slider">
                                Цена
                            </div>
                            <div class="filters-catalog__filter-item-body">
                                <div class="filters-catalog__filter-item-range">
                                    <div class="filters-catalog__filter-item-range-output"><span>от</span>
                                        <input type="text"
                                               class="ion-range-output price-from"><span>до</span><input
                                               type="text" class="ion-range-output price-to"></div>
                                    <div class="filters-catalog__filter-item-range-input">
                                        <input type="text"
                                               name="< ?= $this->context->formName ?>[price]"
                                               value="" data-min="0"
                                               data-max="10000"
                                               data-step="1"
                                               class="ion-range-slider">
                                    </div>
                                </div>
                            </div>
                        </div> -->
            <?php foreach ($this->context->filterData as $data) { ?>
                <?php
                $oField = $data['meta'];
                switch ($oField->ecm_custom_field_meta_ref) {
                    case 3: //no break;
                        //text
                    case 'price':
                        //цена
                        ?>
                        <div class="filters-catalog__filter-item">
                            <div class="filters-catalog__filter-item-title filters-catalog__filter-item-title_r-slider">
                                <?= $oField->field_name ?><?= $oField->field_unit ? ", " . $oField->field_unit : '' ?>
                            </div>
                            <div class="filters-catalog__filter-item-body">
                                <div class="filters-catalog__filter-item-range">
                                    <div class="filters-catalog__filter-item-range-output">
                                        <span>от</span> <input type="text"
                                                               class="ion-range-output price-from">
                                        <span>до</span> <input type="text" class="ion-range-output price-to">
                                    </div>
                                    <div class="filters-catalog__filter-item-range-input">
                                        <input type="text"
                                               name="<?= $this->context->formName ?>[<?= $oField->field_key ?>]"
                                               value="" data-min="<?= $data['min'] ?>"
                                               data-max="<?= $data['max'] ?>"
                                               data-step="<?= $data['scale'] ?>"
                                               class="ion-range-slider">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        break;

                    case 10:
                        //checkboxes
                        ?>
                        <div class="filters-catalog__filter-item">
                            <div class="filters-catalog__filter-item-title"><?= $oField->field_name ?><?= $oField->field_unit ? ", " . $oField->field_unit : '' ?></div>
                            <div class="filters-catalog__filter-item-body">
                                <?php //if ($oField->id == 1) {var_dump($data);}
                                $c = 0;
                                foreach ($data as $id => $value) {
                                    if ($id == 'meta') {
                                        continue;
                                    } ?>
                                    <div class="filters-catalog__filter-item-check-item <?= $c > 3 ? 'hidden' : '' ?>">
                                        <label> <input type="checkbox"
                                                       name="<?= $this->context->formName ?>[<?= $oField->field_key ?>][<?= $id ?>]"
                                                       value="<?= $id ?>">
                                            <span><?= $value ?></span></label>
                                    </div>
                                    <?php $c++; ?>
                                <?php } ?>
                            </div>
                            <div class="filters-catalog__filter-item-check-control">
                                <ul class="list">
                                    <?php if ($c > 3) { ?>
                                        <li>
                                            <div class="filters-catalog__filter-check-control-show">Показать
                                                все
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <div class="filters-catalog__filter-check-control-choose">Выбрать
                                            все
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php
                        break;

                    case 12:
                        //variable/range
                        ?>
                        <div class="filters-catalog__filter-item">
                            <div class="filters-catalog__filter-item-title filters-catalog__filter-item-title_r-slider">
                                <?= $oField->field_name ?><?= $oField->field_unit ? ", " . $oField->field_unit : '' ?>
                            </div>
                            <div class="filters-catalog__filter-item-body">
                                <div class="filters-catalog__filter-item-range">
                                    <div class="filters-catalog__filter-item-range-output">
                                        <span>от</span><input type="text"
                                                              class="ion-range-output price-from">
                                        <span>до</span><input type="text" class="ion-range-output price-to">
                                    </div>
                                    <div class="filters-catalog__filter-item-range-input">
                                        <input type="text"
                                               name="<?= $this->context->formName ?>[<?= $oField->field_key ?>]"
                                               value="" data-min="<?= $data['min'] ?>"
                                               data-max="<?= $data['max'] ?>"
                                               data-step="<?= $data['scale'] ?>"
                                               class="ion-range-slider">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        break;

                    case 13:
                        //radios
                        ?>
                        <div class="filters-catalog__filter-item">
                            <div class="filters-catalog__filter-item-title"><?= $oField->field_name ?><?= $oField->field_unit ? ", " . $oField->field_unit : '' ?></div>
                            <div class="filters-catalog__filter-item-body">
                                <?php
                                foreach ($data as $id => $value) {
                                    if ($id == 'meta') {
                                        continue;
                                    } ?>
                                    <div class="basket-step__item-delivery-itm">
                                        <div class="basket-standart-radio">
                                            <label> <input type="radio"
                                                           name="<?= $this->context->formName . '[' . $oField->field_key . ']' ?>"
                                                           value="<?= $id ?>">
                                                <span class="basket-standart-radio__content filterRadio">
                                                            <span><?= $value ?></span>
                                                        </span> </label>
                                        </div>
                                    </div><br>
                                <?php } ?>

                                <div class="basket-step__item-delivery-itm">
                                    <div class="basket-standart-radio">
                                        <label> <input type="radio"
                                                       name="<?= $this->context->formName . '[' . $oField->field_key . ']' ?>"
                                                       value="any"
                                                       checked>
                                            <span class="basket-standart-radio__content filterRadio">
                                                            <span>Не важно</span>
                                                        </span> </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        break;
                } ?>
            <?php } /**/ ?>

            <div class="filters-catalog__filter-item">
                <div class="filters-catalog__filter-item-sumbit">
                    <div id="sub_button" class="btn btn_filter" style="cursor: pointer">
                        <svg class="svg-icon ico-search">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-search"></use>
                        </svg>
                        <span id="sendFilter">Применить</span>
                    </div>
                </div>
                <div class="filters-catalog__filter-item-search-result">Найдено
                    <span class="countAll"></span>
                </div>
                <div class="filters-catalog__filter-item-delete-result">
                    <button type="reset">Очистить</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Левая панель фильтра -->
