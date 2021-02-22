
    <!-- Start: Header -->
    <header class="navbar navbar-fixed-top">

      <div class="navbar-branding">
        <a class="navbar-brand" href="dashboard.html">
          <b>Admin</b>Tools
        </a>
        <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
      </div>

      <ul class="nav navbar-nav navbar-left">
      </ul>


      <ul class="nav navbar-nav navbar-right">

        <li class="menu-divider hidden-xs">
          <i class="fa fa-circle"></i>
        </li>


        <li class="dropdown menu-merge">

          <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
            <img src="/themes/admin/assets/img/avatars/1.jpg" alt="avatar" class="mw30 br64">
            <span class="hidden-xs pl15"> <?php echo Yii::app()->user->name; ?> </span>
            <span class="caret caret-tp hidden-xs"></span>
          </a>

          <ul class="dropdown-menu list-group dropdown-persist w250" role="menu">
            <li class="list-group-item">
              <a href="#" class="animated animated-short fadeInUp">
                <span class="fa fa-gear"></span> Settings </a>
            </li>
            <li class="dropdown-footer">
              <a href="<?php echo Yii::app()->createUrl('/user/logout'); ?>" class="">
              <span class="fa fa-power-off pr5"></span> Logout </a>
            </li>
          </ul>

        </li>



      </ul>


    </header>
    <!-- End: Header -->


