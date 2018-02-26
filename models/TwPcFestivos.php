<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcFestivos extends Model{	

	/*public function diaFeriado($fecha){
		$db = Yii::$app->params['orcl'];		

		$CONEXION = oci_connect('TELEPRU', 'tytcali', $db);

		//LLAMA AL PROCEDIMIENTO QUE RETORNA LAS EMPRESAS LOS CONTRATOS Y LAS FACTURAS						
		$stid = oci_parse($CONEXION, 'BEGIN SP_DIAS_FERIADOS_AUTOGES(:FECHA,:FERIADO); END;');
		//SE PASAN PARAMETROS
		oci_bind_by_name($stid, ':FECHA', $fecha, 10);
		oci_bind_by_name($stid, ':FERIADO', $feriado, 10);
	    //SE EJECUTA  LA SENTENCIA SQL
	    oci_execute($stid);

	    return $feriado;
	}*/

	public function diaFeriado(){
		$db = Yii::$app->params['orcl'];		

		$CONEXION = oci_connect('TELEPRU', 'tytcali', $db);

		//LLAMA AL PROCEDIMIENTO QUE RETORNA LAS EMPRESAS LOS CONTRATOS Y LAS FACTURAS						
		$stid = oci_parse($CONEXION, 'BEGIN SP_DIAS_FERIADOS_AUTOGES(:CURSOR); END;');
		//SE DECLARAN LOS CURSOR 
		$CURSOR = oci_new_cursor($CONEXION);
		//SE PASAN PARAMETROS
		oci_bind_by_name($stid, ':CURSOR', $CURSOR, -1, OCI_B_CURSOR);
	    //SE EJECUTA  LA SENTENCIA SQL
	    oci_execute($stid);
	    oci_execute($CURSOR, OCI_DEFAULT);
	    //extrae cada fila de cada cursor de una variable 
	    oci_fetch_all($CURSOR, $festivos, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	    return $festivos;
	}
}