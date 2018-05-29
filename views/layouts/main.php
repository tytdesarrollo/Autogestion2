<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Dropdown;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

$session = Yii::$app->session;
?>
	<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
	<link rel="shortcut icon" href="href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
	<script src="../web/js/modernizr.custom.js"></script>
</head>
<body>
	<?php $this->beginBody() ?>	
<div class="headerbar"></div>
<header id="header" class="clearfix">
	<nav id="menu" class="navbar">
		<div class="container-fluid">
			<div class="content__logo pull-left">
				<?= Html::img('@web/img/logo_small.svg', ['alt' => 'Auto Gestión Web', 'height' => '38px']) ?>
				<div class="hidden-xs" style="margin-top: 10px;"><p>Mesa Centro de servicios compartidos.</p></div>
			</div>
			<div class="pull-right">
				<div class="content__icon-menu__aux hidden-xxs">
					<a id="search" href="#" class="menu-trigger"><i class="material-icons icon__26">&#xE8B6;</i></a>
				</div>
				<div class="content__icon-menu__aux">
					<?= Html::a('<i class="material-icons icon__24">&#xE88A;</i>', ['site/principal'], ['class' => 'menu-trigger']) ?>
				</div>
				<div class="content__icon-menu__aux visible-lg-inline-block">
					<div class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle menu-trigger">
							<i class="material-icons icon__24">&#xE5C3;</i>
						</a>
						<ul class="dropdown-menu menu-modul">
							<div class="vin"></div>
							<p class="txt-category fnt__Medium">Productos</p>
							<li class="modul">
								<a href="#">
									<img src="img/icon_nomina.png" alt="Nómina" class="icon-modul">
									<span class="title-modul">Nómina</span>
								</a>
							</li>
							<li class="modul">
								<a href="#">
									<img src="img/icon_awa.png" alt="Awa" class="icon-modul">
									<span class="title-modul">Awa</span>
								</a>
							</li>
							<li class="modul">
								<a href="#">
									<img src="img/icon_hims.png" alt="Hims" class="icon-modul">
									<span class="title-modul">Hims</span>
								</a>
							</li>
							<li class="divider"></li>
							<p class="txt-category fnt__Medium">Módulos</p>
							<?php
								if(@$session['menus'][0]=='TRUE'){
							?>
								<li class="modul">
									<?= Html::a('<img class="icon-modul" src="img/icon_vacaciones.png" alt="Vacaciones"><span class="title-modul">Vacaciones</span>', ['site/vacaciones']) ?>
								</li>
							<?php
								}

								if(@$session['menus'][1]=='TRUE'){
							?>
								<li class="modul">
									<?= Html::a('<img class="icon-modul" src="img/icon_turnos.png" alt="Horas extras"><span class="title-modul">Horas extras</span>', ['site/turnos']) ?>
								</li>
							<?php
								}

								if(@$session['menus'][2]=='TRUE'){
							?>
								<li class="modul">
									<?= Html::a('<img class="icon-modul" src="img/icon_certlaboral.png" alt="Certificado laboral"><span class="title-modul">Certificado laboral</span>', ['site/certificadolaboral']) ?>
								</li>
							<?php
								}

								if(@$session['menus'][3]=='TRUE'){
							?>
								<li class="modul">
									<?= Html::a('<img class="icon-modul" src="img/icon_compago.png" alt="Comprobante de pago"><span class="title-modul">Comprobante de pago</span>', ['site/comprobantespago']) ?>
								</li>
							<?php
								}

								if(@$session['menus'][4]=='TRUE'){
							?>
								<li class="modul">
									<?= Html::a('<img class="icon-modul" src="img/icon_certingreso.png" alt="Certificado de ingresos y retención"><span class="title-modul">Certificado de ingresos</span>', ['site/certificadosretencion']) ?>
								</li>
							<?php
								}
							?>
							<li class="divider"></li>
							<p class="txt-category fnt__Medium">Información</p>
							<?php
								if(@$session['menus'][5]=='TRUE'){
							?>
								<li class="modul">
									<?= Html::a('<img class="icon-modul" src="img/icon_equipnomina.png" alt="Equipo de nómina"><span class="title-modul">Equipo de nómina</span>', ['site/equiponomina']) ?>
								</li>
							<?php
								}

								if(@$session['menus'][6]=='TRUE'){
							?>
								<li class="modul">
									<?= Html::a('<img class="icon-modul" src="img/icon_actlaboral.png" alt="Actualidad laboral"><span class="title-modul">Actualidad laboral</span>', ['site/actualidadlaboral']) ?>
								</li>
							<?php
								}

								if(@$session['menus'][7]=='TRUE'){
							?>
								<li class="modul">
									<?= Html::a('<img class="icon-modul" src="img/icon_cronograma.png" alt="Cronograma cierre de nómina"><span class="title-modul">Cronograma cierre nómina</span>', ['site/cronogramanomina']) ?>
								</li>
							<?php
								}								
							?>
						</ul>
					</div>
				</div>
				<!-- MENÚ MODAL MOBILE -->
				<div class="content__icon-menu__aux hidden-lg">
						<a href="#" class="menu-modal-trigger menu-trigger">
							<i class="material-icons icon__24">&#xE5C3;</i>
						</a>
						<div class="content-menu-modal">
							<nav>
								<ul class="menu-modal">
									<p class="txt-category fnt__Medium">Productos</p>
									<li class="modul">
										<a href="#" onclick="alertsweet()">
											<img src="img/icon_nomina.png" alt="Nómina" class="icon-modul">
											<span class="title-modul">Nómina</span>
										</a>
									</li>
									<li class="modul">
										<a href="#" onclick="alertsweet()">
											<img src="img/icon_awa.png" alt="Awa" class="icon-modul">
											<span class="title-modul">Awa</span>
										</a>
									</li>
									<li class="modul">
										<a href="#" onclick="alertsweet()">
											<img src="img/icon_hims.png" alt="Hims" class="icon-modul">
											<span class="title-modul">Hims</span>
										</a>
									</li>
									<div class="clearfix"></div>
									<p class="txt-category fnt__Medium">Módulos</p>
									<li class="modul">
										<?= Html::a('<img class="icon-modul" src="img/icon_vacaciones.png" alt="Vacaciones"><span class="title-modul">Vacaciones</span>', ['site/vacaciones']) ?>
									</li>
									<li class="modul">
										<?= Html::a('<img class="icon-modul" src="img/icon_turnos.png" alt="Horas extras"><span class="title-modul">Horas extras</span>', ['site/turnos']) ?>
									</li>
									<li class="modul">
										<?= Html::a('<img class="icon-modul" src="img/icon_certlaboral.png" alt="Certificado laboral"><span class="title-modul">Certificado laboral</span>', ['site/certificadolaboral']) ?>
									</li>
									<li class="modul">
										<?= Html::a('<img class="icon-modul" src="img/icon_compago.png" alt="Comprobante de pago"><span class="title-modul">Comprobante de pago</span>', ['site/comprobantespago']) ?>
									</li>
									<li class="modul">
										<?= Html::a('<img class="icon-modul" src="img/icon_certingreso.png" alt="Certificado de ingresos y retención"><span class="title-modul">Certificado de ingresos</span>', ['site/certificadosretencion']) ?>
									</li>
									<div class="clearfix"></div>
									<p class="txt-category fnt__Medium">Información</p>
									<li class="modul">
										<?= Html::a('<img class="icon-modul" src="img/icon_equipnomina.png" alt="Equipo de nómina"><span class="title-modul">Equipo de nómina</span>', ['site/equiponomina']) ?>
									</li>
									<li class="modul">
										<?= Html::a('<img class="icon-modul" src="img/icon_actlaboral.png" alt="Actualidad laboral"><span class="title-modul">Actualidad laboral</span>', ['site/actualidadlaboral']) ?>
									</li>
									<li class="modul">
										<?= Html::a('<img class="icon-modul" src="img/icon_cronograma.png" alt="Cronograma cierre de nómina"><span class="title-modul">Cronograma cierre nómina</span>', ['site/cronogramanomina']) ?>
									</li>
								</ul>
							</nav>
							<a href="" class="close-menu-modal"></a>
						</div>
				</div>
				<div class="content__icon-menu__aux">
					<div id="avatar" class="content-avatar__nav hidden-xs">
						<?= Html::img('@web/img/avatar.png', ['alt' => 'avatar', 'class' => 'img-avatar img-circle']) ?>
					</div>
				</div>
				<div class="content__icon-menu__aux">
					<div class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle menu-trigger"><i class="btn-menu-profile glyphicon glyphicon-option-vertical icon__24"></i></a>
						<ul class="dropdown-menu menu-profile">
							<li><!--
							<div class="dis-inline-block pull-left">
									<div class="content-avatar__menu-profile">
										<?= Html::img('@web/img/avatar.png', ['alt' => 'avatar', 'class' => 'img-avatar img-circle']) ?>
									</div>
							</div>
							-->
								<div class="dis-inline-block">
									<p class="txt-name fnt__Medium"><?= @$session['datopersonal'][0]; ?></p>
									<p class="txt-email"><?= @$session['datopersonaldos'][0]; ?></p>
								</div>
								
							</li>
							<li class="divider"></li>
							<li>
								<p class="txt-cargo fnt__Medium"><?= @$session['datopersonal'][1]; ?></p>
								<p class="txt-info"><?= @$session['datopersonaldos'][1]; ?></p>
								<p class="txt-info"><?= @$session['datopersonaldos'][2]; ?></p>
							</li>
							<li>
								<p class="txt-subcat fnt__Medium">Jefe Inmediato:</p>
								<p class="txt-info"><?= @$session['datopersonaldos'][3]; ?></p>
							</li>
							<li>
								<p class="txt-subcat fnt__Medium">Regional:</p>
								<p class="txt-info"><?= @$session['datopersonaldos'][4]; ?></p>
							</li>
							<li class="divider"></li>
							<li>
								<div class="pull-left">
									<!-- <button class="btn btn-raised btn-default btn-sm">Actualizar</button>-->
								</div>
								<div class="pull-right"> 
								<?= Html::beginForm(['/site/salida'],
								'post', 
								['class' => 'form-inline']); ?>
								<?= Html::submitButton('Salir',['class' => 'btn btn-raised btn-default btn-sm']) ?>
								<?= Html::endForm() ?>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<div class="top-search-content"><div class="search-content"><i id="search-close" class="material-icons clear-icon">&#xE14C;</i><input type="text" class="search-input"><i class="material-icons search-icon">&#xE8B6;</i></div></div>
