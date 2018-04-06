<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\IndexForm;
use app\models\RememberForm;
use app\models\AsignaForm;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\helpers\Url;
use PDO;
use app\models\TwPcIdentity;
use app\models\TwPcPersonalData;
use app\models\TwPcCertIngresos;
use app\models\TwPcCertLaborales;
use app\models\Ldap;
use app\models\TwPcRolesPerfiles;
use app\models\TwPcComprobantePago;
use app\models\TwPcCronoCierreNomina;
use app\models\TwPcEquipoNomina;
use app\models\TwPcHorasExtrasHistorial;
use app\models\TwPcVacaciones;
use app\models\TwPcInsertHorasExtras;
use app\models\TwPcInsertHoras;
use app\models\TwPcArchivos;
use app\models\TwPcEliminaArchivos;


class SiteController extends Controller
{ 	


	public function actionPrueba(){				
	
$model = new TwPcPersonalData;

		$this->layout=false;
		
		$twpcpersonaldata = $model->procedimiento();
		
		//convierto los bloques en arrays y divido los bloques por posicion
		
		$equipo = explode("*_", $twpcpersonaldata[8]);
		
		/*foreach ($PERIODOS as $PERIODO_KEY) {
			$NOM_PERIODO_ARR[] = $PERIODO_KEY['PERIODO'];
			$ANO_PERIODO_ARR[] = $PERIODO_KEY['ANO_INI'];
			$NUM_PERIODO_ARR[] = $PERIODO_KEY['NUM_PER'];
			$JUN_PERIODO_ARR[] = $PERIODO_KEY['PERIODO'].'_*'.$PERIODO_KEY['ANO_INI'];
			

		}*/				
		
		return $this->render('prueba', ["equipo"=>$equipo]);
	
	}

	public function actionMenu()
	{
		$model = new TwPcRolesPerfiles;
		$rolesperfiles = $model->spMenus();
		$menus = $rolesperfiles[0];
		$submenus = $rolesperfiles[1];

		$arraym =array();
		$arraysm =array();

		foreach ($menus as $key) {			
			$arraym[] = $key['VALOR'];
		}

		foreach ($submenus as $key) {			
			$arraysm[] = $key['VALOR'];
		}

		$_SESSION['arrayyy'] = $arraym[0];

		$this->view->params['menus'] = $arraym;
		$this->view->params['submenus'] = $arraysm;
		
	}
	
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
		$recordar = null;
		
		$this->layout=false;       			
		
        $model = new IndexForm();

        $model2 = new RememberForm();
		
		$modeladp = new Ldap;
		
		$ladpcon = $modeladp->directorioactivo();
		
		if($ladpcon[2]=="false"){
			
			$recordar = "<a class='color-white' href='' data-toggle='modal' data-target='#recordarpass'>Olvidaste tu contraseña?</a>";
		}
		
