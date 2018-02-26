<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcRolesPerfiles extends Model{
	
	////////MENUS////////
	//posicion en array - item menu
	//        0         -  vacaoines
	//        1         -  horas extras
	//        2         -  certificado laboral
	//        3         -  comprobantes de pago
	//        4         -  certificado de ingreso y retencion
	//        5         -  equipo de nomina
	//        6         -  actualidad laboral
	//        7         -  cronograma novedades cierre de nomina
	
	////////SUBMENUS////////
	//posicion en array - item submenu
	//        0         -  solicitar vacaciones
	//        1         -  aceptar y rechazar vacaciones
	//        2         -  solicitar horas extras
	//        3         -  aceptar y rechazar horas extras
	//        4         -  generar certificado laboral 
	//        5         -  generar comprobante de pago
	//        6         -  generar certificado de ingreso y retencion
	//        7         -  informacion de equipo de nomina
	//        8         -  informacion de actividad laboral
	//        9         -  informacion cronograma cierre de nomina

	public function spMenus(){
		$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];		

		$CONEXION = oci_connect($usr, $psw, $db);

		$CEDULA = Yii::$app->session['cedula'];
		$CURSORMENU;
		$CURSORSUBMENU;
		$MENSAJE;		
		$CODMENSAJE;		

		//LLAMA AL PROCEDIMIENTO QUE RETORNA LAS EMPRESAS LOS CONTRATOS Y LAS FACTURAS						
		$stid = oci_parse($CONEXION, 'BEGIN SP_AUTOGES_PERFILES_Y_ROLES(:CEDULA,:MENU,:SUBMENU,:MENSAJE,:CODMENSAJE); END;');
		//SE DECLARAN LOS CURSOR 
		$CURSORMENU = oci_new_cursor($CONEXION);
		$CURSORSUBMENU = oci_new_cursor($CONEXION);		
		//SE PASAN COMO PARAMETRO LOS CURSOR 
		oci_bind_by_name($stid, ':CEDULA', $CEDULA, 15);
		oci_bind_by_name($stid, ':MENU', $CURSORMENU, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':SUBMENU', $CURSORSUBMENU, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':MENSAJE', $MENSAJE, 60);
		oci_bind_by_name($stid, ':CODMENSAJE', $CODMENSAJE,20);
		

	    //SE EJECUTA  LA SENTENCIA SQL
	    oci_execute($stid);
	    oci_execute($CURSORMENU, OCI_DEFAULT);
	    oci_execute($CURSORSUBMENU, OCI_DEFAULT);

	    //extrae cada fila de cada cursor de una variable 
	    oci_fetch_all($CURSORMENU, $cursor1, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($CURSORSUBMENU, $cursor2, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	    foreach ($cursor1 as $key) {
	    	$_SESSION['codigoMensaje'] = $key['VALOR'];
	    }

	    //SE RETORNA LAS VARIABLES QUE CONTIENE LA INFROMACION DE LOS CURSORES
		return array ($cursor1 , $cursor2);
	}

	public function spRolGerente($c1){
		//c1: 
		//
		$db = Yii::$app->params['orcl'];
		$usr = Yii::$app->params['usr'];
		$psw = Yii::$app->params['psw'];
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN PKG_AUTOGES_ROLES_Y_PERFILES.SP_AUTOGES_CONSULTA_ROLGERENTE(:c1,:c2); END;');		
		//
		oci_bind_by_name($stid, ':c1', $c1, 10);
		oci_bind_by_name($stid, ':c2', $c2, 10);		
		// ejecucion del procedimiento 
		oci_execute($stid);				
		// array con los datos y la cantidad de pestanas 
	    return $c2;
	}
}