</header>
<section class="scroller-inner">
	<section id="content">
		<div class="fluid-container main-content">
			<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
			<?= $content ?>
		</div>
	</section>
</section>
<footer class="footer">
	<div class="container">
		<p class="pull-left">&copy; Auto Gestión <?= date('Y') ?></p>
		<p class="pull-right">Powered by <a href="http://www.talentsw.com/" target="_blank">Talentos & Tecnología</a></p>
	</div>
</footer>
	<?php $this->endBody() ?>
</body>
</html>
	<?php $this->endPage() ?>
<script>
	/*
	 * Detectar Navegador móvil
	 */
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	   $('html').addClass('mobile');
	}
</script>
<script>
	function alertsweet() {
	sweetAlert("Atención", "Este módulo no está disponible para la versión móvil, porfavor ejecutar desde la versión de escritorio.", "warning");
	}
</script>
<script>
  $(function () {
    $.material.init();
	$('[data-toggle="tooltip"]').tooltip();
	$(".slide-box-back .btn-toggle").click(function(){
	  $(".container-v").toggleClass("sld-in");
	});
	$("#help").modal("show");
	$("#swipeUp").click(function(){
	  $("#modVac").addClass("open-swipeUp");
	});
	$("#swipeDown").click(function(){
	  $("#modVac").removeClass("open-swipeUp");
	});
  });
