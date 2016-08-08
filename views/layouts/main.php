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
<?php $this->beginBody() 
?>
<header id="header" class="clearfix">
	<nav id="menu" class="navbar">
		<div class="container-fluid bg-blue">
			<div class="content__icon-menu__ham pull-left">
				<!--<a href="#" id="trigger" class="menu-trigger glyphicon glyphicon-menu-hamburger icon__24">
					<div class="line-wrap">
						<div class="line top"></div>
						<div class="line center"></div>
						<div class="line bottom"></div>
					</div>
				</a>-->
				<a href="#" id="trigger" class="menu-trigger">
					<div class="line-wrap">
						<div class="line top"></div>
						<div class="line center"></div>
						<div class="line bottom"></div>
					</div>
				</a>
			</div>
			<div class="content__logo pull-left">
				<?= Html::img('@web/img/logo_small.svg', ['alt' => 'Auto Gestión Web', 'height' => '38px']) ?>
				<div class="hidden-xs" style="margin-top: 10px;"><p>Mesa Centro de servicios compartidos.</p></div>
			</div>
			<div class="content__icon-menu__aux pull-right">
				<div class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle menu-trigger"><i class="btn-menu-profile glyphicon glyphicon-option-vertical icon__24"></i></a>
					<ul class="dropdown-menu menu-profile">
						<li>
							<p class="txt-name fnt__Medium"><?= Yii::$app->user->identity->usuario ?></p>
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
							
							<div class="pull-right">
							<?= Html::beginForm(['/site/logout'],
							'post', 
							['class' => 'form-inline']); ?>
							<?= Html::submitButton('Salir',['class' => 'btn btn-raised btn-default btn-sm']) ?>
							<?= Html::endForm() ?>
								<!--<button class="btn btn-raised btn-default btn-sm">Salir</button>-->
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</nav>
</header>
<section class="scroller-inner">
	<aside class="mp-pusher" id="mp-pusher">
		<nav id="mp-menu" class="mp-menu">
			<div class="mp-level">
				<p></p>
				<ul>
					<li>
					<?= Html::a('<i class="material-icons">&#xE88A;</i><span>Inicio</span>', ['site/principal']) ?></li>
					<li>
					<?= Html::a('<i class="material-icons">&#xE7EF;</i><span>Equipo de nómina</span>', ['site/equiponomina']) ?></li>
					<li class="divider"></li>
					<li>
						<p class="category">Módulos</p>
					</li>
					<li>
					<?= Html::a('<i class="material-icons">&#xE873;</i><span>Certificado Laboral</span>', ['site/certificadolaboral']) ?></li>
					<li>
					<?= Html::a('<i class="material-icons">&#xE53E;</i><span>Comprobantes de pago</span>', ['site/comprobantespago']) ?></li>
					<li>
					<?= Html::a('<i class="material-icons">&#xE84F;</i><span>Certificado de ingresos y retención</span>', ['site/certificadosretencion']) ?></li>
					<li>
					<?= Html::a('<i class="material-icons">&#xEB48;</i><span>Vacaciones</span>', ['site/vacaciones']) ?></li>
					<li>
					<?= Html::a('<i class="material-icons">&#xE856;</i><span>Trabajo por turnos</span>', ['site/novedades']) ?></li>
					<li>
					<?= Html::a('<i class="material-icons">&#xE3F3;</i><span>Incapacidades</span>', ['site/incapacidades']) ?></li>					
					<li class="divider"></li>
					<li>
						<p class="category">Información</p>
					</li>
					<li>
					<?= Html::a('<i class="material-icons">&#xE801;</i><span>Actualidad laboral</span>', ['site/actualidadlaboral']) ?></li>	
					<li>
					<?= Html::a('<i class="material-icons">&#xE916;</i><span>Cronográma cierre de nómina</span>', ['site/cronogramanomina']) ?></li>	
				</ul>
			</div>
		</nav>
	</aside>
	<section id="content">
		<div class="fluid-container main-content">
			<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
			<?= $content ?>
		</div>
	</section>
</section>
<footer class="footer">
	<div class="container">
		<p class="pull-left">&copy; Auto Gestión <?= date('Y') ?></p>
		<p class="pull-right">Powered by <a href="http://www.talentsw.com/" target="_blank">Talentos & Tecnología</a></p>
	</div>
</footer>
<?php 
$this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<script>
  $(function () {
    $.material.init();
	$('[data-toggle="tooltip"]').tooltip();
	$(".slide-box-back .btn-toggle").click(function(){
	  $(".container-v").toggleClass("sld-in");
	});
	$("#help").modal("show");
  });
</script>
<script>
	new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger' ), {
		type : 'cover'
	} );
</script>
<script>
	$(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: '2016-06-12',
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				var title = prompt('Event Title:');
				var eventData;
				if (title) {
					eventData = {
						title: title,
						start: start,
						end: end
					};
					$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
				}
				$('#calendar').fullCalendar('unselect');
			},
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2016-06-01'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2016-06-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2016-06-16T16:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2016-06-13T07:00:00'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2016-06-28'
				}
			]
		});
		
	});

</script>
