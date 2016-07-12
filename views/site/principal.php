<?php
use yii\helpers\Html;
$this->title = 'Pagina Principal';

?>
<div id="tabbar" class="tab-bar">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#principal" data-toggle="tab">Principal</a></li>
		<li class="divider"><div class="ln"></div></li>
		<li><a href="#info" data-toggle="tab">Datos Personales</a></li>
	</ul>
</div>
<div id="TabContent" class="tab-content tab-content-main container">
	<div class="tab-pane fade active in" id="principal">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-news">
					<div class="panel-heading clearfix">
						<div class="pull-left fnt__Medium">Cierre de novedades:</div>
						<div class="pull-right fnt__Medium">05/05/2016</div>
					</div>
					<div class="panel-body">
						Las novedades se trasmiten por fuera de los límites establecidos en el cronográma de actividades de nómina, serán registradas para el pago de la nómina del mes siguiente.
					</div>
					<div class="panel-footer clearfix">
						<button class="btn btn-default btn-sm pull-right">Entendido</button>
					</div>
				</div>
				<div class="panel panel-vacaci">
					<div class="panel-heading">
						<h4 class="fnt__Medium">Agenda aquí tus vacaciones!</h4>
						<button type="button" class="btn btn-raised btn-float btn-amber"><i class="material-icons">&#xEB48;</i></button>
					</div>
					<div class="panel-body text-center">
						<div class="content-main-days">
							<div class="content-days bg-blue-A700 center-block">
								<p class="text-ini">Cuentas con</p>
								<span class="text-number">12</span>
								<p class="text-end">Días</p>
							</div>
						</div>
						<p class="text-desc">Prográmalas ahora!</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-certify text-center">
							<div class="panel-body">
								<div class="content-btn"><a href="#"><i class="material-icons">&#xE873;</i></a></div>
								<div>
									<h4 class="fnt__Medium">Certificado Laboral</h4>
									<div class="divider"></div>
									<p>Genera aquí de manera personalizada tus certificados laborales, los puedes descargar en formato PDF o enviarlos por correo electrónico.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel panel-danger panel-cert-ing text-center">
							<div class="panel-body">
								<div class="content-btn"><a href="#"><i class="material-icons">&#xE84F;</i></a></div>
								<div>
									<h4 class="fnt__Medium">Certificado de ingresos y retención</h4>
									<div class="divider"></div>
									<p>Genera tus certificados de ingreso y retención, selecciona el año que desees y descargalo.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel">
					<div class="panel-heading">
						<h4 class="fnt__Medium">Comprobantes de pago</h4>
						<small>Genera de manera personalizada tus comprobantes de pago.</small>
						<button type="button" class="btn btn-raised btn-float btn-blue-A700"><i class="material-icons">&#xE53E;</i></button>
					</div>
					<div class="panel-body">
						<table class="table table-widget-comp-pago table-striped table-hover mrg__top-30">
							<thead>
								<tr>
									<th> </th>
									<th>Column heading</th>
									<th>Column heading</th>
									<th>Column heading</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a href="#"><i class="material-icons">&#xE8F4;</i></a></td>
									<td>Column content</td>
									<td>Column content</td>
									<td>Column content</td>
								</tr>
								<tr>
									<td><a href="#"><i class="material-icons">&#xE8F4;</i></a></td>
									<td>Column content</td>
									<td>Column content</td>
									<td>Column content</td>
								</tr>
								<tr>
									<td><a href="#"><i class="material-icons">&#xE8F4;</i></a></td>
									<td>Column content</td>
									<td>Column content</td>
									<td>Column content</td>
								</tr>
							</tbody>
						</table>
						<div class="text-right "><small><em>*Últimos 3 comprobantes de pago.</em></small></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-turnos text-center">
							<div class="panel-heading">
								<?= Html::img('@web/img/turnos.jpg', ['alt' => 'Trabajo por turnos', 'class' => 'img-bg img-responsive']) ?>
							</div>
							<div class="panel-body">
								<button type="button" class="btn btn-raised btn-float btn-blue-A700"><i class="material-icons">&#xE856;</i></button>
								<h4 class="fnt__Medium">Te invitamos a registrar tus novedades</h4>
								<p>Este módulo permitirá optimizar el proceso de registro y transcripción de los reportes mensuales.</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel panel-incapacidades text-center">
							<div class="panel-body">
								<div class="content-btn"><a href="#"><i class="material-icons">&#xE3F3;</i></a></div>
								<div>
									<h4 class="fnt__Medium">Incapacidades</h4>
									<div class="divider"></div>
									<p>En esta herramienta únicamente debes registrar los días correspondientes a incapacidades, Licencias de Maternidad y Licencias de Paterninadad.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane fade" id="info">
		<div class="row">
			<div class="col-md-6">Datos Informativos</div>
			<div class="col-md-6">Info</div>
		</div>
	</div>
</div>
