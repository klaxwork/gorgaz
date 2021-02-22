<?php

use common\components\M;
use frontend\components\widgets\CatalogCardWidget\CatalogCardWidget;
use yii\helpers\Url;

?>

<?php
//M::printr('BOTTOM');
?>
<div class="filters-catalog__items clearfix" id="products">
    <?php $c = 0; ?>
    <?php foreach ($this->context->result as $row) { ?>
        <?php
        //M::printr($row, '$row');

        /*/

        [id] => 7847
            [category] => 1768
            [category_name] => Lucky John CLASSIC 15H
        [ns_left_key] => 1018
            [img] => /store/th/7W8NYqKnls.jpg
        [labels] => Array
        (
            [is_new] => 0
                    [is_sale] => 0
                )

            [count] => 0
            [1c_product_vendor] => 81501
            [manufacture] => 60
            [ves_gr] => 13
            [dlina_mm] => 50
            [unit] => 0
            [1c_product_id] => 0
            [troynik] => 125
            [color_h1code] => 15
            [price] => 0
        //*/
        $card = [
            'catalog' => $row['category_id'],
            'url' => Url::to(['/route/catalog', 'id' => $row['category_id']]),
            'imgUrl' => $row['img'],
            'name' => $row['category_name'],
            'price' => $row['price'],
            'count' => $row['count'],
        ];
        $card['cart'] = 1;
        if ($row['is_price']) {
            if ($row['is_count']) {
                //M::printr('is_price && is_count');
                $card['cart'] = 1;
            } else {
                //M::printr('is_price && !is_count');
                $card['cart'] = 1;
            }
        } else {
            //M::printr('!is_price');
            $card['cart'] = 4;
        }
        ?>
        <?= CatalogCardWidget::Widget(
            [
                'cart' => $this->context->cart,
                'card' => $card,
                'count' => $c,
                //'categoryId' => $oCategory->id,
                //'formName' => $this->context->formName,
                //'filterConfig' => $this->context->filterConfig,
            ]
        ); ?>
    <?php } ?>

</div>
