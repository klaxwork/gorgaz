<?php

namespace frontend\components\widgets\FilterWidget;

use common\components\M;
use common\models\Cart;
use common\models\ElSearchFilter;
use common\models\models\CmsNodeProperties;
use common\models\models\EcmCustomFieldDictionary;
use common\models\models\EcmCustomFields;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;

class FilterWidget extends Widget

{
    public $categoryId = 200; //cms_tree_ref
    public $oCategory = null;
    public $filterData = [];
    public $filterConfig = [];
    public $countAll = 0;
    public $formName = 'FilterForm';
    public $config = [];
    public $result = null;
    public $filterDisplaying = 'block';
    public $cart = [];

    /**
     * Renders the content of the portlet.
     */
    public function run() {
        $oCart = (new Cart())->give();
        $this->cart = $oCart;
        //M::printr($this->cart, '$this->cart');
        $cookies = Yii::$app->request->cookies;
        //M::printr($cookies, '$cookies');
        $this->filterDisplaying = $cookies->getValue('filterDisplaying');

        //получить данные для левой части фильтра
        $tm1 = microtime(1);
        $this->config = ElSearchFilter::getConfig($this->config);
        $tm11 = microtime(1);

        $this->filterData = ElSearchFilter::getFilterData($this->categoryId);
        $tm12 = microtime(1);
        //M::printr($tm12 - $tm11, '$tm12 - $tm11 (getFilterData)');

        $response = ElSearchFilter::getElasticItems($this->categoryId, $this->config);
        $categories = $response['categories'];
        $this->countAll = $response['countAll'];
        //M::printr($response, '$response');

        $tm13 = microtime(1);
        //M::printr($tm13 - $tm12, '$tm13 - $tm12 (getElasticItems)');
        $tm2 = microtime(1);
        //M::printr($tm2 - $tm1, '$tm2 - $tm1 (getConfig, getFilterData, getElasticItems)');

        //выбираем по limit и offset
        //M::printr($categories, '$categories');
        //return false;
        if (!empty($categories)) {
            $categories = array_slice($categories, $this->config['offset'], $this->config['limit'], true);
        } else {
            $categories = [];
        }
        $tm14 = microtime(true);
        //M::printr($tm14 - $tm13, '$tm14 - $tm13 (array_slice)');

        //M::printr(count($categories), 'count($categories)');
        $tm3 = microtime(1);
        //M::printr($tm3 - $tm2, '$tm3 - $tm2');

        $this->config['countAll'] = count($categories);

        $this->result = $categories;

        //M::printr($tm3 - $tm1, '$tm3 - $tm1 (ALL)');
        return $this->render('view');
    }
}