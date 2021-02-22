<?php

use common\components\M;

use frontend\components\widgets\BreadcrumbsWidget\BreadcrumbsWidget;
use frontend\components\widgets\FilterWidget\FilterWidget;
use \yii\helpers\Json;
use \yii\helpers\Url;

?>

<style>
    .list {
        padding-left: 0;
        list-style-type: none;
        margin-bottom: 0;
    }

    ul, ol {
        margin-top: 0;
        margin-bottom: 10px;
    }

    .breadcrumb ul li {
        float: left;
        position: relative;
        font-size: 17px;
    }
</style>
<?= $_breadcrumbs ?>
<?php /*/ ?>
<div class="breadcrumb-wr">
	<div class="container">
		<div class="breadcrumb">
            <?php
            $breadcrumbs['Главная'] = '/';
            $breadcrumbs += $oContent->getBreadcrumbs();
            ?>
            <?= BreadcrumbsWidget::widget(
                [
                    //'is_hide_last' => true,
                    'links' => $breadcrumbs,
                ]
            ); ?>
		</div>
	</div>
</div>
<?php //*/ ?>

<script>
    var filterConfig = <?= Json::encode($config) ?>;
</script>

<section class="main-title">
    <div class="container">
        <?php
        $name = (!empty($oCategory->content)
            && !empty($oCategory->content->page_longtitle))
            ? $oCategory->content->page_longtitle
            : $oCategory->node_name;
        ?>
        <h1><?= str_replace('"', '&#8243;', $name) ?></h1>
    </div>
</section>

<?php //= $this->render('_menu_catalog', ['oCategory' => $oCategory]); ?>
<?= $_menu_catalog ?>

