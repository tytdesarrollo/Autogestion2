<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
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
</head>

<body>
<?php $this->beginBody() ?>
<div class="menu-wrap">
	<nav class="menu">
		<div>
			<a href="#">Inicio</a>
			<a href="#">Equipo de nómina</a>
			<hr>
			<p class="fnt__Medium">Módulos</p>
			<a href="#">Certificado Laboral</a>
			<a href="#">Comprobantes de pago</a>
			<a href="#">Certificado de ingresos y retenciones</a>
			<a href="#">Vacaciones</a>
			<a href="#">Trabajo por turnos</a>
			<a href="#">Incapacidades</a>
			<hr>
			<p class="fnt__Medium">Información</p>
			<a href="#">Actualidad laboral</a>
			<a href="#">Cronograma cierre de nómina</a>
		</div>
	</nav>
	<button id="close-button" class="close-button"></button>
	<div class="morph-shape" id="morph-shape" data-morph-open="M-7.312,0H15c0,0,66,113.339,66,399.5C81,664.006,15,800,15,800H-7.312V0z;M-7.312,0H100c0,0,0,113.839,0,400c0,264.506,0,400,0,400H-7.312V0z">
		<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="5000" viewBox="0 0 100 800" preserveAspectRatio="none">
			<path d="M-7.312,0H0c0,0,0,113.839,0,400c0,264.506,0,400,0,400h-7.312V0z"/>
		</svg>
	</div>
</div>
<div class="wrap content">
		<nav class="navbar navbar-fixed-top">
			<div class="container-fluid">
				<div class="content__icon-menu__ham pull-left">
					<button id="open-button" class="icon-menu">
						<span class="glyphicon glyphicon-menu-hamburger icon__24" aria-hidden="true"></span>
					</button>
				</div>
				<div class="content__logo pull-left">
					<?= Html::img('@web/img/logo_small.svg', ['alt' => 'Auto Gestión Web', 'height' => '38px']) ?>
					<div style="margin-top: 10px;"><p>Mesa Centro de servicios compartidos.</p></div>
				</div>
				<div class="content__icon-menu__aux pull-right">
					<button id="menu-aux" class="icon-menu">
						<span class="glyphicon glyphicon-option-vertical icon__24" aria-hidden="true"></span>
					</button>
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

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script src="../web/js/classie.js"></script>
<script src="../web/js/menu.js"></script>
<script>
  $(function () {
    $.material.init();
  });
</script>
