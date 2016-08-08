<?php
use yii\helpers\Html;
$this->title = 'Vacaciones';
?>
<div class="bg-vacaciones">
	<div class="container">
		<div class="block-header clearfix mrg__top-15">
			<div class="pull-right btn-group-sm">
				<!--<button type="button" class="btn btn-default btn-fab" data-toggle="modal" data-target="#modtabs">
					<i class="material-icons">&#xE02F;</i>
				</button>-->
				<button type="button" class="btn btn-default btn-fab" data-toggle="modal" data-target="#record">
					<i class="material-icons">&#xE889;</i>
				</button>
				<button type="button" class="btn btn-default btn-fab" data-toggle="modal" data-target="#help">
					<i class="material-icons">&#xE887;</i>
				</button>
			</div>
			<div class="modal fade modal-modtabs" id="modtabs" tabindex="-1" role="dialog" aria-labelledby="modtabsLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<div class="container">
								<div id="tabbar">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#tab1" data-toggle="tab">Solicitudes por empleado</a></li>
										<li class="divider"><div class="ln"></div></li>
										<li><a href="#tab2" data-toggle="tab">Solicitudes rechazadas</a></li>
										<li class="divider"><div class="ln"></div></li>
										<li><a href="#tab3" data-toggle="tab">Solicitudes vacaciones vigentes</a></li>
										<li class="divider"><div class="ln"></div></li>
										<li><a href="#tab4" data-toggle="tab">Solicitudes por aprobar o rechazar</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="modal-body">
							<div id="tabsmodal" class="tab-content tab-content-main container">
								<div class="tab-pane fade active in" id="tab1">
									<div class="heading">
										<h3 class="fnt__Medium">Historial solicitudes de vacaciones</h3>
									</div>
									<div class="body">
										<table class="table">
											<thead>
												<tr>
													<th>Consecutivo</th>
													<th>Fecha solicitud</th>
													<th>Fecha inicio</th>
													<th>Fecha fin</th>
													<th>Días hábiles</th>
													<th>Estado</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>00001</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00002</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00003</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00004</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00005</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade in" id="tab2">
									<div class="heading">
										<h3 class="fnt__Medium">Historial solicitudes de vacaciones</h3>
									</div>
									<div class="body">
										<table class="table">
											<thead>
												<tr>
													<th>Consecutivo</th>
													<th>Fecha solicitud</th>
													<th>Fecha inicio</th>
													<th>Fecha fin</th>
													<th>Días hábiles</th>
													<th>Estado</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>00001</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00002</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00003</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00004</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00005</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade in" id="tab3">
									<div class="heading">
										<h3 class="fnt__Medium">Historial solicitudes de vacaciones</h3>
									</div>
									<div class="body">
										<table class="table">
											<thead>
												<tr>
													<th>Consecutivo</th>
													<th>Fecha solicitud</th>
													<th>Fecha inicio</th>
													<th>Fecha fin</th>
													<th>Días hábiles</th>
													<th>Estado</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>00001</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00002</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00003</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00004</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
												<tr>
													<td>00005</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td><div class="label-table label-success">Aprobado</div></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade in" id="tab4">
									<div class="heading">
										<h3 class="fnt__Medium">Solicitudes por aprobar o rechazar</h3>
									</div>
									<div class="body">
										<table class="table">
											<thead>
												<tr>
													<th>Consec</th>
													<th>Código</th>
													<th>Cédula</th>
													<th>Nombres y apellidos</th>
													<th>Área</th>
													<th>Cargo</th>
													<th>Fecha inicial</th>
													<th>Fecha final</th>
													<th>Fecha solicitud</th>
													<th>Días hábiles</th>
													<th>Aceptar</th>
													<th>Rechazar</th>
													<th>Comentario rechazo</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>00001</td>
													<td>12345678</td>
													<td>12345678</td>
													<td>John Doe</td>
													<td>Gerencia</td>
													<td>Jefe nómina</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td>
														<div class="togglebutton">
															<label>
																<input type="checkbox" checked>
															</label>
														</div>
													</td>
													<td>
														<button type="button" class="btn btn-table btn-danger">
															<i class="material-icons">&#xE15C;</i>
														</button>
													</td>
													<td><input class="input-table" type="text"></td>
												</tr>
												<tr>
													<td>00002</td>
													<td>12345678</td>
													<td>12345678</td>
													<td>John Doe</td>
													<td>Gerencia</td>
													<td>Jefe nómina</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td>
														<div class="togglebutton">
															<label>
																<input type="checkbox">
															</label>
														</div>
													</td>
													<td>
														<button type="button" class="btn btn-table btn-danger">
															<i class="material-icons">&#xE15C;</i>
														</button>
													</td>
													<td><input class="input-table" type="text"></td>
												</tr>
												<tr>
													<td>00003</td>
													<td>12345678</td>
													<td>12345678</td>
													<td>John Doe</td>
													<td>Gerencia</td>
													<td>Jefe nómina</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td>
														<div class="togglebutton">
															<label>
																<input type="checkbox">
															</label>
														</div>
													</td>
													<td>
														<button type="button" class="btn btn-table btn-danger">
															<i class="material-icons">&#xE15C;</i>
														</button>
													</td>
													<td><input class="input-table" type="text"></td>
												</tr>
												<tr>
													<td>00004</td>
													<td>12345678</td>
													<td>12345678</td>
													<td>John Doe</td>
													<td>Gerencia</td>
													<td>Jefe nómina</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td>
														<div class="togglebutton">
															<label>
																<input type="checkbox">
															</label>
														</div>
													</td>
													<td>
														<button type="button" class="btn btn-table btn-danger">
															<i class="material-icons">&#xE15C;</i>
														</button>
													</td>
													<td><input class="input-table" type="text"></td>
												</tr>
												<tr>
													<td>00005</td>
													<td>12345678</td>
													<td>12345678</td>
													<td>John Doe</td>
													<td>Gerencia</td>
													<td>Jefe nómina</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>24-04-2016</td>
													<td>10</td>
													<td>
														<div class="togglebutton">
															<label>
																<input type="checkbox">
															</label>
														</div>
													</td>
													<td>
														<button type="button" class="btn btn-table btn-danger">
															<i class="material-icons">&#xE15C;</i>
														</button>
													</td>
													<td><input class="input-table" type="text"></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade modal-record" id="record" tabindex="-1" role="dialog" aria-labelledby="recordLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							<div class="container">
								<div class="heading">
									<h3 class="fnt__Medium">Historial solicitudes de vacaciones</h3>
								</div>
								<div class="body">
									<table class="table">
										<thead>
											<tr>
												<th>Consecutivo</th>
												<th>Fecha solicitud</th>
												<th>Fecha inicio</th>
												<th>Fecha fin</th>
												<th>Días hábiles</th>
												<th>Estado</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>00001</td>
												<td>24-04-2016</td>
												<td>24-04-2016</td>
												<td>24-04-2016</td>
												<td>10</td>
												<td><div class="label-table label-success">Aprobado</div></td>
											</tr>
											<tr>
												<td>00002</td>
												<td>24-04-2016</td>
												<td>24-04-2016</td>
												<td>24-04-2016</td>
												<td>10</td>
												<td><div class="label-table label-success">Aprobado</div></td>
											</tr>
											<tr>
												<td>00003</td>
												<td>24-04-2016</td>
												<td>24-04-2016</td>
												<td>24-04-2016</td>
												<td>10</td>
												<td><div class="label-table label-success">Aprobado</div></td>
											</tr>
											<tr>
												<td>00004</td>
												<td>24-04-2016</td>
												<td>24-04-2016</td>
												<td>24-04-2016</td>
												<td>10</td>
												<td><div class="label-table label-success">Aprobado</div></td>
											</tr>
											<tr>
												<td>00005</td>
												<td>24-04-2016</td>
												<td>24-04-2016</td>
												<td>24-04-2016</td>
												<td>10</td>
												<td><div class="label-table label-success">Aprobado</div></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade modal-help" id="help" tabindex="-1" role="dialog" aria-labelledby="helpLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="header-box">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h3 class="modal-title txt__light-100" id="helpLabel">Recuerda!!!</h3>
							</div>
						</div>
						<div class="modal-body">
							<p>En esta herramienta únicamente debes registrar los días de vacaciones hábiles que vas a disfrutar.</p>
							<p class="mrg__top-30">Ten en cuenta lo siguiente al momento de solicitar tus vacaciones:</p>
							<h4 class="fnt__Medium txt__blue mrg__top-15">Programación de Vacaciones:</h4>
							<p class="text-justify">Para realizar la programación de tus vacaciones debes reunirte con tu jefe y definir los días que disfrutarás, esta programación debe ser registrada antes del inicio de tus vacaciones, teniendo en cuenta las fechas de <em><strong>cronograma cierres novedades de nómina</strong></em>. Únicamente debes registrar los días de vacaciones hábiles que vas a disfrutar.</p>
							<h4 class="fnt__Medium txt__blue mrg__top-30">Las vacaciones se pagan de acuerdo al mes de disfrute, no se adelanta pago del mes siguiente:</h4>
							<p class="text-justify">Si tu periodo de vacaciones va del <strong>15-06-2013</strong> al <strong>15-07-2013</strong> y tu solicitud fue registrada antes del cierre de nómina de Junio, en ese mes recibirás el pago de tu salario del <strong>01-06-2013</strong> al <strong>14-06-2013</strong> y los días de vacaciones del <strong>15-06-2013</strong> al <strong>30-06-2013</strong>; el resto de tus vacaciones (<strong>01-07-2013</strong> al <strong>15-07-2013</strong>) serán pagadas en el mes de Julio, más los días laborales que restan del mes de Julio (<strong>16-07-2013</strong> al <strong>30-07-2013</strong>).</p>
							<div class="box__blue-50 pdg__24">
								<h3 class="fnt__Medium txt__blue-A700 no-mrg">Beneficios Uno para tus vacaciones</h3>
								<h4 class="fnt__Medium mrg__top-30">Beneficio UNO 15 = 17:</h4>
								<p class="text-justify">Consiste en recibir 2 días adicionales por programar y disfrutar mínimo un periodo completo de vacaciones (<strong>15 días</strong>). Programa tu beneficio <span><a href="#">aquí</a></span> y <span><a href="#">prográmalo</a></span>.</p>
								<h4 class="fnt__Medium mrg__top-30">Beneficio UNO 8 es mejor:</h4>
								<p class="text-justify">Consiste en recibir 1 día adicional por programar 7 días de vacaciones. Programa tu beneficio <span><a href="#">aquí</a></span> y <span><a href="#">prográmalo</a></span>.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="cont-float-vac">
			<button type="button" class="btn btn-raised btn-info" data-toggle="modal" data-target="#modtabs">
					<i class="material-icons">&#xE02F; </i>  Autorizaciones de empleados
			</button>
		</div>
		<div class="container-v">
			<div class="box"></div>
			<div class="content">
				<div class="content-info clearfix">
					<div class="info-item">
						<div class="bg-dark-54 text-center pdg__16">
							<h3 class="no-mrg">Vacaciones vigentes</h3>
						</div>
						<div class="pdg__16">
							<table class="table">
								<thead>
									<tr>
										<th>Fecha inicio</th>
										<th>Fecha fin</th>
										<th>Días hábiles</th>
										<th>Estado</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>24-04-2016</td>
										<td>24-04-2016</td>
										<td>7</td>
										<td>Pendiente</td>
									</tr>
									<tr>
										<td>24-04-2016</td>
										<td>24-04-2016</td>
										<td>5</td>
										<td>Pendiente</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="info-item text-center pdg__16">
						<div class="content-main-days">
							<div class="content-days bg-amber-A700 center-block">
								<p class="text-ini">Cuentas con</p>
								<span class="text-number">12</span>
								<p class="text-end">Días</p>
							</div>
						</div>
						<p class="text-desc">Para programar y disfrutar tus vacaciones.</p>
						<hr>
						<p>Tus posibles vacaciones serían</p>
						<p class="no-mrg"><strong>Desde: 16/05/2016</strong></p>
						<p class="no-mrg"><strong>Hasta: 31/05/2016</strong></p>
						<hr>
						<button class="btn btn-default no-mrg">Cambiar fecha</button>
					</div>
				</div>
				<div class="content-slide">
					<div class="slide-box-back">
						<button class="btn btn-toggle no-mrg"><i class="material-icons shake animated infinite">&#xE5C8;</i></button>
					</div>
					<div class="slide-box">
						<div class="slide-item calendar pdg__16">
							<div id='calendar'></div>
						</div>
						<div class="slide-item detail pdg__16">
							<h4>contenido pendiente</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
