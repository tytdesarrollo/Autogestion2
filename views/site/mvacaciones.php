<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Vacaciones';
?>

<div class="bg-vacaciones">
	<div class="bg-dark-87">
		<!-- CONTENT TOUCH CAROUSEL -->
		<div class="ag-carousel">
			<!-- MÓDULO IZQUIERDA --> 
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
			</div>
			<!-- */ MÓDULO IZQUIERDA -->
			<!-- MÓDULO CENTRAL -->
			<div class="ag-carousel__cell ag-carousel__cell-2">
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
									<p class="text-ini">Cuentas con</p>
									<span class="text-number">12</span>
									<p class="text-end">Días</p>
								</div>
							</div>
							<p class="text-desc">Para programar y disfrutar tus vacaciones.</p>
							<hr class="line-divider-info-vacaciones top">
							<p class="no-mrg">Tus posibles vacaciones serían</p>
							<p class="no-mrg"><strong>Desde: 16/05/2016</strong></p>
							<p class="no-mrg"><strong>Hasta: 31/05/2016</strong></p>
							<hr class="line-divider-info-vacaciones bottom">
						</div>
						<div class="calendar-main-content text-center">
							<button id="swipeUp" class="btn-change-date">Cambiar fecha</button>
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
			<div class="ag-carousel__cell ag-carousel__cell-3">
				<div class="ag-carousel__cell-content">
					<div id="modVacHist" class="container bg__grt-blue__mobile">
						<div class="header">
							<h4 class="fnt__Medium">Historial solicitudes de vacaciones</h4>
						</div>
						<div class="vrtl-grid mrg__top-30">
							<div class="vrtl-grid__cell">
								<div class="vrtl-grid__cell-content content-icon">
									<i class="material-icons">&#xE86C;</i>
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
									<i class="material-icons">&#xE5C9;</i>
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
<!-- */ MODAL HELP -->
<!-- */ MODALS TOP BUTTONS -->

<!-- MODALS CALENDARIO -->
<!---------------------------------------------------
  // MODAL ADD
  // Modal formulario para solicitar vacaciones.
------------------------------------------------------->
<div class="modal fade modal-mobile-header-gray" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?= Html::beginForm(Url::toRoute("site/addevent"), "POST") ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="fnt__Medium">Solicitud de Vacaciones</h3>
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
							<label for="start" class="control-label">Fecha Inicial</label>
							<input type="text" name="start" class="form-control" id="start" readonly>
						</div>
						<div class="form-group mrg__top-15">
							<label for="end" class="control-label">Fecha Final</label>
							<input type="text" name="end" class="form-control" id="end" readonly>
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
  // Modal formulario para eliminar la solicitud de vacaciones.
---------------------------------------------------------------->
<div class="modal fade modal-header-gray" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
<!-- */ MODAL EDIT -->
<!-- */ MODALS CALENDARIO -->
 <!-- // FIN-MODALS // -->
 