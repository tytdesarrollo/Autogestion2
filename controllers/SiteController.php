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
			if ($tablet_browser > 0) {
			// Si es tablet has lo que necesites

                return $this->render('mvacaciones');

			}
			else if ($mobile_browser > 0) {
			// Si es dispositivo mobil has lo que necesites			
			  
                return $this->render('mvacaciones');
			}
			else {
				
                return $this->render('vacaciones');
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
		$model = new TwPcPersonalData;

		$twpcpersonaldata = $model->procedimiento();
		
		//convierto los bloques en arrays y divido los bloques por posicion
		
		$bloque1 = explode("_*", $twpcpersonaldata[0]);
		$bloque2 = explode("_*", $twpcpersonaldata[1]);
		$bloque3 = explode("_*", $twpcpersonaldata[2]);
		$bloque4 = explode("_*", $twpcpersonaldata[3]);
		$bloque5 = explode("_*", $twpcpersonaldata[4]);
		$bloque6 = explode("_*", $twpcpersonaldata[5]);
		$bloque7 = explode("_*", $twpcpersonaldata[6]);
		$bloque8 = explode("_*", $twpcpersonaldata[7]);
		//CAMBIA EL ORDEN EN EL BLOQUE9 PARA REALIZAR POSTERIOR SEPARACION DEL ARRAY
		$bloque9 = explode("*_", $twpcpersonaldata[8]);
		
		$bloque10 = explode("_*", $twpcpersonaldata[9]);
		$bloque11 = explode("_*", $twpcpersonaldata[10]);
		$bloque12 = explode("_*", $twpcpersonaldata[11]);
		$bloque13 = explode("_*", $twpcpersonaldata[12]);
		$bloque14 = explode("_*", $twpcpersonaldata[13]);
		
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


		//VALIDO SI LA SESSION SE ENCUENTRA ACTIVA, SINO LA DEVUELVO AL INDEX
		if (isset(Yii::$app->session['cedula'])){
		
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
			
			//INICIO DE LOGICA PARA TURNOS
			
			$model = new TwPcHorasExtrasHistorial;

			$twpchorasextrashistorial = $model->HorasExtras();
			
			$HHEXTRAS = $twpchorasextrashistorial[0];
			$HHMESSAGE = $twpchorasextrashistorial[1];
			$HHOUTPUT = $twpchorasextrashistorial[2];			
						
			//$this->view->params['customParam'] = $events;
				
                return $this->render('turnos',['HHEXTRAS' => $HHEXTRAS, 'HHOUTPUT' => $HHOUTPUT, 'HHMESSAGE' => $HHMESSAGE]);
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
        return $this->render('certificadolaboral');
		
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
	
		$model = new TwPcCertLaborales;
	
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			Yii::$app->response->headers->add('Content-Type', 'application/pdf');	
			
			// Load Component Yii2 TCPDF 
			Yii::$app->get('tcpdf');
		
		$twpccertlaborales = $model->procedimiento();
		
		//$BLOQUE2 = explode("_*", $twpccertlaborales[1]);
		$BLOQUEA = $twpccertlaborales[0];
		$BLOQUET = $twpccertlaborales[1];
		$BLOQUEB = $twpccertlaborales[2];
		$BLOQUEC = $twpccertlaborales[3];
		
        return $this->render('pdf_certificadolaboral', ["encabezado"=>$BLOQUEA,"titulo"=>$BLOQUET,"cuerpo"=>$BLOQUEB,"pie"=>$BLOQUEC]);
		
    }
	public function actionCertificadosretencion()
    {				
			
		$this->layout='main_light';
		
		$model = new TwPcCertIngresos;
		
		$twpccertingresos = $model->procedimiento();
		
		$BLOQUE2 = explode("_*", $twpccertingresos[1]);
				
        return $this->render('certificadosretencion',["anoscerti"=>$BLOQUE2]);
		
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
	
	$model = new TwPcCertIngresos;
	
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			Yii::$app->response->headers->add('Content-Type', 'application/pdf');	
			
			// Load Component Yii2 TCPDF 
			Yii::$app->get('tcpdf');

			$twpccertingresos = $model->procedimiento();
			
			$BLOQUE1 = explode("_*", $twpccertingresos[0]);
		
        return $this->render('pdf_certificadosretencion', ["datos"=>$BLOQUE1]);
		
    }
	public function actionComprobantespago()
    {	
		$this->layout='main_light';
		
		$model = new TwPcComprobantePago;
		
		$twpccomprobantepago = $model->ComprobantePago();
		
		$PERIODOS = $twpccomprobantepago[1];
		
		foreach ($PERIODOS as $PERIODO_KEY) {
			$ANO_PERIODO_ARR[] = $PERIODO_KEY['ANO_INI'];
		}
		
		//ELIMINO LOS ANIOS DUPLICADOS
		$ANO_PERIODO_FILT = array_unique($ANO_PERIODO_ARR);
					
        return $this->render('comprobantespago', ["ANO_PERIODO_ARR"=>$ANO_PERIODO_FILT]);
		
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

		
		return $this->render('pdf_comprobantespago', ["bloque1"=>$BLOQUE1,"bloque2"=>$BLOQUE2, "bloque4"=>$BLOQUE4, "bloque6"=>$BLOQUE6, "bloque3_0"=>$BLOQUE3, "bloque5_0"=>$BLOQUE5]);
	
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
		
        return $this->render('equiponomina', ["bloque1"=>$bloque1,"bloque2"=>$bloque2,"bloque3"=>$bloque3,"bloque4"=>$bloque4,"bloque5"=>$bloque5,"bloque6"=>$bloque6,"bloque7"=>$bloque7]);
		
    }
	public function actionCronogramanomina()
    {				
		$model = new TwPcCronoCierreNomina;
		
		$twpccierrenomina = $model->CierreNomina();
		
		$crono = $twpccierrenomina[0];
		
        return $this->render('cronogramanomina', ["crono"=>$crono]);
		
    }
	public function actionActualidadlaboral()
    {				
		
        return $this->render('actualidadlaboral');
		
    }
	public function actionJsoncalendar()
	{
		
		if(Yii::$app->request->get('bandera')=='0'){
		
		//TURNOS, SI RECIBO 0
		$model = new TwPcHorasExtrasHistorial;

		$twpchorasextrashistorial = $model->HorasExtras();
		
		$HHEXTRAS = $twpchorasextrashistorial[0];		
				
    	echo json_encode($HHEXTRAS);
		
		}else if(Yii::$app->request->get('bandera')=='1'){
		
		//VACACIONES, SI RECIBO 1 
		$model = new TwPcVacaciones;

		$twpcvacaciones = $model->Vacaciones();
		
		$HVACACIONES = $twpcvacaciones[0];
		
		echo json_encode($HVACACIONES);
		
		}
    }

    public function actionAutorzacionvacap1(){

    	$c1 = $_GET['cantidad'];
    	$c2 = $_GET['pagina'];
    	$c3 = $_GET['search'];
    	$c4 = $_GET['column'];	
    	$c5 = $_GET['cedula'];	

    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesEpl($c1,$c2,$c3,$c4,$c5);

    	echo json_encode($datos);
    }

    public function actionAutorzacionvacap2(){

    	$c1 = $_GET['cantidad'];
    	$c2 = $_GET['pagina'];
    	$c3 = $_GET['search'];
    	$c4 = $_GET['column'];
		$c5 = $_GET['cedula'];

    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesRechazadas($c1,$c2,$c3,$c4,$c5);

    	echo json_encode($datos);
    }

    public function actionAutorzacionvacap3(){

    	$c1 = $_GET['cantidad'];
    	$c2 = $_GET['pagina'];
    	$c3 = $_GET['search'];
    	$c4 = $_GET['column'];
    	$c5 = $_GET['cedula'];

    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesVigentes($c1,$c2,$c3,$c4,$c5);

    	echo json_encode($datos);
    }

    public function actionAutorzacionvacap4(){

    	$c1 = $_GET['cantidad'];
    	$c2 = $_GET['pagina'];
    	$c3 = $_GET['search'];
    	$c4 = $_GET['column'];
    	$c5 = $_GET['cedula'];

    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesAcepRech($c1,$c2,$c3,$c4,$c5);

    	echo json_encode($datos);
    }

    public function actionAceptarsolicitudesvaca(){

    	$get1 = $_GET['solicitudes'];
    	$c1 = array();

    	for ($i=0; $i < count($get1); $i++) { 
    		$c1[$i] = $get1[$i]['valor'];
    	}
    	
    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesAceptar($c1);

    	echo $datos;
    }

    public function actionRechazarsolicitudesvaca(){

    	$get1 = $_GET['paramSp'];
    	$c1 = array();
    	$c1[0] = $get1;

    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesRechazar($c1);

    	echo $datos;
    }

    public function actionEditarsolicitudvaca(){

    	$c1 = $_GET['codigoepl'];
		$c2 = $_GET['consecutivo'];
		$c3 = $_GET['dias'];
		$c4 = $_GET['fechaini'];
		$c5 = $_GET['fechafin'];

		$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->solicitudesEditar($c1,$c2,$c3,$c4,$c5);

    	echo "true";
    }

    public function actionCalculafecha(){

    	$c1 = $_GET['fecha'];
    	$c2 = $_GET['dias'];    	    	
    	
    	$vacaciones = new TwPcVacaciones();
    	$datos = $vacaciones->calcularFecha($c1,$c2);

    	echo $datos;

    }
}
