<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Pagina Principal';
$session = Yii::$app->session;
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
				
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
  <?PHP											
												for($i = 0 ; $i < count($bloque9)-1 ; $i++) {
													
													$BLOQUE9_KEY_ARR = explode("_*", $bloque9[$i]);
													
													if($i == 0){
														
						echo '<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>';
	
													}else{
														
						echo '<li data-target="#carousel-example-generic" data-slide-to="'.$i.'"></li>';
    
													}
												}
												?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner mrg__bottom-20" role="listbox">
  												
							<?PHP											
												for($i = 0 ; $i < count($bloque9)-1 ; $i++) {
													
													$BLOQUE9_KEY_ARR = explode("_*", $bloque9[$i]);
													
													if($i == 0){
														
													echo '<div class="item active">
											<div class="panel panel-news no-mrg-bottom">
												<div class="panel-heading clearfix">
													<div class="pull-left fnt__Medium">'.$BLOQUE9_KEY_ARR[0].'</div>
													<div class="pull-right fnt__Medium">'.$BLOQUE9_KEY_ARR[1].'</div>
												</div>
												<div class="panel-body">
													'.$BLOQUE9_KEY_ARR[2].'
												</div>
												<div class="panel-footer clearfix">
													<button class="btn btn-default btn-sm pull-right"></button>
												</div>
											</div>
													</div>';
														
													}else{
													
													echo '<div class="item">
											<div class="panel panel-news no-mrg-bottom">
												<div class="panel-heading clearfix">
													<div class="pull-left fnt__Medium">'.$BLOQUE9_KEY_ARR[0].'</div>
													<div class="pull-right fnt__Medium">'.$BLOQUE9_KEY_ARR[1].'</div>
												</div>
												<div class="panel-body">
													'.$BLOQUE9_KEY_ARR[2].'
												</div>
												<div class="panel-footer clearfix">
													<button class="btn btn-default btn-sm pull-right"></button>
												</div>
											</div>
													</div>';
													
													}	
												}												
							?>	
   
    
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
  </a>
