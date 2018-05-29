<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Trabajo por Turnos';

?>

<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/tingle.min.js') ?>
<?= Html::jsFile('@web/js/tablefunctionsturnos.js') ?>
<?= Html::jsFile('@web/js/funcionesAjaxturnos.js') ?>

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
<div class="bg-turnos">

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
								<p class="mrg__bottom-5">Pendiente por aprobar gerente</p>
							</div>
							<div class="dis-inline-block pull-right">
								<div class="help-noti blue"></div>
							</div>
						</li>
						<li class="divider"></li>
						<li>
							<div class="dis-inline-block">
								<p class="mrg__bottom-5">Pendiente por aprobar jefe</p>
							</div>
							<div class="dis-inline-block pull-right">
								<div class="help-noti gray"></div>
							</div>
						</li>
						<li class="divider"></li>
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
				<button type="button" class="btn btn-default btn-fab" data-toggle="modal" data-target="#help">
					<i class="material-icons">&#xE887;</i>
				</button>
			</div>
			<div class="modal fade modal-modtabs" id="modtabs" tabindex="-1" role="dialog" aria-labelledby="modtabsLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">		
						<?php if ($gerente === 'TRUE'): ?>
						<!--TAB BAR DE JEFES Y GGERENTES -->	
							<div id="tabbar" class="">
								<ul class="nav nav-tabs">
									<li class="active" onClick="JefeGrente('JEFE')">
										<a href="#jefe" data-toggle="tab">JEFE</a>
									</li>
									<li class="divider">
										<div class="ln"></div>
									</li>
									<li onClick="JefeGrente('GERENTE')">
										<a href="#gerente" data-toggle="tab">GERENTE</a>
									</li>
								</ul>
							</div>							
						<!--DATOS DEL TAB JEFE-->	
							<div class="tab-pane fade active in" id="jefe">
								<div class="modal-header">
									<button id="closeModalId" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<div class="container">
										<div id="tabbar">
											<ul class="nav nav-tabs">
												<li onclick="cambioPestana(1)" class="active"  id="tabPestana1"><a href="#tab1" data-toggle="tab">Solicitudes por empleado</a></li>
												<li class="divider"><div class="ln"></div></li>
												<li onclick="cambioPestana(2)" id="tabPestana2"><a href="#tab2" data-toggle="tab">Solicitudes rechazadas</a></li>
												<li class="divider"><div class="ln"></div></li>
												<li onclick="cambioPestana(3)" id="tabPestana3"><a href="#tab3" data-toggle="tab">Solicitudes por aprobar o rechazar</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="modal-body">
									<div id="tabsmodal" class="tab-content tab-content-main container">
										<div class="tab-pane fade active in" id="tab1">
											<div class="heading">
												<h3 class="fnt__Medium">Historial solicitudes de horas extras</h3>
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
												<h3 class="fnt__Medium">Solicitudes de empleados con horas extras rechazadas</h3>
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
												<h3 class="fnt__Medium">Solicitudes por aprobar o rechazar</h3>
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
												<div class="row">																					
													<button type="button" id="solicitudAceptar" class="btn pull-right" onclick="aceptarTurnos()" disabled="true">Enviar solicitud</button>
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						<!--DATOS DEL TAB GERENTE-->
							<div class="tab-pane fade" id="gerente">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<div class="container">
										<div id="tabbar">
											<ul class="nav nav-tabs">
												<li onclick="cambioPestana(4)" class="active"  id="tabPestana4"><a href="#tab4" data-toggle="tab">Solicitudes por empleado</a></li>
												<li class="divider"><div class="ln"></div></li>
												<li onclick="cambioPestana(5)" id="tabPestana5"><a href="#tab5" data-toggle="tab">Solicitudes rechazadas</a></li>
												<li class="divider"><div class="ln"></div></li>
												<li onclick="cambioPestana(6)" id="tabPestana6"><a href="#tab6" data-toggle="tab">Solicitudes por aprobar o rechazar</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="modal-body">
									<div id="tabsmodal" class="tab-content tab-content-main container">
										<div class="tab-pane fade active in" id="tab4">
											<div class="heading">
												<h3 class="fnt__Medium">Historial solicitudes de horas extras</h3>
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
									                        <li id="li14" class="active"><a href="#" id="p14" onclick="clickPage(1,4)">1</a></li>
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
											</div>
										</div>	
										<div class="tab-pane fade in" id="tab5">
											<div class="heading">
												<h3 class="fnt__Medium">Solicitudes de empleados con horas extras rechazadas</h3>
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
									                        <li id="li15" class="active"><a href="#" id="p15" onclick="clickPage(1,5)">1</a></li>
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
										<div class="tab-pane fade in" id="tab6">
											<div class="heading">
												<h3 class="fnt__Medium">Solicitudes de Empleados por Aprobar o Rechazar</h3>
											</div>
											<div class="body">
												<div class="row">											
													<div class="form-inline">			
														<div class="pull-right">			
															<div class="form-group">													
																<input type="text" class="form-control" id="search6" placeholder="Filtro">
															</div>											
															<button onclick="searchClick(6)" class="btn btn-default">Buscar</button>
														</div>													
														<div div="col-6">
															<select id="cantidadXP6" class="form-control" style="width:120px">
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
									                    <ul class="pagination" id="paginationView6">
									                        <li id="liprimero6"><a href="#" id="primero6" onclick="clickFirst(6)">Primero</a></li>
									                        <li id="liback6"><a href="#" onclick="clickBack(6)">&laquo;</a></li>
									                        <li id="li16" class="active"><a href="#" id="p16" onclick="clickPage(1,6)">1</a></li>
									                        <li id="li26"><a href="#" id="p26" onclick="clickPage(2,6)">2</a></li>
									                        <li id="li36"><a href="#" id="p36" onclick="clickPage(3,6)">3</a></li>
									                        <li id="li46"><a href="#" id="p46" onclick="clickPage(4,6)">4</a></li>
									                        <li id="li56"><a href="#" id="p56" onclick="clickPage(5,6)">5</a></li>
									                        <li id="li66"><a href="#" id="p66" onclick="clickPage(6,6)">6</a></li>
									                        <li id="li76"><a href="#" id="p76" onclick="clickPage(7,6)">7</a></li>
									                        <li id="li86"><a href="#" id="p86" onclick="clickPage(8,6)">8</a></li>
									                        <li id="li96"><a href="#" id="p96" onclick="clickPage(9,6)">9</a></li>
									                        <li id="li106"><a href="#" id="p106" onclick="clickPage(10,6)">10</a></li>
									                        <li id="linext6"><a href="#" onclick="clickNext(6)">&raquo;</a></li>
									                        <li id="liultimo6"><a href="#" id="ultimo6" onclick="clickLast(6)">Ultimo</a></li>
									                    </ul>
									                </div>
									            </div>
									            <div class="table-responsive">
													<div id="datosTabla6">
		                                
		                    						</div>   											
												</div>	
												<div class="row">																					
													<button type="button" id="solicitudAceptarGere" class="btn pull-right" onclick="aceptarTurnosGere()" disabled="true">Enviar solicitud</button>
												</div>		
											</div>
										</div>									
									</div>
								</div>						
							</div>
						<?php else: ?>
							<div class="tab-pane fade active in" id="jefe">
								<div class="modal-header">
									<button id="closeModalId" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<div class="container">
										<div id="tabbar">
											<ul class="nav nav-tabs">
												<li onclick="cambioPestana(1)" class="active"  id="tabPestana1"><a href="#tab1" data-toggle="tab">Solicitudes por empleado</a></li>
												<li class="divider"><div class="ln"></div></li>
												<li onclick="cambioPestana(2)" id="tabPestana2"><a href="#tab2" data-toggle="tab">Solicitudes rechazadas</a></li>
												<li class="divider"><div class="ln"></div></li>
												<li onclick="cambioPestana(3)" id="tabPestana3"><a href="#tab3" data-toggle="tab">Solicitudes por aprobar o rechazar</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="modal-body">
									<div id="tabsmodal" class="tab-content tab-content-main container">
										<div class="tab-pane fade active in" id="tab1">
											<div class="heading">
												<h3 class="fnt__Medium">Historial solicitudes de horas extras</h3>
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
												<h3 class="fnt__Medium">Solicitudes de empleados con horas extras rechazadas</h3>
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
												<h3 class="fnt__Medium">Solicitudes por aprobar o rechazar</h3>
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
												<div class="row">																					
													<button type="button" id="solicitudAceptar" class="btn pull-right" onclick="aceptarTurnos()" disabled="true">Enviar solicitud</button>
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endif ?>
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
			<?php if(Yii::$app->request->get('refresh')!='1'){ ?>
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
			<?php };?>
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
							<h3 class="no-mrg">Ultimos 5 Registros de Turnos</h3>
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
									<?php
									if ($HHOUTPUT=="1"){
										
									foreach ($HHEXTRASTOP as $HHEXTRASTOP_KEY) {
												
												echo '
										<tr>												
												<td>'.utf8_encode ($HHEXTRASTOP_KEY['CONSECUTIVO']).'</td>
												<td>'.utf8_encode ($HHEXTRASTOP_KEY['FEC_SOLICITUD']).'</td>
												<td>'.utf8_encode ($HHEXTRASTOP_KEY['FEC_H_EXTRAS']).'</td>
												<td>'.utf8_encode ($HHEXTRASTOP_KEY['HORAS']).'</td>
												<td>'.utf8_encode ($HHEXTRASTOP_KEY['CONCEPTO']).'</td>
												<td>'.utf8_encode ($HHEXTRASTOP_KEY['ESTADO']).'</td>
										</tr>
												';
												}	
									}else{
										
										echo '
										<tr>												
												<td>'.utf8_encode ($HHMESSAGE).'</td>												
										</tr>
										';										
									}									
											?>	
								</tbody>
							</table>
						</div>
						<div style="display:none;">
							<?= Html::img('@web/img/no_registros_horas_extra.png', ['alt' => 'No hay registros', 'class' => 'img-responsive']) ?>
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
					
							<div class="modal fade modal-header-gray modal-r-hextras" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h3 class="dis-inline-block">Registro de Horas Extras</h3>
											<div class="pull-right cnt-btn-add-rhextra">
												<button id="cloneButton" class="btn" OnClick="capturedat(this.id)"><i class="material-icons">&#xE148;</i>Adicionar</button>
											</div>
										</div>
										<div class="modal-body">
											<div id="panelAdd" class="row">
												<div id="nvid">
													<div id="panel1" class="col-md-6">
														<div class="panel panel-r-hextras">
															<div class="panel-heading">
																<input type="text" name="start" class="form-control" id="start" align="right" style="color:#FFFFFF; text-align:right"; disabled>
															</div>
															<div class="panel-body">
																<div class="row">
																	<div class="col-md-8">
																		<div class="form-group select-m mrg__top-15"><label id="concepto" name="concepto" for="concepto" class="control-label dis-block">Seleccione el Concepto</label>
																			<div class="mad-select" id="s2" name="s2">
																				<ul id="concpt">
																					
																				</ul><input type="hidden" id="s1" name="s1" value="0" class="form-control">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group mrg__top-15 label-floating">
																		<label for="i2" class="control-label">Cantidad de Horas</label>
																			<div class="numv">
																			<input type="number" name="hora" id="h" class="form-control" min="1" max="24" maxlength="4" size="4" value="1"  required="required">
																			</div>
																			<span class="help-block">Máximo 24 horas</span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="panel-footer">
																<span id="alertaError" class="dis-inline-block txt-est-hextra"></span>
																<div id="buttonRe" class="pull-right cnt-rbtn"></div>
															</div>
														</div>			
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" id="cancelarButton" class="btn btn-default" data-dismiss="modal">Cancelar Solicitud</button>
											<button id="saveButton" type="submit" OnClick="capturedat(this.id)" class="btn btn-primary">Guardar Registros</button>
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
<script type="text/javascript">

