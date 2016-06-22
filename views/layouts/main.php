<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Dropdown;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<script src="../web/js/modernizr.custom.js"></script>
</head>

<body>
<?php $this->beginBody() ?>
<div class="main">
	<div class="mp-pusher" id="mp-pusher">
		<nav id="mp-menu" class="mp-menu">
			<div class="mp-level">
				<h2>Menu</h2>
				<ul>
					<li class="icon icon-menu-left">
						<a href="#">Level 1</a>
						<div class="mp-level">
							<h2>level 1</h2>
							<a class="mp-back" href="#">back</a>
							<ul>
								<li class="icon icon-menu-left">
									<a href="#">level 2</a>
									<div class="mp-level">
										<h2>Level 2</h2>
										<a class="mp-back" href="#">back</a>
										<ul>
											<li><a href="#">ítem 1</a></li>
											<li><a href="#">ítem 2</a></li>
											<li><a href="#">ítem 3</a></li>
											<li><a href="#">ítem 4</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</div>
					</li>
					<li><a href="#">ítem 1</a></li>
					<li><a href="#">ítem 2</a></li>
				</ul>
			</div>
		</nav>
		<div class="scroller">
			<div class="scroller-inner content">
					<nav class="navbar navbar-fixed-top">
						<div class="container-fluid">
							<div class="content__icon-menu__ham pull-left">
								<a href="#" id="trigger" class="menu-trigger glyphicon glyphicon-menu-hamburger icon__24"></a>
							</div>
							<div class="content__logo pull-left">
								<?= Html::img('@web/img/logo_small.svg', ['alt' => 'Auto Gestión Web', 'height' => '38px']) ?>
								<div style="margin-top: 10px;"><p>Mesa Centro de servicios compartidos.</p></div>
							</div>
							<div class="content__icon-menu__aux pull-right">
								<div class="dropdown">
									<a href="#" data-toggle="dropdown" class="dropdown-toggle menu-trigger glyphicon glyphicon-option-vertical icon__24"></a>
									<ul class="dropdown-menu menu-profile">
										<li>
											<p class="txt-name fnt__Medium">John Doe</p>
											<p class="txt-email">john.doe@hello.com</p>
										</li>
										<li class="divider"></li>
										<li>
											<p class="txt-cargo fnt__Medium">Profesional Nómina</p>
											<p class="txt-info">C.C. 52513735</p>
											<p class="txt-info">BOGOTÁ</p>
										</li>
										<li>
											<p class="txt-subcat fnt__Medium">Jefe Inmediato:</p>
											<p class="txt-info">Luis Alejandro Galindo Ramirez</p>
										</li>
										<li>
											<p class="txt-subcat fnt__Medium">Regional:</p>
											<p class="txt-info">Administración Central</p>
										</li>
										<li class="divider"></li>
										<li>
											<div class="pull-left">
											<button class="btn btn-raised btn-default btn-sm">Ver Perfil</button>
											</div>
											<div class="pull-right">
												<button class="btn btn-raised btn-default btn-sm">Salir</button>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</nav>

					<div class="container">
						<?= Breadcrumbs::widget([
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						]) ?>
						<?= $content ?>
					</div>
			</div>

			<footer class="footer">
				<div class="container">
					<p class="pull-left">&copy; Auto Gestión <?= date('Y') ?></p>

					<p class="pull-right">Powered by <a href="http://www.talentsw.com/" target="_blank">Talentos & Tecnología</a></p>
				</div>
			</footer>
		</div>
	</div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script>
  $(function () {
    $.material.init();
  });
</script>
<script>
	new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger' ), {
		type : 'cover'
	} );
</script>
