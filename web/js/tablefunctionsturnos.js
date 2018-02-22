	//array que contiene los valores de 
	var arrToggle = new Array();

	function toggleclick(params, operation){		
		// separo los datos en un array
		var arrayParam = params.split("*_");
		// identificador que llevara en el array 
		var clave = arrayParam[0]+""+arrayParam[1];	
		// id de boton
		var id = "#toggle"+clave;
		console.log(id);	
		// operacion a realizar agregar al array o eliminar del array
		switch(operation){		
			case 1:
				//agrega al array
				arrToggle.push({clave:clave, valor:params});
				// cambia la funcion onclick
				$(id).attr('onclick', 'toggleclick("'+params+'",2)');

				$("#solicitudAceptar").prop("disabled", false);
				$("#solicitudAceptarGere").prop("disabled", false);
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
					$("#solicitudAceptarGere").prop("disabled", true);
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

	function reiniciarToggle(){
		arrToggle = new Array();
	}

	/*********************************************************************************************************************
       JEFES
    *********************************************************************************************************************/
	function rechazarClick(params){
		var datos = params.split("*_");
		var idObserv = "#razonRechaza"+datos[2]+datos[0];		
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
				text: "El empleado con código "+datos[2]+" será notificado por el rechazo a su solicitud",
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
			            url: rechazaSolicitudes, 	                              
			            method: "GET",
			            data: {'paramSp':paramSp},
			            success: function (data){  
			            	console.log(data.localeCompare("true"));
			            	if(data.localeCompare("true") == 0){
			            		swal.close();
			            		cambioPestana(3);
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

	function aceptarTurnos(){
		swal({
			title: "¿Está seguro de aceptar las solicitudes marcadas?",
			text: "El empleado será notificado de la aprobación de sus horas extras.",
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
		            		cambioPestana(3);
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

		/*****************************************************************************************************************
		 MODAL DE DETALLE DEL EMPLEADO
		*****************************************************************************************************************/
		var	idFocus;
		var codigoEplUsar;		

		//genera el modal para editar la fecha
		var modalButtonOnly = new tingle.modal({
	        closeMethods: [],
	        footer: true,
	        stickyFooter: true
	    });

	    //boton de aceptar
	    modalButtonOnly.addFooterBtn('Aceptar', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function(){
	         //se cierra el modal de edicion
	        modalButtonOnly.close();
	        //muestra el modal de las tablas
		    $("#openModalId").click();	    
		    //se lleva a la fila de donde quedo la vista anstes de la edicion
		    var idFocusIn = "#btnDet"+idFocus;
		    setTimeout(function() {
				$(idFocusIn).focus();
			}, 500); // tiempo para que el modal se cargue 
	    });

	    function mostrarModal(params, id){
			//id de donde fue clickeda la edicion
			idFocus = id;		
			
			//cierra el modal de las tablas
			$("#closeModalId").click();

			//
			codigoEplUsar= params;

			//consulta los datos del detalle del empleado y abre el modal
			detalleEplHE(params);			
		}
		/*****************************************************************************************************************
		 MODAL DE DETALLE DEL EMPLEADO
		*****************************************************************************************************************/

	/*********************************************************************************************************************
       GERENTE
    *********************************************************************************************************************/
    function rechazarClickGere(params){
		var datos = params.split("*_");		
		var idObserv = "#razonRechaza"+datos[2]+datos[0];		
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
			            url: rechSolicitudesgre, 	                              
			            method: "GET",
			            data: {'paramSp':paramSp},
			            success: function (data){  
			            	console.log(data.localeCompare("true"));
			            	if(data.localeCompare("true") == 0){
			            		swal.close();
			            		cambioPestana(3);
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

	function aceptarTurnosGere(){
		swal({
			title: "¿Está seguro de aceptar las solicitudes marcadas?",
			text: "El empleado será notificado de la aprobación de sus horas extras.",
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
		            url: acepSolicitudesgre, 	                              
		            method: "GET",
		            data: {'solicitudes':arrToggle},
		            success: function (data){  
		            	console.log(data);
		            	if(data.localeCompare("true") == 0){
		            		swal.close();
		            		cambioPestana(6);
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
			case "6":
				cambioPestana(6,$("#cantidadXP6").val());
				break;			
			default:
				console.log("no esta ingresando");				
				break;
		}
	}