		//VALIDACIONES HTML PARA RECORDAR PASS
		if($model2->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
			
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model2);			
		}
		
		if($model2->load(Yii::$app->request->post())){
		if($model2->validate()){		
			
			return $this->redirect(['site/olvidapassword','usuario'=>$model2->cedula,'operacion'=>'U']);
			
		}else{
			
			 return $this->goBack();
			 
			}
		}			
		
		//VALIDACIONES HTML PARA USUARIO Y PASS
		if($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
			
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);			
		}
		
		if($model->load(Yii::$app->request->post())){
		if($model->validate()){		
			
			return $this->redirect(['site/logueo','usuario'=>$model->usuario,'clave'=>$model->clave,'operacion'=>'L']);
			
		}else{
			
			 return $this->goBack();
			 
			}		
		}
		
		if (isset(Yii::$app->session['cedula'])){
			
		return $this->redirect(['site/principal']);
			
									}else{
		
        return $this->render('index', ['model' => $model,'model2' => $model2,'recordar' => $recordar]);

											}
		
    }

	public function actionLogueo()
    {
		$modeladp = new Ldap;
		
		$ladpcon = $modeladp->directorioactivo();
		
		if(isset($ladpcon[0]) && $ladpcon[2]=="true"){
			
			//envio los parametros del bloque de datos personales hacia el modelo PersonalData	
		
		Yii::$app->session['cedula'] = $ladpcon[0];
			
				return $this->redirect(['site/principal']);
				
		}elseif(isset($ladpcon[1]) && $ladpcon[2]=="true"){
			
			return $this->redirect(['site/index', "error"=>$ladpcon[1]]);
			
		}elseif($ladpcon[2]=="false"){
		
		$model = new TwPcIdentity;
		
		$twpcidentity = $model->procedimiento();
		
		if($twpcidentity[1]=="2"){
			
			return $this->redirect(['site/asignapassword', "error"=>$twpcidentity[2]]);
			
		}elseif($twpcidentity[1]=="1"){
			
			Yii::$app->session['cedula'] = $twpcidentity[0];
					
			return $this->redirect(['site/principal', "message"=>$twpcidentity[2]]);
			
		}elseif($twpcidentity[1]=="0"){
			
			return $this->redirect(['site/index', "activate"=>$twpcidentity[2], 'usuario'=>Yii::$app->request->get('usuario'), 'clave'=>Yii::$app->request->get('clave')]);
			
		}else{
			
			return $this->redirect(['site/index', "error"=>$twpcidentity[2]]);
			
		}
			}else{
				
				return $this->redirect(['site/index', "error"=>"No hay conexion, por favor contacte con el administrador."]);
				
			}	   
    }
		
    public function actionSalida()
    {
		
		// Escaneo y elimino los archivos generados para este usuario en la carpeta reportes
		
		$model = new TwPcEliminaArchivos;
		
		$twpceliminaarchivos = $model->EliminaArchivo();
		
		foreach ($twpceliminaarchivos as $key) {			
			@unlink('../views/reportes/'.$key['NOMBRE_ARCHIVO']);
		}

		//Elimino session de la cedula que es el parametro principal
		Yii::$app->session['cedula'];
		
		Yii::$app->session->destroy();
		
        return $this->goHome();
    }

    public function actionVacaciones()
    {        		
		
			$tablet_browser = 0;
			$mobile_browser = 0;
			$body_class = 'desktop';
			 
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$tablet_browser++;
				$body_class = "tablet";
			}
			 
			if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
			$mobile_agents = array(
				'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
				'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
				'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
				'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
				'newt','noki','palm','pana','pant','phil','play','port','prox',
				'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
				'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
				'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
				'wapr','webc','winw','winw','xda ','xda-');
			 
			if (in_array($mobile_ua,$mobile_agents)) {
				$mobile_browser++;
			}
			 
			if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
				$mobile_browser++;
				//Check for tablets on opera mini alternative headers
				$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
				if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
				  $tablet_browser++;
				}
			}
			////////////////////////////////////////////////LOGICA//////////////////////////////////////////////////
			//habilitar la opcion de autorizar empleados
			$autorizaciones = Yii::$app->session['submenus'][1];
			//modelo 
			$vacaciones = new TwPcVacaciones();
			//historial de vacacines del empleado 			
    		$datos = $vacaciones->Vacaciones();
    		//variables con los datos del empleado
    		$vacasHistorial = $datos[0];
    		$vacasvigentes = $datos[1];    		
    		$diaspedientes = $datos[4];
    		//validaciones
    		if($datos[2] === 0){
    			$vacasHistorial = $datos[2];
    		}
    		if($datos[3] === 0){
    			$vacasvigentes = $datos[3];
    		}

    		//paginacion    		
		   	

			////////////////////////////////////////////////LOGICA//////////////////////////////////////////////////

			if ($tablet_browser > 0) {
			// Si es tablet has lo que necesites

                return $this->render('mvacaciones',["autorizaciones"=>$autorizaciones,"vacasvigentes"=>$vacasvigentes,"vacasHistorial"=>$vacasHistorial,"diaspedientes"=>$diaspedientes]);

			}
			else if ($mobile_browser > 0) {
			// Si es dispositivo mobil has lo que necesites			
			  
                return $this->render('mvacaciones',["autorizaciones"=>$autorizaciones,"vacasvigentes"=>$vacasvigentes,"vacasHistorial"=>$vacasHistorial,"diaspedientes"=>$diaspedientes]);
			}
			else {
				
				//VALIDO SI LA SESSION SE ENCUENTRA ACTIVA, SINO LA DEVUELVO AL INDEX
		if (isset(Yii::$app->session['cedula'])){
		
         return $this->render('vacaciones',["autorizaciones"=>$autorizaciones,"vacasvigentes"=>$vacasvigentes,"vacasHistorial"=>$vacasHistorial,"diaspedientes"=>$diaspedientes]);
									
									}else{
										
										 return $this->goHome();
										
											}
			}        
		
    }
	
	public function actionAddevent(){
		
		if (Yii::$app->request->post()){
			
			$titulo = Html::encode($_POST["title"]);
			$start = Html::encode($_POST['start']);
			$end = Html::encode($_POST['end']);
			$color = Html::encode($_POST['color']);
			
			if(isset($titulo)){

			//INSERTO VACACIONES
			
			return $this->redirect(["site/vacaciones"]);
					
				}else{
					
				echo "ha ocurrido un error, redireccionando...";
				echo "<meta http-equiv='refresh' content='3;'".Url::toRoute("site/vacaciones")."'>";
				}				
				
			}else{
			
			return $this->redirect(["site/vacaciones"]);
		}
	}

    public function actionPrincipal()
    {	
	
	// Primero escaneo y elimino los archivos generados para este usuario en la carpeta reportes
		
		$model = new TwPcEliminaArchivos;
		
		$twpceliminaarchivos = $model->EliminaArchivo();
		
		foreach ($twpceliminaarchivos as $key) {			
			@unlink('../views/reportes/'.$key['NOMBRE_ARCHIVO']);
		}
		
	//VALIDO SI LA SESSION SE ENCUENTRA ACTIVA, SINO LA DEVUELVO AL INDEX
		if (isset(Yii::$app->session['cedula'])){
		
	// Inicia logica de la pantalla principal
		
		$model = new TwPcPersonalData;

		$twpcpersonaldata = $model->procedimiento();
		
		//convierto los bloques en arrays y divido los bloques por posicion
		
		$bloque1 = explode("_*", utf8_encode($twpcpersonaldata[0]));
		$bloque2 = explode("_*", utf8_encode($twpcpersonaldata[1]));
		$bloque3 = explode("_*", utf8_encode($twpcpersonaldata[2]));
		$bloque4 = explode("_*", utf8_encode($twpcpersonaldata[3]));
		$bloque5 = explode("_*", utf8_encode($twpcpersonaldata[4]));
		$bloque6 = explode("_*", utf8_encode($twpcpersonaldata[5]));
		$bloque7 = explode("_*", utf8_encode($twpcpersonaldata[6]));
		$bloque8 = explode("_*", utf8_encode($twpcpersonaldata[7]));
		//CAMBIA EL ORDEN EN EL BLOQUE9 PARA REALIZAR POSTERIOR SEPARACION DEL ARRAY
		$bloque9 = explode("*_", utf8_encode($twpcpersonaldata[8]));
		
		$bloque10 = explode("_*", utf8_encode($twpcpersonaldata[9]));
		$bloque11 = explode("_*", utf8_encode($twpcpersonaldata[10]));
		$bloque12 = explode("_*", utf8_encode($twpcpersonaldata[11]));
		$bloque13 = explode("_*", utf8_encode($twpcpersonaldata[12]));
		$bloque14 = explode("_*", utf8_encode($twpcpersonaldata[13]));
		
		//envio los parametros del bloque de datos personales hacia el main
		
		Yii::$app->session['datopersonal'] = $bloque1;
		Yii::$app->session['datopersonaldos'] = $bloque2;		
		
		//=======================================PERFILES=========================================
		$model = new TwPcRolesPerfiles;
		$rolesperfiles = $model->spMenus();
		$menus = $rolesperfiles[0];
		$submenus = $rolesperfiles[1];

		$arraym =array();
		$arraysm =array();

		foreach ($menus as $key) {			
			$arraym[] = $key['VALOR'];
		}

		foreach ($submenus as $key) {			
			$arraysm[] = $key['VALOR'];
		}

		Yii::$app->session['menus'] = $arraym;
		Yii::$app->session['submenus'] = $arraysm;
		//================================================================================
		
        return $this->render('principal', ["bloque1"=>$bloque1,"bloque2"=>$bloque2,"bloque3"=>$bloque3,"bloque4"=>$bloque4,"bloque5"=>$bloque5,"bloque6"=>$bloque6,"bloque7"=>$bloque7,"bloque8"=>$bloque8,"bloque9"=>$bloque9,"bloque10"=>$bloque10,"bloque11"=>$bloque11,"bloque12"=>$bloque12,"bloque13"=>$bloque13,"bloque14"=>$bloque14]);
									
									}else{
										
										 return $this->goHome();
										
											}
    }
	
	    public function actionMvacaciones()
    {
				if (Yii::$app->user->isGuest) {
			 return $this->goBack();
        }else{
		
		$tablet_browser = 0;
			$mobile_browser = 0;
			$body_class = 'desktop';
			 
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$tablet_browser++;
				$body_class = "tablet";
			}
			 
			if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
			$mobile_agents = array(
				'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
				'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
				'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
				'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
				'newt','noki','palm','pana','pant','phil','play','port','prox',
				'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
				'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
				'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
				'wapr','webc','winw','winw','xda ','xda-');
			 
			if (in_array($mobile_ua,$mobile_agents)) {
				$mobile_browser++;
			}
			 
			if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
				$mobile_browser++;
				//Check for tablets on opera mini alternative headers
				$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
				if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
				  $tablet_browser++;
				}
			}
			if ($tablet_browser > 0) {
			// Si es tablet has lo que necesites
			   return $this->render('mvacaciones');
			}
			else if ($mobile_browser > 0) {
			// Si es dispositivo mobil has lo que necesites
			   return $this->render('mvacaciones');
			}
			else {
			// Si es ordenador de escritorio has lo que necesites			 
			  return $this->render('vacaciones');
			}
		}
    }
		public function actionAsignapassword()
    {
		$this->layout=false;
		  
		$modelform = new AsignaForm();
		
		$model = new TwPcIdentity;
		
		$twpcidentity = $model->procedimiento();	  
		
		if($modelform->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
			
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($modelform);			
		}
		
		if($modelform->load(Yii::$app->request->post())){
		if($modelform->validate()){		
			
			return $this->redirect(['site/validapassword','clave'=>$modelform->nuevaclave, 'tokenreset'=>Yii::$app->request->get('tokenreset') , 'usuario'=>Yii::$app->request->get('usuario'), 'operacion'=>'F']);
			
		}	
		}
		
		if($twpcidentity[1]=="10"){

			return $this->render('asignapassword',['model' => $modelform]);
			
		}elseif($twpcidentity[1]=="11"){
			
			return $this->redirect(['site/index', "error"=>$twpcidentity[2]]);
			
		}else{
			
			return $this->redirect(['site/index', "error"=>$twpcidentity[2]]);
			
		}
		
	}
		public function actionValidapassword()
	{
				$model = new TwPcIdentity;
				
				$twpcidentity = $model->procedimiento();
				
				if($twpcidentity[1]=="1"){
					
					Yii::$app->session['cedula'] = $twpcidentity[0];
					
					return $this->redirect(['site/principal', "message"=>$twpcidentity[2]]);
					
				}else{
					
					return $this->redirect(['site/validapassword', "error"=>$twpcidentity[2], 'tokenreset'=>Yii::$app->request->get('tokenreset') , 'usuario'=>Yii::$app->request->get('usuario'), 'operacion'=>'F']);
				}	
	}
	
	public function actionOlvidapassword()
	{
				$model = new TwPcIdentity;
				
				$twpcidentity = $model->procedimiento();
				
				if($twpcidentity[1]=="9"){
					
					return $this->redirect(['site/index', "remember"=>$twpcidentity[2]]);
					
				}elseif($twpcidentity[1]=="0"){
					
					return $this->redirect(['site/index', "error"=>$twpcidentity[2]]);
					
				}else{
					
					return $this->redirect(['site/index', "error"=>$twpcidentity[2]]);
					
				}
						
	}
	
	public function actionActivapassword()
	{
				$model = new TwPcIdentity;
				
				$twpcidentity = $model->procedimiento();
								
				 if(isset($_POST['activate'])){					 			
							
					$datos = $twpcidentity[2];
							
					echo(($datos)?json_encode($datos):'');
				
				}else{
					
					$datos = 0; 
					
					echo(($datos)?json_encode($datos):''); 
				}			
	}
	
	public function actionTurnos()
    {
		$tablet_browser = 0;
			$mobile_browser = 0;
			$body_class = 'desktop';
			 
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$tablet_browser++;
				$body_class = "tablet";
			}
			 
			if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
			$mobile_agents = array(
				'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
				'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
				'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
				'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
				'newt','noki','palm','pana','pant','phil','play','port','prox',
				'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
				'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
				'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
				'wapr','webc','winw','winw','xda ','xda-');
			 
			if (in_array($mobile_ua,$mobile_agents)) {
				$mobile_browser++;
			}
			 
			if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
				$mobile_browser++;
				//Check for tablets on opera mini alternative headers
				$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
				if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
				  $tablet_browser++;
				}
			}
			if ($tablet_browser > 0) {
			// Si es tablet has lo que necesites
			
                return $this->render('mturnos');

			}
			else if ($mobile_browser > 0) {
			// Si es dispositivo mobil has lo que necesites			

                return $this->render('mturnos');
			}
			else {

				//VALIDO SI LA SESSION SE ENCUENTRA ACTIVA, SINO LA DEVUELVO AL INDEX
				if (isset(Yii::$app->session['cedula'])){

				//identifar si es genernte quien ingresa
				$gerente = Yii::$app->session['gerente'];
			
				//INICIO DE LOGICA PARA TURNOS
				//historiales de horas extras
				$model = new TwPcHorasExtrasHistorial;

				$twpchorasextrashistorial = $model->HorasExtras();
				
				$HHEXTRAS = $twpchorasextrashistorial[0];
				$HHEXTRASTOP = $twpchorasextrashistorial[1];
				$HHMESSAGE = $twpchorasextrashistorial[2];
				$HHOUTPUT = $twpchorasextrashistorial[3];			
							
				//Conceptos de horas extras
				$model = new TwPcInsertHorasExtras;

				$twpchorasextras = $model->HorasExtrasVal();
				
				$HCONCEPTOS = $twpchorasextras[0];			

				foreach ($HCONCEPTOS as $HCONCEPTOS_KEY) {												
											
											$ARRCON_KEY[] = $HCONCEPTOS_KEY['CONCEPTO'];
											$ARRCOD_KEY[] = $HCONCEPTOS_KEY['COD_CON'];
													}									
				
				$autorizaciones = Yii::$app->session['submenus'][3];
		
        return $this->render('turnos',['HHEXTRAS' => $HHEXTRAS,'HHEXTRASTOP' => $HHEXTRASTOP, 'HHOUTPUT' => $HHOUTPUT, 'HHMESSAGE' => $HHMESSAGE, 'HCONCEPTOS' => $HCONCEPTOS, 'ARRCON_KEY' => $ARRCON_KEY, 'ARRCOD_KEY' => $ARRCOD_KEY,'gerente'=>$gerente,'autorizaciones'=>$autorizaciones]);
									
									}else{
										
										 return $this->goHome();
										
											}
			}        
		
    }
	
	public function actionMturnos()
    {
				if (Yii::$app->user->isGuest) {
			 return $this->goBack();
        }else{
		
		$tablet_browser = 0;
			$mobile_browser = 0;
			$body_class = 'desktop';
			 
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$tablet_browser++;
				$body_class = "tablet";
			}
			 
			if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
			$mobile_agents = array(
				'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
				'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
				'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
				'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
				'newt','noki','palm','pana','pant','phil','play','port','prox',
				'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
				'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
				'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
				'wapr','webc','winw','winw','xda ','xda-');
			 
			if (in_array($mobile_ua,$mobile_agents)) {
				$mobile_browser++;
			}
			 
			if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
				$mobile_browser++;
				//Check for tablets on opera mini alternative headers
				$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
				if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
				  $tablet_browser++;
				}
			}
			if ($tablet_browser > 0) {
			// Si es tablet has lo que necesites
			   return $this->render('mturnos');
			}
			else if ($mobile_browser > 0) {
			// Si es dispositivo mobil has lo que necesites
			   return $this->render('mturnos');
			}
			else {
			// Si es ordenador de escritorio has lo que necesites			 
			  return $this->render('turnos');
			}
		}
    }
	
	public function actionCertificadolaboral()
    {
		$this->layout='main_light';
		
		//VALIDO SI LA SESSION SE ENCUENTRA ACTIVA, SINO LA DEVUELVO AL INDEX
		if (isset(Yii::$app->session['cedula'])){
		
        return $this->render('certificadolaboral');
									
									}else{
										
										 return $this->goHome();
										
											}
    }
	public function actionPdf_certificadolaboral()
    {				
	
	if (isset($_POST['optionsRadios'])&&isset($_POST['optionsText'])){		
		
		$radio = $_POST['optionsRadios'];
		$text = $_POST['optionsText'];
		
		Yii::$app->session['checklab'] = $radio;		
		Yii::$app->session['textlab'] = $text;		
		
		echo(($radio)?json_encode($radio):'');		
		echo(($text)?json_encode($text):'');		
		
	}else{
		
		$radio = 'ERROR';
		$text = 'ERROR';
		
		echo(($radio)?json_encode($radio):'');
		echo(($text)?json_encode($text):'');
		
	}
	
	//Modelo para genera el nombre del archivo temporal del pdf
	$tiprend=Yii::$app->request->get('tiprend');
	
	if($tiprend=='envPdf'){
	
	$model = new TwPcArchivos;
	
	$c1=Yii::$app->session['cedula'];
	$c2="pdf";
	$c3="Archivo adjunto en Certificado Laboral";
	
	$nombreArchivo = $model->nombreArchivo($c1,$c2,$c3);
	
	$NMBR = $nombreArchivo;
	
	}else{
		
	$NMBR = Yii::$app->session['cedula'].".pdf";
	}
	//Modelo para implementar el pdf del certificado
	
		$model = new TwPcCertLaborales;
	
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			Yii::$app->response->headers->add('Content-Type', 'application/pdf');	
			
			// Load Component Yii2 TCPDF 
			Yii::$app->get('tcpdf');
		
		$twpccertlaborales = $model->procedimiento();
		
		//$BLOQUE2 = explode("_*", $twpccertlaborales[1]);
		$BLOQUEA = utf8_encode($twpccertlaborales[0]);
		$BLOQUET = utf8_encode($twpccertlaborales[1]);
		$BLOQUEB = utf8_encode($twpccertlaborales[2]);
		$BLOQUEC = utf8_encode($twpccertlaborales[3]);
		
        return $this->render('pdf_certificadolaboral', ["encabezado"=>$BLOQUEA,"titulo"=>$BLOQUET,"cuerpo"=>$BLOQUEB,"pie"=>$BLOQUEC, "tiprend"=>$tiprend, "NMBR"=>$NMBR]);
		
    }
	public function actionCertificadosretencion()
    {				
			
		$this->layout='main_light';
		
		$model = new TwPcCertIngresos;
		
		$twpccertingresos = $model->procedimiento();
		
		$BLOQUE2 = explode("_*", $twpccertingresos[1]);
			
		//VALIDO SI LA SESSION SE ENCUENTRA ACTIVA, SINO LA DEVUELVO AL INDEX
		if (isset(Yii::$app->session['cedula'])){
		
        return $this->render('certificadosretencion',["anoscerti"=>$BLOQUE2]);
									
									}else{
										
										 return $this->goHome();
										
											}
    }
	public function actionPdf_certificadosretencion()
    {		
	
	if (isset($_POST['myOptions'])){		
		
		$resultado = $_POST['myOptions'];
		Yii::$app->session['ano'] = $resultado;		
		
		echo(($resultado)?json_encode($resultado):'');		
		
	}else{
		
		$resultado = 'ERROR';
		
		echo(($resultado)?json_encode($resultado):'');
		
	}
	
	//Modelo para genera el nombre del archivo temporal del pdf
	$tiprend=Yii::$app->request->get('tiprend');
	
	if($tiprend=='envPdf'){
	
	$model = new TwPcArchivos;
	
	$c1=Yii::$app->session['cedula'];
	$c2="pdf";
	$c3="Archivo adjunto en Certificado y Retenciones";
	
	$nombreArchivo = $model->nombreArchivo($c1,$c2,$c3);
	
	$NMBR = $nombreArchivo;
	
	}else{
		
	$NMBR = Yii::$app->session['cedula'].".pdf";
	}
	//Modelo para implementar el pdf del certificadosretencion
	$model = new TwPcCertIngresos;
	
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			Yii::$app->response->headers->add('Content-Type', 'application/pdf');	
			
			// Load Component Yii2 TCPDF 
			Yii::$app->get('tcpdf');

			$twpccertingresos = $model->procedimiento();
			
			$BLOQUE1 = explode("_*", $twpccertingresos[0]);
		
        return $this->render('pdf_certificadosretencion', ["datos"=>$BLOQUE1, "tiprend"=>$tiprend, "NMBR"=>$NMBR]);
		
    }
	public function actionComprobantespago()
    {	
		$this->layout='main_light';
		
		//VALIDO SI LA SESSION SE ENCUENTRA ACTIVA, SINO LA DEVUELVO AL INDEX
		if (isset(Yii::$app->session['cedula'])){
		
		$model = new TwPcComprobantePago;
		
		$twpccomprobantepago = $model->ComprobantePago();
		
		$PERIODOS = $twpccomprobantepago[1];
		
		foreach ($PERIODOS as $PERIODO_KEY) {
			$ANO_PERIODO_ARR[] = $PERIODO_KEY['ANO_INI'];
		}
		
		//ELIMINO LOS ANIOS DUPLICADOS
		$ANO_PERIODO_FILT = array_unique($ANO_PERIODO_ARR);
		
        return $this->render('comprobantespago', ["ANO_PERIODO_ARR"=>$ANO_PERIODO_FILT]);
									
									}else{
										
										 return $this->goHome();
										
											}
    }
	public function actionMenucomprobantespago()
    {
		
		$model = new TwPcComprobantePago;
		
		$twpccomprobantepago = $model->ComprobantePago();
		
		$PERIODOS = $twpccomprobantepago[1];
		
		foreach ($PERIODOS as $PERIODO_KEY) {									
									
			if ($PERIODO_KEY['ANO_INI'] == $_POST['anoenv']) {
								  
			$NOM_PERIODO_ARR[] = $PERIODO_KEY['PERIODO'];
			$NUR_PERIODO_ARR[] = $PERIODO_KEY['NUM_PER'];
			
				}
			}
		
		if (isset($_POST['anoenv'])){		
		
		$resultado = $_POST['anoenv'];
		
		Yii::$app->session['ano_com'] = $resultado;			
		
		$ARRAY_PERIODO = array($NOM_PERIODO_ARR,$NUR_PERIODO_ARR);
		
		echo(($ARRAY_PERIODO)?json_encode($ARRAY_PERIODO):'');
		
	}
		
    }
	public function actionPdf_comprobantespago()
    {
		
	//Modelo para genera el nombre del archivo temporal del pdf
	$tiprend=Yii::$app->request->get('tiprend');
	
	if($tiprend=='envPdf'){
	
	$model = new TwPcArchivos;
	
	$c1=Yii::$app->session['cedula'];
	$c2="pdf";
	$c3="Archivo adjunto en Comprobante de Pago";
	
	$nombreArchivo = $model->nombreArchivo($c1,$c2,$c3);
	
	$NMBR = $nombreArchivo;
	
	}else{
		
	$NMBR = Yii::$app->session['cedula'].".pdf";
	}
	//Modelo para implementar el pdf del certificado
		
		$model = new TwPcComprobantePago;		
		
		Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
		Yii::$app->response->headers->add('Content-Type', 'application/pdf');	
			
		// Load Component Yii2 TCPDF 
		Yii::$app->get('tcpdf');
		
		//RECIBO PERIODO
		
		if (isset($_POST['perenv'])){		
		
		$resultado = $_POST['perenv'];
		
		Yii::$app->session['per_com'] = $resultado;			
		
		echo(($resultado)?json_encode($resultado):'');
		
		}
		
		//ANO ENVIADO SOLAMENTE DE LA VISTA PRINCIPAL PARA LOS 3 ULTIMOS COMPROBANTES
		if (isset($_POST['anoenv'])){		
		
		$resultadoano = $_POST['anoenv'];
		
		Yii::$app->session['ano_com'] = $resultadoano;
		
		}
			
		$twpccomprobantepago = $model->ComprobantePago();	
		
			//POSICIONES PARA CURSORES
		$ANIO = $twpccomprobantepago[0];
		$PERIODOS = $twpccomprobantepago[1];
		$BLOQUE3 = $twpccomprobantepago[2];
		$BLOQUE5 = $twpccomprobantepago[3];
		
			//RECORRE LOS CURSORES
		foreach ($ANIO as $ANO_KEY) {			
			$ANO_ARR[] = $ANO_KEY['ANO_INI'];	
		}
		
		foreach ($PERIODOS as $PERIODOS_KEY) {
			$PERIODO_ARR[] = $PERIODOS_KEY['PERIODO'];
		}		
			
			//POSICIONES PARA PROCEDIMIENTOS
		$BLOQUE1 = explode("_*", $twpccomprobantepago[4]);
		$BLOQUE2 = explode("_*", $twpccomprobantepago[5]);
		$BLOQUE4 = explode("_*", $twpccomprobantepago[6]);
		$BLOQUE6 = explode("_*", $twpccomprobantepago[7]);
		$MESSAGE = explode("_*", $twpccomprobantepago[8]);
		$OUTPUT = explode("_*", $twpccomprobantepago[9]);

		
		return $this->render('pdf_comprobantespago', ["bloque1"=>$BLOQUE1,"bloque2"=>$BLOQUE2, "bloque4"=>$BLOQUE4, "bloque6"=>$BLOQUE6, "bloque3_0"=>$BLOQUE3, "bloque5_0"=>$BLOQUE5, "tiprend"=>$tiprend, "NMBR"=>$NMBR]);
	
	}	
	public function actionEquiponomina()
    {				
		$model = new TwPcEquipoNomina;
		
		$twpcequiponomina = $model->EquipoNomina();
		
		$bloque1 = $twpcequiponomina[0];
		$bloque2 = $twpcequiponomina[1];
		$bloque3 = $twpcequiponomina[2];
		$bloque4 = $twpcequiponomina[3];
		$bloque5 = $twpcequiponomina[4];
		$bloque6 = $twpcequiponomina[5];
		$bloque7 = $twpcequiponomina[6];
		
		//VALIDO SI LA SESSION SE ENCUENTRA ACTIVA, SINO LA DEVUELVO AL INDEX
		if (isset(Yii::$app->session['cedula'])){
		
         return $this->render('equiponomina', ["bloque1"=>$bloque1,"bloque2"=>$bloque2,"bloque3"=>$bloque3,"bloque4"=>$bloque4,"bloque5"=>$bloque5,"bloque6"=>$bloque6,"bloque7"=>$bloque7]);
									
									}else{
										
										 return $this->goHome();
										
											}
    }
	public function actionCronogramanomina()
    {				
		$model = new TwPcCronoCierreNomina;
		
		$twpccierrenomina = $model->CierreNomina();
		
		$crono = $twpccierrenomina[0];
		
		//VALIDO SI LA SESSION SE ENCUENTRA ACTIVA, SINO LA DEVUELVO AL INDEX
		if (isset(Yii::$app->session['cedula'])){
		
                return $this->render('cronogramanomina', ["crono"=>$crono]);
									
									}else{
										
										 return $this->goHome();
										
											}
		
    }
	public function actionActualidadlaboral()
    {				
		
		//VALIDO SI LA SESSION SE ENCUENTRA ACTIVA, SINO LA DEVUELVO AL INDEX
		if (isset(Yii::$app->session['cedula'])){
		
                return $this->render('actualidadlaboral');
									
									}else{
										
										 return $this->goHome();
										
											}
    }
	public function actionJsoncalendar()
	{
		
		if(Yii::$app->request->get('bandera')=='0'){
		
		//TURNOS, SI RECIBO 0
		$model = new TwPcHorasExtrasHistorial;

		$twpchorasextrashistorial = $model->HorasExtras();
		
		$HHEXTRAS = $twpchorasextrashistorial[0];		
		
		//VALIDACIONES DE TURNOS
		
			@$he1 = $_POST['numStr'];
			//$he1 = '1,2';
			@$he2 = $_POST['fecStr'];
			//$he2 = '19-02-2018,19-02-2018';
			@$he3 = $_POST['conStr'];
			//$he3 = '1005,1008';
			@$he4 = $_POST['idStr'];
			
			$model = new TwPcInsertHorasExtras;
			
			$twpchorasextras = $model->HorasExtrasRec($he1,$he2,$he3,$he4);
			
			$HMSSG = $twpchorasextras[0];
			$HOUTP = $twpchorasextras[1];
			
			//echo json_encode($HMSSG);
				
				$ARRHHEXTRAS= ["HHEXTRAS"=>$HHEXTRAS,"HMSSG"=>$HMSSG,"HOUTP"=>$HOUTP];
				
    	echo json_encode($ARRHHEXTRAS);
		
		}else if(Yii::$app->request->get('bandera')=='1'){
		
		//VACACIONES, SI RECIBO 1 
		$model = new TwPcVacaciones;

		$twpcvacaciones = $model->Vacaciones();
		
		$HVACACIONES = $twpcvacaciones[0];
		
		echo json_encode($HVACACIONES);
		
		}

    }
    public function actionAutorzacionvacap1(){

    	$c1 = Yii::$app->request->get('cantidad');
    	$c2 = Yii::$app->request->get('pagina');
    	$c3 = Yii::$app->request->get('search');
    	$c4 = Yii::$app->request->get('column');
    	$c5 = Yii::$app->request->get('cedula');

    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesEpl($c1,$c2,$c3,$c4,$c5);
		
    	$datosTable = array();

		foreach ($datos[0] as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}

		$datosTable = array($datosTable,$datos[1]);
		echo json_encode($datosTable);    	
    }

    public function actionAutorzacionvacap2(){

    	$c1 = Yii::$app->request->get('cantidad');
    	$c2 = Yii::$app->request->get('pagina');
    	$c3 = Yii::$app->request->get('search');
    	$c4 = Yii::$app->request->get('column');
		$c5 = Yii::$app->request->get('cedula');

    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesRechazadas($c1,$c2,$c3,$c4,$c5);

    	$datosTable = array();

		foreach ($datos[0] as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}

		$datosTable = array($datosTable,$datos[1]);
		echo json_encode($datosTable);    
    }

    public function actionAutorzacionvacap3(){

    	$c1 = Yii::$app->request->get('cantidad');
    	$c2 = Yii::$app->request->get('pagina');
    	$c3 = Yii::$app->request->get('search');
    	$c4 = Yii::$app->request->get('column');
    	$c5 = Yii::$app->request->get('cedula');

    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesVigentes($c1,$c2,$c3,$c4,$c5);

    	$datosTable = array();

		foreach ($datos[0] as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}

		$datosTable = array($datosTable,$datos[1]);
		echo json_encode($datosTable);    
    }

    public function actionAutorzacionvacap4(){

    	$c1 = Yii::$app->request->get('cantidad');
    	$c2 = Yii::$app->request->get('pagina');
    	$c3 = Yii::$app->request->get('search');
    	$c4 = Yii::$app->request->get('column');
    	$c5 = Yii::$app->request->get('cedula');

    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesAcepRech($c1,$c2,$c3,$c4,$c5);

    	$datosTable = array();

		foreach ($datos[0] as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}

		$datosTable = array($datosTable,$datos[1],$datos[2]);
		echo json_encode($datosTable);    
    }

    public function actionAceptarsolicitudesvaca(){

    	$get1 = Yii::$app->request->get('solicitudes');
    	$c1 = array();

    	for ($i=0; $i < count($get1); $i++) { 
    		$c1[$i] = $get1[$i]['valor'];
    	}
    	
    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesAceptar($c1);

    	echo $datos;
    }

    public function actionRechazarsolicitudesvaca(){

    	$get1 = Yii::$app->request->get('paramSp');
    	$c1 = array();
    	$c1[0] = $get1;

    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesRechazar($c1);

    	echo $datos;
    }

    public function actionEditarsolicitudvaca(){

    	$c1 = Yii::$app->request->get('codigoepl');
		$c2 = Yii::$app->request->get('consecutivo');
		$c3 = Yii::$app->request->get('dias');
		$c4 = Yii::$app->request->get('fechaini');
		$c5 = Yii::$app->request->get('fechafin');

		$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesEditar($c1,$c2,$c3,$c4,$c5);

    	echo $datos;
    }

    public function actionCalculafecha(){

    	$c1 = Yii::$app->request->get('fecha');
    	$c2 = Yii::$app->request->get('dias');
    	
    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->calcularFecha($c1,$c2);

    	echo $datos;

    }

    public function actionHistorialvacas(){
    	$c1 = Yii::$app->request->get('cantidad');
    	$c2 = Yii::$app->request->get('pagina');
    	$c3 = Yii::$app->request->get('search');
    	$c4 = Yii::$app->request->get('column');
    	$c5 = Yii::$app->request->get('cedula');

    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->historialEmpleado($c1,$c2,$c3,$c4,$c5);

    	$datosTable = array();

		foreach ($datos[0] as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}

		$datosTable = array($datosTable,$datos[1]);
		echo json_encode($datosTable);    
    }

    public function actionValidadvacaciones(){
    	$c1 = Yii::$app->session['cedula'];
		$c2 = Yii::$app->request->get('fecha');
		$c3 = Yii::$app->request->get('dias');

		$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->validaVacaciones($c1,$c2,$c3);

		echo json_encode($datos);
    }

    public function actionEnviarsolicitudvacas(){
    	$c1 = Yii::$app->session['cedula'];
		$c2 = Yii::$app->request->get('dias'); 
		$c3 = Yii::$app->request->get('fechaini');
		$c4 = Yii::$app->request->get('fechafin');

		$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->envioVacaciones($c1,$c2,$c3,$c4);		
		
		echo json_encode($datos);
    }

    public function actionAutorzacionextrp1(){
    	$c1 = Yii::$app->request->get('cantidad');
    	$c2 = Yii::$app->request->get('pagina');
    	$c3 = Yii::$app->request->get('search');
    	$c4 = Yii::$app->request->get('column');
    	$c5 = Yii::$app->request->get('cedula');

    	$horasextras = new TwPcInsertHorasExtras();
    	$datos = $horasextras->solicitudesEpl($c1,$c2,$c3,$c4,$c5);

    	$datosTable = array();

		foreach ($datos[0] as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}

		$datosTable = array($datosTable,$datos[1]);
		echo json_encode($datosTable);    
    }

    public function actionAutorzacionextrp2(){
    	$c1 = Yii::$app->request->get('cantidad');
    	$c2 = Yii::$app->request->get('pagina');
    	$c3 = Yii::$app->request->get('search');
    	$c4 = Yii::$app->request->get('column');
    	$c5 = Yii::$app->request->get('cedula');

    	$horasextras = new TwPcInsertHorasExtras();
    	$datos = $horasextras->solicitudesEp2($c1,$c2,$c3,$c4,$c5);

    	$datosTable = array();

		foreach ($datos[0] as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}

		$datosTable = array($datosTable,$datos[1]);
		echo json_encode($datosTable);    
    }

    public function actionAutorzacionextrp3(){
    	$c1 = Yii::$app->request->get('cantidad');
    	$c2 = Yii::$app->request->get('pagina');
    	$c3 = Yii::$app->request->get('search');
    	$c4 = Yii::$app->request->get('column');
    	$c5 = Yii::$app->request->get('cedula');

    	$horasextras = new TwPcInsertHorasExtras();
    	$datos = $horasextras->solicitudesEp3($c1,$c2,$c3,$c4,$c5);

    	$datosTable = array();

		foreach ($datos[0] as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}

		$datosTable = array($datosTable,$datos[1]);
		echo json_encode($datosTable);    
    }

    public function actionAutorzacionextrp4(){
    	$c1 = Yii::$app->request->get('cantidad');
    	$c2 = Yii::$app->request->get('pagina');
    	$c3 = Yii::$app->request->get('search');
    	$c4 = Yii::$app->request->get('column');
    	$c5 = Yii::$app->request->get('cedula');

    	$horasextras = new TwPcInsertHorasExtras();
    	$datos = $horasextras->solicitudesEp4($c1,$c2,$c3,$c4,$c5);

    	$datosTable = array();

		foreach ($datos[0] as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}

		$datosTable = array($datosTable,$datos[1]);
		echo json_encode($datosTable);
    }

    public function actionAutorzacionextrp5(){
    	$c1 = Yii::$app->request->get('cantidad');
    	$c2 = Yii::$app->request->get('pagina');
    	$c3 = Yii::$app->request->get('search');
    	$c4 = Yii::$app->request->get('column');
    	$c5 = Yii::$app->request->get('cedula');

    	$horasextras = new TwPcInsertHorasExtras();
    	$datos = $horasextras->solicitudesEp5($c1,$c2,$c3,$c4,$c5);

    	$datosTable = array();

		foreach ($datos[0] as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}

		$datosTable = array($datosTable,$datos[1]);
		echo json_encode($datosTable);
    }

    public function actionAutorzacionextrp6(){
    	$c1 = Yii::$app->request->get('cantidad');
    	$c2 = Yii::$app->request->get('pagina');
    	$c3 = Yii::$app->request->get('search');
    	$c4 = Yii::$app->request->get('column');
    	$c5 = Yii::$app->request->get('cedula');

    	$horasextras = new TwPcInsertHorasExtras();
    	$datos = $horasextras->solicitudesEp6($c1,$c2,$c3,$c4,$c5);

    	$datosTable = array();

		foreach ($datos[0] as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}

		$datosTable = array($datosTable,$datos[1]);
		echo json_encode($datosTable);
    }

    public function actionAceptarsolicitudesturnos(){
    	$get1 = Yii::$app->request->get('solicitudes');
    	$c1 = array();

    	for ($i=0; $i < count($get1); $i++) { 
    		$c1[$i] = $get1[$i]['valor'];
    	}
    	
    	$horasextras = new TwPcInsertHorasExtras();
    	$datos = $horasextras->solicitudesAceptar($c1);

    	echo $datos;
    }

    public function actionRechazarsolicitudesturnos(){
    	$get1 = Yii::$app->request->get('paramSp');
    	$c1 = array();
    	$c1[0] = $get1;

    	$horasextras = new TwPcInsertHorasExtras();
    	$datos = $horasextras->solicitudesRechazar($c1);

    	echo $datos;
    }

    public function actionDetallegerenteturnos(){
    	$c1 = Yii::$app->request->get('codigoepl');

    	$horasextras = new TwPcInsertHorasExtras();
    	$datos = $horasextras->detalleHistorialHorasExtrasGere($c1);

    	$datosTable = array();

		foreach ($datos as $cursor){
			$cursor = array_map("utf8_decode", $cursor);    
			array_push($datosTable, $cursor);
		}
		
		echo json_encode($datosTable);
    }

    public function actionAceptarsolicitudesturnosgre(){
    	$get1 = Yii::$app->request->get('solicitudes');
    	$c1 = array();

    	for ($i=0; $i < count($get1); $i++) { 
    		$c1[$i] = $get1[$i]['valor'];
    	}
    	
    	$horasextras = new TwPcInsertHorasExtras();
    	$datos = $horasextras->solicitudesAceptarGre($c1);

    	echo $datos;
    }

    public function actionRechazasolicitudesturnosgre(){
    	$get1 = Yii::$app->request->get('paramSp');
    	$c1 = array();
    	$c1[0] = $get1;

    	$horasextras = new TwPcInsertHorasExtras();
    	$datos = $horasextras->solicitudesRechazaGre($c1);

    	echo $datos;
    }
}
