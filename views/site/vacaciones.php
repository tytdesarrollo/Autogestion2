<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Vacaciones';
?>
<?= Html::jsFile('@web/js/jquery.js') ?>
<style type="text/css">
	.loader {
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16px solid #3498db;
		width: 120px;
		height: 120px;
		-webkit-animation: spin 2s linear infinite; /* Safari */
		animation: spin 2s linear infinite;
	}

	/* Safari */
	@-webkit-keyframes spin {
	  	0% { -webkit-transform: rotate(0deg); }
	  	100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
	  	0% { transform: rotate(0deg); }
	  	100% { transform: rotate(360deg); }
	}
</style>
<div class="bg-vacaciones">

	<div class="container">
		<div class="block-header clearfix mrg__top-15">
			<div class="pull-right btn-group-sm btn-group-raised">
				<div class="cnt-help-noti dis-inline-block dropdown">
					<a href="#" class="dropdown-toggle btn btn-warning btn-fab" data-toggle="dropdown">
						<i class="material-icons">&#xE001;</i>
					</a>
					<ul class="dropdown-menu menu-profile">
						<p class="txt-name fnt__Medium text-center">Notificación Etiquetas</p>
						<li class="divider"></li>
						<li>
							<div class="dis-inline-block">
								<p class="mrg__bottom-5">Pendiente por aprobar</p>
							</div>
							<div class="dis-inline-block pull-right">
								<div class="help-noti gray"></div>
							</div>
						</li>
						<li>
							<div class="dis-inline-block">
								<p class="mrg__bottom-5">Aprobado</p>
							</div>
							<div class="dis-inline-block pull-right">
								<div class="help-noti green"></div>
							</div>
						</li>
						<li>
							<div class="dis-inline-block">
								<p class="mrg__bottom-5">Rechazado</p>
							</div>
							<div class="dis-inline-block pull-right">
								<div class="help-noti red"></div>
							</div>
						</li>
					</ul>
				</div>
				<?php if (is_array($vacasHistorial)): ?>
					<button type="button" class="btn btn-default btn-fab" data-toggle="modal" data-target="#record" onclick="cambioPestana(5)">
						<i class="material-icons">&#xE889;</i>
					</button>
				<?php endif ?>					
				<button type="button" class="btn btn-default btn-fab" data-toggle="modal" data-target="#help">
					<i class="material-icons">&#xE887;</i>
				</button>
			</div>
			<div class="modal fade modal-modtabs" id="modtabs" tabindex="-1" role="dialog" aria-labelledby="modtabsLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button id="closeModalId" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<div class="container">
								<div id="tabbar">
									<ul class="nav nav-tabs">
										<li class="active" onclick="cambioPestana(1)"><a href="#tab1" data-toggle="tab">Solicitudes por empleado</a></li>
										<li class="divider"><div class="ln"></div></li>
										<li onclick="cambioPestana(2)"><a href="#tab2" data-toggle="tab">Solicitudes rechazadas</a></li>
										<li class="divider"><div class="ln"></div></li>
										<li onclick="cambioPestana(3)"><a href="#tab3" data-toggle="tab">Solicitudes vacaciones vigentes</a></li>
										<li class="divider"><div class="ln"></div></li>
										<li onclick="cambioPestana(4)"><a href="#tab4" data-toggle="tab">Solicitudes por aprobar o rechazar</a></li>
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
										<div class="row">											
											<div class="form-inline">			
												<div class="pull-right">			
													<div class="form-group">													
														<input type="text" class="form-control" id="search1" placeholder="Filtro">
													</div>											
													<button onclick="searchClick(1)" class="btn btn-default">Buscar</button>
												</div>													
												<div div="col-6">
													<select id="cantidadXP1" class="form-control" style="width:120px">
														<option value="10">10 registros</option>
														<option value="20">20 registros</option>
														<option value="30">30 registros</option>
														<option value="40">40 registros</option>
														<option value="50">50 registros</option>
													</select>
												</div>
											</div>											
										</div>
										<div class="row">
							                <div class="col-sm-12 text-center">
							                    <ul class="pagination" id="paginationView1">
							                        <li id="liprimero1"><a href="#" id="primero1" onclick="clickFirst(1)">Primero</a></li>
							                        <li id="liback1"><a href="#" onclick="clickBack(1)">&laquo;</a></li>
							                        <li id="li11" class="active"><a href="#" id="p11" onclick="clickPage(1,1)">1</a></li>
							                        <li id="li21"><a href="#" id="p21" onclick="clickPage(2,1)">2</a></li>
							                        <li id="li31"><a href="#" id="p31" onclick="clickPage(3,1)">3</a></li>
							                        <li id="li41"><a href="#" id="p41" onclick="clickPage(4,1)">4</a></li>
							                        <li id="li51"><a href="#" id="p51" onclick="clickPage(5,1)">5</a></li>
							                        <li id="li61"><a href="#" id="p61" onclick="clickPage(6,1)">6</a></li>
							                        <li id="li71"><a href="#" id="p71" onclick="clickPage(7,1)">7</a></li>
							                        <li id="li81"><a href="#" id="p81" onclick="clickPage(8,1)">8</a></li>
							                        <li id="li91"><a href="#" id="p91" onclick="clickPage(9,1)">9</a></li>
							                        <li id="li101"><a href="#" id="p101" onclick="clickPage(10,1)">10</a></li>
							                        <li id="linext1"><a href="#" onclick="clickNext(1)">&raquo;</a></li>
							                        <li id="liultimo1"><a href="#" id="ultimo1" onclick="clickLast(1)">Ultimo</a></li>
							                    </ul>
							                </div>
							            </div>
										<div class="table-responsive">
											<div id="datosTabla1">
                                
                    						</div>   											
										</div>
									</div>
								</div>
								<div class="tab-pane fade in" id="tab2">
									<div class="heading">
										<h3 class="fnt__Medium">Historial solicitudes de vacaciones</h3>
									</div>
									<div class="body">
										<div class="row">											
											<div class="form-inline">			
												<div class="pull-right">			
													<div class="form-group">													
														<input type="text" class="form-control" id="search2" placeholder="Filtro">
													</div>											
													<button onclick="searchClick(2)" class="btn btn-default">Buscar</button>
												</div>													
												<div div="col-6">
													<select id="cantidadXP2" class="form-control" style="width:120px">
														<option value="10">10 registros</option>
														<option value="20">20 registros</option>
														<option value="30">30 registros</option>
														<option value="40">40 registros</option>
														<option value="50">50 registros</option>
													</select>
												</div>
											</div>											
										</div>
										<div class="row">
							                <div class="col-sm-12 text-center">
							                    <ul class="pagination" id="paginationView2">
							                        <li id="liprimero2"><a href="#" id="primero2" onclick="clickFirst(2)">Primero</a></li>
							                        <li id="liback2"><a href="#" onclick="clickBack(2)">&laquo;</a></li>
							                        <li id="li12" class="active"><a href="#" id="p12" onclick="clickPage(1,2)">1</a></li>
							                        <li id="li22"><a href="#" id="p22" onclick="clickPage(2,2)">2</a></li>
							                        <li id="li32"><a href="#" id="p32" onclick="clickPage(3,2)">3</a></li>
							                        <li id="li42"><a href="#" id="p42" onclick="clickPage(4,2)">4</a></li>
							                        <li id="li52"><a href="#" id="p52" onclick="clickPage(5,2)">5</a></li>
							                        <li id="li62"><a href="#" id="p62" onclick="clickPage(6,2)">6</a></li>
							                        <li id="li72"><a href="#" id="p72" onclick="clickPage(7,2)">7</a></li>
							                        <li id="li82"><a href="#" id="p82" onclick="clickPage(8,2)">8</a></li>
							                        <li id="li92"><a href="#" id="p92" onclick="clickPage(9,2)">9</a></li>
							                        <li id="li102"><a href="#" id="p102" onclick="clickPage(10,2)">10</a></li>
							                        <li id="linext2"><a href="#" onclick="clickNext(2)">&raquo;</a></li>
							                        <li id="liultimo2"><a href="#" id="ultimo2" onclick="clickLast(2)">Ultimo</a></li>
							                    </ul>
							                </div>
							            </div>
										<div class="table-responsive">
											<div id="datosTabla2">
                                
                    						</div>   											
										</div>
									</div>
								</div>
								<div class="tab-pane fade in" id="tab3">
									<div class="heading">
										<h3 class="fnt__Medium">Historial solicitudes de vacaciones</h3>
									</div>
									<div class="body">
										<div class="row">											
											<div class="form-inline">			
												<div class="pull-right">			
													<div class="form-group">													
														<input type="text" class="form-control" id="search3" placeholder="Filtro">
													</div>											
													<button onclick="searchClick(3)" class="btn btn-default">Buscar</button>
												</div>													
												<div div="col-6">
													<select id="cantidadXP3" class="form-control" style="width:120px">
														<option value="10">10 registros</option>
														<option value="20">20 registros</option>
														<option value="30">30 registros</option>
														<option value="40">40 registros</option>
														<option value="50">50 registros</option>
													</select>
												</div>
											</div>											
										</div>
										<div class="row">
							                <div class="col-sm-12 text-center">
							                    <ul class="pagination" id="paginationView3">
							                        <li id="liprimero3"><a href="#" id="primero3" onclick="clickFirst(3)">Primero</a></li>
							                        <li id="liback3"><a href="#" onclick="clickBack(3)">&laquo;</a></li>
							                        <li id="li13" class="active"><a href="#" id="p13" onclick="clickPage(1,3)">1</a></li>
							                        <li id="li23"><a href="#" id="p23" onclick="clickPage(2,3)">2</a></li>
							                        <li id="li33"><a href="#" id="p33" onclick="clickPage(3,3)">3</a></li>
							                        <li id="li43"><a href="#" id="p43" onclick="clickPage(4,3)">4</a></li>
							                        <li id="li53"><a href="#" id="p53" onclick="clickPage(5,3)">5</a></li>
							                        <li id="li63"><a href="#" id="p63" onclick="clickPage(6,3)">6</a></li>
							                        <li id="li73"><a href="#" id="p73" onclick="clickPage(7,3)">7</a></li>
							                        <li id="li83"><a href="#" id="p83" onclick="clickPage(8,3)">8</a></li>
							                        <li id="li93"><a href="#" id="p93" onclick="clickPage(9,3)">9</a></li>
							                        <li id="li103"><a href="#" id="p103" onclick="clickPage(10,3)">10</a></li>
							                        <li id="linext3"><a href="#" onclick="clickNext(3)">&raquo;</a></li>
							                        <li id="liultimo3"><a href="#" id="ultimo3" onclick="clickLast(3)">Ultimo</a></li>
							                    </ul>
							                </div>
							            </div>
										<div class="table-responsive">
											<div id="datosTabla3">
                                
                    						</div>   											
										</div>
									</div>
								</div>
								<div class="tab-pane fade in" id="tab4">
									<div class="heading">
										<h3 class="fnt__Medium">Solicitudes por aprobar o rechazar</h3>
									</div>
									<div class="body">		
										<div class="row">											
											<div class="form-inline">			
												<div class="pull-right">			
													<div class="form-group">													
														<input type="text" class="form-control" id="search4" placeholder="Filtro">
													</div>											
													<button onclick="searchClick(4)" class="btn btn-default">Buscar</button>
												</div>													
												<div div="col-6">
													<select id="cantidadXP4" class="form-control" style="width:120px">
														<option value="10">10 registros</option>
														<option value="20">20 registros</option>
														<option value="30">30 registros</option>
														<option value="40">40 registros</option>
														<option value="50">50 registros</option>
													</select>
												</div>
											</div>											
										</div>																			
										<div class="row">											
							                <div class="col-sm-12 text-center">
							                    <ul class="pagination" id="paginationView4">
							                        <li id="liprimero4"><a href="#" id="primero4" onclick="clickFirst(4)">Primero</a></li>
							                        <li id="liback4"><a href="#" onclick="clickBack(4)">&laquo;</a></li>
							                        <li id="li14" class="active"><a href="#" id="p13" onclick="clickPage(1,4)">1</a></li>
							                        <li id="li24"><a href="#" id="p24" onclick="clickPage(2,4)">2</a></li>
							                        <li id="li34"><a href="#" id="p34" onclick="clickPage(3,4)">3</a></li>
							                        <li id="li44"><a href="#" id="p44" onclick="clickPage(4,4)">4</a></li>
							                        <li id="li54"><a href="#" id="p54" onclick="clickPage(5,4)">5</a></li>
							                        <li id="li64"><a href="#" id="p64" onclick="clickPage(6,4)">6</a></li>
							                        <li id="li74"><a href="#" id="p74" onclick="clickPage(7,4)">7</a></li>
							                        <li id="li84"><a href="#" id="p84" onclick="clickPage(8,4)">8</a></li>
							                        <li id="li94"><a href="#" id="p94" onclick="clickPage(9,4)">9</a></li>
							                        <li id="li104"><a href="#" id="p104" onclick="clickPage(10,4)">10</a></li>
							                        <li id="linext4"><a href="#" onclick="clickNext(4)">&raquo;</a></li>
							                        <li id="liultimo4"><a href="#" id="ultimo4" onclick="clickLast(4)">Ultimo</a></li>
							                    </ul>
							                </div>
							            </div>							            					            
										<div class="table-responsive">
											<div id="datosTabla4">												
							                    					
                    						</div>   											
										</div>
										<div class="row">																					
											<button type="button" id="solicitudAceptar" class="btn pull-right" onclick="aceptarVacaciones()" disabled="true">Enviar solicitud</button>
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
									<div class="row">											
										<div class="form-inline">			
											<div class="pull-right">			
												<div class="form-group">													
													<input type="text" class="form-control" id="search5" placeholder="Filtro">
												</div>											
												<button onclick="searchClick(5)" class="btn btn-default">Buscar</button>
											</div>													
											<div div="col-6">
												<select id="cantidadXP5" class="form-control" style="width:120px">
													<option value="10">10 registros</option>
													<option value="20">20 registros</option>
													<option value="30">30 registros</option>
													<option value="40">40 registros</option>
													<option value="50">50 registros</option>
												</select>
											</div>
										</div>											
									</div>																			
									<div class="row">											
						                <div class="col-sm-12 text-center">
						                    <ul class="pagination" id="paginationView5">
						                        <li id="liprimero5"><a href="#" id="primero5" onclick="clickFirst(5)">Primero</a></li>
						                        <li id="liback5"><a href="#" onclick="clickBack(5)">&laquo;</a></li>
						                        <li id="li15" class="active"><a href="#" id="p13" onclick="clickPage(1,5)">1</a></li>
						                        <li id="li25"><a href="#" id="p25" onclick="clickPage(2,5)">2</a></li>
						                        <li id="li35"><a href="#" id="p35" onclick="clickPage(3,5)">3</a></li>
						                        <li id="li45"><a href="#" id="p45" onclick="clickPage(4,5)">4</a></li>
						                        <li id="li55"><a href="#" id="p55" onclick="clickPage(5,5)">5</a></li>
						                        <li id="li65"><a href="#" id="p65" onclick="clickPage(6,5)">6</a></li>
						                        <li id="li75"><a href="#" id="p75" onclick="clickPage(7,5)">7</a></li>
						                        <li id="li85"><a href="#" id="p85" onclick="clickPage(8,5)">8</a></li>
						                        <li id="li95"><a href="#" id="p95" onclick="clickPage(9,5)">9</a></li>
						                        <li id="li105"><a href="#" id="p105" onclick="clickPage(10,5)">10</a></li>
						                        <li id="linext5"><a href="#" onclick="clickNext(5)">&raquo;</a></li>
						                        <li id="liultimo5"><a href="#" id="ultimo5" onclick="clickLast(5)">Ultimo</a></li>
						                    </ul>
						                </div>
						            </div>							            					            
									<div class="table-responsive">
										<div id="datosTabla5">												
						                    			
                						</div>   											
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
								<h3 class="modal-title txt__light-100" id="helpLabel">Recuerda!!! </h3>
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
		<?php if (strcmp($autorizaciones,'TRUE') === 0): ?>
			<div class="cont-float-vac">
				<button id="openModalId" type="button" class="btn btn-raised btn-info" data-toggle="modal" data-target="#modtabs">
						<i class="material-icons">&#xE02F; </i>  Autorizaciones de empleados
				</button>
			</div>
		<?php endif ?>
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
										<?php if (is_array($vacasvigentes)): ?>
											<?php foreach ($vacasvigentes as $key1): ?>
												<tr>
													<td><?=$key1['FEC_INI_PERIODO']?></td>
													<td><?=$key1['FEC_FIN_PERIODO']?></td>
													<td><?=$key1['DIAS']?></td>
													<td>Pendiente</td>
												</tr>										
											<?php endforeach ?>
										<?php else: ?>
											<tr>
												<td>no hay dato</td>
												<td>no hay dato</td>
												<td>no hay dato</td>
												<td>no hay dato</td>
											</tr>
										<?php endif ?>
											
								</tbody>
							</table>
						</div>
						<div style="display:none;">
							<?= Html::img('@web/img/no_registros_vacaciones.png', ['alt' => 'No hay registros', 'class' => 'img-responsive']) ?>
						</div>
					</div>
					<div class="info-item text-center pdg__16">
						<div class="content-main-days">
							<div class="content-days bg-amber-A700 center-block">
								<p class="text-ini">Cuentas con</p>
								<span class="text-number"><?=$diaspedientes?></span>
								<p class="text-end">Días</p>
							</div>
						</div>
						<p class="text-desc">Para programar y disfrutar tus vacaciones.</p>
						<hr>
						<p>Tus posibles vacaciones serían</p>
						<p class="no-mrg"><strong>Desde: 16/05/2016</strong></p>
						<p class="no-mrg"><strong>Hasta: 31/05/2016</strong></p>
						<hr>
					</div>
				</div>
				<div class="content-slide">
					<div class="slide-box-back">
						<button class="btn btn-toggle no-mrg"><div><i class="material-icons shake animated infinite">&#xE5C8;</i></div></button>
					</div>
					<div class="slide-box">
						<div class="slide-item calendar pdg__16">
							<!-- CALENDARIO -->
							<div id="calendar" class="col-centered"></div>
							<!-- Modal -->
							<div class="modal fade modal-header-gray" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">	
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cerrarVacacionesV"><span aria-hidden="true">&times;</span></button>
											<h3 class="fnt__Medium">Solicitud de vacaciones</h3>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-sm-10 col-sm-offset-1">																										
													<div class="form-group mrg__top-15">
														<label for="start" class="control-label">Fecha Inicial</label>
														<input type="text" name="start" class="form-control" id="start" disabled>
													</div>
													
													<div class="form-group mrg__top-15">
													  
													  <label for="start" class="control-label">Seleccione Cantidad de Dias a Tomar </label>
														<p class="range-field"></br>
														  <div class="range-value"><span id="valor"> </span></div>
														  <input type="range" id="rango" class="slide-range" min="1" max="<?=$diaspedientes?>" value="1"/>
														  
														</p>
													</div>
													
													
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar Solicitud</button>
											<button type="submit" class="btn btn-primary" onclick="validarVacaciones()">Enviar Solicitud</button>
										</div>
									</div>
								</div>
							</div>
							<!-- Modal -->
							<div class="modal fade modal-header-gray" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<?php $form = ActiveForm::begin([
											'method' => 'post',
											'options' => [
														'class' => ''
													 ],
											'action' => ['controller/action'],											
										]);
										?>
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h3 class="fnt__Medium">Desea eliminar esta solicitud?</h3>
										</div>
										<div class="modal-body">
											<p>Realmente desea eliminar esta solicitud de vacaciones? recuerde que se le notificara al lider encargado.</p>
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
						<div class="slide-item detail">
							<div class="text-center pdg__16">
								<h3 class="no-mrg fnt__Medium">Ultimas 5 vacaciones solicitadas</h3>
							</div>
							<div class="table-responsive pdg__16">
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
										<?php  $limite = 1;?>
										<?php if (is_array($vacasHistorial)): ?>
											<?php foreach ($vacasHistorial as $key2): ?>											
													<tr>
														<td><?=$key2['FEC_INI']?></td>
														<td><?=$key2['FEC_FIN']?></td>
														<td><?=$key2['DIAS']?></td>
														<?php if (strcmp($key2['ESTADO'],"APROBADO") === 0): ?>
															<td><div class="label-table label-success">Aprobado</div></td>	
														<?php elseif (strcmp($key2['ESTADO'],"RECHAZADO") === 0): ?>
															<td><div class="label-table" style="background-color: #CB4335; color: #ffffff;">Rechazado</div></td>	
														<?php elseif (strcmp($key2['ESTADO'],"PENDIENTE") === 0): ?>
															<td><div class="label-table"  style="background-color: #808B96; color: #ffffff;">Pendiente</div></td>	
														<?php endif ?>
													</tr>				
													<?php if($limite++ >= 5):?>
														<?php break; ?>														
													<?php endif ?>
											<?php endforeach ?>
										<?php else: ?>
												<tr>
													<td>no hay dato</td>
													<td>no hay dato</td>
													<td>no hay dato</td>
													<td>no hay dato</td>
												</tr>
										<?php endif ?>
									</tbody>
								</table>
							</div>
							<div style="display:none;">
								<?= Html::img('@web/img/no_registros_vacaciones_1.png', ['alt' => 'No hay registros', 'class' => 'img-responsive']) ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->registerJsFile('@web/js/tablefunctionsvacas.js', ['depends' => 'yii\tingle\tinglePluginAsset'])?>
