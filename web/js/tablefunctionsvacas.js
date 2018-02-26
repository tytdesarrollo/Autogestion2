	//array que contiene los valores de 
	var arrToggle = new Array();

	function toggleclick(params, operation){
		// separo los datos en un array
		var arrayParam = params.split("*_");
		// identificador que llevara en el array 
		var clave = arrayParam[0]+""+arrayParam[1];	
		// id de boton
		var id = "#toggle"+clave;

		// operacion a realizar agregar al array o eliminar del array
		switch(operation){		
			case 1:
				//agrega al array
				arrToggle.push({clave:clave, valor:params});
				// cambia la funcion onclick
				$(id).attr('onclick', 'toggleclick("'+params+'",2)');

				$("#solicitudAceptar").prop("disabled", false);
				break;

			case 2:
				//recorre el array 
				for (var i=0 ; i<arrToggle.length ; i--) {
					// si la clave coincide se elimina
					if(clave.localeCompare(arrToggle[i].clave) == 0){
						arrToggle.splice(i, 1);
						break;
					}		
				}
				// cambia la funcion onclick 
				$(id).attr('onclick', 'toggleclick("'+params+'",1)');

				if(arrToggle.length == 0){
					$("#solicitudAceptar").prop("disabled", true);
				}
				break;
		}		
	}

	// saber si el toggle ya fue clickeado
	function checkedToggle(id){
		var cont = 0;
		//recorre el array 
		for (var i=0 ; i<arrToggle.length ; i++) {
			// si la clave coincide se elimina
			if(id.localeCompare(arrToggle[i].clave) == 0){
				cont++;
			}		
		}

		// si hay un registro en array ya fue clickeado
		if(cont > 0){
			return true;
		}else{
			return false;
		}
	}

	function rechazarClick(params){
		var datos = params.split("*_");
		var idObserv = "#razonRechaza"+datos[1]+datos[0];
		var observacion = $(idObserv).val();
		//si la observacion es nula no puede continuar
		if(observacion.localeCompare('') == 0){
			swal({
				title: "¡Error, dato vacio!",
				text: "Debe ingresar un comentario de rechazo!",	
				type: "error",
				showCancelButton: false,		
				showConfirmButton: true,		
				cancelButtonColor: "#0288D1",
				confirmButtonClass: "btn-danger",
				confirmButtonText: "",
				closeOnConfirm: false		
			},
			function(){	  	
				swal.close();
				$(idObserv).focus();
			});	
			
		}else{
			var paramSp = params+"*_"+observacion;

			swal({
				title: "¿Está seguro de rechazar la solicitud?",
				text: "El empleado con código "+datos[1]+" será notificado por el rechazo a su solicitud",
				type: "info",
				showCancelButton: true,		
				cancelButtonColor: "#0288D1",
				confirmButtonClass: "btn-danger",
				cancelmButtonText: "Cancelar",
				confirmButtonText: "Si, aceptar",
				closeOnConfirm: false		
			},function(){
				swal({
					title: "<div id='divLoader' class='loader center-block'></div>",
					text: "<div id='textoLoader'>Rechazando solicitud...</div>",			
					html:true,
					showCancelButton: false,		
					showConfirmButton: false,		
					cancelButtonColor: "#0288D1",
					confirmButtonClass: "btn-danger",
					confirmButtonText: "",
					closeOnConfirm: false		
				});

				//Ejecuta el procedimiento despues de 1 segundos
				var delayInMilliseconds = 1000; 

				setTimeout(function() {
					$.ajax({
			            url: rechazarSolicitud, 	                              
			            method: "GET",
			            data: {'paramSp':paramSp},
			            success: function (data){  
			            	console.log(data.localeCompare("true"));
			            	if(data.localeCompare("true") == 0){
			            		swal.close();
			            		cambioPestana(4);
			            		arrToggle = new Array();
			            		swal("!Solicitud rechazada!","La solicitud ha sido rechazada exitosamente.","success");
			            	}
			            },
			            error: function(result) {
			            	swal("¡Error!","Intente de nuevo o comuníquese con el administrador!","error");
			            }
		        	});	
				}, delayInMilliseconds);
			});
		}

		
	}

	function aceptarVacaciones(){
		swal({
			title: "¿Está seguro de aceptar las solicitudes marcadas?",
			text: "El empleado será notificado de la aprobación de sus vacaciones.",
			type: "info",
			showCancelButton: true,		
			cancelButtonColor: "#0288D1",
			confirmButtonClass: "btn-danger",
			cancelmButtonText: "Cancelar",
			confirmButtonText: "Si, aceptar",
			closeOnConfirm: false		
		},
		function(){	  	
			swal({
				title: "<div id='divLoader' class='loader center-block'></div>",
				text: "<div id='textoLoader'>Aceptando solicitudes...</div>",			
				html:true,
				showCancelButton: false,		
				showConfirmButton: false,		
				cancelButtonColor: "#0288D1",
				confirmButtonClass: "btn-danger",
				confirmButtonText: "",
				closeOnConfirm: false		
			});

			//Ejecuta el procedimiento despues de 3 segundos
			var delayInMilliseconds = 3000; //1 second

			setTimeout(function() {
				$.ajax({
		            url: aceptarSolicitudes, 	                              
		            method: "GET",
		            data: {'solicitudes':arrToggle},
		            success: function (data){  
		            	console.log(data);
		            	if(data.localeCompare("true") == 0){
		            		swal.close();
		            		cambioPestana(4);
		            		arrToggle = new Array();
		            		swal("!Solicitudes aceptadas!","Las solicitudes han sido aceptadas exitosamente.","success");
		            	}
		            },
		            error: function(result) {
		            	swal("¡Error!","Intente de nuevo o comuníquese con el administrador!","error");
		            }
	        	});		  	
			}, delayInMilliseconds);
			
		});
	}

	function editarclick(params){
		//valor de la fecha seleccionada
		var fechaIniNew = $("#dateEdit").val();
		// valor de la fecha final 
		var fechaFinNew = $("#fechaFin").val();
		//datos del empleado a cambia la fecha
		var arrParams;
		arrParams = params.split("*_");
		//
		
		swal({
			title: "¿Está seguro de cambiar la fecha de inicio de las vacaciones del empleado?",
			text: "El empleado será notificado del cambio en sus vacaciones.",
			type: "info",
			showCancelButton: true,		
			cancelButtonColor: "#0288D1",
			confirmButtonClass: "btn-danger",
			cancelmButtonText: "Cancelar",
			confirmButtonText: "Si, aceptar",
			closeOnConfirm: false		
		},
		function(){	  	
			swal({
				title: "<div id='divLoader' class='loader center-block'></div>",
				text: "<div id='textoLoader'>Cambiando solicitud...</div>",			
				html:true,
				showCancelButton: false,		
				showConfirmButton: false,		
				cancelButtonColor: "#0288D1",
				confirmButtonClass: "btn-danger",
				confirmButtonText: "",
				closeOnConfirm: false		
			});

			//Ejecuta el procedimiento despues de 3 segundos
			var delayInMilliseconds = 3000; //1 second

			setTimeout(function() {
				$.ajax({
		            url: editarSolicitud, 	                              
		            method: "GET",
		            data: {'codigoepl':arrParams[1],"consecutivo":arrParams[0],"dias":arrParams[2],"fechaini":fechaIniNew,"fechafin":fechaFinNew},
		            success: function (data){  

		            	if(data.localeCompare("true") == 0){
		            		swal.close();
		            		//muestra el modal de las tablas
						    $("#openModalId").click();	    

						    setTimeout(function() {
								cambioPestana(4);
							}, 500); // tiempo para que el modal se cargue 		            		
		            	}
		            },
		            error: function(result) {
		            	swal("¡Error!","Intente de nuevo o comuníquese con el administrador!","error");
		            }
	        	});		  	
			}, delayInMilliseconds);
			
		});
		
		
	}

	function reiniciarToggle(){
		arrToggle = new Array();
	}

	////////////////////////////////////////////////////////////////////////////
	//MODAL DE EDITAR LA FECHA
	//https://robinparisi.github.io/tingle/
	////////////////////////////////////////////////////////////////////////////
	var	idFocus;
	var paramsEdit;

	function mostrarModal(params, id){
		//id de donde fue clickeda la edicion
		idFocus = id;
		//
		paramsEdit = params;
		//cierra el modal de las tablas
		$("#closeModalId").click();
		//
		var arrParams;
		arrParams = params.split("*_");		
		//cambia el contenido del modal
	    modalButtonOnly.setContent(
	    	'<div class="container">'+
			    '<div class="row">'+
			        '<div class="col-sm-7">'+
			            '<h1><strong>Seleccione el período</strong></h1>'+
			            '<br>'+
			        '</div>'+
			    '</div>'+
			    '<div class="row">'+
			        '<div class="col-sm-2">'+
			            'Dias tomados: '+
			            '<spam id="diaTomados">'+arrParams[2]+'</spam>'+
			        '</div>'+
			        '<div class="col-sm-3">'+
			            'Desde <input type="date" id="dateEdit"  onchange="handler(event);">'+
			        '</div>'+
			        '<div class="col-sm-3">'+
			            'hasta: <input type="date" id="fechaFin"  disabled="true">'+			            
			        '</div>'+
			    '</div>'+
			'</div>'
	    );
		//muestra el modal de la modificacion
		modalButtonOnly.open();
	}
	
	

    function handler(e){
    	// fecha la cual selecciona
    	var fechaIngresada = formato(e.target.value);
    	// array con los datos de la fecha
    	var arrFecha = fechaIngresada.split("/");
    	// fecha actual
    	var sysDate = new Date();
    	var fechaActual;
    	var dia = String(sysDate.getDate());    	
    	var mes = String(sysDate.getMonth() + 1);
    	var ano = sysDate.getFullYear();    	
    	//meses y dias con dos digitos
    	if(dia.length == 1){
    		dia = "0"+dia;
    	}

    	if(mes.length == 1){
    		mes = "0"+mes;
    	}

    	fechaActual = dia+"/"+mes+"/"+ano;  

    	// identificar si la fecha es mayor a la actual 
	  	if (compare_dates(fechaIngresada,fechaActual)){  
	  		//fecha ingresada 
	  		var newDate = new Date(parseInt(arrFecha[2]),parseInt(arrFecha[1])-1 ,parseInt(arrFecha[0]));    	
	  		//valida que no sea sabado o domingo	  		
	  		if(newDate.getDay() != 0 && newDate.getDay() != 6){	  				  			
	  			//array conlos parametros del empledo
	  			var arrParams = paramsEdit.split("*_");	  	
	  			var fechaFormat = 	arrFecha[0]+"/"+arrFecha[1]+"/"+arrFecha[2]	;
	  			//calcula la fecha final de las vacaciones
	  			calcularFechaFin(fechaFormat,arrParams[2]);
	  			

	  		}else{
	  			$("#fechaFin").val("");
	  			$("#dateEdit").val("");
	  			$('.tingle-btn--primary').prop("disabled",true);
				swal("Fecha incorrecta","Seleccione una fecha que no sea feriado","error");
	  		}
		}else{  
			$("#fechaFin").val("");
			$("#dateEdit").val("");
			$('.tingle-btn--primary').prop("disabled",true);
			swal("Fecha incorrecta","Seleccione una fecha mayor a la actual","error");
		}  	  	

		
	}
	
	//genera el modal para editar la fecha
	var modalButtonOnly = new tingle.modal({
        closeMethods: [],
        footer: true,
        stickyFooter: true
    });

    //boton de aceptar
    modalButtonOnly.addFooterBtn('Enviar solicitud', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function(){
        modalButtonOnly.close();
    });

    $('.tingle-btn--primary').prop( "disabled",true);

    //boton de cancelar
    modalButtonOnly.addFooterBtn('Cancelar', 'tingle-btn tingle-btn--default tingle-btn--pull-right', function(){
        //se cierra el modal de edicion
        modalButtonOnly.close();
        //muestra el modal de las tablas
	    $("#openModalId").click();	    
	    //se lleva a la fila de donde quedo la vista anstes de la edicion
	    var idFocusIn = "#btnEdit"+idFocus;
	    setTimeout(function() {
			$(idFocusIn).focus();
		}, 500); // tiempo para que el modal se cargue 
    });
	

    function compare_dates(fecha, fecha2){  
		var xMonth = fecha.substring(3, 5);  
		var xDay = fecha.substring(0, 2);  
		var xYear = fecha.substring(6,10);  
		var yMonth = fecha2.substring(3, 5);  
		var yDay = fecha2.substring(0, 2);  
		var yYear = fecha2.substring(6,10);  
		
		if(xYear> yYear) {  
			return(true)  
		}else{  
			if(xYear == yYear) {   
				if(xMonth> yMonth) {  
					return(true)  
				}else{   
					if(xMonth == yMonth){  
						if (xDay> yDay){  
							return(true);  
						}else{
							return(false);  
						}
					}else {
						return(false);  
					}
				}  
			}else{
				return(false);  
			}
		}  
	}  

	function formato(texto){
		return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
	}

	function sumarDias(fecha, dias){
		fecha.setDate(fecha.getDate() + dias);
		return fecha;
	}
	////////////////////////////////////////////////////////////////////////////
	//ORDENAR LOS DATOS 
	////////////////////////////////////////////////////////////////////////////
	var columnaClickeada = '';
	var contClick = 0;
	var columnParam = ' ';
	var pestana = 1;

	function setOrder(id){

		if(id != pestana){
			// inicializan de nuevo las variables
			columnaClickeada = '';
			contClick = 0;
			columnParam = ' ';
			pestana = id;
		}
	}

	function orderByClick(columna, id){	

		//saber si la columna ya fue clickeada 
		if(columnaClickeada.localeCompare(columna) == 0){
			//aumento el contador de veces clickeada la misma columna 
			contClick++;
			// si par organiza en forma ascendente los datos
			if((contClick % 2) == 0){
				columnParam = columna+'//ASC';
				columnaClickeada = columna;
			}else{
				columnParam = columna+'//DESC';
				columnaClickeada = columna;
			}
		}else{
			// al ser otra columna el contador vuelve a cero
			contClick = 0;
			columnaClickeada = columna;
			//
			columnParam = columna+'//ASC';
		}

		switch(id){
			case "1":
				cambioPestana(1,$("#cantidadXP1").val());
				break;
			case "2":
				cambioPestana(2,$("#cantidadXP2").val());
				break;
			case "3":
				cambioPestana(3,$("#cantidadXP3").val());
				break;
			case "4":
				cambioPestana(4,$("#cantidadXP4").val());
				break;
			case "5":
				cambioPestana(5,$("#cantidadXP5").val());
				break;
			default:
				console.log("no esta ingresando");
				break;
		}
	}
