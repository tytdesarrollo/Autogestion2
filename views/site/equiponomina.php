<?php
use yii\helpers\Html;

$this->title = 'Equipo de nómina';
?>
<div class="container mrg__top-30">
	<div class="block-header">
		<h2>Jefatura de nómina / Gerencia de servicios económicos</h2>
	</div>
	<p class="txt__light-70 mrg__bottom-20">La <span class="txt__light-100 fnt__Medium">Dirección de Operaciones Comerciales</span> a través del Centro de Servicios Compartidos, te presenta la Jefatura de Nómina.</p>
	<div class="row">
		<div class="col-md-3">
			<div class="panel">
									<div class="panel-heading">
									<h4 class="fnt__Medium"><?= utf8_encode ($bloque1[0]['NOM_TITULO']); ?></h4>
									</div>
									<div class="panel-body">
									<ul class="no-list-style">
								<?PHP
									foreach ($bloque1 as $BLOQUE1_KEY) {
									
									echo '									
									<li>'.utf8_encode ($BLOQUE1_KEY['DECRIPCION']).'</li>									
									';
									}									
								?>	
				</ul>
				</div>								
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel">
				<div class="panel-heading">
					<h4 class="fnt__Medium"><?= utf8_encode ($bloque2[0]['NOM_TITULO']); ?></h4>
				</div>
				<div class="panel-body">
					<ul class="no-list-style">
								<?PHP
									foreach ($bloque2 as $BLOQUE2_KEY) {
									
									echo '								
									<li>'.utf8_encode ($BLOQUE2_KEY['DECRIPCION']).'</li>
									';
									}									
								?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel">
				<div class="panel-heading">
					<h4 class="fnt__Medium"><?= utf8_encode ($bloque3[0]['NOM_TITULO']); ?></h4>
				</div>
				<div class="panel-body">
					<ul class="no-list-style">
								<?PHP
									foreach ($bloque3 as $BLOQUE3_KEY) {
									
									echo '								
									<li>'.utf8_encode ($BLOQUE3_KEY['DECRIPCION']).'</li>
									';
									}									
								?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel">
				<div class="panel-heading">
					<h4 class="fnt__Medium"><?= utf8_encode ($bloque4[0]['NOM_TITULO']); ?></h4>
				</div>
				<div class="panel-body">
					<ul class="no-list-style">
								<?PHP
									foreach ($bloque4 as $BLOQUE4_KEY) {
									
									echo '								
									<li>'.utf8_encode ($BLOQUE4_KEY['DECRIPCION']).'</li>
									';
									}									
								?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<h4 class="fnt__Medium"><?= utf8_encode ($bloque5[0]['NOM_TITULO']); ?></h4>
								<?PHP
									foreach ($bloque5 as $BLOQUE5_KEY) {
									
									echo '								
									<p class="text-justify">'.utf8_encode ($BLOQUE5_KEY['DECRIPCION']).'</p>
									';
									}									
								?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<h4 class="fnt__Medium"><?= utf8_encode ($bloque6[0]['NOM_TITULO']); ?></h4>
								<?PHP
									foreach ($bloque6 as $BLOQUE6_KEY) {
									
									echo '								
									<p class="text-justify">'.utf8_encode ($BLOQUE6_KEY['DECRIPCION']).'</p>
									';
									}									
								?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<h4 class="fnt__Medium"><?= utf8_encode ($bloque7[0]['NOM_TITULO']); ?></h4>
								
					<p class="text-justify"><?= utf8_encode ($bloque7[0]['DECRIPCION']); ?></p>
					<ul>
								<?PHP
								$cont='0';
									foreach ($bloque7 as $BLOQUE7_KEY) {
									if($cont>='1'){
										echo '								
										<li>'.utf8_encode ($BLOQUE7_KEY['DECRIPCION']).'</li>
										';
									}
									$cont++;
									}									
								?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>