<?php if (0) { ?>
    <div class="cms-default-index">
        <?php //= common\components\M::printr($this->context, '$this->context');?>
        <h1><?= $oCategory->content->page_title ?></h1>
        <div style="border: 1px solid #000;">
            <ul class="" style="list-style-type: none;">
                <?php foreach ($oChs as $oCh) { ?>
                    <?php
                    M::printr($oCh, '$oCh');
                    continue;
                    ?>
                    <?php $oContent = $oCh->content; ?>
                    <li>
                        <?php
                        //M::printr($oCh->id, '$oCh->id');
                        //$to = Url::to(['page/catalog', 'id' => $oCh->id]);
                        $to = \yii\helpers\Url::toRoute(['/route/catalog', 'id' => $oCh->id]);
                        //M::printr($to, '$to');
                        ?>
                        <a href="<?= $to ?>"><?= !empty($oContent->page_long_title) ? $oContent->page_long_title : $oContent->page_title ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <p>
            This is the view content for action "<?= $this->context->action->id ?>". The action belongs to the
            controller "<?= get_class($this->context) ?>" in the "<?= $this->context->module->id ?>" module.
        </p>
        <p>
            You may customize this page by editing the following file:<br> <code><?= __FILE__ ?></code>
        </p>
    </div>
<?php } ?>
<?php $tm1 = microtime(true); ?>
<?= FilterWidget::widget(
    [
        'categoryId' => $oCategory->id,
        'formName' => $this->context->formName,
        'config' => [
            'limit' => 40,
            'offset' => 0,
        ],
        //'filterConfig' => $this->context->filterConfig,
    ]
); ?>
<?php
$tm2 = microtime(true);
$r = $tm2 - $tm1;
//M::printr($r, '$r');
?>

<script>
    var config = <?= Json::encode($config) ?>;
    console.log('config', config);
    var limit = 20;
    var offset = 40;
    var order = '';
    order = 'rating';
    order = 'product_name';
    order = 'product_price';
    order = 'product_price';
    order = 'product_name';
    var sort = '';
    sort = 'ASC';
    //sort = 'DESC';
    var filterKey = "";
    var dataFilterSerial = {};
    var tovar = ['товар', 'товара', 'товаров'];
    var countCats = 0;
    // $('.countAll').text(config.countAll);
    //$('.offset').text(Number(config.config.offset) + Number(config.countProducts));

    function beginFilter(load) {
        if (load == undefined) load = "NEW";
        console.log('function beginFilter(load = "' + load + '")');
        //параметр load устанавливает новый поиск или догрузку результутов для старого
        //console.log('Отправить данные фильтра для выбора товаров');
        //alert('test');
        if (load == "NEW") {
            limit = 40;
            $('.limit').text(limit);
            offset = 0;
            $('.offset').text(offset);
            $('#products').empty();
        }
        console.log('[limit, offset]', limit, offset);
        $('#preloader').show();
        $('#more_product_button').hide();
        $('#end_list_product').hide();
        $('#filter_limit').val(limit);
        $('#filter_offset').val(offset);

        dataFilterSerial = $('#<?= $this->context->formName ?>').serializeJSON();
        dataFilterSerial['<?= \Yii::$app->request->csrfParam; ?>'] = '<?= \Yii::$app->request->getCsrfToken(); ?>';
        console.log('2 dataFilterSerial', dataFilterSerial);

        $.ajax({
            //url: '< ?= Url::to(['/beta/filter', 'node_id' => $oCategory->id]) ?>',
            url: '<?= Url::to(['/catalog/default/load-more-products', 'node_id' => $oCategory->id]) ?>',
            type: 'POST',
            dataType: 'json',
            data: dataFilterSerial,
            success: function (response) {
                console.log('[response]', response);
                //alert('=)');
                //$('#products').html(response);
                if (response.success) {
                    //ошибок нет
                    var countCats = Number(response.config.offset) + Number(response.config.limit);
                    console.log('[countCats]', countCats);
                    console.log('limit', limit);
                    console.log('offset', offset);

                    $('#preloader').hide();
                    $('.offset').empty();

                    if (countCats > response.config.countAll) response.config.offset = response.config.countAll;

                    $('.offset').text(response.config.offset);

                    if (response.config.offset >= response.config.countAll) {
                        $('#end_list_product').show();
                    } else {
                        $('#more_product_button').show();
                    }
                    //$('.countAll').text(response.config.countAll);
                    $('.countAll').text(declOfNum(response.config.countAll, tovar));
                    //offset = countCats;
                    offset += limit;
                    $('.offset').text(countCats);
                    limit = 20;
                    $('.limit').text(limit);
                    //$('#products').append(response.response_html);
                    $('#products').append(response.html);
                } else {
                    //ошибки есть
                    //$('#errors').empty().append(printrErrors(response.errors));
                    //$('#submit').prop('disabled', false);
                }
            },
            error: function (data, key, value) {
                return false;
                //after_send(data);
            }
        });
    }

    $(document).ready(function () {
        //загрузить первые 20
        //$('.preloader').show();

        config = filterConfig;
        console.log('filterConfig', filterConfig);
        countCats = config.countAll < (Number(config.offset) + Number(config.limit)) ? config.countAll : (Number(config.offset) + Number(config.limit));
        console.log('countCats', countCats);
        $('.offset').text(countCats);

        if (countCats >= config.countAll) {
            $('.filters-catalog__load-btn').hide();
        }

        $('.countAll').text(declOfNum(config.countAll, tovar));

        $('body').on('click', '.addToCart', function (e) {
            //e.preventDefault();
            $(this).closest('.catalog-item').addClass('catalog-item_in-basket');
            var $temp = $('#templateInBasket').html();
            $(this).closest('.product-item__status').html($temp);
        });

        $('#sub_button').on('click', function () {
            beginFilter('NEW');
            var filter_head = $('#filter_top').offset();
            console.log(filter_head);
            $('html, body').stop().animate({
                scrollTop: filter_head.top - 70
            }, 700);
            $('.filters-catalog__filter-wr').removeClass('active');
        });

        $('.mobile_link').on('click', function () {
            var filter_head = $('#FilterForm').offset();
            console.log('[filter_head]', filter_head);
            $('html, body').stop().animate({
                scrollTop: filter_head.top - 70
            }, 700);
            $('body').find('.filters-catalog__filter-wr').addClass('active');
        });

        $('#sort_selection, .filter_check').on('change', function () {
            beginFilter('NEW');
        });

        $('.loadMore').on('click', function () {
            console.log('.loadMore');
            beginFilter('ADD');
        });

    });
</script>
