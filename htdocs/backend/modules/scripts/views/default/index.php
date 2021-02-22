<?php
/* @var $this DefaultController */

use common\components\M;
use yii\helpers\Url;

//M::printr($this->context, '$this->context');
//M::printr($this, '$this');

$this->context->breadcrumbs = [
    Yii::$app->controller->id,
    Yii::$app->controller->module->id,
    Yii::$app->controller->action->id,
];
//M::printr(Yii::$app->controller->id, 'Yii::$app->controller->id');
//M::printr(Yii::$app->controller->module->id, 'Yii::$app->controller->module->id');
//M::printr(Yii::$app->controller->action->id, 'Yii::$app->controller->action->id');

//exit;
?>
<pre><p><h2>Фильтр</h2>
    <a href="/scripts/filter/indexGenerate" target="_blank">Индексация каталогов для фильтра</a>
    Пересчитывает данные для отображения свойст и их значений в фильтре товаров

<h2>Поиск</h2>
    Управление поиском ELASTICSEARCH :
    <a href="/scripts/search/generate" target="_blank">Наполнение индекса товарами (Переиндексация)</a>
    <a href="https://fishmen.ru/fullSearch?request=%D0%A2%D0%B5%D1%81%D1%82" target="_blank">Тест индекса</a>

    Только при изменении конфигурации индекса:
    <a href="/scripts/search/deleteIndex" target="_blank">Удаление индекса</a>
    <a href="/scripts/search/newIndex" target="_blank">Создание индекса </a>

<h2>ICML</h2>
    <a href="/exchange/default/GenerateICML" target="_blank">Генерация ICML файла</a> (не используется, файл создается на Hynt.ru)
    Файл будет помещён в католог: /srv/vhosts/ecm/htdocs/backend/store/exports/catalog.xml
    Внешняя ссылка для данного файла: http://hynt.ru/store/exports/catalogRetail.xml

<h2>Импорт 1С</h2>
    <a href="<?php echo Url::to(['/import/default/parse']); ?>" target="_blank">Импорт 1С to WWW</a>
    Выгружаем данные из 1С в два файла:
    import0_1.xml - содержит структуру каталогов и список товаров
    offers0_1.xml - содержит список складов, кол-во и цену товаров

    При работе парсер проверяет Категории и Товары по Индвидуальному номеру 1С
    Если Товар или Категория не найдены - тогда создаёт их.
    Если Товар или Категория найдены (ID совпадает), проверяет Родителя (в случае отличия - обновляет),
    затем сверяет Заголовок (в случае отличия - обновляет), сверяет цену (в случае отличия - обновляет),
    обновляет кол-во на складе.

<h2>Импорт МойСклад</h2>
    <a href="<?= Url::to(['/exchange/import/parse']); ?>" target="_blank">Импорт МойСклад to WWW</a>
    Ссылка на которую должны поступать данные: /exchange/    (её необходимо указать в настройках МойСклад)
    Полученные данные хранятся в файлах:
    "/var/temp/import.xml"
    "/var/temp/offer.xml"

    После получения данных необходимо запустиь их обработку, перейдя по ссылке:
    /exchange/import/parse/
    (или кнопкой в главном меню: Настройки/Импорт/Импорт из МойСклад)

    Парсер работает в 3 этапа:
    1. Обновление дерева категорий.
    2. Проверка категорий товаров, обновление при перемещении товара.
    3. Обновление данных о товарах (название, цена, колличество, артикул)
    Идентификация товаров и категорий происходит по ключу (аналогисному ID 1С)

<h2>Импорт предложений из файла с сайта http://hynt.ru</h2>
    <a href="<?php echo Url::to(['/import/default/parsingOffers']); ?>" target="_blank"> <span
			    class="glyphicon glyphicon-book"></span> Импорт товаров из .csv </a>

<h2>Импорт категорий и товаров с сайта http://hynt.ru</h2>
    <span href="<?php echo Url::to(['/import/syncHynt/getHyntTree']); ?>" target="_blank"><span
			    class="glyphicon glyphicon-book"></span> Импорт категорий c http://hynt.ru</span> (<?php
    echo Url::to(['/import/syncHynt/getHyntTree']); ?>)
    <a href="<?php echo Url::to(['/import/syncHynt/getHyntProducts']); ?>"
       target="_blank"><span
			    class="glyphicon glyphicon-book"></span> Импорт товаров c http://hynt.ru</a> (<?php
    echo Url::to(['/import/syncHynt/getHyntProducts']); ?>)

<h2>Кеш</h2>
    <a href="<?php echo Url::to(['/test/reset']); ?>" target="_blank"><span
			    class="glyphicon glyphicon-trash"></span> Сброс кэша</a>

<h2>Обновление картинок с хинта</h2>
    ./yiic Synchynt SetCategoryImage --cms_tree=NNN
    Где NNN -- id категории на фишмене

</pre>
