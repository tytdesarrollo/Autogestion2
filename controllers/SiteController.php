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


class SiteController extends Controller
{ 	


	public function actionPrueba(){				
	
		$model = new TwPcCronoCierreNomina;
		
		$twpccierrenomina = $model->CierreNomina();
		
		$crono = $twpccierrenomina[0];
		
		/*foreach ($PERIODOS as $PERIODO_KEY) {
			$NOM_PERIODO_ARR[] = $PERIODO_KEY['PERIODO'];
			$ANO_PERIODO_ARR[] = $PERIODO_KEY['ANO_INI'];
			$NUM_PERIODO_ARR[] = $PERIODO_KEY['NUM_PER'];
			$JUN_PERIODO_ARR[] = $PERIODO_KEY['PERIODO'].'_*'.$PERIODO_KEY['ANO_INI'];
			

		}*/				
		
		return $this->render('prueba', ["crono"=>$crono]);
	
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
			$events = Yii::$app->mysqldb->createCommand("SELECT ID AS ID, TITLE AS TITLE, START AS START, END AS END, COLOR AS COLOR FROM EVENTS")->queryAll();
			
			$this->view->params['customParam'] = $events;

                return $this->render('mvacaciones',['events' => $events]);

			}
			else if ($mobile_browser > 0) {
			// Si es dispositivo mobil has lo que necesites			
			   $events = Yii::$app->mysqldb->createCommand("SELECT ID AS ID, TITLE AS TITLE, START AS START, END AS END, COLOR AS COLOR FROM EVENTS")->queryAll();
			
			$this->view->params['customParam'] = $events;

                return $this->render('mvacaciones',['events' => $events]);
			}
			else {
			// Si es ordenador de escritorio has lo que necesites
			$events = Yii::$app->mysqldb->createCommand("SELECT ID AS ID, TITLE AS TITLE, START AS START, END AS END, COLOR AS COLOR FROM EVENTS")->queryAll();
			
			$this->view->params['customParam'] = $events;
				
                return $this->render('vacaciones',['events' => $events]);
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
		$bloque9 = explode("_*", $twpcpersonaldata[8]);
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
			$events = Yii::$app->mysqldb->createCommand("SELECT ID AS ID, TITLE AS TITLE, START AS START, END AS END, COLOR AS COLOR FROM EVENTS")->queryAll();
			
			$this->view->params['customParam'] = $events;

                return $this->render('mturnos',['events' => $events]);

			}
			else if ($mobile_browser > 0) {
			// Si es dispositivo mobil has lo que necesites			
			   $events = Yii::$app->mysqldb->createCommand("SELECT ID AS ID, TITLE AS TITLE, START AS START, END AS END, COLOR AS COLOR FROM EVENTS")->queryAll();
			
			$this->view->params['customParam'] = $events;

                return $this->render('mturnos',['events' => $events]);
			}
			else {
			// Si es ordenador de escritorio has lo que necesites
			$events = Yii::$app->mysqldb->createCommand("SELECT ID AS ID, TITLE AS TITLE, START AS START, END AS END, COLOR AS COLOR FROM EVENTS")->queryAll();
			
			$this->view->params['customParam'] = $events;
				
                return $this->render('turnos',['events' => $events]);
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
		
        return $this->render('equiponomina');
		
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
}
