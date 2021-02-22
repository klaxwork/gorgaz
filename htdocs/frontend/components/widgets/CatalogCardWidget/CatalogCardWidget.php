<?php

namespace frontend\components\widgets\CatalogCardWidget;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class CatalogCardWidget extends Widget
{

	public $cart;
	public $wish;

	public $parent = 'parent';
	public $child = 'child';
	public $card = [];
	public $count = 0;

	public $is_wish = false;
    public $price = 0;
    public $is_price = false;
    public $is_count = false;
    public $category_id = false;
    public $product_id = false;
    public $node_name = null;
    public $content = null;
    public $url = null;
    public $imgUrl = null;

	/**
	 * Renders the content of the portlet.
	 */
	public function run() {
	    //\common\components\M::printr($this->card, '$card');
		return $this->render('card');
	}
}