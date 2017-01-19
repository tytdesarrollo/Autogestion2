<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Trabajo por Turnos';
?>

<div class="bg-turnos">
	<div class="bg-dark-87">
		<!-- CONTENT TOUCH CAROUSEL -->
		<div class="ag-carousel sec">
			<!-- MÓDULO IZQUIERDA --> <!--
			<div class="ag-carousel__cell ag-carousel__cell-1">
				<div class="ag-carousel__cell-content">
					<div id="modVacVig" class="container bg__grt-blue__mobile">
						<div class="header">
							<h4 class="fnt__Medium">Vacaciones vigentes</h4>
						</div>
						<div class="vrtl-grid mrg__top-30">
							<div class="vrtl-grid__cell">
								<div class="vrtl-grid__cell-content content-icon">
									<i class="material-icons">&#xE88E;</i>
								</div>
								<div class="vrtl-grid__cell-content content-info-1">
									<p class="title">24-04-2016</p>
									<div class="txt__light-50">
										<p class="dis-inline-block no-mrg">Inicio: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
								</div>
								<div class="vrtl-grid__cell-content content-info-2">
									<div class="content-label">
										<div class="label">
											<p class="dis-inline-block no-mrg">10</p>
											<p class="dis-inline-block no-mrg">Días</p>
										</div>
									</div>
									<div class="txt__light-50">
										<p class="dis-inline-block no-mrg">Fin: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
								</div>
							</div>
							<div class="vrtl-grid__cell">
								<div class="vrtl-grid__cell-content content-icon">
									<i class="material-icons">&#xE88E;</i>
								</div>
								<div class="vrtl-grid__cell-content content-info-1">
									<p class="title">24-04-2016</p>
									<div class="txt__light-50">
										<p class="dis-inline-block no-mrg">Inicio: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
								</div>
								<div class="vrtl-grid__cell-content content-info-2">
									<div class="content-label">
										<div class="label">
											<p class="dis-inline-block no-mrg">10</p>
											<p class="dis-inline-block no-mrg">Días</p>
										</div>
									</div>
									<div class="txt__light-50">
										<p class="dis-inline-block no-mrg">Fin: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
								</div>
							</div>
							<div class="vrtl-grid__cell">
								<div class="vrtl-grid__cell-content content-icon">
									<i class="material-icons">&#xE88E;</i>
								</div>
								<div class="vrtl-grid__cell-content content-info-1">
									<p class="title">24-04-2016</p>
									<div class="txt__light-50">
										<p class="dis-inline-block no-mrg">Inicio: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
								</div>
								<div class="vrtl-grid__cell-content content-info-2">
									<div class="content-label">
										<div class="label">
											<p class="dis-inline-block no-mrg">10</p>
											<p class="dis-inline-block no-mrg">Días</p>
										</div>
									</div>
									<div class="txt__light-50">
										<p class="dis-inline-block no-mrg">Fin: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>-->
			<!-- */ MÓDULO IZQUIERDA -->
			<!-- MÓDULO CENTRAL -->
			<div class="ag-carousel__cell ag-carousel__cell-1">
				<div class="ag-carousel__cell-content">
					<div id="modVac" class="container">
						<div class="block-header clearfix mrg__top-10">
							<div class="pull-right btn-group-sm mrg__right-40">
								<button type="button" class="btn btn-default btn-fab" data-toggle="modal" data-target="#help">
									<i class="material-icons">&#xE887;</i>
								</button>
							</div>
						</div>
						<div class="text-center txt__light-100">
							<div class="content-main-days">
								<div class="content-days bg-amber-A700 center-block">
									<div class="ds-txt">
										<p class="text-ini">Te han aprobado</p>
										<span class="text-number">12</span>
										<p class="text-end">Horas Extras</p>
									</div>
								</div>
								<p class="text-desc mrg__top-15">En lo recorrido de este mes.</p>
							</div>
						</div>
						<div class="calendar-main-content text-center">
							<button id="swipeUp" class="btn-change-date">reportar horas extras</button>
							<div class="pdg__16 no-pdg-bottom clearfix">
								<button id="swipeDown" class="close mrg__right-40"><i class="material-icons">&#xE14C;</i></button>
							</div>
							<div class="pdg__16">
								<!-- CALENDARIO -->
								<div id="calendar" class="col-centered"></div>
								<!-- */.CALENDARIO -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- */ MÓDULO CENTRAL -->
			<!-- MÓDULO DERECHA -->
			<div class="ag-carousel__cell ag-carousel__cell-2">
				<div class="ag-carousel__cell-content">
					<div id="modVacHist" class="container bg__grt-blue__mobile">
						<div class="header">
							<h4 class="fnt__Medium">Historial Horas Extras</h4>
						</div>
						<div class="vrtl-grid mrg__top-30">
							<div class="vrtl-grid__cell">
								<div class="vrtl-grid__cell-content content-icon vrtl-al__txt-b">
									<i class="material-icons">&#xE86C;</i>
								</div>
								<div class="vrtl-grid__cell-content content-info-1">
									<p class="title">11001</p>
									<div class="txt__light-50 mrg__bottom-5">
										<p class="dis-inline-block no-mrg">Reporte: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
									<p class="txt__light-70">Recargo nocturno ordinario</p>
								</div>
								<div class="vrtl-grid__cell-content content-info-2">
									<div class="content-label">
										<div class="label">
											<p class="dis-inline-block no-mrg">2</p>
											<p class="dis-inline-block no-mrg">Horas</p>
										</div>
									</div>
									<div class="txt__light-50">
										<p class="dis-inline-block no-mrg">Del día: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
								</div>
							</div>
							<div class="vrtl-grid__cell">
								<div class="vrtl-grid__cell-content content-icon vrtl-al__txt-b">
									<i class="material-icons">&#xE88E;</i>
								</div>
								<div class="vrtl-grid__cell-content content-info-1">
									<p class="title">11002</p>
									<div class="txt__light-50">
										<p class="dis-inline-block no-mrg">Reporte: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
									<p class="txt__light-70">Recargo nocturno ordinario</p>
								</div>
								<div class="vrtl-grid__cell-content content-info-2">
									<div class="content-label">
										<div class="label">
											<p class="dis-inline-block no-mrg">1</p>
											<p class="dis-inline-block no-mrg">Hora</p>
										</div>
									</div>
									<div class="txt__light-50">
										<p class="dis-inline-block no-mrg">Del día: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
								</div>
							</div>
							<div class="vrtl-grid__cell">
								<div class="vrtl-grid__cell-content content-icon vrtl-al__txt-b">
									<i class="material-icons">&#xE5C9;</i>
								</div>
								<div class="vrtl-grid__cell-content content-info-1">
									<p class="title">11003</p>
									<div class="txt__light-50">
										<p class="dis-inline-block no-mrg">Reporte: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
									<p class="txt__light-70">Recargo nocturno ordinario</p>
								</div>
								<div class="vrtl-grid__cell-content content-info-2">
									<div class="content-label">
										<div class="label">
											<p class="dis-inline-block no-mrg">3</p>
											<p class="dis-inline-block no-mrg">Horas</p>
										</div>
									</div>
									<div class="txt__light-50">
										<p class="dis-inline-block no-mrg">Del día: </p>
										<p class="dis-inline-block no-mrg">24-04-2016</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- */ MÓDULO DERECHA -->
		</div>
		<!-- */ CONTENT TOUCH CAROUSEL -->
	</div>
