<section class="main-description">
    <div class="container">
        <div class="main-description__items">
            <h2 class="visuallyhidden">Об интернет-магазине Фишмен.Ру</h2>
            <div class="row main-description__row">
                <?php
                $oCategory = CmsTree::model()->getCategoryByAlias('glavnaja-tekst-levyj');
                $oContent = $oCategory->content;
                ?>
                <div class="col-md-6 main-description__col">
                    <div class="main-description__item">
                        <?= $oContent->page_body ?>
                    </div>
                </div>
                <?php
                $oCategory = CmsTree::model()->getCategoryByAlias('glavnaja-tekst-pravyj');
                $oContent = $oCategory->content;
                ?>
                <div class="col-md-6 main-description__col">
                    <div class="main-description__item">
                        <?= $oContent->page_body ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
