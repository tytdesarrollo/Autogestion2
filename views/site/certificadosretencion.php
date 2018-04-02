<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Certificado de ingresos y retención';
?>

<div class="mod-docs">
	<div class="mod-docs-header bg-teal-std">
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
					<?php $form = ActiveForm::begin([
					"method" => "post",
					"id" => "certi-form",
					"enableClientValidation" => false,
					"enableAjaxValidation" => true,
					]); 
					?>				
					<div class="panel-body">
						<div class="box-certingreso-drw">
							<img src="img/certingreso_drw.svg" alt="Certificado de ingresos y retención">
						</div>
						<h2 class="fnt__Medium text-center mrg__top-10 mrg__bottom-20">Certificado de ingresos y retención</h2>
						<p class="mrg__bottom-20">Genera el certificado de ingresos y retención para el año que desees.</p>

						<div class="form-group select-m">
							<label class="control-label" for="certRetecionSelect">
								Año
							</label>

							<div class="mad-select" id="pdfSelect">
								<ul>
								<li class="selected" data-value="0">seleccione</li>
								<?php
								foreach($anoscerti as $row): ?>
									<li data-value="<?= $row ?>"><?= $row ?></li>		
								<?php endforeach ?>
								</ul>
								<input type="hidden" id="certRetecionSelect" name="myOptions" value="1" class="form-control">
							</div>
					
						</div>					
						<div class="form-group text-right">
						<?= Html::Button('Generar', ['class' => 'btn btn-raised btn-primary', 'data-toggle'=>"modal",  'name' => 'btnPdf', 'id' => 'btnPdf', 'onclick'=>'Warn(this.id);']) ?>
						<?= Html::Button('Enviar al correo', ['class' => 'btn btn-raised btn-primary', 'name' => 'enviar-button', 'id' => 'envPdf', 'onclick'=>'Warn(this.id);']) ?>
						</div>
					</div>
					<?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-vrtl modal-pdfviewer" id="pdfViewer" tabindex="-1" role="dialog" aria-labelledby="pdfViewerLabel"> </div>

<script type="text/javascript">

//TU CORREO ELECTRONICOS
var correoelectronico= <?= json_encode(Yii::$app->session['datopersonaldos'][0]); ?>;

function Warn(id) {
	
	$.ajax({
             cache: false,
             type: 'POST',
			 url: '<?= Url::toRoute(['site/pdf_certificadosretencion', 'tiprend' => '']); ?>'+id,
             data: $("#certi-form").serialize(), 
			 
			success: function(data){	

			if(id=='btnPdf'){			
				
				$('#pdfViewer').modal('toggle').html(
        '<div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><div class="header-box"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h3 class="modal-title txt__light-100" id="pdfViewerLabel">Certificado de Ingresos y Retención</h3></div></div><div class="modal-body"><object class="box-pdf" data="<?= Url::toRoute(['site/pdf_certificadosretencion', 'tiprend' => '']); ?>'+id+'" type="application/pdf"></object></div></div></div>'
		);
		
			}else if(id=='envPdf'){
				
				swal("Enviado!", "Tu certficado ha sido enviado al correo "+correoelectronico, "success");
				
			}
			
									}
	             
        });			

	};

</script>