</div>

 <!-- // MODALS // -->
<!-- MODALS TOP BUTTONS -->
<!---------------------------------------------------
  // MODAL RECORD
  // Modal de historial de solicitudes de vacaciones.
------------------------------------------------------->
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
<!-- */ MODAL RECORD -->

<!---------------------------------------------------
  // MODAL HELP
  // Modal de información sobre el módulo de vacaciones.
------------------------------------------------------->
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
<!-- */ MODAL HELP -->
<!-- */ MODALS TOP BUTTONS -->

<!-- MODALS CALENDARIO -->
<!---------------------------------------------------
  // MODAL ADD
  // Modal formulario para solicitar vacaciones.
------------------------------------------------------->
<div class="modal fade modal-sv-calendar" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?= Html::beginForm(Url::toRoute("site/addevent"), "POST") ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="heading">
					<h3 class="fnt__Medium">Solicitud de Vacaciones</h3>
				</div>
				<div class="form-group">
					<label for="title" class="col-sm-2 control-label">Titulo</label>
					<div class="col-sm-10">
						<input type="text" name="title" class="form-control" id="title" placeholder="Titulo">
					</div>
				</div>
				<div class="form-group">
					<label for="color" class="col-sm-2 control-label">Color</label>
					<div class="col-sm-10">
						<select name="color" class="form-control" id="color">
							<option value="">Seleccione...</option>
							<option style="color:#0071c5;" value="#0071c5">&#9724; Azul Oscuro</option>
							<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
							<option style="color:#008000;" value="#008000">&#9724; Verde</option>						  
							<option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
							<option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
							<option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
							<option style="color:#000;" value="#000">&#9724; Negro</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="start" class="col-sm-2 control-label">Fecha Inicial</label>
					<div class="col-sm-10">
						<input type="text" name="start" class="form-control" id="start" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="end" class="col-sm-2 control-label">Fecha Final</label>
					<div class="col-sm-10">
						<input type="text" name="end" class="form-control" id="end" readonly>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar Solicitud</button>
				<button type="submit" class="btn btn-primary">Guardar Fecha</button>
			</div>
			<?= Html::endForm() ?>
		</div>
	</div>
</div>
<!-- */ MODAL ADD -->

<!--------------------------------------------------------------
  // MODAL EDIT
  // Modal formulario para eliminar la solicitud de vacaciones.
---------------------------------------------------------------->
<div class="modal fade modal-sv-calendar" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?php $form = ActiveForm::begin([
				'method' => 'post',
				'options' => [
							'class' => 'form-horizontal'
						 ],
			 'id' => 'editEventTitle',
			]);
			?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="heading">
					<h3 class="fnt__Medium">Desea eliminar esta solicitud?</h3>
				</div>
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
<!-- */ MODAL EDIT -->
<!-- */ MODALS CALENDARIO -->
 <!-- // FIN-MODALS // -->