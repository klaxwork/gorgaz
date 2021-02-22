<?php

namespace frontend\components\widgets\ProductCardWidget;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ProductCardWidget extends Widget
{

    public $cart;
    public $wish;

    public $parent = 'parent';
    public $child = 'child';
    public $card = [];
    public $count = 0;

    public $name = null;
    public $price = 0;
    public $is_price = false;
    public $url = null;
    public $category_id = 200;
    public $vendor = null;
    public $imgUrl = null;
    public $is_count = false;

    public $n = '';
    public $m = '';

    public $is_wish = false;

    /**
     * Renders the content of the portlet.
     */
    public function run() {
        //\common\components\M::printr($this->card, '$card');
        return $this->render('card');
    }
}