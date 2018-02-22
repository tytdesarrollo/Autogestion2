    /*********************************************************************************************************************
        CARGA DE DATOS PARA LOS JEFES
    *********************************************************************************************************************/
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
                                '<th id="thcnsctv1" onclick="orderByClick(\'thcnsctv\',\'1\')">Consec</th>'+
                                '<th id="thcodepl1" onclick="orderByClick(\'thcodepl\',\'1\')">Codigo empleado</th>'+
                                '<th id="thcedula1" onclick="orderByClick(\'thcedula\',\'1\')">Cedula</th>'+
                                '<th id="thnomape1" onclick="orderByClick(\'thnomape\',\'1\')">Nombres y apellidos</th>'+
                                '<th id="tharecar1" onclick="orderByClick(\'tharecar\',\'1\')">Area / Cargo</th>'+
                                '<th id="thfecsol1" onclick="orderByClick(\'thfecsol\',\'1\')">Fecha solicitud</th>'+
                                '<th id="thfecini1" onclick="orderByClick(\'thfecini\',\'1\')">Fecha inicio</th>'+
                                '<th id="thfecfin1" onclick="orderByClick(\'thfecfin\',\'1\')">Fecha fin</th>'+
                                '<th id="thdiahab1" onclick="orderByClick(\'thdiahab\',\'1\')">Horas registradas</th>'+
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


                            if(datos[i].ESTADO.localeCompare("Aprobado por gerente") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #808B96; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else if(datos[i].ESTADO.localeCompare("Rechazado") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #CB4335; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else if(datos[i].ESTADO.localeCompare("Pendiente por aprobar gerente") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #0f0f6d; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else{
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table label-success" >'+
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

                if(datos[0].ESTADO.localeCompare("N/A") == 0){
                    ocultarPaginador("paginationView1");
                }else{
                    mostrarPaginador("paginationView1");
                }
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
                                '<th id="thcnsctv2" onclick="orderByClick(\'thcnsctv\',\'2\')">Consec</th>'+
                                '<th id="thcodepl2" onclick="orderByClick(\'thcodepl\',\'2\')">Codigo empleado</th>'+
                                '<th id="thcedula2" onclick="orderByClick(\'thcedula\',\'2\')">Cedula</th>'+
                                '<th id="thnomape2" onclick="orderByClick(\'thnomape\',\'2\')">Nombres y apellidos</th>'+
                                '<th id="tharecar2" onclick="orderByClick(\'tharecar\',\'2\')">Area / Cargo</th>'+
                                '<th id="thfecsol2" onclick="orderByClick(\'thfecsol\',\'2\')">Fecha solicitud</th>'+
                                '<th id="thfecini2" onclick="orderByClick(\'thfecini\',\'2\')">Fecha inicio</th>'+
                                '<th id="thfecfin2" onclick="orderByClick(\'thfecfin\',\'2\')">Fecha fin</th>'+
                                '<th id="thdiahab2" onclick="orderByClick(\'thdiahab\',\'2\')">Horas registradas</th>'+
                                '<th id="thdiahab2" onclick="orderByClick(\'threcpor\',\'2\')">Rechazado por</th>'+
                                '<th id="thdiahab2" onclick="orderByClick(\'thobserv\',\'2\')">Observación</th>'+
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
                            '<td>'+datos[i].DIAS+'</td>'+
                            '<td>'+datos[i].RESPUESTA+'</td>'+
                            '<td>'+datos[i].RAZON+'</td>';

                            if(datos[i].ESTADO.localeCompare("Aprobado por gerente") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #808B96; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else if(datos[i].ESTADO.localeCompare("Rechazado") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #CB4335; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else if(datos[i].ESTADO.localeCompare("Pendiente por aprobar gerente") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #0f0f6d; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else{
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table label-success" >'+
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

                if(datos[0].ESTADO.localeCompare("N/A") == 0){
                    ocultarPaginador("paginationView2");
                }else{
                    mostrarPaginador("paginationView2");
                }
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
                                '<th thcnsctv3" onclick="orderByClick(\'thcnsctv\',\'3\')">Consec</th>'+
                                '<th thcodepl3" onclick="orderByClick(\'thcodepl\',\'3\')">Codigo empleado</th>'+
                                '<th thcedula3" onclick="orderByClick(\'thcedula\',\'3\')">Cedula</th>'+
                                '<th thnomape3" onclick="orderByClick(\'thnomape\',\'3\')">Nombres y apellidos</th>'+
                                '<th tharecar3" onclick="orderByClick(\'tharecar\',\'3\')">Area / Cargo</th>'+
                                '<th thfecsol3" onclick="orderByClick(\'thfecsol\',\'3\')">Fecha solicitud</th>'+
                                '<th thfecini3" onclick="orderByClick(\'thfecini\',\'3\')">Fecha inicio</th>'+
                                '<th thfecfin3" onclick="orderByClick(\'thfecfin\',\'3\')">Fecha fin</th>'+
                                '<th thdiahab3" onclick="orderByClick(\'thdiahab\',\'3\')">Horas registradas</th>'+
                                '<th thdiahab3" onclick="orderByClick(\'thcodcon\',\'3\')">Concepto</th>'+
                                '<th >Aceptar</th>'+                                
                                '<th >Rechazar</th>'+
                                '<th >Comentario rechazo</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>';
                
                for (var i=0 ; i<datos.length ; i++) {
                    // si no hay datos en tabla se pone disabled el toggle 
                    var submitButton = '';
                    if(datos[0].COD_EPL.localeCompare("N/A") == 0){
                        submitButton = 'disabled';
                    }

                    // checked toggle
                    var checkedT = "";
                    var operacionT = 1;

                    if(checkedToggle(datos[i].COD_EPL+datos[i].CONSECUTIVO)){
                        checkedT = "checked";
                        operacionT = 2;
                    }

                    //parametros para aceptar la solicitud
                    var datosAceptar = datos[i].COD_EPL+"*_"+datos[i].CONSECUTIVO+"*_"+datos[i].FEC_INI+"*_"+datos[i].FEC_FIN+"*_"+datos[i].COD_CC2+"*_"+datos[i].DIAS+"*_"+datos[i].COD_AUS+"*_"+datos[i].COD_CON2+"*_"+cedula;
                    // parametros para rechazar la solicitud
                    var datosRechazar = datos[i].CONSECUTIVO+"*_"+cedula+"*_"+datos[i].COD_EPL+"*_"+datos[i].DIAS+"*_"+datos[i].FEC_INI;

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
                            '<td>'+datos[i].DIAS+'</td>'+                           
                            '<td>'+datos[i].COD_CON+'</td>'+
                            '<td>'+
                                '<div class="togglebutton">'+
                                    '<label>'+
                                        '<input type="checkbox" onclick="toggleclick(\''+datosAceptar+'\','+operacionT+')" id="toggle'+datos[i].COD_EPL+datos[i].CONSECUTIVO+'" '+checkedT+' '+submitButton+'>'+
                                        '<span class="toggle"></span>'+
                                    '</label>'+
                                '</div>'+
                            '</td>'+                            
                            '<td>'+
                                '<button type="button" class="btn btn-table btn-danger" onclick="rechazarClick(\''+datosRechazar+'\')" '+submitButton+'>'+
                                    '<i class="material-icons">&#xE15C;</i>'+
                                '</button>'+
                            '</td>'+
                            '<td>'+
                                '<input class="input-table" type="text" id="razonRechaza'+datos[i].COD_EPL+datos[i].CONSECUTIVO+'" '+submitButton+'>'+
                            '</td>'+                 
                        '<tr>';  
                }             

                cuerpo = cuerpo +
                        '</tbody>'+
                    '</table>';
                
                document.getElementById("datosTabla3").innerHTML = cuerpo;

                if(datos[0].COD_EPL.localeCompare("N/A") == 0){
                    ocultarPaginador("paginationView3");
                }else{
                    mostrarPaginador("paginationView3");
                }
            }
        });

    } 

    /*********************************************************************************************************************
        CARGA DE DATOS PARA LOS GERENTES
    *********************************************************************************************************************/
    function solicitudesXep4(pagina = 1, filtro = 10){
        //filtros
        var search = $("#search4").val();
        if(search == '') {
            search = " ";
        }
       
        $.ajax({
            url: pestana4, 
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
               paginationControl(pestanas,4);           

                var cuerpo = 
                    '<table class="table">'+
                        '<thead>'+
                            '<tr>'+
                                '<th id="thcnsctv4" onclick="orderByClick(\'thcnsctv\',\'4\')">Consec</th>'+
                                '<th id="thcodepl4" onclick="orderByClick(\'thcodepl\',\'4\')">Codigo empleado</th>'+
                                '<th id="thcedula4" onclick="orderByClick(\'thcedula\',\'4\')">Cedula</th>'+
                                '<th id="thnomape4" onclick="orderByClick(\'thnomape\',\'4\')">Nombres y apellidos</th>'+
                                '<th id="tharecar4" onclick="orderByClick(\'tharecar\',\'4\')">Area / Cargo</th>'+
                                '<th id="thfecsol4" onclick="orderByClick(\'thfecsol\',\'4\')">Fecha solicitud</th>'+
                                '<th id="thfecini4" onclick="orderByClick(\'thfecini\',\'4\')">Fecha inicio</th>'+
                                '<th id="thfecfin4" onclick="orderByClick(\'thfecfin\',\'4\')">Fecha fin</th>'+
                                '<th id="thdiahab4" onclick="orderByClick(\'thdiahab\',\'4\')">Horas registradas</th>'+
                                '<th id="thestado4" onclick="orderByClick(\'thestado\',\'4\')">Estado</th>'+
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


                            if(datos[i].ESTADO.localeCompare("Aprobado por gerente") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #808B96; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else if(datos[i].ESTADO.localeCompare("Rechazado") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #CB4335; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else if(datos[i].ESTADO.localeCompare("Pendiente por aprobar gerente") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #0f0f6d; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else{
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table label-success" >'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }
                }         

                cuerpo = cuerpo +
                        '</tbody>'+
                    '</table>';
                
                document.getElementById("datosTabla4").innerHTML = cuerpo;

                if(datos[0].ESTADO.localeCompare("N/A") == 0){
                    ocultarPaginador("paginationView4");
                }else{
                    mostrarPaginador("paginationView4");
                }
            }
        });
    }

    function solicitudesXep5(pagina = 1, filtro = 10){
        //filtros
        var search = $("#search5").val();
        if(search == '') {
            search = " ";
        }

        $.ajax({
            url: pestana5, 
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
                paginationControl(pestanas,5);            

                var cuerpo = 
                    '<table class="table">'+
                        '<thead>'+
                            '<tr>'+
                                '<th id="thcnsctv5" onclick="orderByClick(\'thcnsctv\',\'5\')">Consec</th>'+
                                '<th id="thcodepl5" onclick="orderByClick(\'thcodepl\',\'5\')">Codigo empleado</th>'+
                                '<th id="thcedula5" onclick="orderByClick(\'thcedula\',\'5\')">Cedula</th>'+
                                '<th id="thnomape5" onclick="orderByClick(\'thnomape\',\'5\')">Nombres y apellidos</th>'+
                                '<th id="tharecar5" onclick="orderByClick(\'tharecar\',\'5\')">Area / Cargo</th>'+
                                '<th id="thfecsol5" onclick="orderByClick(\'thfecsol\',\'5\')">Fecha solicitud</th>'+
                                '<th id="thfecini5" onclick="orderByClick(\'thfecini\',\'5\')">Fecha inicio</th>'+
                                '<th id="thfecfin5" onclick="orderByClick(\'thfecfin\',\'5\')">Fecha fin</th>'+
                                '<th id="thdiahab5" onclick="orderByClick(\'thdiahab\',\'5\')">Horas registradas</th>'+
                                '<th id="thdiahab5" onclick="orderByClick(\'threcpor\',\'5\')">Rechazado por</th>'+                                
                                '<th id="thestado5" onclick="orderByClick(\'thestado\',\'5\')">Estado</th>'+
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
                            '<td>'+datos[i].DIAS+'</td>'+
                            '<td>'+datos[i].RESPUESTA+'</td>';                            

                            if(datos[i].ESTADO.localeCompare("Aprobado por gerente") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #808B96; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else if(datos[i].ESTADO.localeCompare("Rechazado") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #CB4335; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else if(datos[i].ESTADO.localeCompare("Pendiente por aprobar gerente") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #0f0f6d; color: #ffffff;">'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else{
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table label-success" >'+
                                                datos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }
                }             

                cuerpo = cuerpo +
                        '</tbody>'+
                    '</table>';
                
                document.getElementById("datosTabla5").innerHTML = cuerpo;

                if(datos[0].ESTADO.localeCompare("N/A") == 0){
                    ocultarPaginador("paginationView5");
                }else{
                    mostrarPaginador("paginationView5");
                }
            }
        });

    }

    function solicitudesXep6(pagina = 1, filtro = 10){
        //filtros
        var search = $("#search6").val();
        if(search == '') {
            search = " ";
        }

        $.ajax({
            url: pestana6, 
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
                paginationControl(pestanas,6);            

                var cuerpo = 
                    '<table class="table">'+
                        '<thead>'+
                            '<tr>'+                                
                                '<th id="thcodepl6" onclick="orderByClick(\'thcodepl\',\'6\')">Codigo empleado</th>'+                                
                                '<th id="thnomape6" onclick="orderByClick(\'thnomape\',\'6\')">Nombres y apellidos</th>'+                                
                                '<th id="thrn6" onclick="orderByClick(\'thrn\',\'6\')">RN</th>'+
                                '<th id="thhed6" onclick="orderByClick(\'thhed\',\'6\')">HED</th>'+
                                '<th id="thhen6" onclick="orderByClick(\'thhen\',\'6\')">HEN</th>'+
                                '<th id="thhefd6" onclick="orderByClick(\'thhefd\',\'6\')">HEFD</th>'+
                                '<th id="thhefn6" onclick="orderByClick(\'thhefn\',\'6\')">HEFN</th>'+
                                '<th id="thrnd6" onclick="orderByClick(\'thrnd\',\'6\')">HFOD</th>'+                                
                                '<th id="thrdd6" onclick="orderByClick(\'thrdd\',\'6\')">HFON</th>'+
                                '<th id="thjefe6" onclick="orderByClick(\'thjefe\',\'6\')">Jefe Autorizador</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>';
                
                for (var i=0 ; i<datos.length ; i++) {

                    // si no hay datos en tabla se pone disabled el toggle 
                    var submitButton = '';
                    if(datos[0].COD_EPL.localeCompare("N/A") == 0){
                        submitButton = 'disabled';
                    }

                    // checked toggle
                    var checkedT = "";
                    var operacionT = 1;

                    if(checkedToggle(datos[i].COD_EPL+datos[i].NOM_APE)){
                        checkedT = "checked";
                        operacionT = 2;
                    }

                    var nombreSinEspacio = (datos[i].NOM_APE).replace(/ /g , "");
                    //parametros para aceptar la solicitud
                    var datosAceptar = datos[i].COD_EPL+"*_"+nombreSinEspacio+"*_"+datos[i].RND+"*_"+cedula;
                    // parametros para rechazar la solicitud
                    var datosRechazar = nombreSinEspacio+"*_"+cedula+"*_"+datos[i].COD_EPL;
                    //parametros para ver detalle del empleado
                    var datosDetalle = datos[i].COD_EPL;

                    //id del toggle                    
                    var idToggle = (datos[i].COD_EPL+datos[i].NOM_APE).replace(/ /g , "");

                    cuerpo = cuerpo +
                        '<tr>'+
                            '<td>'+datos[i].COD_EPL+'</td>'+                              
                            '<td>'+datos[i].NOM_APE+'</td>'+                            
                            '<td>'+datos[i].RN+'</td>'+
                            '<td>'+datos[i].HED+'</td>'+
                            '<td>'+datos[i].HEN+'</td>'+
                            '<td>'+datos[i].HEFD+'</td>'+
                            '<td>'+datos[i].HEFN+'</td>'+
                            '<td>'+datos[i].RND+'</td>'+
                            '<td>'+datos[i].RDD+'</td>'+
                            '<td>'+datos[i].JEFE+'</td>'+    
                            '<td>'+
                                '<button id="btnDet'+i+'" type="button" class="btn btn-table " onclick="mostrarModal(\''+datosDetalle+'\')" '+submitButton+'>'+
                                    '<i class="material-icons">&#xe3c8;</i>'+
                                '</button>'+
                            '</td>'+
                            '<td>'+
                                '<div class="togglebutton">'+
                                    '<label>'+
                                        '<input type="checkbox" onclick="toggleclick(\''+datosAceptar+'\','+operacionT+')" id="toggle'+idToggle+'" '+checkedT+' '+submitButton+'>'+
                                        '<span class="toggle"></span>'+
                                    '</label>'+
                                '</div>'+
                            '</td>'+                            
                            '<td>'+
                                '<button type="button" class="btn btn-table btn-danger" onclick="rechazarClickGere(\''+datosRechazar+'\')" '+submitButton+'>'+
                                    '<i class="material-icons">&#xE15C;</i>'+
                                '</button>'+
                            '</td>'+
                            '<td>'+
                                '<input class="input-table" type="text" id="razonRechaza'+datos[i].COD_EPL+nombreSinEspacio+'" '+submitButton+'>'+
                            '</td>'+                 
                        '<tr>'; 
 
                }             

                cuerpo = cuerpo +
                        '</tbody>'+
                    '</table>';
                
                document.getElementById("datosTabla6").innerHTML = cuerpo;

                if(datos[0].COD_EPL.localeCompare("N/A") == 0){
                    ocultarPaginador("paginationView6");
                }else{
                    mostrarPaginador("paginationView6");
                }
            }
        });

    }

    function detalleEplHE(codigoEpl,){       

        $.ajax({
            url: detalleEplHistExtr, 
            dataType:'json',                                
            method: "GET",
            data: {'codigoepl':codigoEpl},
            success: function (data) {  
                //un arrray contiene en arrays de cada columna devuelta por el json (consulta hecha a base de datos)
                var arrayDatos = $.map(data, function(value, index) {
                    return [value];
                });                     

                /************************************************************
                    CONSTRUCCION DE LA TABLA DE DATOS
                ************************************************************/
                 var cuerpo = 
                    '<table class="table">'+
                        '<thead>'+
                            '<tr>'+                                
                                '<th>Nombres y apellidos</th>'+
                                '<th>Consecutivo</th>'+
                                '<th>Fecha solicitud</th>'+
                                '<th>Fecha incial</th>'+
                                '<th>Concepto</th>'+
                                '<th>Estado</th>'+                                
                            '</tr>'+
                        '</thead>'+
                        '<tbody>';

                for(var i=0 ; i<arrayDatos.length ; i++){
                    cuerpo = cuerpo +
                        '<tr>'+
                            '<td>'+arrayDatos[i].NOMBRE+'</td>'+
                            '<td>'+arrayDatos[i].CONSECUTIVO+'</td>'+
                            '<td>'+arrayDatos[i].FECHASOL+'</td>'+
                            '<td>'+arrayDatos[i].FEC_INI+'</td>'+
                            '<td>'+arrayDatos[i].CONCEPT+'</td>';

                            if(arrayDatos[i].ESTADO.localeCompare("Aprobado por gerente") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #808B96; color: #ffffff;">'+
                                                arrayDatos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else if(arrayDatos[i].ESTADO.localeCompare("Rechazado") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #CB4335; color: #ffffff;">'+
                                                arrayDatos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else if(arrayDatos[i].ESTADO.localeCompare("Pendiente por aprobar gerente") == 0){
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table" style="background-color: #0f0f6d; color: #ffffff;">'+
                                                arrayDatos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }else{
                                cuerpo = cuerpo + 
                                        '<td>'+
                                            '<div class="label-table label-success" >'+
                                                arrayDatos[i].ESTADO+
                                            '</div>'+
                                        '</td>'+
                                    '<tr>';
                            }
                }

                cuerpo = cuerpo +
                        '</tbody>'+
                    '</table>';

                //cambia el contenido del modal
                modalButtonOnly.setContent(
                    '<div class="container">'+
                        '<div class="row">'+
                            '<div class="col-sm-7">'+
                                '<h1><strong>HISTORIAL DE HORAS EXTRAS</strong></h1>'+
                                '<br>'+
                            '</div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-sm-7">'+                           
                                cuerpo+
                            '</div>'+                       
                        '</div>'+
                    '</div>'
                );
                //muestra el modal de la modificacion
                modalButtonOnly.open();

            }
        });
    }
    
     
     



