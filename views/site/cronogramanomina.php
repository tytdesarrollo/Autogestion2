<?php
use yii\helpers\Html;

$this->title = 'Cronograma cierre novedades de nómina';
?>
<div class="container mrg__top-30">
	<div class="block-header">
		<h2>Cronograma cierre novedades de nómina</h2>
	</div>
	<p class="txt__light-70 mrg__bottom-20">El Centro de Servicios Compartidos te informa que la fecha de cierre de novedades para los colaboradores directos de Telefónica, para el año 2016</p>
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Mes</th>
									<th>Día</th>
									<th>Cierre</th>
									<th>Día</th>
									<th>Pago</th>
								</tr>
							</thead>
							<tbody>
								<?PHP
									foreach ($crono as $CRONO_KEY) {
									
									echo '
									<tr>
									<td>'.$CRONO_KEY['MES'].'</td>
									<td>'.utf8_encode ($CRONO_KEY['DIA']).'</td>
									<td>'.$CRONO_KEY['CIERRE'].'</td>
									<td>'.utf8_encode ($CRONO_KEY['DIA_CIERRE']).'</td>
									<td>'.$CRONO_KEY['PAGO'].'</td>
									</tr>
									';
									}
									
									?>								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>