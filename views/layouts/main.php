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
				<h2></h2>
				<ul>
					<li><a href="#"><i class="material-icons">&#xE88A;</i><span>Inicio</span></a></li>
					<li><a href="#"><i class="material-icons">&#xE7EF;</i><span>Equipo de nómina</span></a></li>
					<li class="divider"></li>
					<li>
						<p class="category">Módulos</p>
					</li>
					<li><a href="#"><i class="material-icons">&#xE873;</i><span>Certificado Laboral</span></a></li>
					<li><a href="#"><i class="material-icons">&#xE53E;</i><span>Comprobantes de pago</span></a></li>
					<li class="icon icon-menu-left">
						<a href="#"><i class="material-icons">&#xE84F;</i><span>Certificado de ingresos y retención</span></a>
						<div class="mp-level">
								<h2>Certificado de ingresos y retención</h2>
							<a class="mp-back" href="#">Atrás</a>
							<ul>
								<li><a href="#">Email masivo</a></li>
								<li><a href="#">Descarga</a></li>
							</ul>
						</div>
					</li>
					<li class="icon icon-menu-left">
						<a href="#"><i class="material-icons">&#xEB48;</i><span>Vacaciones</span></a>
						<div class="mp-level">
							<h2>Vacaciones</h2>
							<a class="mp-back" href="#">Atrás</a>
							<ul>
								<li><a href="#">Historial solicitudes empleado</a></li>
								<li><a href="#">Historial solicitudes rechazadas</a></li>
								<li><a href="#">Solicitudes Empleado vaciones vigentes</a></li>
								<li><a href="#">Aprobar, editar, Rechazar solicitudes</a></li>
							</ul>
						</div>
					</li>
					<li><a href="#"><i class="material-icons">&#xE856;</i><span>Trabajo por turnos</span></a></li>
					<li><a href="#"><i class="material-icons">&#xE3F3;</i><span>incapacidades</span></a></li>
					<li class="divider"></li>
					<li>
						<p class="category">Información</p>
					</li>
					<li><a href="#"><i class="material-icons">&#xE801;</i><span>Actualidad laboral</span></a></li>
					<li><a href="#"><i class="material-icons">&#xE916;</i><span>Cronográma cierre de nómina</span></a></li>
				</ul>
			</div>
		</nav>
		<div class="scroller">
			<div class="scroller-inner content">
				<div id="menu-contenedor">
					<nav id="menu" class="navbar">
						<div class="container-fluid bg-blue">
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
				</div>
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
<script>
  $(function() {
  var menu = $('#menu');
  var contenedor = $('#menu-contenedor');
  var cont_offset = contenedor.offset().top;

  $('.scroller').on('scroll', function() {
	// alert($(window).scrollTop());
	if($('.scroller').scrollTop() > cont_offset) {
	  $( '.scroller-inner' ).addClass('fix');
	  $( menu ).addClass('is-fixed');
	} else {
	  $( menu ).removeClass('is-fixed');
	  $( '.scroller-inner' ).removeClass('fix');
	};
  });
});
</script>
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
