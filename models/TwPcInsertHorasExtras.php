<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcInsertHorasExtras extends Model{

	public function HorasExtrasVal(){
		$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];		

		$CONEXION = oci_connect($usr, $psw, $db);
		
		//Entrada
		$CODIGO_EPL = Yii::$app->session['cedula'];
		
		$IN_HORAS = '';
		$IN_FECHA = '';
		$IN_CONCEPTO = '';
		
		//Salida
		
		//cursores
		$BLOQUE1;
		//Strings
		$CODIGO_EPL;
		$IN_HORAS;
		$IN_FECHA;
		$IN_CONCEPTO;
		$MESSAGE;	
		$OUTPUT;		

		//LLAMA AL PROCEDIMIENTO					
		$stid = oci_parse($CONEXION, 'BEGIN TW_PC_INSERT_HORAS_EXTRAS(:IN_CODIGO_EPL,:IN_HORAS,:IN_FECHA,:IN_CONCEPTO,:IN_INSERT,:BLOQUE1,:OUTPUT,:MESSAGE);END;');
		//SE DECLARAN LOS CURSOR 
		$BLOQUE1 = oci_new_cursor($CONEXION);	
		//SE PASAN COMO PARAMETRO LOS CURSOR 

		oci_bind_by_name($stid, ':IN_CODIGO_EPL', $CODIGO_EPL, 12);
		oci_bind_by_name($stid, ':IN_HORAS',  $he1,200);
		oci_bind_by_name($stid, ':IN_FECHA', $he2,200);
		oci_bind_by_name($stid, ':IN_CONCEPTO', $he3,200);
		oci_bind_by_name($stid, ':IN_INSERT', $he4,200);
		oci_bind_by_name($stid, ':BLOQUE1', $BLOQUE1, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':OUTPUT', $OUTPUT,200);		
		oci_bind_by_name($stid, ':MESSAGE', $MESSAGE,200);

		

	    //SE EJECUTA  LA SENTENCIA SQL
	    oci_execute($stid);
	    oci_execute($BLOQUE1, OCI_DEFAULT);

	    //extrae cada fila de cada cursor de una variable 
	    oci_fetch_all($BLOQUE1, $cursor1, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	    //SE RETORNA LAS VARIABLES QUE CONTIENE LA INFROMACION DE LOS CURSORES
		return array ($cursor1);
	}
	
	public function HorasExtrasRec($he1,$he2,$he3,$he4){
		
		$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];		

		$CONEXION = oci_connect($usr, $psw, $db);
		
		//Entrada
		$CODIGO_EPL = Yii::$app->session['cedula'];
		
		//Salida
		
		//cursores
		$BLOQUE1;
		//Strings
		$CODIGO_EPL;
		$MESSAGE;	
		$OUTPUT;		

		//LLAMA AL PROCEDIMIENTO					
		$stid = oci_parse($CONEXION, 'BEGIN TW_PC_INSERT_HORAS_EXTRAS(:IN_CODIGO_EPL,:IN_HORAS,:IN_FECHA,:IN_CONCEPTO,:IN_INSERT,:BLOQUE1,:OUTPUT,:MESSAGE);END;');
		//SE DECLARAN LOS CURSOR 
		$BLOQUE1 = oci_new_cursor($CONEXION);	
		//SE PASAN COMO PARAMETRO LOS CURSOR 

		oci_bind_by_name($stid, ':IN_CODIGO_EPL', $CODIGO_EPL, 12);
		oci_bind_by_name($stid, ':IN_HORAS',  $he1,200);
		oci_bind_by_name($stid, ':IN_FECHA', $he2,200);
		oci_bind_by_name($stid, ':IN_CONCEPTO', $he3,200);
		oci_bind_by_name($stid, ':IN_INSERT', $he4,200);
		oci_bind_by_name($stid, ':BLOQUE1', $BLOQUE1, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':OUTPUT', $OUTPUT,200);		
		oci_bind_by_name($stid, ':MESSAGE', $MESSAGE,200);

	    //SE EJECUTA  LA SENTENCIA SQL
	    oci_execute($stid);

	    //SE RETORNA LAS VARIABLES QUE CONTIENE LA INFROMACION DE LOS CURSORES
		return array ($MESSAGE,$OUTPUT);
	}

	public function solicitudesEpl($c1,$c2,$c3,$c4,$c5){
		//c1: cantidad de datos por pagina
		//c2: pagina a visualizar
		//c3: filtro de busqueda
		//c4: order por columna
		//c5: cedula de quien ingresa
		//c6: cantidad de pestanas a generar
		//c7: datos de l consulta
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUDES_POR_EPL_TR(:c1,:c2,:c3,:c4,:c5,:c6,:c7); END;');
		//parametros 		
		$c6;
		$c7 = oci_new_cursor($conexion);        
		//
		oci_bind_by_name($stid, ':c1', $c1, 10);
		oci_bind_by_name($stid, ':c2', $c2, 10);
		oci_bind_by_name($stid, ':c3', $c3, 50);
		oci_bind_by_name($stid, ':c4', $c4, 50);
		oci_bind_by_name($stid, ':c5', $c5, 30);
		oci_bind_by_name($stid, ':c6', $c6, 10);
		oci_bind_by_name($stid, ':c7', $c7, -1, OCI_B_CURSOR);
		// ejecucion del procedimiento 
		oci_execute($stid);
		oci_execute($c7);
		// datos del cursor
		oci_fetch_all($c7, $cursor, null, null, OCI_FETCHSTATEMENT_BY_ROW);		
		// array con los datos y la cantidad de pestanas 
	    return array($cursor,$c6);		
	}

	public function solicitudesEp2($c1,$c2,$c3,$c4,$c5){
		//c1: cantidad de datos por pagina
		//c2: pagina a visualizar
		//c3: filtro de busqueda
		//c4: order por columna
		//c5: cedula de quien ingresa
		//c6: cantidad de pestanas a generar
		//c7: datos de l consulta
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUDES_RECHAZADASTR(:c1,:c2,:c3,:c4,:c5,:c6,:c7); END;');
		//parametros 		
		$c6;
		$c7 = oci_new_cursor($conexion);        
		//
		oci_bind_by_name($stid, ':c1', $c1, 10);
		oci_bind_by_name($stid, ':c2', $c2, 10);
		oci_bind_by_name($stid, ':c3', $c3, 50);
		oci_bind_by_name($stid, ':c4', $c4, 50);
		oci_bind_by_name($stid, ':c5', $c5, 30);
		oci_bind_by_name($stid, ':c6', $c6, 10);
		oci_bind_by_name($stid, ':c7', $c7, -1, OCI_B_CURSOR);
		// ejecucion del procedimiento 
		oci_execute($stid);
		oci_execute($c7);
		// datos del cursor
		oci_fetch_all($c7, $cursor, null, null, OCI_FETCHSTATEMENT_BY_ROW);		
		// array con los datos y la cantidad de pestanas 
	    return array($cursor,$c6);		
	}

	public function solicitudesEp3($c1,$c2,$c3,$c4,$c5){
		//c1: cantidad de datos por pagina
		//c2: pagina a visualizar
		//c3: filtro de busqueda
		//c4: order por columna
		//c5: cedula de quien ingresa
		//c6: cantidad de pestanas a generar
		//c7: datos de l consulta
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUD_APROV_RECHA_TR(:c1,:c2,:c3,:c4,:c5,:c6,:c7); END;');
		//parametros 		
		$c6;
		$c7 = oci_new_cursor($conexion);        
		//
		oci_bind_by_name($stid, ':c1', $c1, 10);
		oci_bind_by_name($stid, ':c2', $c2, 10);
		oci_bind_by_name($stid, ':c3', $c3, 50);
		oci_bind_by_name($stid, ':c4', $c4, 50);
		oci_bind_by_name($stid, ':c5', $c5, 30);
		oci_bind_by_name($stid, ':c6', $c6, 10);
		oci_bind_by_name($stid, ':c7', $c7, -1, OCI_B_CURSOR);
		// ejecucion del procedimiento 
		oci_execute($stid);
		oci_execute($c7);
		// datos del cursor
		oci_fetch_all($c7, $cursor, null, null, OCI_FETCHSTATEMENT_BY_ROW);		
		// array con los datos y la cantidad de pestanas 
	    return array($cursor,$c6);		
	}

	public function solicitudesEp4($c1,$c2,$c3,$c4,$c5){
		//c1: cantidad de datos por pagina
		//c2: pagina a visualizar
		//c3: filtro de busqueda
		//c4: order por columna
		//c5: cedula de quien ingresa
		//c6: cantidad de pestanas a generar
		//c7: datos de l consulta
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUD_X_EPL_GRNTE_TR(:c1,:c2,:c3,:c4,:c5,:c6,:c7); END;');
		//parametros 		
		$c6;
		$c7 = oci_new_cursor($conexion);        
		//
		oci_bind_by_name($stid, ':c1', $c1, 10);
		oci_bind_by_name($stid, ':c2', $c2, 10);
		oci_bind_by_name($stid, ':c3', $c3, 50);
		oci_bind_by_name($stid, ':c4', $c4, 50);
		oci_bind_by_name($stid, ':c5', $c5, 30);
		oci_bind_by_name($stid, ':c6', $c6, 10);
		oci_bind_by_name($stid, ':c7', $c7, -1, OCI_B_CURSOR);
		// ejecucion del procedimiento 
		oci_execute($stid);
		oci_execute($c7);
		// datos del cursor
		oci_fetch_all($c7, $cursor, null, null, OCI_FETCHSTATEMENT_BY_ROW);		
		// array con los datos y la cantidad de pestanas 
	    return array($cursor,$c6);		
	}

	public function solicitudesEp5($c1,$c2,$c3,$c4,$c5){
		//c1: cantidad de datos por pagina
		//c2: pagina a visualizar
		//c3: filtro de busqueda
		//c4: order por columna
		//c5: cedula de quien ingresa
		//c6: cantidad de pestanas a generar
		//c7: datos de l consulta
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICIT_RECHAZAD_GRNT_TR(:c1,:c2,:c3,:c4,:c5,:c6,:c7); END;');
		//parametros 		
		$c6;
		$c7 = oci_new_cursor($conexion);        
		//
		oci_bind_by_name($stid, ':c1', $c1, 10);
		oci_bind_by_name($stid, ':c2', $c2, 10);
		oci_bind_by_name($stid, ':c3', $c3, 50);
		oci_bind_by_name($stid, ':c4', $c4, 50);
		oci_bind_by_name($stid, ':c5', $c5, 30);
		oci_bind_by_name($stid, ':c6', $c6, 10);
		oci_bind_by_name($stid, ':c7', $c7, -1, OCI_B_CURSOR);
		// ejecucion del procedimiento 
		oci_execute($stid);
		oci_execute($c7);
		// datos del cursor
		oci_fetch_all($c7, $cursor, null, null, OCI_FETCHSTATEMENT_BY_ROW);		
		// array con los datos y la cantidad de pestanas 
	    return array($cursor,$c6);		
	}

	public function solicitudesEp6($c1,$c2,$c3,$c4,$c5){
		//c1: cantidad de datos por pagina
		//c2: pagina a visualizar
		//c3: filtro de busqueda
		//c4: order por columna
		//c5: cedula de quien ingresa
		//c6: cantidad de pestanas a generar
		//c7: datos de l consulta
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUD_APVRCH_GRNT_TR(:c1,:c2,:c3,:c4,:c5,:c6,:c7); END;');
		//parametros 		
		$c6;
		$c7 = oci_new_cursor($conexion);        
		//
		oci_bind_by_name($stid, ':c1', $c1, 10);
		oci_bind_by_name($stid, ':c2', $c2, 10);
		oci_bind_by_name($stid, ':c3', $c3, 50);
		oci_bind_by_name($stid, ':c4', $c4, 50);
		oci_bind_by_name($stid, ':c5', $c5, 30);
		oci_bind_by_name($stid, ':c6', $c6, 10);
		oci_bind_by_name($stid, ':c7', $c7, -1, OCI_B_CURSOR);
		// ejecucion del procedimiento 
		oci_execute($stid);
		oci_execute($c7);
		// datos del cursor
		oci_fetch_all($c7, $cursor, null, null, OCI_FETCHSTATEMENT_BY_ROW);		
		// array con los datos y la cantidad de pestanas 
	    return array($cursor,$c6);		
	}

	public function solicitudesAceptar($c1){
		//$c1  datos del empleado a confirmar solicitud
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUD_ACEPTAR_TR(:c1); END;');

		oci_bind_array_by_name($stid, ":c1", $c1, 100, -1, SQLT_CHR);

		oci_execute($stid);

		return 'true';
	}

	public function solicitudesRechazar($c1){
		//$c1  datos del empleado a rechazar solicitud
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUD_RECHAZA_TR(:c1); END;');

		oci_bind_array_by_name($stid, ":c1", $c1, 100, -1, SQLT_CHR);

		oci_execute($stid);

		return 'true';
	}
	public function detalleHistorialHorasExtrasGere($c1){
		//$1  codigo del empleado ue se consulta el historial
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_HISTORIAL_EPL_GERENTE_TR(:c1,:c2); END;');
		//parametros 				
		$c2 = oci_new_cursor($conexion);        
		//
		oci_bind_by_name($stid, ':c1', $c1, 12);
		oci_bind_by_name($stid, ':c2', $c2, -1, OCI_B_CURSOR);
		// ejecucion del procedimiento 
		oci_execute($stid);
		oci_execute($c2);
		// datos del cursor
		oci_fetch_all($c2, $cursor, null, null, OCI_FETCHSTATEMENT_BY_ROW);		

		return $cursor;
	}

	public function solicitudesAceptarGre($c1){
		//$c1  datos del empleado a confirmar solicitud
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUD_ACEPTA_GRNT_TR(:c1); END;');

		oci_bind_array_by_name($stid, ":c1", $c1, 100, -1, SQLT_CHR);

		oci_execute($stid);

		return 'true';
	}

	public function solicitudesRechazaGre($c1){
		//$c1  datos del empleado a confirmar solicitud
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUD_RECHAZA_GRT_TR(:c1); END;');

		oci_bind_array_by_name($stid, ":c1", $c1, 100, -1, SQLT_CHR);

		oci_execute($stid);

		return 'true';
	}
}