</div>
				<?php 
					if(@$session['menus'][0]=='TRUE'){
				?>
					<div class="panel panel-vacaci">
						<div class="panel-heading">
							<h4 class="fnt__Medium">Agenda aquí tus vacaciones!</h4>						
							<?= Html::a('<i class="material-icons">&#xEB48;</i>', ['site/vacaciones'], ['class'=>'btn btn-raised btn-float btn-amber']) ?>
						</div>
						<div class="panel-body text-center">
							<div class="content-main-days">
								<div class="content-days bg-blue-A700 center-block">
									<p class="text-ini">Cuentas con</p>
									<span class="text-number"><?= @$bloque11[0] ?></span>
									<p class="text-end">Días</p>
								</div>
							</div>
							<p class="text-desc">Prográmalas ahora!</p>
						</div>
					</div>
				<?php
					}
				?>
				<div class="row">
					<?php 
						if(@$session['menus'][2]=='TRUE'){
					?>
						<div class="col-sm-6">
							<?= Html::a('<div class="panel panel-certify text-center"><div class="panel-body"><div class="content-btn"><div class="content-icon"><img src="img/certlaboral_icon_white.svg" alt="Certificado laboral"></div></div><div><h4 class="fnt__Medium">Certificado Laboral</h4><div class="divider"></div><p>Genera aquí de manera personalizada tus certificados laborales, los puedes descargar en formato PDF o enviarlos por correo electrónico.</p></div></div></div>', ['site/certificadolaboral'], ['class'=>'link-panel']) ?>
						</div>
					<?php
						}
					?>
					<?php 
						if(@$session['menus'][4]=='TRUE'){
					?>
					<div class="col-sm-6">
						<?= Html::a('<div class="panel panel-cert-ing text-center"><div class="panel-body"><div class="content-btn"><div class="content-icon"><img src="img/certingreso_icon_white.svg" alt="Certificado de ingresos y retención"></div></div><div><h4 class="fnt__Medium">Certificado de ingresos y retención</h4><div class="divider"></div><p>Genera tus certificados de ingreso y retención, selecciona el año que desees y descargalo.</p><br/></div></div></div>', ['site/certificadosretencion'], ['class'=>'link-panel']) ?>
					</div>
					<?php
						}
					?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-head-img  text-center">
							<div class="panel-heading">
								<?= Html::img('@web/img/nomina_widget.png', ['alt' => 'Nómina', 'class' => 'img-bg img-responsive']) ?>
							</div>
							<div class="panel-body">
								<?= Html::a('<i class="material-icons">&#xE145;</i>', ['site/principal'], ['class'=>'btn btn-raised btn-float btn-blue-A700']) ?>
								<h4 class="fnt__Medium">Nómina</h4>
								<p>Herramienta de gestión de nómina y recursos humanos.</p>
								<br/>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel panel-head-img  text-center">
							<div class="panel-heading">
								<?= Html::img('@web/img/awa_widget4.png', ['alt' => 'Awa', 'class' => 'img-bg img-responsive']) ?>
							</div>
							<div class="panel-body">
								<?= Html::a('<i class="material-icons">&#xE145;</i>', ['site/principal'], ['class'=>'btn btn-raised btn-float btn-blue-A700']) ?>
								<h4 class="fnt__Medium">Awa</h4>
								<p>Herramienta para la administración presupuestal, contable, financiera y comercial.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-head-img  text-center">
							<div class="panel-heading">
								<?= Html::img('@web/img/hims_widget.png', ['alt' => 'Hims', 'class' => 'img-bg img-responsive']) ?>
							</div>
							<div class="panel-body">
								<?= Html::a('<i class="material-icons">&#xE145;</i>', ['site/principal'], ['class'=>'btn btn-raised btn-float btn-blue-A700']) ?>
								<h4 class="fnt__Medium">Hims</h4>
								<p>Herrmanienta administrativa y financiera enfocada en controlar la gestión del negocio de las Instituciones Prestadoras de Servicios de Salud.</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel panel-turnos text-center">
							<div class="panel-heading">
								<?= Html::img('@web/img/turnos.jpg', ['alt' => 'Trabajo por turnos', 'class' => 'img-bg img-responsive']) ?>
							</div>
							<div class="panel-body">
							<?= Html::a('<i class="material-icons">&#xE145;</i>', ['site/turnos'], ['class'=>'btn btn-raised btn-float btn-blue-A700']) ?>
								<h4 class="fnt__Medium">Te invitamos a registrar tus novedades</h4>
								<p>Este módulo permitirá optimizar el proceso de registro y transcripción de los reportes mensuales.</p>
								<br/>
							</div>
						</div>
					</div>
				</div>
				<?php 
					if(@$session['menus'][3]=='TRUE'){
				
				$form = ActiveForm::begin([
					"method" => "POST",
					"id" => "compro-form",
					"enableClientValidation" => false,
					"enableAjaxValidation" => true,
					]); 
				?>
				<div class="panel">
					<div class="panel-heading">
						<h4 class="fnt__Medium">Comprobantes de pago</h4>
						<small>Genera de manera personalizada tus comprobantes de pago.</small><br>
						<small>*DATO: presiona en el icono para ver alguno de tus últimos tres comprobantes.</small>
						<?= Html::a('<i class="material-icons">&#xE53E;</i>', ['site/comprobantespago'], ['class'=>'btn btn-raised btn-float btn-blue-A700']) ?>						
					</div>
					<div class="panel-body">
						<table class="table table-widget-comp-pago table-striped table-hover mrg__top-30">
							<thead>
								<tr>
									<th>Ver</th>
									<th>Periodo</th>
									<th>Año</th>
									<th>Fecha</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a onclick="Warn(<?= $bloque10[3];?>,<?= $bloque10[1];?>);"><i class="material-icons">&#xE8F4;</i></a></td>
									<td><?= @$bloque10[0] ?></td>
									<td><?= @$bloque10[1] ?></td>
									<td><?= @$bloque10[2] ?></td>
								</tr>
								<tr>
									<td><a onclick="Warn(<?= $bloque10[7];?>,<?= $bloque10[1];?>);"><i class="material-icons">&#xE8F4;</i></a></td>
									<td><?= @$bloque10[4] ?></td>
									<td><?= @$bloque10[5] ?></td>
									<td><?= @$bloque10[6] ?></td>
								</tr>
								<tr>
									<td><a onclick="Warn(<?= $bloque10[11];?>,<?= $bloque10[1];?>);"><i class="material-icons">&#xE8F4;</i></a></td>
									<td><?= @$bloque10[8] ?></td>
									<td><?= @$bloque10[9] ?></td>
									<td><?= @$bloque10[10] ?></td>
								</tr>
							</tbody>
						</table>
						<div class="text-right "><small><em>*Últimos 3 comprobantes de pago.</em></small></div>
					</div>
				</div>
				<?php ActiveForm::end(); 
					}
				?>
				<div class="row">
					<!--<div class="col-sm-6">
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
					</div>-->
				</div>
			</div>
		</div>
	</div>
	
	
	<!--    PAGINA DE DATOS PERSONALES    -->
	
	<div class="tab-pane fade" id="info">
	
	<!--    BLOQUE 1    -->
		
		<div class="block-header">
			<h2><?= @$bloque1[0] ?><small><?= @$bloque1[1] ?></small></h2>
		</div>
		<div class="row">		
			<div class="col-md-3">
			<?PHP if($bloque1[0]!="INACTIVO"){ ?>
				<div class="panel bg-blue-std widget-extrasmall-htl">
					<div class="panel-body">
						<div class="dis-inline-block">
							<h5 class="fnt__Medium no-mrg">Tipo de salario:</h5>
							<h3 class="fnt__Medium no-mrg"><?= @$bloque1[2] ?></h3>
						</div>
						<i class="material-icons">&#xE227;</i>
					</div>
				</div>
				<div class="panel bg-cyan-std widget-extrasmall-htl">
					<div class="panel-body">
						<div class="dis-inline-block">
							<h5 class="fnt__Medium no-mrg">Tipo de contrato:</h5>
							<h3 class="fnt__Medium no-mrg"><?= @$bloque1[3] ?></h3>
						</div>
						<i class="material-icons">&#xE880;</i>
					</div>
				</div>
				<div class="panel bg-teal-std widget-extrasmall-htl">
					<div class="panel-body">
						<div class="dis-inline-block">
							<h5 class="fnt__Medium no-mrg">Fecha de ingreso:</h5>
							<h3 class="fnt__Medium no-mrg"><?= @$bloque1[4] ?></h3>
						</div>
						<i class="material-icons">&#xE8DF;</i>
					</div>
				</div>
				<?PHP }; ?>	
	<!--    BLOQUE 2    -->
			<?PHP if($bloque2[0]!="INACTIVO"){ ?>	
				<div class="panel panel-contact">
					<div class="panel-body">
						<h2 class="fnt__Medium">Datos Personales</h2>
						<ul>
							<li><i class="material-icons">&#xE0BE;</i><?= @$bloque2[0] ?></li>
							<li><i class="material-icons">&#xE86D;</i><?= @$bloque2[1] ?></li>
							<li><i class="material-icons">&#xE0C8;</i><?= @$bloque2[2] ?></li>
						</ul>
						<div class="mrg__top-15">
							<h5 class="fnt__Medium no-mrg-bottom">Jefe inmediato:</h5>
							<p><?= @$bloque2[3] ?></p>
						</div>
						<div class="mrg__top-15">
							<h5 class="fnt__Medium no-mrg-bottom">Regional:</h5>
							<p><?= @$bloque2[4] ?></p>
						</div>
					</div>
				</div>
				<?PHP }; ?>	
	<!--    BLOQUE 4    -->
			<?PHP if($bloque4[0]!="INACTIVO"){ ?>	
				<div class="panel panel-contact">
					<div class="panel-body">
						<h2 class="fnt__Medium">Datos Informativos</h2>
						<table class="table table-no-border">
							<tbody>
								<tr>
									<td class="fnt__Medium">Declarante de renta</td>
									<td><?= @$bloque4[0] ?></td>
								</tr>
								<tr>
									<td class="fnt__Medium">Procedimiento retención en la fuente</td>
									<td><?= @$bloque4[1] ?></td>
								</tr>
								<tr>
									<td class="fnt__Medium">Porcentaje de retención</td>
									<td><?= @$bloque4[2] ?></td>
								</tr>
								<tr>
									<td class="fnt__Medium">Cuota máxima disponible de descuento</td>
									<td><?= @$bloque4[3] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<?PHP }; ?>		
			</div>					
			<div class="col-md-9">
				<div class="row">
				
	<!--    BLOQUE 3    -->
				<?PHP if($bloque3[0]!="INACTIVO"){ ?>
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
											<?PHP
												foreach ($bloque3 as $BLOQUE3_KEY) {
												
												echo '									
												<td>'.utf8_encode ($BLOQUE3_KEY).'</td>									
												';
												}									
											?>												
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				<?PHP }; ?>
	<!--    BLOQUE 5    -->
				<?PHP if($bloque5[0]!="INACTIVO"){ ?>	
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
										<h4 class="fnt__Medium"><?= @$bloque5[0] ?></h4>
										<p><?= @$bloque5[1] ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade modal-vrtl" id="formNovedades" tabindex="-1" role="dialog" aria-labelledby="formNovedadesLabel">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<div class="header-box">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h3 class="modal-title txt__light-100" id="formNovedadesLabel">Reporte de novedades</h3>
									</div>
								</div>
								<div class="modal-body">
									<p>Si tienes alguna novedad por reportar, por favor tener en cuenta lo siguiente:</p>
									<div class="list-group list-novedades mrg__top-30">
										<div class="row">
											<div class="col-md-6">
												<div class="list-group-item">
													<div class="row-picture">
														<div class="content-number bg-blue-A700 fnt__Medium">1</div>
													</div>
													<div class="row-content">
													  <h5 class="fnt__Medium txt__blue mrg__bottom-5">Reporte Paz y Salvos libranzas:</h5>
													  <p class="list-group-item-text">Adjuntar certificado del banco del crédito y formato único diligenciado y firmado.</p>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="list-group-item">
													<div class="row-picture">
														<div class="content-number bg-blue-A700 fnt__Medium">2</div>
													</div>
													<div class="row-content">
														<h5 class="fnt__Medium txt__blue mrg__bottom-5">Para modificar cuenta bancaria de nómina:</h5>
														<p class="list-group-item-text">Adjuntar certificado del banco y formato único diligenciado y firmado.</p>
													</div>
												</div>
											</div>
										</div>
										<div class="list-group-separator"></div>
										<div class="row">
											<div class="col-md-6">
												<div class="list-group-item">
													<div class="row-picture">
														<div class="content-number bg-blue-A700 fnt__Medium">3</div>
													</div>
													<div class="row-content">
													  <h5 class="fnt__Medium txt__blue mrg__bottom-5">Para adicionar, modificar o suspender aporte a pensiones voluntarias:</h5>
													  <p class="list-group-item-text">Adjuntar formato único diligenciado y firmado.</p>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="list-group-item">
													<div class="row-picture">
														<div class="content-number bg-blue-A700 fnt__Medium">4</div>
													</div>
													<div class="row-content">
														<h5 class="fnt__Medium txt__blue mrg__bottom-5">Para adicionar, modificar o suspender aporte AFC:</h5>
														<p class="list-group-item-text">Si es cuenta nueva adjuntar certificado del banco y formato único diligenciado y firmado, de lo contrario únicamente el formato único diligenciado y firmado.</p>
													</div>
												</div>
											</div>
										</div>
										<div class="list-group-separator"></div>
										<div class="row">
											<div class="col-md-6">
												<div class="list-group-item">
													<div class="row-picture">
														<div class="content-number bg-blue-A700 fnt__Medium">5</div>
													</div>
													<div class="row-content">
														<h5 class="fnt__Medium txt__blue mrg__bottom-5">Para reportar intereses de vivienda:</h5>
														<p class="list-group-item-text">Adjuntar certificado del banco y formato único diligenciado y firmado.</p>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="list-group-item">
													<div class="row-picture">
														<div class="content-number bg-blue-A700 fnt__Medium">6</div>
													</div>
													<div class="row-content">
														<h5 class="fnt__Medium txt__blue mrg__bottom-5">Para reportar medicina prepagada:</h5>
														<p class="list-group-item-text">Adjuntar certificado de la entidad y formato único diligenciado y firmado.</p>
													</div>
												</div>
											</div>
										</div>
										<div class="list-group-separator"></div>
										<div class="row">
											<div class="col-md-12">
												<div class="list-group-item">
													<div class="row-picture">
														<div class="content-number bg-blue-A700 fnt__Medium">7</div>
													</div>
													<div class="row-content">
														<h5 class="fnt__Medium txt__blue mrg__bottom-5">Para reportar dependientes:</h5>
														<p class="list-group-item-text">Adjuntar formato único diligenciado y firmado teniendo en cuenta:</p>
														<div class="box__blue-50 pdg__24 mrg__top-15 mrg__left-15">
															<div class="list-indent">
																<ul>
																	<li>Hijos hasta 18 años, adjuntar registro civil de nacimiento</li>
																	<li>Hijos de 18 a 23 años, adjuntar registro civil de nacimiento y certificado de estudios de institución de educación superior</li>
																	<li>Cónyuge o compañero, padres y hermanos con dependencia económica del trabajador, debe adjuntar certificación de contador público indicando la dependencia económica y la no generación de ingresos</li>
																	<li>Discapacidad física / mental de Cónyuge o compañero, padres, hermanos e hijos mayores de 23 años, debe adjuntar certificado de medicina legar o entidad competente para determinar la discapacidad.</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="text-center mrg__top-30 mrg__bottom-30">
										<a href="#" class="btn btn-raised btn-blue-A700">
											Descarga tu formulario único <i class="material-icons">&#xE2C4;</i>
										</a>
									</div>
									<div class="row mrg__top-40">
										<div class="col-md-8 col-md-offset-2"><small>Los campos marcados con (*) son obligatorios.</small></div>
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group label-floating">
												<label class="control-label" for="focusedInput1">
													Nombre*
												</label>
												<input class="form-control" id="focusedInput1" type="text">
											</div>
										</div>
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group label-floating">
												<label class="control-label" for="focusedInput1">
													email corporativo*
												</label>
												<input class="form-control" id="focusedInput1" type="text">
											</div>
										</div>
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group">
												<input type="file" id="inputFile4" multiple="">
												<div class="input-group">
													<input type="text" readonly="" class="form-control" placeholder="Seleccionar archivo...">
													<span class="input-group-btn input-group-sm">
														<button type="button" class="btn btn-fab btn-fab-mini">
															<i class="material-icons">attach_file</i>
														</button>
												  </span>
												</div>
												<span class="help-block">Puede adjuntar hasta 10 archivos.</span>
											</div>
										</div>
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group label-floating">
												<label for="textArea" class="control-label">Comentarios*</label>
												<textarea class="form-control" rows="3" id="textArea"></textarea>
											</div>
										</div>
										<div class="col-md-8 col-md-offset-2">
											<p class="mrg__top-30">Verifique por favor su email antes de dar click en enviar.</p>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									<button type="button" class="btn btn-primary">Enviar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?PHP }; ?>		
	<!--    BLOQUE 6    -->
				<?PHP if($bloque6[0]!="INACTIVO"){ ?>
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
											<?PHP
											$cont='0';
											
												foreach ($bloque6 as $BLOQUE6_KEY) {
													
													//IMPRIME TD A LOS MULTIPLOS DE 3 PARA REALIZAR EL SALTO DE LINEA
														$div=$cont/3;
														$multiplo=round($div)-$div;
												
												if($multiplo!=0){		
												echo '
												<td>'.$BLOQUE6_KEY.'</td>
												';
													}else{
												echo '
												</tr><tr><td>'.$BLOQUE6_KEY.'</td>
												';													
													}													
														$cont++;
												}											
											?>	
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?PHP }; ?>
	<!--    BLOQUE 7    -->
				<?PHP if($bloque7[0]!="INACTIVO"){ ?>
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
										<?PHP
											$cont='0';
											
												foreach ($bloque7 as $BLOQUE7_KEY) {
													
													//IMPRIME TD A LOS MULTIPLOS DE 3 PARA REALIZAR EL SALTO DE LINEA
														$div=$cont/3;
														$multiplo=round($div)-$div;
												
												if($multiplo!=0){		
												echo '
												<td>'.$BLOQUE7_KEY.'</td>
												';
													}else{
												echo '
												</tr><tr><td>'.$BLOQUE7_KEY.'</td>
												';													
													}													
														$cont++;
												}											
											?>								
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?PHP }; ?>
	<!--    BLOQUE 8    -->
				<?PHP if($bloque8[0]!="INACTIVO"){ ?>
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
										<td><?= @$bloque8[0] ?></td>
										<td><?= @$bloque8[1] ?></td>
									</tr>
									<tr>
										<td>Salud Prepagada</td>
										<td><?= @$bloque8[2] ?></td>
										<td><?= @$bloque8[3] ?></td>
									</tr>
									<tr>
										<td>Dependientes</td>
										<td><?= @$bloque8[4] ?></td>
										<td><?= @$bloque8[5] ?></td>
									</tr>
									<tr>
										<td>Salud Obligatoria</td>
										<td><?= @$bloque8[6] ?></td>
										<td><?= @$bloque8[7] ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?PHP }; ?>	
	<!--    ZONA DE AYUDA    -->				
				
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

<div class="modal fade modal-vrtl modal-pdfviewer" id="pdfViewer" tabindex="-1" role="dialog" aria-labelledby="pdfViewerLabel"> </div>

		<script type="text/javascript">

		function Warn(mes,ano) {
			
				$.ajax({
					cache: false,
					type: 'POST',
					url: '<?php echo Url::toRoute(['site/pdf_comprobantespago', 'tiprend' => 'btnPdf']); ?>',
					data: {'perenv':mes,'anoenv':ano},//$("#compro-form").serialize(), 
					 
					success: function(data){				
						
						$('#pdfViewer').modal('toggle').html(
				'<div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><div class="header-box"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h3 class="modal-title txt__light-100" id="pdfViewerLabel">Comprobante de Pago</h3></div></div><div class="modal-body"><object class="box-pdf" data="<?php echo Url::toRoute(['site/pdf_comprobantespago', 'tiprend' => 'btnPdf']);?>" type="application/pdf"></object></div></div></div>'
				);			
											}
				});			

			};

		</script>
