<div class="page-wrapper">
    <?php
    $breadcrumbs = [];
    $breadcrumbs['Главная'] = '/';
    $breadcrumbs[$oNews->node_name] = '/news/';
    $breadcrumbs += $oNewsItem->getBreadcrumbs();
    //M::printr($breadcrumbs, '$breadcrumbs');
    ?>
    <div class="breadcrumb-wr">
        <div class="container">
            <div class="breadcrumb">
                <?php if (isset($breadcrumbs)) { ?>
                    <?php
                    $this->widget(
                        'common.widgets.Breadcrumbs.Breadcrumbs',//'zii.widgets.CBreadcrumbs',
                        array(
                            'links' => $breadcrumbs,
                        )
                    );
                    ?><!-- breadcrumbs -->
                <?php } ?>
            </div>
        </div>
    </div>
    <section class="main-title">
        <div class="container">
            <h1><?= $oNewsItem->content->page_longtitle ?: $oNewsItem->content->page_title ?></h1>
        </div>
    </section>

    <div class="catalog-item-wr">
        <div class="container">
            <div class="catalog-item__list">
                <div class="row">
                    <div class="catalog-item__item col-md-12 col-sm-12 col-xs-12">
                        <article>
                            <div class="visuallyhidden">
                                <h2><?= $oNewsItem->content->page_longtitle ?: $oNewsItem->content->page_title ?></h2>
                            </div>
                            <?php
                            $img = '/images/noimg_64.jpg';
                            $oImages = $oNewsItem->getImages();
                            if (!empty($oImages)) {
                                $oImg = $oImages[0]->getCropped('ecm:teaser_news');
                                $img = '/store' . $oImg->fs_alias;
                            }

                            ?>
                            <img src="<?= $img ?>" style="float: left; margin: 0 15px 15px 0;"
                                 alt="<?= $oNewsItem->content->page_longtitle ?: $oNewsItem->content->page_title ?>">
                            <?= $oNewsItem->content->page_body ?>
                        </article>
                    </div>
                    <div class="main-item-ds__payment-social clearfix">
                        <div class="main-item-ds__payment-social-title">Поделитесь новостью с друзьями</div>
                        <div class="ya-share2"
                             data-services="vkontakte,facebook,odnoklassniki,gplus,twitter,viber,whatsapp,telegram"></div>
                    </div>
                </div>
            </div>
            <div style="margin: 20px 0 0 30px;">
                <a href="<?= $this->createUrl('/page/watch/news') ?>">&larr; Вернуться ко всем новостям</a>
            </div>

        </div>
    </div>
</div>
<?= $this->renderPartial('_main/_subs') ?>
