<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Certificado laboral';
?>

<div class="mod-docs">
	<div class="mod-docs-header bg-lightblue-std">
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
						<div class="box-certlaboral-drw">
							<img src="img/certlaboral_drw.svg" alt="Certificado laboral">
						</div>
						<h2 class="fnt__Medium text-center mrg__top-10 mrg__bottom-20">Certificado laboral</h2>
						<p>¿Qué deseas incluir en el certificado laboral?</p>
						<div class="form-group">
							<div class="radio radio-primary">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
									Certificado normal con salario
								</label>
							</div>
							<div class="radio radio-primary">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
									Certificado normal sin salario
								</label>
							</div>
						</div>
						<div class="form-group label-floating">
							<label class="control-label" for="focusedInput1">
								Dirigido a:
							</label>
							<input class="form-control" id="focusedInput1" type="text">
						</div>
						<div class="form-group text-right">
							<button type="button" class="btn btn-raised btn-primary visible-lg-inline-block" data-toggle="modal" data-target="#pdfViewer">Generar</button>
							<a href="img/certificado_laboral.pdf" target="_blank" class="btn btn-raised btn-primary hidden-lg">Generar</a>
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
					<h3 class="modal-title txt__light-100" id="pdfViewerLabel">Certificado laboral</h3>
				</div>
			</div>
			<div class="modal-body">
				<object class="box-pdf" data="img/certificado_laboral.pdf" type="application/pdf">
					<embed src="img/certificado_laboral.pdf" type="application/pdf"></embed>
						<a href="img/certificado_laboral.pdf">certificado laboral.</a>
                </object>
			</div>
		</div>
	</div>
</div>