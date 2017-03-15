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
								<div class="content-days bg-orange-std center-block">
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
<!---------------------------------------------------
  // MODAL HELP
  // Modal de información sobre el módulo de turnos.
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
  // Modal formulario para reportar horas extras.
------------------------------------------------------->
<div class="modal fade modal-mobile-header-gray" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?= Html::beginForm(Url::toRoute("site/addevent"), "POST") ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="fnt__Medium">Solicitud de horas extras</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="form-group label-floating mrg__top-15">
							<label for="title" class="control-label">Titulo</label>
								<input type="text" name="title" class="form-control" id="title">
						</div>
						<div class="form-group select-m mrg__top-15">
							<label for="color" class="control-label dis-block">Color</label>
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
						<div class="form-group mrg__top-15">
							<label for="start" class="control-label">Hora Inicial</label>
							<input type="text" name="start" class="form-control" id="start" readonly>
						</div>
						<div class="form-group mrg__top-15">
							<label for="end" class="control-label">Hora Final</label>
							<input type="text" name="end" class="form-control" id="end" readonly>
						</div>
						<div class="form-group select-m mrg__top-15">
							<label for="concepto" class="control-label dis-block">Concepto</label>
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
  // Modal formulario para eliminar el reporte de horas extras.
---------------------------------------------------------------->
<div class="modal fade modal-sv-calendar" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?php $form = ActiveForm::begin([
				'method' => 'post',
				'options' => [
							'class' => ''
						 ],
			 'id' => 'editEventTitle',
			]);
			?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="fnt__Medium">Desea eliminar esta solicitud?</h3>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<p>Realmente desea eliminar esta solicitud de vacaciones? recuerde que se le notificara al lider encargado.</p>
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
 