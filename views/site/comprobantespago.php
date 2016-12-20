<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Comprobante de pago';
?>

<div class="mod-docs">
	<div class="mod-docs-header bg-blue-std">
	</div>
	<div class="mod-docs-body container">
		<div class="row">
			<div class="box-circle">
				<svg version="1.1" id="circle" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="400px" height="400px" viewBox="0 0 400 400" enable-background="new 0 0 400 400" xml:space="preserve">
					<path fill="#FFFFFF" d="M400,201H0C0,90,89.543,1,200,1S400,90,400,201z"/>
				</svg>
			</div>
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="box-compago-drw">
							<img src="img/compago_drw.svg" alt="Comprobante de pago">
						</div>
						<h2 class="fnt__Medium text-center mrg__top-10 mrg__bottom-20">Comprobante de pago</h2>
						<p>Genera el comprobante de pago asignando el respectivo año y periodo.</p>
						<div class="form-group select-m">
							<label class="control-label" for="compagoSelect">
								Año
							</label>
							<div class="mad-select">
								<ul>
									<li data-value="1">2016</li>
									<li data-value="2">2015</li>
									<li data-value="3">2014</li>
									<li data-value="4">2013</li>
									<li data-value="5">2012</li>
									<li data-value="6">2011</li>
									<li data-value="7">2010</li>
								</ul>
								<input type="hidden" id="compagoSelect" name="myOptions" value="1" class="form-control">
							</div>
						</div>
						<div class="form-group select-m">
							<label class="control-label" for="certRetecionSelect">
								Periodo
							</label>
							<div class="mad-select">
								<ul>
									<li data-value="1">2016</li>
									<li data-value="2">2015</li>
									<li data-value="3">2014</li>
									<li data-value="4">2013</li>
									<li data-value="5">2012</li>
									<li data-value="6">2011</li>
									<li data-value="7">2010</li>
								</ul>
								<input type="hidden" id="compagoPeriodoSelect" name="myOptions" value="1" class="form-control">
							</div>
						</div>
						<div class="form-group text-right">
							<button type="button" class="btn btn-raised btn-primary" data-toggle="modal" data-target="#pdfViewer">Generar</button>
							<button class="btn btn-raised btn-primary">Enviar al correo</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-vrtl modal-pdfviewer" id="pdfViewer" tabindex="-1" role="dialog" aria-labelledby="pdfViewerLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="header-box">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title txt__light-100" id="pdfViewerLabel">Comprobante de pago</h3>
				</div>
			</div>
			<div class="modal-body">
				<object class="box-pdf" data="img/sample_pdf.pdf" type="application/pdf">
					<embed src="img/sample_pdf.pdf" type="application/pdf"></embed>
						alt :<a href="img/sample_pdf.pdf">comprobante de pago.</a>
                </object>
			</div>
		</div>
	</div>
</div>