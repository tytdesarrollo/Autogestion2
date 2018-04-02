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
				<?php $form = ActiveForm::begin([
					"method" => "POST",
					"id" => "compro-form",
					"enableClientValidation" => false,
					"enableAjaxValidation" => true,
					]); 
					?>
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
							<div class="mad-select" id="ano">
								<ul>
								<li class="selected" data-value="0" OnClick="ocultv();">Seleccione</li>
								<?php
								foreach($ANO_PERIODO_ARR as $row): ?>
									<li data-value="<?= $row ?>" OnClick="setTimeout(show, 50);"><?= $row ?></li>		
								<?php endforeach ?>
								</ul>
								<input type="hidden" id="anoenv" name="anoenv" value="0" class="form-control">
							</div>
						</div>
						
						<div id="divper" name="divper">
						<div class="form-group select-m"><label class="control-label" for="compagoPeriodoSelect">Periodo</label><div id="dier" class="mad-select">
						<ul id="periodo">
						
						</ul>
						<input type="hidden" id="perenv" name="perenv" value="0" class="form-control"></div></div>
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

	document.getElementById("divper").style.display = 'none';
	

	function ocultv(){
		document.getElementById("divper").style.display = 'none';
		};

	function show() {
	
	document.getElementById("divper").style.display = 'block';

	$.ajax({
		
				cache: false,
				type: 'POST',
				url: '<?php echo Url::toRoute(['site/menucomprobantespago']); ?>',
				data: $("#compro-form").serialize(),
				dataType: 'json',
				success: function(data){	
		
						nomPer = data[0];
						nurPer = data[1];
						var li = new Array();
						
						for(var i=0;i<nurPer.length;i++){

							
							if(i==0){
								li=li+'<li class="selected" data-value="0">Seleccione</li>';
							}
							
						li=li+'<li data-value="'+nurPer[i]+'">'+nomPer[i]+'</li>';
						}

						$("#periodo").html(li);
						$("#dier .mad-select-drop").html(li);
		
				}
				});	
	};
	
</script>

<script type="text/javascript">

//TU CORREO ELECTRONICOS
var correoelectronico= <?= json_encode(Yii::$app->session['datopersonaldos'][0]); ?>;

function Warn(id) {
	
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo Url::toRoute(['site/pdf_comprobantespago', 'tiprend' => '']); ?>'+id,
            data: $("#compro-form").serialize(), 
			 
			success: function(data){	

			if(id=='btnPdf'){					
				
				$('#pdfViewer').modal('toggle').html(
        '<div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><div class="header-box"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h3 class="modal-title txt__light-100" id="pdfViewerLabel">Comprobante de Pago</h3></div></div><div class="modal-body"><object class="box-pdf" data="<?php echo Url::toRoute(['site/pdf_comprobantespago', 'tiprend' => '']); ?>'+id+'" type="application/pdf"></object></div></div></div>'
		);			
			}else if(id=='envPdf'){
				
				swal("Enviado!", "Tu certficado ha sido enviado al correo "+correoelectronico, "success");
				
			}
			
									}
	             
        });			

	};

</script>