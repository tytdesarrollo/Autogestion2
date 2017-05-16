<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class RolesPerfiles extends Model{

	public function spMenus(){
		$db = Yii::$app->params['orcl'];		

		$CONEXION = oci_connect('TELEPRU', 'tytcali', $db);

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
}