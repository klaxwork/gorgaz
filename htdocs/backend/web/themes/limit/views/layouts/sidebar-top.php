<!-- Second navbar -->
<div class="navbar navbar-default" id="navbar-second">
    <ul class="nav navbar-nav no-border visible-xs-block">
        <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i
                        class="icon-menu7"></i></a></li>
    </ul>

    <div class="navbar-collapse collapse" id="navbar-second-toggle">
        <ul class="nav navbar-nav">
            <li class="hide"><a href="/site/dashboard/"><i class="icon-display4 position-left"></i> Dashboard</a></li>
            <li class="hide"><a href="/import/default/upload1c/"><i class="icon-display4 position-left"></i> Загрузка из
                    1C</a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-puzzle4 position-left"></i> Настройки <span class="caret"></span>
                </a>

                <ul class="dropdown-menu width-300">
                    <li><a href="/scripts"><i class="icon-googleplus5"></i> Скрипты </a></li>
                    <li class="hide">
                        <a href="/partner/default/index" target="_blank"><i class="icon-googleplus5"></i>
                            Партнеры/склады </a>
                    </li>
                    <li>
                        <a href="<?php echo \yii\helpers\Url::to('/cms/tree/watch', ['id' => 1]); ?>"><i
                                    class="icon-googleplus5"></i> Страницы </a>
                    </li>

                    <li>
                        <a href="/cms/tree" target="_blank"><i class="icon-googleplus5"></i>Управление деревьями</a>
                    </li>

                    <li class="">
                        <a href="/import/properties/list/"><i class="icon-googleplus5"></i> Свойства</a>
                    </li>

                    <li>
                        <a href="/front/catalog/index/category_id/200" target="_blank"><i class="icon-googleplus5"></i>Frontend</a>
                    </li>
                    <li><a href="/cms/tree/seo"><i class="icon-googleplus5"></i> SEO категорий </a></li>
                    <li><a href="/cms/market/seoProducts"><i class="icon-googleplus5"></i> SEO товаров </a></li>
                    <li><a href="/cms/redirects/index"><i class="icon-googleplus5"></i> Редиректы </a></li>
                    <li class="dropdown-submenu">
                        <a href="#"><i class="icon-task"></i> Уведомления</a>
                        <ul class="dropdown-menu width-200">
                            <li><a href="/notify/notify/list"><i class="icon-googleplus5"></i> Шаблоны</a></li>
                            <li><a href="/notify/event/list"><i class="icon-googleplus5"></i> События</a></li>
                        </ul>
                    </li>

                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-puzzle4 position-left"></i> Каталог <span class="caret"></span>
                </a>

                <ul class="dropdown-menu width-300">
                    <li class="hide">
                        <a href="/catalog/default/parsingNoms">
                            <i class="icon-googleplus5"></i> Загрузка
                        </a>
                    </li>
                    <li><a href="<?= \yii\helpers\Url::to('/cms/tree/free-noms') ?>">
                            <i class="icon-googleplus5"></i> Распределение товаров
                        </a>
                    </li>
                    <li><a href="/cms/default/global">
                            <i class="icon-googleplus5"></i> Полный каталог
                        </a>
                    </li>
                    <li>
                        <a class="" data-toggle="modal" data-target="#modal" href="<?= \yii\helpers\Url::to(['/cms/tree/create-node', 'id' => 200, 'is_tab' => 1]) ?>" target="_blank">
                            <i class="icon-googleplus5"></i> Создать категорию
                        </a>
                    </li>
                    <li class="">
                        <a href="/import/properties/list/">
                            <i class="icon-googleplus5"></i> Свойства
                        </a>
                    </li>
                    <li class="hide">
                        <a href="/import/properties/massset/">
                            <i class="icon-googleplus5"></i>МассЭффект
                        </a>
                    </li>
                    <li class="hide">
                        <a href="/cms/default/prices">
                            <i class="icon-googleplus5"></i>Спец товары
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-puzzle4 position-left"></i> Спецпредложения <span class="caret"></span>
                </a>

                <ul class="dropdown-menu width-300">
                    <li class="">
                        <a href="/cms/spec/speclist">
                            <i class="icon-googleplus5"></i> Изменить список
                        </a>
                    </li>
                    <li><a href="/cms/spec/specprices">
                            <i class="icon-googleplus5"></i> Изменить цены
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-puzzle4 position-left"></i> YandexMarket <span class="caret"></span>
                </a>

                <ul class="dropdown-menu width-300">
                    <li class="">
                        <a href="/cms/market/marketlist">
                            <i class="icon-googleplus5"></i> Изменить список
                        </a>
                    </li>
                    <li class=""><a href="/cms/market/markettree">
                            <i class="icon-googleplus5"></i> Просмотр по категориям
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-puzzle4 position-left"></i> Vexton <span class="caret"></span>
                </a>

                <ul class="dropdown-menu width-300">
                    <li class="">
                        <a href="/cms/vexton/list">
                            <i class="icon-googleplus5"></i> Изменить список
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown hide">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-puzzle4 position-left"></i> Опт <span class="caret"></span>
                </a>

                <ul class="dropdown-menu width-300">
                    <li>
                        <a href="/cms/tree/createNode/id/200/?theme=admin" target="_blank"><i
                                    class="icon-googleplus5"></i> Создание узла </a>
                    </li>
                    <li><a href="/catalog/default/global"><i class="icon-googleplus5"></i> Глобальный каталог </a></li>
                </ul>

            </li>
            <li class="dropdown hide">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-puzzle4 position-left"></i> Розница <span class="caret"></span>
                </a>

                <ul class="dropdown-menu width-300">
                    <li>
                        <a href="/cms/tree/createNode/id/300/?theme=admin" target="_blank"><i
                                    class="icon-googleplus5"></i> Создание узла </a>
                    </li>
                    <li><a href="/catalog/retail/freeNoms"><i class="icon-googleplus5"></i> Распределение </a></li>
                </ul>

            </li>
        </ul>

    </div>
</div>
<!-- /second navbar -->


