    function solicitudesXepl(pagina = 1, filtro = 10){
		//filtros
		var search = $("#search1").val();
		if(search == '') {
			search = " ";
		}

        $.ajax({
            url: pestana1, 
            dataType:'json',                                
            method: "GET",
            data: {'cantidad':filtro,'pagina':pagina,'search':search, 'column':columnParam, 'cedula':cedula},
            success: function (data) {  
                //un arrray contiene en arrays de cada columna devuelta por el json (consulta hecha a base de datos)
                var arrayDatos = $.map(data, function(value, index) {
                    return [value];
                });     

                var datos = arrayDatos[0];
                var pestanas = arrayDatos[1];

               setGeneralxPage(pestanas);    
               paginationControl(pestanas,1);           

                var cuerpo = 
                    '<table class="table">'+
                        '<thead>'+
                            '<tr>'+
                                '<th id="thcnsctv1" onclick="orderByClick(\'thcnsctv\',\'1\')" width="50">Consec</th>'+
                                '<th id="thcodepl1" onclick="orderByClick(\'thcodepl\',\'1\')" width="80">Codigo empleado</th>'+
                                '<th id="thcedula1" onclick="orderByClick(\'thcedula\',\'1\')">Cedula</th>'+
                                '<th id="thnomape1" onclick="orderByClick(\'thnomape\',\'1\')" width="150">Nombres y apellidos</th>'+
                                '<th id="tharecar1" onclick="orderByClick(\'tharecar\',\'1\')" width="150">Area / Cargo</th>'+
                                '<th id="thfecsol1" onclick="orderByClick(\'thfecsol\',\'1\')" >Fecha solicitud</th>'+
                                '<th id="thfecini1" onclick="orderByClick(\'thfecini\',\'1\')" >Fecha inicio</th>'+
                                '<th id="thfecfin1" onclick="orderByClick(\'thfecfin\',\'1\')">Fecha fin</th>'+
                                '<th id="thdiahab1" onclick="orderByClick(\'thdiahab\',\'1\')" width="50">Días hábiles</th>'+
                                '<th id="thestado1" onclick="orderByClick(\'thestado\',\'1\')">Estado</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>';
                
                for (var i=0 ; i<datos.length ; i++) {
                    cuerpo = cuerpo +
                        '<tr>'+
                            '<th scope="row">'+datos[i].CONSECUTIVO+'</th>'+
                            '<td>'+datos[i].COD_EPL+'</td>'+
                            '<td>'+datos[i].CEDULA+'</td>'+
                            '<td>'+datos[i].NOM_APE+'</td>'+
                            '<td>'+datos[i].AREA_CARGO+'</td>'+
                            '<td>'+datos[i].FECHASOL+'</td>'+
                            '<td>'+datos[i].FEC_INI+'</td>'+
                            '<td>'+datos[i].FEC_FIN+'</td>'+
                            '<td>'+datos[i].DIAS+'</td>';

                            if(datos[i].ESTADO.localeCompare("Rechazado") == 0){
                            	cuerpo = cuerpo + 
	                            		'<td>'+
		                            		'<div class="label-table" style="background-color: #CB4335; color: #ffffff;">'+
		                            			datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+
                            		'<tr>';
                            }else if(datos[i].ESTADO.localeCompare("Aprobado") == 0){
                            	cuerpo = cuerpo + 
                            			'<td>'+
	                            			'<div class="label-table label-success">'+
			                            		datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+
                            		'<tr>';
                            }else{
                            	cuerpo = cuerpo + 
	                            		'<td>'+
		                            		'<div class="label-table" style="background-color: #808B96; color: #ffffff;">'+
		                            			datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+
                            		'<tr>';
                            }
                }         

                cuerpo = cuerpo +
                        '</tbody>'+
                    '</table>';
                
                document.getElementById("datosTabla1").innerHTML = cuerpo;
            }
        });
    }

    function solicitudesXep2(pagina = 1, filtro = 10){
        //filtros
        var search = $("#search2").val();
        if(search == '') {
            search = " ";
        }

        $.ajax({
            url: pestana2, 
            dataType:'json',                                
            method: "GET",
            data: {'cantidad':filtro,'pagina':pagina,'search':search,'column':columnParam, 'cedula':cedula},
            success: function (data) {  
                //un arrray contiene en arrays de cada columna devuelta por el json (consulta hecha a base de datos)
                var arrayDatos = $.map(data, function(value, index) {
                    return [value];
                });     

                var datos = arrayDatos[0];
                var pestanas = arrayDatos[1];

               	setGeneralxPage(pestanas);   
               	paginationControl(pestanas,2);            

                var cuerpo = 
                    '<table class="table">'+
                        '<thead>'+
                            '<tr>'+
                                '<th id="thcnsctv2" onclick="orderByClick(\'thcnsctv\',\'2\')" width="50">Consec</th>'+
                                '<th id="thcodepl2" onclick="orderByClick(\'thcodepl\',\'2\')" width="80">Codigo empleado</th>'+
                                '<th id="thcedula2" onclick="orderByClick(\'thcedula\',\'2\')">Cedula</th>'+
                                '<th id="thnomape2" onclick="orderByClick(\'thnomape\',\'2\')" width="150">Nombres y apellidos</th>'+
                                '<th id="tharecar2" onclick="orderByClick(\'tharecar\',\'2\')" width="150">Area / Cargo</th>'+
                                '<th id="thfecsol2" onclick="orderByClick(\'thfecsol\',\'2\')">Fecha solicitud</th>'+
                                '<th id="thfecini2" onclick="orderByClick(\'thfecini\',\'2\')">Fecha inicio</th>'+
                                '<th id="thfecfin2" onclick="orderByClick(\'thfecfin\',\'2\')">Fecha fin</th>'+
                                '<th id="thdiahab2" onclick="orderByClick(\'thdiahab\',\'2\')" width="50">Días hábiles</th>'+
                                '<th id="thestado2" onclick="orderByClick(\'thestado\',\'2\')">Estado</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>';
                
                for (var i=0 ; i<datos.length ; i++) {
                    cuerpo = cuerpo +
                        '<tr>'+
                            '<th scope="row">'+datos[i].CONSECUTIVO+'</th>'+
                            '<td>'+datos[i].COD_EPL+'</td>'+  
                            '<td>'+datos[i].CEDULA+'</td>'+
                            '<td>'+datos[i].NOM_APE+'</td>'+
                            '<td>'+datos[i].AREA_CARGO+'</td>'+                          
                            '<td>'+datos[i].FECHASOL+'</td>'+
                            '<td>'+datos[i].FEC_INI+'</td>'+
                            '<td>'+datos[i].FEC_FIN+'</td>'+
                            '<td>'+datos[i].DIAS+'</td>';

                            if(datos[i].ESTADO.localeCompare("Rechazado") == 0){
                            	cuerpo = cuerpo + 
	                            		'<td>'+
		                            		'<div class="label-table" style="background-color: #CB4335; color: #ffffff;">'+
		                            			datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+
                            		'<tr>';
                            }else if(datos[i].ESTADO.localeCompare("Aprobado") == 0){
                            	cuerpo = cuerpo + 
                            			'<td>'+
	                            			'<div class="label-table label-success">'+
			                            		datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+
                            		'<tr>';
                            }else{
                            	cuerpo = cuerpo + 
	                            		'<td>'+
		                            		'<div class="label-table" style="background-color: #808B96; color: #ffffff;">'+
		                            			datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+
                            		'<tr>';
                            }
                }             

                cuerpo = cuerpo +
                        '</tbody>'+
                    '</table>';
                
                document.getElementById("datosTabla2").innerHTML = cuerpo;
            }
        });

    }

    function solicitudesXep3(pagina = 1, filtro = 10){
        //filtros
        var search = $("#search3").val();
        if(search == '') {
            search = " ";
        }

        $.ajax({
            url:pestana3, 
            dataType:'json',                                
            method: "GET",
            data: {'cantidad':filtro,'pagina':pagina,'search':search,'column':columnParam,'cedula':cedula},
            success: function (data) {  
                //un arrray contiene en arrays de cada columna devuelta por el json (consulta hecha a base de datos)
                var arrayDatos = $.map(data, function(value, index) {
                    return [value];
                });     

                var datos = arrayDatos[0];
                var pestanas = arrayDatos[1];

               setGeneralxPage(pestanas);      
               paginationControl(pestanas,3);

                var cuerpo = 
                    '<table class="table">'+
                        '<thead>'+
                            '<tr>'+
                                '<th id="thcnsctv3" onclick="orderByClick(\'thcnsctv\',\'3\')" width="50">Consec</th>'+
                                '<th id="thcodepl3" onclick="orderByClick(\'thcodepl\',\'3\')" width="80">Codigo empleado</th>'+
                                '<th id="thcedula3" onclick="orderByClick(\'thcedula\',\'3\')">Cedula</th>'+
                                '<th id="thnomape3" onclick="orderByClick(\'thnomape\',\'3\')" width="150">Nombres y apellidos</th>'+
                                '<th id="tharecar3" onclick="orderByClick(\'tharecar\',\'3\')" width="150">Area / Cargo</th>'+
                                '<th id="thfecsol3" onclick="orderByClick(\'thfecsol\',\'3\')">Fecha solicitud</th>'+
                                '<th id="thfecini3" onclick="orderByClick(\'thfecini\',\'3\')">Fecha inicio</th>'+
                                '<th id="thfecfin3" onclick="orderByClick(\'thfecfin\',\'3\')">Fecha fin</th>'+
                                '<th id="thdiahab3" onclick="orderByClick(\'thdiahab\',\'3\')" width="50">Días hábiles</th>'+
                                '<th id="thestado3" onclick="orderByClick(\'thestado\',\'3\')">Estado</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>';
                
                for (var i=0 ; i<datos.length ; i++) {
                    cuerpo = cuerpo +
                        '<tr>'+
                            '<th scope="row">'+datos[i].CONSECUTIVO+'</th>'+
                            '<td>'+datos[i].COD_EPL+'</td>'+  
                            '<td>'+datos[i].CEDULA+'</td>'+
                            '<td>'+datos[i].NOM_APE+'</td>'+
                            '<td>'+datos[i].AREA_CARGO+'</td>'+                          
                            '<td>'+datos[i].FECHASOL+'</td>'+
                            '<td>'+datos[i].FEC_INI+'</td>'+
                            '<td>'+datos[i].FEC_FIN+'</td>'+
                            '<td>'+datos[i].DIAS+'</td>';

                            if(datos[i].ESTADO.localeCompare("Rechazado") == 0){
                            	cuerpo = cuerpo + 
	                            		'<td>'+
		                            		'<div class="label-table" style="background-color: #CB4335; color: #ffffff;">'+
		                            			datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+
                            		'<tr>';
                            }else if(datos[i].ESTADO.localeCompare("Aprobado") == 0){
                            	cuerpo = cuerpo + 
                            			'<td>'+
	                            			'<div class="label-table label-success">'+
			                            		datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+
                            		'<tr>';
                            }else{
                            	cuerpo = cuerpo + 
	                            		'<td>'+
		                            		'<div class="label-table" style="background-color: #808B96; color: #ffffff;">'+
		                            			datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+
                            		'<tr>';
                            }
                }             

                cuerpo = cuerpo +
                        '</tbody>'+
                    '</table>';
                
                document.getElementById("datosTabla3").innerHTML = cuerpo;
            }
        });

    }   

    function solicitudesXep4(pagina = 1, filtro = 10){
        //filtros
        var search = $("#search4").val();
        if(search == '') {
            search = " ";
        }

        $.ajax({
            url:pestana4, 
            dataType:'json',                                
            method: "GET",
            data: {'cantidad':filtro,'pagina':pagina,'search':search,'column':columnParam,'cedula':cedula},
            success: function (data) {  
                //un arrray contiene en arrays de cada columna devuelta por el json (consulta hecha a base de datos)
                var arrayDatos = $.map(data, function(value, index) {
                    return [value];
                });     

                var datos = arrayDatos[0];
                var pestanas = arrayDatos[1];
                var rol = arrayDatos[2]; 

               setGeneralxPage(pestanas);      
               paginationControl(pestanas,4);

               var edit = '';

               if(rol.localeCompare("ADMIN") == 0){
                    edit = '<th >Editar</th>';
               }

                var cuerpo = 
                    '<table class="table">'+
                        '<thead>'+
                            '<tr>'+
                                '<th thcnsctv4" onclick="orderByClick(\'thcnsctv\',\'4\')" width="50">Consec</th>'+
                                '<th thcodepl4" onclick="orderByClick(\'thcodepl\',\'4\')" width="80">Codigo empleado</th>'+
                                '<th thcedula4" onclick="orderByClick(\'thcedula\',\'4\')">Cedula</th>'+
                                '<th thnomape4" onclick="orderByClick(\'thnomape\',\'4\')" width="150">Nombres y apellidos</th>'+
                                '<th tharecar4" onclick="orderByClick(\'tharecar\',\'4\')" width="150">Area / Cargo</th>'+
                                '<th thfecsol4" onclick="orderByClick(\'thfecsol\',\'4\')">Fecha solicitud</th>'+
                                '<th thfecini4" onclick="orderByClick(\'thfecini\',\'4\')">Fecha inicio</th>'+
                                '<th thfecfin4" onclick="orderByClick(\'thfecfin\',\'4\')">Fecha fin</th>'+
                                '<th thdiahab4" onclick="orderByClick(\'thdiahab\',\'4\')" width="50">Días hábiles</th>'+
                                '<th thestado4" onclick="orderByClick(\'thestado\',\'4\')">Estado</th>'+
                                '<th >Aceptar</th>'+
                                edit+
                                '<th >Rechazar</th>'+
                                '<th >Comentario rechazo</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>';
                
                for (var i=0 ; i<datos.length ; i++) {
                	//parametros para aceptar la solicitud
                	var datosAceptar = datos[i].COD_EPL+"*_"+datos[i].CONSECUTIVO+"*_"+datos[i].COD_CC2+"*_"+datos[i].COD_AUS+"*_"+datos[i].COD_CON+"*_"+datos[i].DIAS+"*_"+datos[i].FEC_INI+"*_"+datos[i].FEC_FIN;
                	// parametros para editar la solicitud
                	var datosEditar = datos[i].CONSECUTIVO+"*_"+datos[i].COD_EPL+"*_"+datos[i].DIAS;
                	// parametros para rechazar la solicitud
                	var datosRechazar = datos[i].CONSECUTIVO+"*_"+datos[i].COD_EPL+"*_"+datos[i].DIAS+"*_"+datos[i].FEC_INI+"*_"+datos[i].FEC_FIN;

                    cuerpo = cuerpo +
                        '<tr>'+
                            '<th scope="row">'+datos[i].CONSECUTIVO+'</th>'+
                            '<td>'+datos[i].COD_EPL+'</td>'+  
                            '<td>'+datos[i].CEDULA+'</td>'+
                            '<td>'+datos[i].NOM_APE+'</td>'+
                            '<td>'+datos[i].AREA_CARGO+'</td>'+                          
                            '<td>'+datos[i].FECHASOL+'</td>'+
                            '<td>'+datos[i].FEC_INI+'</td>'+
                            '<td>'+datos[i].FEC_FIN+'</td>'+
                            '<td>'+datos[i].DIAS+'</td>';

                            //ESTADO DE LA SOLICITUD
                            if(datos[i].ESTADO.localeCompare("Rechazado") == 0){

                                if(rol.localeCompare("ADMIN") == 0){
                                    edit = '<td>'+                                                
                                                '<button id="btnEdit'+i+'" type="button" class="btn btn-table btn-danger" style="color: #F4D03F;" onclick="mostrarModal(\''+datosEditar+'\','+i+')">'+
                                                    '<i class="material-icons">&#xe150;</i>'+
                                                '</button>'+
                                            '</td>';
                                }

                            	cuerpo = cuerpo + 
	                            		'<td>'+
		                            		'<div class="label-table" style="background-color: #CB4335; color: #ffffff;">'+
		                            			datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+   
		                            	'<td>'+
											'<div class="togglebutton">'+
												'<label>'+
													'<input type="checkbox" onclick="toggleclick(\''+datosAceptar+'\',1)" id="toggle'+datos[i].COD_EPL+datos[i].CONSECUTIVO+'">'+
													'<span class="toggle"></span>'+
												'</label>'+
											'</div>'+
										'</td>'+
                                        edit+
										'<td>'+
											'<button type="button" class="btn btn-table btn-danger" onclick="rechazarClick(\''+datosRechazar+'\')" disabled>'+
												'<i class="material-icons">&#xE15C;</i>'+
											'</button>'+
										'</td>'+
										'<td><input class="input-table" type="text" id="razonRechaza'+datos[i].COD_EPL+datos[i].CONSECUTIVO+'" disabled></td>'+					
									'<tr>';	   

                            }else if(datos[i].ESTADO.localeCompare("Aprobado") == 0){

                                if(rol.localeCompare("ADMIN") == 0){
                                    edit = '<td>'+                                                
                                                '<button id="btnEdit'+i+'" type="button" class="btn btn-table" style="color: #F4D03F;" onclick="mostrarModal(\''+datosEditar+'\','+i+')">'+
                                                    '<i class="material-icons">&#xe150;</i>'+
                                                '</button>'+
                                            '</td>';
                                }

                            	cuerpo = cuerpo + 
	                        			'<td>'+
	                            			'<div class="label-table label-success">'+
			                            		datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+
		                            	'<td>'+
											'<div class="togglebutton">'+
												'<label>'+
													'<input type="checkbox" onclick="toggleclick(\''+datosAceptar+'\',1)" id="toggle'+datos[i].COD_EPL+datos[i].CONSECUTIVO+'" disabled>'+
													'<span class="toggle"></span>'+
												'</label>'+
											'</div>'+
										'</td>'+
                                        edit+
										'<td>'+
											'<button type="button" class="btn btn-table btn-danger" onclick="rechazarClick(\''+datosRechazar+'\')">'+
												'<i class="material-icons">&#xE15C;</i>'+
											'</button>'+
										'</td>'+
										'<td><input class="input-table" type="text" id="razonRechaza'+datos[i].COD_EPL+datos[i].CONSECUTIVO+'"></td>'+					
									'<tr>';	   
                            }else{
                            	// checked toggle
                            	var checkedT = "";
                            	var operacionT = 1;

                            	if(checkedToggle(datos[i].COD_EPL+datos[i].CONSECUTIVO)){
                            		checkedT = "checked";
                            		operacionT = 2;
                            	}

                                if(rol.localeCompare("ADMIN") == 0){                                    
                                    edit = '<td>'+
                                                
                                                '<button id="btnEdit'+i+'" type="button" class="btn btn-table" style="color: #F4D03F;" onclick="mostrarModal(\''+datosEditar+'\','+i+')">'+
                                                    '<i class="material-icons">&#xe150;</i>'+
                                                '</button>'+
                                            '</td>';
                                }

                            	cuerpo = cuerpo + 
	                            		'<td>'+
		                            		'<div class="label-table" style="background-color: #808B96; color: #ffffff;">'+
		                            			datos[i].ESTADO+
		                            		'</div>'+
		                            	'</td>'+
		                            	'<td>'+
											'<div class="togglebutton">'+
												'<label>'+
													'<input type="checkbox" onclick="toggleclick(\''+datosAceptar+'\','+operacionT+')" id="toggle'+datos[i].COD_EPL+datos[i].CONSECUTIVO+'" '+checkedT+'>'+
													'<span class="toggle"></span>'+
												'</label>'+
											'</div>'+
										'</td>'+
                                        edit+
										'<td>'+
											'<button type="button" class="btn btn-table btn-danger" onclick="rechazarClick(\''+datosRechazar+'\')">'+
												'<i class="material-icons">&#xE15C;</i>'+
											'</button>'+
										'</td>'+
										'<td><input class="input-table" type="text" id="razonRechaza'+datos[i].COD_EPL+datos[i].CONSECUTIVO+'"></td>'+					
									'<tr>';	                 		
                            }

                    
	                    				
                }             

                cuerpo = cuerpo +
                        '</tbody>'+
                    '</table>';
                
                document.getElementById("datosTabla4").innerHTML = cuerpo;
            }
        });

    }  

    function calcularFechaFin(fecha , dias){
        $.ajax({
            url:calculoFechas,                                 
            method: "GET",
            data: {'fecha':fecha,'dias':dias},
            success: function (data) {  
                //
                var arrData = data.split("/");
                var fechaNew = arrData[2]+"-"+arrData[1]+"-"+arrData[0];
                //
                document.getElementById("fechaFin").value = fechaNew;                
                $('.tingle-btn--primary').prop("disabled",false);
                $('.tingle-btn--primary').attr("onclick","editarclick('"+paramsEdit+"')");
            }
        });

    }