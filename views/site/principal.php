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
						<?= Html::a('<i class="material-icons">&#xEB48;</i>', ['site/vacaciones'], ['class'=>'btn btn-raised btn-float btn-amber']) ?>
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
								<div class="content-btn">
								<?= Html::a('<i class="material-icons">&#xE873;</i>', ['site/certificadolaboral']) ?></div>
								<div>
									<h4 class="fnt__Medium">Certificado Laboral</h4>
									<div class="divider"></div>
									<p>Genera aquí de manera personalizada tus certificados laborales, los puedes descargar en formato PDF o enviarlos por correo electrónico.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel panel-cert-ing text-center">
							<div class="panel-body">
								<div class="content-btn"><?= Html::a('<i class="material-icons">&#xE84F;</i>', ['site/certificadosretencion']) ?></div>
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
						<?= Html::a('<i class="material-icons">&#xE53E;</i>', ['site/comprobantespago'], ['class'=>'btn btn-raised btn-float btn-blue-A700']) ?>						
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
							<?= Html::a('<i class="material-icons">&#xE856;</i>', ['site/novedades'], ['class'=>'btn btn-raised btn-float btn-blue-A700']) ?>
								<h4 class="fnt__Medium">Te invitamos a registrar tus novedades</h4>
								<p>Este módulo permitirá optimizar el proceso de registro y transcripción de los reportes mensuales.</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel panel-incapacidades text-center">
							<div class="panel-body">
								<div class="content-btn">
								<?= Html::a('<i class="material-icons">&#xE3F3;</i>', ['site/incapacidades']) ?>
								</div>
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
		<div class="block-header">
			<h2>John Doe<small>Jefe Nómina</small></h2>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="panel bg-blue-std widget-extrasmall-htl">
					<div class="panel-body">
						<div class="dis-inline-block">
							<h5 class="fnt__Medium no-mrg">Tipo de salario:</h5>
							<h3 class="fnt__Medium no-mrg">Básico</h3>
						</div>
						<i class="material-icons">&#xE227;</i>
					</div>
				</div>
				<div class="panel bg-cyan-std widget-extrasmall-htl">
					<div class="panel-body">
						<div class="dis-inline-block">
							<h5 class="fnt__Medium no-mrg">Tipo de contrato:</h5>
							<h3 class="fnt__Medium no-mrg">Indefinido</h3>
						</div>
						<i class="material-icons">&#xE880;</i>
					</div>
				</div>
				<div class="panel bg-teal-std widget-extrasmall-htl">
					<div class="panel-body">
						<div class="dis-inline-block">
							<h5 class="fnt__Medium no-mrg">Fecha de ingreso:</h5>
							<h3 class="fnt__Medium no-mrg">17-09-2014</h3>
						</div>
						<i class="material-icons">&#xE8DF;</i>
					</div>
				</div>
				<div class="panel panel-contact">
					<div class="panel-body">
						<h2 class="fnt__Medium">Datos Personales</h2>
						<ul>
							<li><i class="material-icons">&#xE0BE;</i>john.doe@hello.com</li>
							<li><i class="material-icons">&#xE86D;</i>C.C. 52513735</li>
							<li><i class="material-icons">&#xE0C8;</i>BOGOTÁ</li>
						</ul>
						<div class="mrg__top-15">
							<h5 class="fnt__Medium no-mrg-bottom">Jefe inmediato:</h5>
							<p>Luis Alejandro Galindo Ramirez</p>
						</div>
						<div class="mrg__top-15">
							<h5 class="fnt__Medium no-mrg-bottom">Regional:</h5>
							<p>Administración Central</p>
						</div>
					</div>
				</div>
				<div class="panel panel-contact">
					<div class="panel-body">
						<h2 class="fnt__Medium">Datos Informativos</h2>
						<table class="table table-no-border">
							<tbody>
								<tr>
									<td class="fnt__Medium">Declarante de renta</td>
									<td>Si</td>
								</tr>
								<tr>
									<td class="fnt__Medium">Procedimiento retención en la fuente</td>
									<td>2</td>
								</tr>
								<tr>
									<td class="fnt__Medium">Porcentaje de retención</td>
									<td>2.92</td>
								</tr>
								<tr>
									<td class="fnt__Medium">Cuota máxima disponible de descuento</td>
									<td>0</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-7">
						<div class="panel">
							<div class="panel-heading">
								<h4 class="fnt__Medium">Cuenta bancaria</h4>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Entidad bancaria</th>
												<th>Número de cuenta</th>
												<th>Tipo de cuenta</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Banco BBVA</td>
												<td>765006192</td>
												<td>ahorros</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="panel widget-small-htl">
							<div class="row">
								<div class="col-xs-4 text-center bg-lightblue-std">
									<button type="button" class="btn" data-toggle="modal" data-target="#formNovedades">
										<i class="material-icons">&#xE7F7;</i>
									</button>
								</div>
								<div class="col-xs-8">
									<div class="panel-body">
										<h4 class="fnt__Medium">Novedades</h4>
										<p>Reporta novedades para Pensión voluntaria y AFC, cambio de cuenta de nómina, declarante de renta y reporte paz y salvo libranzas.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="formNovedades" tabindex="-1" role="dialog" aria-labelledby="formNovedadesLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="formNovedadesLabel">Modal title</h4>
								</div>
								<div class="modal-body">
									...
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel">
					<div class="panel-heading">
						<h4 class="fnt__Medium">Afiliaciones - Seguridad social</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Concepto</th>
										<th>Entidad</th>
										<th>Fecha vinculación</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Aporte salud</td>
										<td>Coomeva EPS</td>
										<td>17-09-2014</td>
									</tr>
									<tr>
										<td>Aporte pensión</td>
										<td>Protección pensiones Obligator</td>
										<td>01-06-2015</td>
									</tr>
									<tr>
										<td>Aporte riesgos laborales</td>
										<td>Colmena riesgos profesionales</td>
										<td>17-09-2014</td>
									</tr>
									<tr>
										<td>Caja de compensación</td>
										<td>Cafam</td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="panel">
					<div class="panel-heading">
						<h4 class="fnt__Medium">Deducibles de retención en la fuente</h4>
					</div>
					<div class="panel-body">
						<h5 class="fnt__Medium">Pensiones voluntarias y AFC(cuenta de ahorro para vivienda)</h5>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Concepto</th>
										<th>Entidad</th>
										<th>Aporte actual</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Pensión vol / AFC - bonif.unica y ext.</td>
										<td>Fdo pensiones voluntarias prot</td>
										<td>$8,000,000</td>
									</tr>
									<tr>
										<td>pensiones voluntarias</td>
										<td>Fdo pensiones voluntarias prot</td>
										<td>$2,000,000</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="panel">
					<div class="panel-heading">
						<h4 class="fnt__Medium">Certificados de beneficio</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Tipo</th>
										<th>Valor mensual</th>
										<th>Fecha de vencimiento</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Intereses de Vivienda</td>
										<td>$ 435,451</td>
										<td>31-03-2016</td>
									</tr>
									<tr>
										<td>Salud Prepagada</td>
										<td>$ 61,950</td>
										<td>31-03-2016</td>
									</tr>
									<tr>
										<td>Dependientes</td>
										<td>$ 600,000</td>
										<td>31-03-2016</td>
									</tr>
									<tr>
										<td>Salud Obligatoria</td>
										<td>$ 165,394</td>
										<td>31-12-2016</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="content__help">
					<h3 class="fnt__Medium">Ayuda</h3>
					<div class="col-md-4">
						<ul>
							<li><a href="#">Pensiones voluntarias</a></li>
							<li><a href="#">Cuentas AFC</a></li>
							<li><a href="#">Bancos</a></li>
							<li><a href="#">Deducibles de retención en la fuente</a></li>
							<li><a href="#">Horas extra</a></li>
						</ul>
					</div>
					<div class="col-md-4">
						<ul>
							<li><a href="#">EPS entidad promotora de salud</a></li>
							<li><a href="#">Pensiones</a></li>
							<li><a href="#">ARL</a></li>
							<li><a href="#">Incapacidades</a></li>
							<li><a href="#">Retiro de sesantías</a></li>
						</ul>
					</div>
					<div class="col-md-4">
						<ul>
							<li><a href="#">Caja de compensación y subsidio familiar</a></li>
							<li><a href="#">Seguro de vida</a></li>
							<li><a href="#">Plan global de acciones</a></li>
							<li><a href="#">Libranzas</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