<?= $this->registerJsFile('@web/js/funcionesAjaxvacas.js', ['depends' => 'yii\tingle\tinglePluginAsset'])?>
<script>
//CONTADOR DE DIAS
var slider = document.getElementById("rango");
var output = document.getElementById("valor");
output.innerHTML = slider.value; 

slider.oninput = function() {
    output.innerHTML = this.value;
} 

//DEFINO UNA BANDERA PARA HEREDAR PROPIEDADES DEL CALENDARIO, 0 ES TURNOS Y 1 ES VACACIONES
var bandera = "1";
</script>
<script type="text/javascript">
	/*variables de la session*/
		var cedula = '<?=Yii::$app->session['cedula']?>';//'52513735';		
		var autorizaciones = '<?=Yii::$app->session['submenus'][1]?>';
	/**/

	/*Variables de las ejecuciones con ajax*/
		var aceptarSolicitudes = '<?php echo Url::toRoute(['site/aceptarsolicitudesvaca']);?>';
		var rechazarSolicitud = '<?php echo Url::toRoute(['site/rechazarsolicitudesvaca']);?>';		
		var editarSolicitud = '<?php echo Url::toRoute(['site/editarsolicitudvaca']); ?>';
		var validaVacacas = '<?php echo Url::toRoute(['site/validadvacaciones']); ?>';
		var pestana1 = '<?php echo Url::toRoute(['site/autorzacionvacap1']); ?>';
		var pestana2 = '<?php echo Url::toRoute(['site/autorzacionvacap2']); ?>';
		var pestana3 = '<?php echo Url::toRoute(['site/autorzacionvacap3']); ?>';
		var pestana4 = '<?php echo Url::toRoute(['site/autorzacionvacap4']); ?>';
		var pestana5 = '<?php echo Url::toRoute(['site/historialvacas']); ?>';
		var calculoFechas = '<?php echo Url::toRoute(['site/calculafecha']); ?>';
		var enviarvacaciones = '<?php echo Url::toRoute(['site/enviarsolicitudvacas']); ?>';
		var vacacionesRefresh = '<?php echo Url::toRoute(['site/vacaciones','refresh' => '1']); ?>';

	/**/	

	$(document).ready(function() {	
		//control de jefes o administradores
		if(autorizaciones.localeCompare("TRUE") == 0){
			$(cambioPestana(1));	
		}
	});
	
	function ejecute(id){
		var pagination = generalPage;
		var pageXp = $('select#cantidadXP'+id).val();
        //CODIGO PARA EJECUTAR CADA VEZ QUE CAMBIE DE PAGINA
        switch(id){
        	case 1:
        		//ejecuciones para solicitudes por empleado         		
        		solicitudesXepl(pagination, pageXp);
        		break;
        	case 2:
				solicitudesXep2(pagination, pageXp);
				break;
			case 3:
				solicitudesXep3(pagination, pageXp);
				break;
			case 4:
				solicitudesXep4(pagination, pageXp);
				break;
			case 5:
				historialVacaciones(pagination, pageXp);
				break;
        }
	}

	function cambioPestana(id, filtro = 10){		
		switch(id){
			case 1:				
				limpiaFiltros(1); 			reiniciarToggle();
				solicitudesXepl(1,filtro);	setGeneralValuesDefault(id);				
				break;
			case 2:
				limpiaFiltros(2);			reiniciarToggle();
				solicitudesXep2(1,filtro);  setGeneralValuesDefault(id);
				break;
			case 3:
				limpiaFiltros(3);			reiniciarToggle();
				solicitudesXep3(1,filtro);	setGeneralValuesDefault(id);
				break;
			case 4:
				limpiaFiltros(4);			reiniciarToggle();
				solicitudesXep4(1,filtro);	setGeneralValuesDefault(id);
				break;
			case 5:
				limpiaFiltros(5);				reiniciarToggle();
				historialVacaciones(1,filtro);	setGeneralValuesDefault(id);
				break;

		}
	}
    

    function searchClick(id){
    	switch(id){
			case 1:
				cambioPestana(id,$("#cantidadXP1").val());
				break;
			case 2:
				cambioPestana(id,$("#cantidadXP2").val());
				break;
			case 3:
				cambioPestana(id,$("#cantidadXP3").val());
				break;
			case 4:
				cambioPestana(id,$("#cantidadXP4").val());
				break;
			case 5:
				cambioPestana(id,$("#cantidadXP5").val());
				break;
		}    	
    }

    function limpiaFiltros(id){
    	//recorre todos los filtros y los limpia
    	for(var i=1 ; i<=6 ; i++){
    		//si es el id ingresado no entra
    		if(i != id){   			
    			//id del buscador y de la cantidad
    			var idJquery1 = "#search"+i;
    			var idJquery2 = "#cantidadXP"+i;
    			//camia el valor del buscador y de la cantidad
    			$(idJquery1).val(''); 
    			$(idJquery2).val('10');
    		}
    	}   

    	setOrder(id);     	
    }   


    $("#cantidadXP1").change(function(event) {
		cambioPestana(1,$(this).val());
	});

	$("#cantidadXP2").change(function(event) {
		cambioPestana(2,$(this).val());
	});

	$("#cantidadXP3").change(function(event) {
		cambioPestana(3,$(this).val());
	});

	$("#cantidadXP4").change(function(event) {
		cambioPestana(4,$(this).val());
	});	

	$("#cantidadXP5").change(function(event) {
		cambioPestana(5,$(this).val());
	});	


	function modalVacaciones(fechaIni,fechaFin,dias){
		$('#ModalAdd #start').val(fechaIni);
		$('#rango').val(dias);
		$('#valor').html(dias);
		$('#ModalAdd').modal('show');
	}

</script>