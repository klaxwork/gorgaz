<?php

use common\components\M;
use backend\assets\BackAsset;

$webtheme = Yii::getAlias('@webtheme');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php //= $this->pageTitle ?></title>

    <?= Yii::$app->controller->renderPartial('@layouts/_htmlhead.php'); ?>
</head>
<body class="">

<?php //= Yii::$app->controller->renderPartial('@layouts/_header.php'); ?>

<!-- Main navbar -->
<div class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="index.html"><img src="<?= $webtheme ?>/assets/images/logo_light.png" alt=""></a>

		<ul class="nav navbar-nav pull-right visible-xs-block">
			<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
		</ul>
	</div>

	<div class="navbar-collapse collapse" id="navbar-mobile">
		<ul class="nav navbar-nav">

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-dots position-left"></i>
					Product <span class="caret"></span> </a>

				<ul class="dropdown-menu Xdropdown-menu-right">
					<li><a href="/cms/product/list"> List </a></li>
					<li><a href="/cms/product/create"> Create </a></li>

					<li class="dropdown-submenu hide">
						<a href="#"><i class="icon-firefox"></i> Has child</a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="icon-android"></i> Third level</a></li>
							<li class="dropdown-submenu">
								<a href="#"><i class="icon-apple2"></i> Has child</a>
								<ul class="dropdown-menu">
									<li><a href="#"><i class="icon-html5"></i> Fourth level</a></li>
									<li><a href="#"><i class="icon-css3"></i> Fourth level</a></li>
								</ul>
							</li>
							<li><a href="#"><i class="icon-windows"></i> Third level</a></li>
						</ul>
					</li>
					<li class="hide"><a href="#"><i class="icon-chrome"></i> Second level</a></li>
				</ul>
			</li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-people"></i> <span
							class="visible-xs-inline-block position-right">Users</span> </a>

				<div class="dropdown-menu dropdown-content">
					<div class="dropdown-content-heading">
						Users online
						<ul class="icons-list">
							<li><a href="#"><i class="icon-gear"></i></a></li>
						</ul>
					</div>

					<ul class="media-list dropdown-content-body width-300">
						<li class="media">
							<div class="media-left"><img src="<?= $webtheme ?>/assets/images/placeholder.jpg"
							                             class="img-circle img-sm" alt=""></div>
							<div class="media-body">
								<a href="#" class="media-heading text-semibold">Jordana Ansley</a> <span
										class="display-block text-muted text-size-small">Lead web developer</span>
							</div>
							<div class="media-right media-middle"><span class="status-mark border-success"></span>
							</div>
						</li>

						<li class="media">
							<div class="media-left"><img src="<?= $webtheme ?>/assets/images/placeholder.jpg"
							                             class="img-circle img-sm" alt=""></div>
							<div class="media-body">
								<a href="#" class="media-heading text-semibold">Will Brason</a> <span
										class="display-block text-muted text-size-small">Marketing manager</span>
							</div>
							<div class="media-right media-middle"><span class="status-mark border-danger"></span>
							</div>
						</li>

						<li class="media">
							<div class="media-left"><img src="<?= $webtheme ?>/assets/images/placeholder.jpg"
							                             class="img-circle img-sm" alt=""></div>
							<div class="media-body">
								<a href="#" class="media-heading text-semibold">Hanna Walden</a> <span
										class="display-block text-muted text-size-small">Project manager</span>
							</div>
							<div class="media-right media-middle"><span class="status-mark border-success"></span>
							</div>
						</li>

						<li class="media">
							<div class="media-left"><img src="<?= $webtheme ?>/assets/images/placeholder.jpg"
							                             class="img-circle img-sm" alt=""></div>
							<div class="media-body">
								<a href="#" class="media-heading text-semibold">Dori Laperriere</a> <span
										class="display-block text-muted text-size-small">Business developer</span>
							</div>
							<div class="media-right media-middle"><span
										class="status-mark border-warning-300"></span></div>
						</li>

						<li class="media">
							<div class="media-left"><img src="<?= $webtheme ?>/assets/images/placeholder.jpg"
							                             class="img-circle img-sm" alt=""></div>
							<div class="media-body">
								<a href="#" class="media-heading text-semibold">Vanessa Aurelius</a> <span
										class="display-block text-muted text-size-small">UX expert</span>
							</div>
							<div class="media-right media-middle"><span class="status-mark border-grey-400"></span>
							</div>
						</li>
					</ul>

					<div class="dropdown-content-footer">
						<a href="#" data-popup="tooltip" title="All users"><i
									class="icon-menu display-block"></i></a>
					</div>
				</div>
			</li>

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-bubbles4"></i> <span
							class="visible-xs-inline-block position-right">Messages</span> <span
							class="badge bg-warning-400">2</span> </a>

				<div class="dropdown-menu dropdown-content width-350">
					<div class="dropdown-content-heading">
						Messages
						<ul class="icons-list">
							<li><a href="#"><i class="icon-compose"></i></a></li>
						</ul>
					</div>

					<ul class="media-list dropdown-content-body">
						<li class="media">
							<div class="media-left">
								<img src="<?= $webtheme ?>/assets/images/placeholder.jpg" class="img-circle img-sm"
								     alt=""> <span
										class="badge bg-danger-400 media-badge">5</span>
							</div>

							<div class="media-body">
								<a href="#" class="media-heading"> <span class="text-semibold">James Alexander</span>
									<span class="media-annotation pull-right">04:58</span> </a>

								<span class="text-muted">who knows, maybe that would be the best thing for me...</span>
							</div>
						</li>

						<li class="media">
							<div class="media-left">
								<img src="<?= $webtheme ?>/assets/images/placeholder.jpg" class="img-circle img-sm"
								     alt=""> <span
										class="badge bg-danger-400 media-badge">4</span>
							</div>

							<div class="media-body">
								<a href="#" class="media-heading"> <span class="text-semibold">Margo Baker</span> <span
											class="media-annotation pull-right">12:16</span> </a>

								<span class="text-muted">That was something he was unable to do because...</span>
							</div>
						</li>

						<li class="media">
							<div class="media-left"><img src="<?= $webtheme ?>/assets/images/placeholder.jpg"
							                             class="img-circle img-sm" alt=""></div>
							<div class="media-body">
								<a href="#" class="media-heading"> <span class="text-semibold">Jeremy Victorino</span>
									<span class="media-annotation pull-right">22:48</span> </a>

								<span class="text-muted">But that would be extremely strained and suspicious...</span>
							</div>
						</li>

						<li class="media">
							<div class="media-left"><img src="<?= $webtheme ?>/assets/images/placeholder.jpg"
							                             class="img-circle img-sm" alt=""></div>
							<div class="media-body">
								<a href="#" class="media-heading"> <span class="text-semibold">Beatrix Diaz</span> <span
											class="media-annotation pull-right">Tue</span> </a>

								<span class="text-muted">What a strenuous career it is that I've chosen...</span>
							</div>
						</li>

						<li class="media">
							<div class="media-left"><img src="<?= $webtheme ?>/assets/images/placeholder.jpg"
							                             class="img-circle img-sm" alt=""></div>
							<div class="media-body">
								<a href="#" class="media-heading"> <span class="text-semibold">Richard Vango</span>
									<span class="media-annotation pull-right">Mon</span> </a>

								<span class="text-muted">Other travelling salesmen live a life of luxury...</span>
							</div>
						</li>
					</ul>

					<div class="dropdown-content-footer">
						<a href="#" data-popup="tooltip" title="All messages"><i
									class="icon-menu display-block"></i></a>
					</div>
				</div>
			</li>

			<li class="dropdown dropdown-user">
				<a class="dropdown-toggle" data-toggle="dropdown"> <img
							src="<?= $webtheme ?>/assets/images/placeholder.jpg" alt=""> <span>Victoria</span> <i
							class="caret"></i> </a>

				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
					<li><a href="#"><i class="icon-coins"></i> My balance</a></li>
					<li><a href="#"><span class="badge badge-warning pull-right">58</span> <i
									class="icon-comment-discussion"></i> Messages</a></li>
					<li class="divider"></li>
					<li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
					<li><a href="#"><i class="icon-switch2"></i> Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<!-- /main navbar -->

