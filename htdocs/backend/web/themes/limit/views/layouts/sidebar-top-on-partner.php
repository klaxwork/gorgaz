<!-- Start: Sidebar -->
<aside id="sidebar_left" class="affix">

    <!-- Start: Sidebar Left Content -->
    <div class="sidebar-left-content nano-content">

        <!-- Start: Sidebar Menu -->
        <ul class="nav sidebar-menu">

            <li>
                <a href="<?php echo Yii::app()->createUrl('/partner'); ?>"> <span
                        class="glyphicon glyphicon-home"></span> <span class="sidebar-title">Рабочий стол</span> </a>
            </li>

            <li style="display: none;">
                <a class="accordion-toggle" href="<?php echo Yii::app()->createUrl('/core'); ?>"> <span
                        class="fa fa-tasks"></span> <span class="sidebar-title">Мои квесты</span> <span
                        class="caret"></span> </a>
                <ul class="nav sub-nav">
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/q'); ?>"> <span class="fa fa-group"></span> Список
                            квестов </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/q'); ?>"> <span class="fa fa-key"></span> Расписание
                            сеансов </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/q'); ?>"> <span class="fa fa-gears"></span>
                            Настройки </a>
                    </li>
                </ul>
            </li>

            <li>
                <a class="accordion-toggle" href="<?php echo Yii::app()->createUrl('/core'); ?>"> <span
                        class="fa fa-tasks"></span> <span class="sidebar-title">Бонусная система</span> <span
                        class="caret"></span> </a>
                <ul class="nav sub-nav">
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/partner/order/list'); ?>"> <span class="fa fa-group"></span> Список заказов </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/partner/order/listCallbacks'); ?>"> <span class="fa fa-group"></span> Обратные звонки </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/partner/order/transfer'); ?>"> <span class="fa fa-key"></span> Перевод бонусов клиенту </a>
                    </li>
                    <li style="display: none;">
                        <a href="<?php echo Yii::app()->createUrl('/q'); ?>"> <span class="fa fa-gears"></span>
                            Настройки квестов </a>
                    </li>
                </ul>
            </li>

        </ul>
        <!-- End: Sidebar Menu -->

    </div>
    <!-- End: Sidebar Left Content -->

</aside>