//DEFINO UNA BANDERA PARA HEREDAR PROPIEDADES DEL CALENDARIO, 0 ES TURNOS Y 1 ES VACACIONES
	var bandera = "0";
	
	//CONSTRUYO EL SELECT
	
	var ARRCONC_KEY=<?= json_encode($ARRCON_KEY);?>;
	var ARRCOD_KEY=<?= json_encode($ARRCOD_KEY);?>;
	
	//console.log(ARRCOD_KEY);
	
	var li = [];
						
						for(var i=0;i<ARRCOD_KEY.length;i++){

							
							if(i==0){
								li=li+'<li class="selected" data-value="'+ARRCOD_KEY[i]+'">'+ARRCONC_KEY[i]+'</li>';
								document.getElementById("s1").value=ARRCOD_KEY[i];
							}else{
							
						li=li+'<li data-value="'+ARRCOD_KEY[i]+'">'+ARRCONC_KEY[i]+'</li>';
							}
						}

						
						document.getElementById("concpt").innerHTML = li;
						document.getElementsByClassName("mad-select-drop").innerHTML = li;
	
	//CAPTURO LOS VALORES DEL FORMULARIO

	function capturedat(id, cancel = false){
		
		var numArr = [];
		var conArr = [];
		var fecArr = [];
				
		var num = document.querySelectorAll('input[name="hora"]');		
		var con = document.querySelectorAll('input[name$="s1"]');		
		var fec = document.querySelectorAll('input[name="start"]');		
		
		for(var i=0 ; i<num.length ; i++){
			
			numArr.push(num[i].value);
			conArr.push(con[i].value);
			fecArr.push(fec[i].value);
		}

		conStr=conArr.toString();
		numStr=numArr.toString();
		fecStr=fecArr.toString();
		
		/*console.log(conStr);
		console.log(numStr);
		console.log(fecStr);*/
		
		//console.log(id);
		switch (id){
			case "saveButton":
				id=1;
			break;
			case "cloneButton":
				id=0;
			break;
		}
		
		var parametros = {
			"conStr":conStr,
			"numStr":numStr,
			"fecStr":fecStr,
			"idStr":id
		}
	//console.log(parametros);
	
	
	$.ajax({
            cache: false,
            type: 'POST',
            url: '<?= Url::toRoute(['site/jsoncalendar', 'bandera' => '0']); ?>',
			data: parametros,
			dataType: 'json',
			 
			success: function(data){				
				
				var valida = data['HMSSG'];
				var houpt = data['HOUTP'];
				var mensajesArr = valida.split(",");
				
				//console.log(mensajesArr);
				//console.log(idsAlerts);
				
				if(houpt==0){
					for(var i=0 ; i<mensajesArr.length ; i++){
						
						var idAlert = idsAlerts[i+1];							
						
						
						switch (id){
							case 1:
								if((i+1)== mensajesArr.length){
									idAlert = idsAlerts[0]
								}
								
								//console.log("idAlert "+idAlert);
								break;						
						}

						if(cancel){
							idAlert = idsAlerts[i];
						}						
						
						var mensaje = mensajesArr[i];
						
						// console.log(idAlert+" - "+mensaje);
						
						document.getElementById(idAlert).innerHTML = mensaje;
					}
				
				}else if(houpt==1){
					
				swal({
				  title: "Importante!",
				  text: valida,
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonColor: "#DD6B55",
				  confirmButtonText: "Confirmar solicitud",
				  cancelButtonText: "Cancelar solicitud",
				  closeOnConfirm: false,
				  closeOnCancel: false
				},
				function(isConfirm){
				  if (isConfirm) {
					  
					  id=2;
					  capturedat(id);
						swal("Enviado!", "Tu solicitud de horas extras fueron registradas con éxito.", "success");
						$('.confirm').click(function(){
						window.location.href = '<?= Url::toRoute(['site/turnos', 'refresh' => '1']); ?>';
						});
				  } else {
						swal("Cancelado!", "Aprovecha para verificar tu formulario antes de enviarlo a tu jefe.", "error");
						
						id=0;
						capturedat(id, true);
						
				  }
				});
					
				}
				
									}
        });	
	}

