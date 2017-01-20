<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Trabajo por Turnos';
?>

<div class="bg-turnos">

	<div class="container">
		<div class="block-header clearfix mrg__top-15">
			<div class="pull-right btn-group-sm">
				<!--<button type="button" class="btn btn-default btn-fab" data-toggle="modal" data-target="#record">
					<i class="material-icons">&#xE889;</i>
				</button>-->
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
										<li><a href="#tab1" data-toggle="tab">Solicitudes por empleado</a></li>
										<li class="divider"><div class="ln"></div></li>
										<li><a href="#tab2" data-toggle="tab">Solicitudes rechazadas</a></li>
										<li class="divider"><div class="ln"></div></li>
										<li class="active"><a href="#tab3" data-toggle="tab">Solicitudes por aprobar o rechazar</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="modal-body">
							<div id="tabsmodal" class="tab-content tab-content-main container">
								<div class="tab-pane fade in" id="tab1">
									<div class="heading">
										<h3 class="fnt__Medium">Historial solicitudes de horas extras</h3>
									</div>
									<div class="body">
										<div class="table-responsive">
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
								<div class="tab-pane fade in" id="tab2">
									<div class="heading">
										<h3 class="fnt__Medium">Solicitudes de empleados con horas extras rechazadas</h3>
									</div>
									<div class="body">
										<div class="table-responsive">
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
								<div class="tab-pane fade active in" id="tab3">
									<div class="heading">
										<h3 class="fnt__Medium">Solicitudes por aprobar o rechazar</h3>
									</div>
									<div class="body">
										<div class="table-responsive">
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
									<div class="table-responsive">
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
			</div>
			<div class="modal fade modal-help" id="help" tabindex="-1" role="dialog" aria-labelledby="helpLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="header-box">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h3 class="modal-title txt__light-100" id="helpLabel">Recuerda! </h3>
							</div>
						</div>
						<div class="modal-body">
							<h4 class="fnt__Medium txt__blue">Trabajo por turnos:</h4>
							<p>Este módulo permitirá optimizar el proceso de registro y transcripción de los reportes mensuales.</p>
							<p class=""> Es importante que el líder revise el registro y garantice la información suministrada.</p>
							<div class="box__blue-50 pdg__24">
								<p class="text-justify fnt__Medium">Se define <b>Turnos de Trabajo</b> cuando la naturaleza de la labor no exija actividad continua y se lleve a cabo por turnos de trabajadores, la duración de la jornada puede ampliarse en más de 8 horas diarias o en más de 48 horas semanales, siempre que el promedio de la horas de trabajo calculado para un periodo que no exceda de tres semanas, no pase de 8 horas diarias o de 48 a la semana. Esta ampliación no constituye trabajo suplementario o de horas extras.</p>
							</div>
							<p class="text-justify mrg__top-15">Si quieres consultar la política de la compañía respecto al tema, ingresa <span><a href="#">aquí</a></span></p>
							<hr class="mrg__top-30">
							<h4 class="fnt__Medium txt__blue">Si eres líder ten encuenta:</h4>
							<ul>
								<li class="fnt__Medium"><b>Importante validar las horas extras solicitadas de tus colaboradores.</b></li>
								<li><b>Verifica la programación de tu equipo de trabajo antes de la aprobación.</b></li>
								<li><b>Si consideras que un colaborador debe cambiar las fechas de programación, puedes marcarla como rechazada.</b></li>
								<li><b>Importante, Una vez aprobadas las horas extras, la herramienta no permite cambios en la programación.</b></li>
							</ul>
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
					<div class="info-item info-item-lft">
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
					<div class="info-item info-item-rgt" style="min-height: 388px;">
						<div class="bg-dark-54 text-center pdg__16">
							<h3 class="no-mrg">Historial horas extras</h3>
						</div>
						<div class="pdg__16">
							<table class="table">
								<thead>
									<tr>
										<th>Consecutivo</th>
										<th>Fecha solicitud</th>
										<th>Fecha horas extras</th>
										<th>Horas</th>
										<th>Concepto</th>
										<th>Estado</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>11001</td>
										<td>24-04-2016</td>
										<td>24-04-2016</td>
										<td>2</td>
										<td>Recargo nocturno ordinario</td>
										<td>Aprobado</td>
									</tr>
									<tr>
										<td>11002</td>
										<td>24-04-2016</td>
										<td>24-04-2016</td>
										<td>1</td>
										<td>Recargo nocturno ordinario</td>
										<td>Aprobado</td>
									</tr>
									<tr>
										<td>11003</td>
										<td>24-04-2016</td>
										<td>24-04-2016</td>
										<td>4</td>
										<td>Recargo nocturno ordinario</td>
										<td>Aprobado</td>
									</tr>
									<tr>
										<td>11004</td>
										<td>24-04-2016</td>
										<td>24-04-2016</td>
										<td>2</td>
										<td>Recargo nocturno ordinario</td>
										<td>Aprobado</td>
									</tr>
									<tr>
										<td>11005</td>
										<td>24-04-2016</td>
										<td>24-04-2016</td>
										<td>4</td>
										<td>Recargo nocturno ordinario</td>
										<td>Aprobado</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="content-slide">
					<div class="slide-box-back">
						<!--<button class="btn btn-toggle no-mrg"><div><i class="material-icons shake animated infinite">&#xE5C8;</i></div></button>-->
					</div>
					<div class="slide-box">
						<div class="slide-item calendar pdg__16">
							<!-- CALENDARIO -->
							<div id="calendar" class="col-centered"></div>
							<!-- Modal -->
							<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										
										<?php $form = ActiveForm::begin([
											'method' => 'POST',
											'options' => [
														'class' => 'form-horizontal'
													 ],
											'action' => ['site/addevent'],
										]);
										?>
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="myModalLabel">Solicitud de horas extras</h4>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<label for="title" class="col-sm-2 control-label">Titulo</label>
												<div class="col-sm-10">
													<input type="text" name="title" class="form-control" id="title" placeholder="Titulo">
												</div>
											</div>
											<div class="form-group select-m">
												<label for="color" class="col-sm-2 control-label">Color</label>
												<div class="col-sm-10">
													<div class="mad-select">
														<ul>
															<li data-value="0">Seleccione...</li>
															<li style="color:#0071c5;" data-value="1">Azul Oscuro</li>
															<li style="color:#40E0D0;" data-value="2">Turquesa</li>
															<li style="color:#008000;" data-value="3">Verde</li>
															<li style="color:#FFD700;" data-value="4">Amarillo</li>
															<li style="color:#FF8C00;" data-value="5">Naranja</li>
															<li style="color:#FF0000;" data-value="6">Rojo</li>
															<li style="color:#000;" data-value="7">Negro</li>
														</ul>
														<input type="hidden" id="color" name="color" value="0" class="form-control">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="start" class="col-sm-2 control-label">Hora Inicial</label>
												<div class="col-sm-10">
													<input type="text" name="start" class="form-control" id="start" readonly>
												</div>
											</div>
											<div class="form-group">
												<label for="end" class="col-sm-2 control-label">Hora Final</label>
												<div class="col-sm-10">
													<input type="text" name="end" class="form-control" id="end" readonly>
												</div>
											</div>
											<div class="form-group select-m">
												<label for="concepto" class="col-sm-2 control-label">Concepto</label>
												<div class="col-sm-10">
													<div class="mad-select">
														<ul>
															<li data-value="0">Seleccione...</li>
															<li data-value="1">Recargo nocturno ordinario - 1005</li>
															<li data-value="2">Horas extras diurnas - 1006</li>
															<li data-value="3">Horas extras nocturnas - 1007</li>
															<li data-value="4">Horas extras festiva diurna - 1008</li>
															<li data-value="5">Horas extras festiva nocturna - 1009</li>
															<li data-value="6">Recargo nocturno dominical/festivo - 1118</li>
															<li data-value="7">Recargo diurno dominical/festivo - 1119</li>
														</ul>
														<input type="hidden" id="concepto" name="concepto" value="0" class="form-control">
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar Solicitud</button>
											<button type="submit" class="btn btn-primary">Guardar Fecha</button>
										</div>
										<?php $form->end() ?>
									</div>
								</div>
							</div>
							<!-- Modal -->
							<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<?php $form = ActiveForm::begin([
											'method' => 'post',
											'options' => [
														'class' => 'form-horizontal'
													 ],
											'action' => ['controller/action'],											
										]);
										?>
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="myModalLabel">Desea eliminar esta solicitud?</h4>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<label>Realmente desea eliminar esta solicitud de vacaciones? recuerde que se le notificara al lider encargado.</label>
											</div>
											<input type="hidden" name="id" class="form-control" id="id">
											<input type="hidden" name="delete" class="form-control" id="delete">
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
											<button type="submit" class="btn btn-primary">Eliminar Solicitud</button>
										</div>
										<?php $form->end() ?>
									</div>
								</div>
							</div>
							<!-- /.CALENDARIO -->
						</div>
						<div class="slide-item detail pdg__16">
							<div class="text-center pdg__16">
								<h3 class="no-mrg fnt__Medium">Vacaciones solicitadas</h3>
							</div>
							<div class="table-responsive">
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
											<td>10</td>
											<td><div class="label-table label-success">Aprobado</div></td>
										</tr>
										<tr>
											<td>24-04-2016</td>
											<td>24-04-2016</td>
											<td>10</td>
											<td><div class="label-table label-success">Aprobado</div></td>
										</tr>
										<tr>
											<td>24-04-2016</td>
											<td>24-04-2016</td>
											<td>10</td>
											<td><div class="label-table label-success">Aprobado</div></td>
										</tr>
										<tr>
											<td>24-04-2016</td>
											<td>24-04-2016</td>
											<td>10</td>
											<td><div class="label-table label-success">Aprobado</div></td>
										</tr>
										<tr>
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
	</div>
</div>


