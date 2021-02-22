<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<?php
/* @var $this SiteController */

//$this->context->page_title = Yii::$app->name;
?>

<div class="row">

	<div class="col-md-8">
		<div class="panel">
			<div class="panel-heading">
				<span class="panel-icon"></span> <span class="panel-title"> Panel One</span>
			</div>
			<div class="panel-body">
				<p class="">
					<a href="/store/docs/sinh_MoySklad.pdf">Инструкция "Синхронизация МойСклад to WWW"</a>
				<div id="gridContainer"></div>

                <pre>
Механизм работы при создании заказа следующий:
в RetailCRM менеджер меняет СТАТУС ЗАКАЗА на "Согласовано с клиентом".
как только поменял - срабатывает триггер, который отправляет информацию о заказе  на фишмен,
с фишмена она летит в Эквайринг
тут же клиенту придет ссылка на почту для оплаты.
                </pre>
				</p>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel">
			<div class="panel-heading">
				<span class="panel-icon"></span> <span class="panel-title"> Panel Two</span>
			</div>
			<div class="panel-body">
                <pre>
htdocs/frontend/modules/page/views/watch/_main/_head_banner.php
меню на главной странице
баннеры на главной (слайдер)

htdocs/frontend/modules/page/views/watch/_main/_banner1.php
htdocs/frontend/modules/page/views/watch/_main/_banner2.php
баннеры на главной (не слайдер)

htdocs/frontend/www/themes/fishmen/views/layouts/_header.php
меню на второстепенных страницах

htdocs/frontend/modules/page/views/robots/robots.php
редактирование robots.txt

Редактирование шага свойства фильтра (ползунок)
Таблица ecm_custom_fields, находим нужное нам свойство, в поле
field_data указываем параметр {"scale":1} если шаг равен единице,
или {"scale":0.1} если шаг равен 0.1

htdocs/frontend/modules/page/views/watch/catalog.php
Каталог выстраивается автоматически из дерева каталогов.
Картинка должна лежать в папке "/www/images/catalog/", иметь имя равное алиасу каталога (url_alias) и расширение ".png"
/www/images/catalog/url_alias.png


<b>Синхронизация с Hynt.ru</b>
Заходим в консоль в папку /srv/vhosts/fishmen/fs.test/htdocs/

Для синхронизации последних измененных товаров и категорий запускаем
./yii service/hynt
Для синхронизации с конкретных даты/времени запускаем
./yii service/hynt 500 0 2001-01-01
./yii service/hynt 500 0 "2019-02-11 16:00:00"
Дату можно указывать без времени.

где     500 -- количество записей за 1 раз
0 -- смещение (сколько первых товаров пропустить)

Очередность синхронизации:
1. метаданных (типы доп.полей)
2. доп. полей (поля свойств товаров)
3. товаров (берет с хинта по API поумолчанию по 500 товаров начиная с даты изменения товаров из таблицы SysVars)
3.1. проверяется товар на существование в базе; если не найден, то создается.
3.2. создается запись в таблице app_products
3.3. сохранение количества на складе в виде суммы количества товара со всех складов на хинте
3.4. сохранение всех свойств товара
3.5. картинки на данный момент не синхронизируются
4. таблицы SysVars
                </pre>
			</div>
		</div>
	</div>

</div>

