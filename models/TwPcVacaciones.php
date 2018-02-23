<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcVacaciones extends Model{

	public function Vacaciones(){
		$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];		

		$CONEXION = oci_connect($usr, $psw, $db);
		
		//Entrada
		$CODIGO_EPL = Yii::$app->session['cedula'];
			
		//cursores
		$BLOQUE1;
		$BLOQUE2;
		//Strings
		$CODIGO_EPL;		
		$OUTPUT_B1;	
		$OUTPUT_B2;	
		$OUT_DIAS_PEND;		

		//LLAMA AL PROCEDIMIENTO					
		$stid = oci_parse($CONEXION, 'BEGIN TW_PC_VACACIONES(:IN_CODIGO_EPL,:BLOQUE1,:OUTPUT_B1,:BLOQUE2,:OUTPUT_B2,:OUT_DIAS_PEND);END;');
		//SE DECLARAN LOS CURSOR 
		$BLOQUE1 = oci_new_cursor($CONEXION);	
		$BLOQUE2 = oci_new_cursor($CONEXION);	
		//SE PASAN COMO PARAMETRO LOS CURSOR 

		oci_bind_by_name($stid, ':BLOQUE1', $BLOQUE1, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':BLOQUE2', $BLOQUE2, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':IN_CODIGO_EPL', $CODIGO_EPL, 12);
		oci_bind_by_name($stid, ':OUTPUT_B1', $OUTPUT_B1,200);
		oci_bind_by_name($stid, ':OUTPUT_B2', $OUTPUT_B2,200);
		oci_bind_by_name($stid, ':OUT_DIAS_PEND', $OUT_DIAS_PEND,10);
		
	    //SE EJECUTA  LA SENTENCIA SQL
	    oci_execute($stid);
	    oci_execute($BLOQUE1, OCI_DEFAULT);
	    oci_execute($BLOQUE2, OCI_DEFAULT);

	    //extrae cada fila de cada cursor de una variable 
	    oci_fetch_all($BLOQUE1, $cursor1, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($BLOQUE2, $cursor2, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	    //SE RETORNA LAS VARIABLES QUE CONTIENE LA INFROMACION DE LOS CURSORES
		return array ($cursor1, $cursor2, $OUTPUT_B1, $OUTPUT_B2, $OUT_DIAS_PEND);
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
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUDES_POR_EPL_MV(:c1,:c2,:c3,:c4,:c5,:c6,:c7); END;');
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

	public function solicitudesRechazadas($c1,$c2,$c3,$c4,$c5){
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
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUDESRECHAZADAS_MV(:c1,:c2,:c3,:c4,:c5,:c6,:c7); END;');
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

	public function solicitudesVigentes($c1,$c2,$c3,$c4,$c5){
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
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUDES_VIGENTES_MV(:c1,:c2,:c3,:c4,:c5,:c6,:c7); END;');
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

	public function solicitudesAcepRech($c1,$c2,$c3,$c4,$c5){
		//c1: cantidad de datos por pagina
		//c2: pagina a visualizar
		//c3: filtro de busqueda
		//c4: order por columna
		//c5: cedula de quien ingresa
		//c6: cantidad de pestanas a generar
		//c7: datos de l consulta
		//c8: rol de la sesion
		//		
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUD_APROV_RECHA_MV(:c1,:c2,:c3,:c4,:c5,:c6,:c7,:c8); END;');
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
		oci_bind_by_name($stid, ':c8', $c8, 10);
		// ejecucion del procedimiento 
		oci_execute($stid);
		oci_execute($c7);
		// datos del cursor
		oci_fetch_all($c7, $cursor, null, null, OCI_FETCHSTATEMENT_BY_ROW);		
		// array con los datos y la cantidad de pestanas 
	    return array($cursor,$c6,$c8);
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
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUD_ACEPTAR_MV(:c1); END;');

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
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUD_RECHAZA_MV(:c1); END;');

		oci_bind_array_by_name($stid, ":c1", $c1, 100, -1, SQLT_CHR);

		oci_execute($stid);

		return 'true';
	}

	public function solicitudesEditar($c1,$c2,$c3,$c4,$c5){
		//c1: codigo del empleado de la solicitud
		//c2: consecutivo de la solicitud
		//c3: dias solicitados
		//c4: fecha de inicio
		//c5: fecha de finalizacion

		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_SOLICITUD_EDITA_MV(:c1,:c2,:c3,:c4,:c5); END;');
		
		//parametros
		oci_bind_by_name($stid, ':c1', $c1, 12);
		oci_bind_by_name($stid, ':c2', $c2, 10);
		oci_bind_by_name($stid, ':c3', $c3, 10);
		oci_bind_by_name($stid, ':c4', $c4, 10);
		oci_bind_by_name($stid, ':c5', $c5, 10);	
	    
	    oci_execute($stid);
	    
		return 'true';
	}

	public function calcularFecha($c1,$c2){	
		//c1: codigo del empleado de la solicitud
		//c2: fecha que inicia las vacaciones
		//c3: cantidad de dias
		//c4: fecha o mensaje de salida
		//c5: codigo de salida

		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_CALCULA_FECHA(:c1,:c2,:c3); END;');
		
		//parametros
		oci_bind_by_name($stid, ':c1', $c1, 10);
		oci_bind_by_name($stid, ':c2', $c2, 10);
		oci_bind_by_name($stid, ':c3', $c3, 10);	
	    
	    oci_execute($stid);
	    
		return $c3;
	}

	public function historialEmpleado($c1,$c2,$c3,$c4,$c5){
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
		$stid = oci_parse($conexion, 'BEGIN TW_PC_HISTORIAL_EMPLEADO_MV(:c1,:c2,:c3,:c4,:c5,:c6,:c7); END;');
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

	public function validaVacaciones($c1,$c2,$c3){
		//c1: codigo
		//c2: fecha
		//c3: dias
		//c4: codigo de mensaje
		//c5: mensaje
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_VALIDAR_VACACIONES(:c1,:c2,:c3,:c4,:c5); END;');

		oci_bind_by_name($stid, ':c1', $c1, 12);
		oci_bind_by_name($stid, ':c2', $c2, 10);
		oci_bind_by_name($stid, ':c3', $c3, 10);
		oci_bind_by_name($stid, ':c4', $c4, 200);
		oci_bind_by_name($stid, ':c5', $c5, 200);
		// ejecucion del procedimiento 
		oci_execute($stid);

		//codigo y mensaje
	    return array($c4,$c5);	
	}

	public function envioVacaciones($c1,$c2,$c3,$c4){
		//c1: codigo
		//c2: cantidad de dias
		//c3: fecha inicial
		//c4: fecha final
		//c5: codigo
		//c6: mensaje
		//
		// TNS DE LA BASE DE DATOS
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_ENVIO_VACACIONES(:c1,:c2,:c3,:c4,:c5,:c6); END;');

		oci_bind_by_name($stid, ':c1', $c1, 12);
		oci_bind_by_name($stid, ':c2', $c2, 10);
		oci_bind_by_name($stid, ':c3', $c3, 200);
		oci_bind_by_name($stid, ':c4', $c4, 200);
		oci_bind_by_name($stid, ':c5', $c5, 200);
		oci_bind_by_name($stid, ':c6', $c6, 200);
		// ejecucion del procedimiento 
		oci_execute($stid);

		//codigo y mensaje
	    return array($c5,$c6);	
	}

}