<!-- Page container -->
<div class="page-container">

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-default">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Horizontal
								Nav</span> - On Click</h4>
					</div>

					<div class="heading-elements hide">
						<div class="heading-btn-group">
							<a href="#" class="btn btn-link btn-float has-text"><i
										class="icon-bars-alt text-primary"></i><span>Statistics</span></a> <a
									href="#" class="btn btn-link btn-float has-text"><i
										class="icon-calculator text-primary"></i> <span>Invoices</span></a> <a
									href="#" class="btn btn-link btn-float has-text"><i
										class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
						</div>
					</div>
				</div>

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
						<li><a href="navigation_horizontal_click.html">Horizontal nav</a></li>
						<li class="active">On click</li>
					</ul>

					<ul class="breadcrumb-elements">
						<li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i
										class="icon-gear position-left"></i> Settings <span class="caret"></span> </a>

							<ul class="dropdown-menu dropdown-menu-right">
								<li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
								<li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
								<li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
								<li class="divider"></li>
								<li><a href="#"><i class="icon-gear"></i> All settings</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

                <?php echo $content; ?>

				<!-- Footer -->
				<div class="footer text-muted">
					&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a
							href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
				</div>
				<!-- /footer -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</div>
<!-- /page container -->

<?= Yii::$app->controller->renderPartial('@layouts/_footer.php'); ?>

</body>
</html>