</script>
<script>
		$('.ag-carousel.sec').flickity({
		  // options
		  setGallerySize: false,
		  cellAlign: 'left',
		  initialIndex: 0,
		  // contain: true,
		  pageDots: false,
		  dragThreshold: 10,
		});
		$('.ag-carousel').flickity({
		  // options
		  setGallerySize: false,
		  cellAlign: 'left',
		  initialIndex: 1,
		  // contain: true,
		  pageDots: false,
		  dragThreshold: 10,
		});		
</script>
<script>
	(function(){
        $('body').on('click', '#search', function(e){
            e.preventDefault();

            $('#header').addClass('search-toggled');
            $('.top-search-content input').focus();
        });

        $('body').on('click', '#search-close', function(e){
            e.preventDefault();

            $('#header').removeClass('search-toggled');
        });
    })();
</script>
<script>

	function madSelectUp(){
		
		// /////
	// MAD-SELECT
		var madSelectHover = 0;
		$(".mad-select").each(function() {
			var $input = $(this).find("input"),
				$ul = $(this).find("> ul"),
				$ulDrop =  $ul.clone().addClass("mad-select-drop");

			//console.log($(this).find("> ul"));
			
			$(this)
			  .append('<i class="material-icons">arrow_drop_down</i>', $ulDrop)
			  .on({
			  hover : function() { madSelectHover ^= 1; },
			  click : function() { $ulDrop.toggleClass("show");}
			});

			// PRESELECT
			$ul.add($ulDrop).find("li[data-value='"+ $input.val() +"']").addClass("selected");

			// MAKE SELECTED
			$ulDrop.on("click", "li", function(evt) {
			  evt.stopPropagation();
			  $input.val($(this).data("value")); // Update hidden input value
			  $ul.find("li").eq($(this).index()).add(this).addClass("selected")
				.siblings("li").removeClass("selected");
			});
			// UPDATE LIST SCROLL POSITION
			$ul.on("click", function() {
			  var liTop = $ulDrop.find("li.selected").position().top;
			  $ulDrop.scrollTop(liTop + $ulDrop[0].scrollTop);
			});
		});

		$(document).on("mouseup", function(){
			if(!madSelectHover) $(".mad-select-drop").removeClass("show");
		});
		
	}

	$(function () {
		
  //INICIALIZO POR DEFAULT EL MADSELECT SOBREPUESTO
	madSelectUp();
		  
	});