</script>

<!--MANEJO DE LOS DATOS DE LAS TABLAS Y E AGINADOR-->
<script type="text/javascript">
	/*variables de la session*/
		var cedula = '<?=Yii::$app->session['cedula']?>';//'52513735' jefe //'94493860' gerente;;
		var autorizaciones = '<?=Yii::$app->session['submenus'][3]?>';
		var gerente = '<?=$gerente?>';
	/**/

	/*Variables de las ejecuciones con ajax*/		
		var pestana1 = '<?php echo Url::toRoute(['site/autorzacionextrp1']); ?>';
		var pestana2 = '<?php echo Url::toRoute(['site/autorzacionextrp2']); ?>';
		var pestana3 = '<?php echo Url::toRoute(['site/autorzacionextrp3']); ?>';
		var pestana4 = '<?php echo Url::toRoute(['site/autorzacionextrp4']); ?>';
		var pestana5 = '<?php echo Url::toRoute(['site/autorzacionextrp5']); ?>';
		var pestana6 = '<?php echo Url::toRoute(['site/autorzacionextrp6']); ?>';
		var aceptarSolicitudes = '<?php echo Url::toRoute(['site/aceptarsolicitudesturnos']);?>';
		var rechazaSolicitudes = '<?php echo Url::toRoute(['site/rechazarsolicitudesturnos']);?>';
		var detalleEplHistExtr = '<?php echo Url::toRoute(['site/detallegerenteturnos']);?>';
		var acepSolicitudesgre = '<?php echo Url::toRoute(['site/aceptarsolicitudesturnosgre']);?>';
		var rechSolicitudesgre = '<?php echo Url::toRoute(['site/rechazasolicitudesturnosgre']);?>';
	/**/	

	/*Jefe y gerente*/
	function JefeGrente(cargo){
		if(cargo.localeCompare("JEFE") == 0){

			$("#gerente").hide();
			$("#jefe").show();

			$("#tabPestana1").click();			
		}

		if(cargo.localeCompare("GERENTE") == 0){

			$("#jefe").hide();
			$("#gerente").show();

			$("#tabPestana4").click();		
		}
	}	  
	/**/

	//control de jefes o genrentes
	if(autorizaciones.localeCompare("TRUE") == 0){
		$(JefeGrente("JEFE"));
	}

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
				solicitudesXep5(pagination, pageXp);
				break;		
			case 6:
				solicitudesXep6(pagination, pageXp);
				break;		
        }
	}

	function cambioPestana(id, filtro = 10){			
		switch(id){
			case 1:				
				limpiaFiltros(1);           reiniciarToggle(); 
				solicitudesXepl(1,filtro);  setGeneralValuesDefault(id);				
				break;
			case 2:
				limpiaFiltros(2);			reiniciarToggle();				
				solicitudesXep2(1,filtro);	setGeneralValuesDefault(id);
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
				limpiaFiltros(5);			reiniciarToggle();				
				solicitudesXep5(1,filtro);	setGeneralValuesDefault(id);
				break;
			case 6:
				limpiaFiltros(6);			reiniciarToggle();				
				solicitudesXep6(1,filtro);	setGeneralValuesDefault(id);
				break;
		}
	}

	function searchClick(id){	    	
		//id de la cantidad
		var idJquery = "#cantidadXP"+id;    			
		//inicia la pestana con los fitros
		cambioPestana(id,$(idJquery).val());  	    	
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

	$("#cantidadXP6").change(function(event) {
		cambioPestana(6,$(this).val());
	});
</script>