</script>
<script>
	$(document).ready(function() {

		if(bandera==1){
		
		//PROPIEDADES PARA VACACIONES
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			navLinks: true,
			height: 'auto',
			businessHours: { dow: [1,2,3,4,5,6] },
			editable: false,
			eventLimit: false, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			selectOverlap: false,
			select: function(start, end) {
				
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD'));
				//$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd').modal('show');
				
			},
			
			//FUNCION DOBLE CLICK PARA ELIMINAR, AUN NO ES NECESARIO
			/*
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit').modal('show');
					
				});
			},*/
			
			eventDrop: function(event, delta, revertFunc) { // si changement de position

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

				edit(event);

			},

			events: function(start, end, timezone, callback) {
	    	 $.ajax({
	            url:'<?php echo Url::toRoute(['site/jsoncalendar', 'bandera' => '1']);?>', 
	            dataType:'json',
	            success: function (data) {  
	            	var arrayDatos = $.map(data, function(value, index) {
	                    return [value];
	                });  

	            	//console.log(arrayDatos);
	            	var events = [];	

	            	for(var i=0 ; i<arrayDatos.length ; i++){
	            		 events.push({

		                 	id: data[i]['CONSECUTIVO'],
	                        title: "ID ".concat(data[i]['CONSECUTIVO']),
	                        start: data[i]['FEC_INI'],                        
	                        end: data[i]['FEC_FIN'],
	                        color: data[i]['COLOR']
	                    }); 
	            	}  	            	          	
	               
	                callback(events);
	                
	            }
	        });
	        
	    }
		});
		
		}else if(bandera==0){
			
			//PROPIEDADES PARA TURNOS
			
		$('#calendar').fullCalendar({
			header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			navLinks: true,
			height: 'auto',
			businessHours: { dow: [1,2,3,4,5,6] },
			editable: false,
			eventLimit: false, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			selectOverlap: true,
			select: function(start, end) {
				
				$('#ModalAdd #start').val(moment(start).format('DD-MM-YYYY'));
				//$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd').modal('show');
				
			},
			
			//FUNCION DOBLE CLICK PARA ELIMINAR, AUN NO ES NECESARIO
			/*
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit').modal('show');
					
				});
			},*/
			
			eventDrop: function(event, delta, revertFunc) { // si changement de position

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

				edit(event);

			},

			events: function(start, end, timezone, callback) {
	    	 $.ajax({
	            url:'<?php echo Url::toRoute(['site/jsoncalendar', 'bandera' => '0']);?>', 
	            dataType:'json',
	            success: function (data) {  
				var dathor=data['HHEXTRAS'];
				//console.log(dathor);
	            	var arrayDatos = $.map(dathor, function(value, index) {
	                    return [value];
	                });  

	            	//console.log(arrayDatos);
	            	var events = [];	

	            	for(var i=0 ; i<arrayDatos.length ; i++){
	            		 events.push({

		                 	id: dathor[i]['CONSECUTIVO'],
	                        title: "ID ".concat(dathor[i]['CONSECUTIVO']),
	                        start: dathor[i]['FEC_H_EXTRAS'],                        
	                        end: dathor[i]['FEC_H_EXTRAS'],
	                        color: dathor[i]['COLOR']
	                    }); 
	            	}  	            	          	
	               
	                callback(events);
	                
	            }
	        });
	        
	    }
		});
			
			
		}
		
		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			
			id =  event.id;
			
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			
			$.ajax({
			 url: 'editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Registro actualizado');
					}else{
						alert('El registro no fue guardado, intente de nuevo.'); 
					}
				}
			});
		}
		
	});
	
	//CLONAMOS EL DIV PRINCIPAL DE TURNOS PARA ELIMINAR LO DUPLICADO EN CASO DE CANCELAR LA SOLICITUD
	var divClone = $("#panelAdd").html();	
	
	$("#cancelarButton").on("click", function(){
		
		var nuevoEsquema = divClone;
		idsAlerts = new Array("alertaError");
		
		$("#panelAdd").html(nuevoEsquema);
		$firstForm = $("#panel1")
		madSelectUp2("#s2");
	});
	
	var idsAlerts = new Array("alertaError");
	
	//FUNCION PARA CLONAR LAS SOLICITUDES DE TURNOS
	$("#cloneButton").on("click", function(){
		//var $clonedForm = $firstForm.clone().prop('id', 'panel1' );;
		var $clonedForm = $firstForm.clone();
		// console.log($clonedForm);
		$clonedForm.find("#buttonRe").append('<button id="removeButton" class="btn btn-sm btn-default{">Eliminar</button>');	
		
		// CAMBIO DE ID DEL DIV PRINCIPAL
		var $div = $('div[id^="panel"]:last');
		
		$($div).each(function(i) {
		$div.attr('id', $div.attr('id') + i);
		});
		
		//	CAMBIO DE PROPIEDADES PARA INPUT DE DIAS
		var $input = $('input[id^="h"]:last');
		 
		$($input).each(function(i) {
		$input.attr('id', $input.attr('id') + i);
		});
		
		//	CAMBIO DE PROPIEDADES PARA SELECT CONCEPTOS
		var $select = $('div[id^="s2"]:last');
		 
		 
		var nuevoId = "#"+$select.attr('id');
		
		$($select).each(function(i) {
		$select.attr('id', $select.attr('id')+1);
		});

		//CLONO
		$div.after( $clonedForm ).appendTo('#nvid');	
		
		bindRemove($clonedForm);
		
		madSelectUp2(nuevoId);
		
		var nuevoIdMensaje = idsAlerts[idsAlerts.length-1]+""+1;
		
		$("#alertaError").attr("id",nuevoIdMensaje);
		
		idsAlerts.push(nuevoIdMensaje);
		
		// console.log(nuevoId);
	});
	
	var $firstForm = $("#panel1");
	
	
	function bindRemove($form){
    $form.find("#removeButton").on("click", function(){       
		
		var idForm = $form[0].id;
		
		var span = $("#"+idForm).find(".txt-est-hextra");
		var idspan = span[0].id;
		var arrNew = new Array();
		
		for(var i=0 ; i<idsAlerts.length ; i++){
			if(idspan.localeCompare(idsAlerts[i])!=0){
				arrNew.push(idsAlerts[i]);
			}
		}
		
		idsAlerts = arrNew;
		
		$form.remove();
    });
	}

	bindRemove($firstForm);
	
	//////////////////////LA FUNCION DE MADSELECT SE DUPLICA PARA TENER NUEVAS PROPIEDADES DE CLONADO

	function madSelectUp2(id){
		
		// /////
	// MAD-SELECT
		var madSelectHover = 0;
		$(id).each(function() {			
			
			var ulCopy = $(this).find("> ul");	
			var inputCopy = $(this).find("input");
			
			if($(this).find("> ul").hasClass("mad-select-drop")){	
				$(this).find("> ul").remove();
			}
					
			$(this).html(ulCopy[0]);						
			$(this).find("#concpt").after(inputCopy);			
			
				
			var $input = $(this).find("input"),
				$ul = $(this).find("> ul"),
				$ulDrop =  $ul.clone().addClass("mad-select-drop");
			
			$(this)
			  .append('<i class="material-icons">arrow_drop_down</i>', $ulDrop)
			  .on({
			  hover : function() { madSelectHover ^= 1; },
			  click : function() { $ulDrop.toggleClass("show");}
			});

			// PRESELECT
			//$ul.add($ulDrop).find("li[data-value='"+ $input.val() +"']").addClass("selected");

			// MAKE SELECTED
			$ulDrop.on("click", "li", function(evt) {
			  evt.stopPropagation();
			  $input.val($(this).data("value")); // Update hidden input value
			  $ul.find("li").eq($(this).index()).add(this).addClass("selected")
				.siblings("li").removeClass("selected");
			});
			// UPDATE LIST SCROLL POSITION
			$ul.on("click", function() {
			  var liTop = $ulDrop.find("li.selected").position().top;
			  $ulDrop.scrollTop(liTop + $ulDrop[0].scrollTop);
			});
		});

		$(document).on("mouseup", function(){
			if(!madSelectHover) $(".mad-select-drop").removeClass("show");
		});		
	}
</script>