<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\IndexForm;
use app\models\AsignaForm;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\FormSearch;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\helpers\Url;
use PDO;
use app\models\TwPcIdentity;
use app\models\Ldap;



class SiteController extends Controller
{ 	

	public function actionSaluda(){

		$model = new TwPcIdentity;

		$proce = $model->procedimiento();

        return $this->render('saluda', ["rows"=>$proce]);
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
		
		$modeladp = new Ldap;
		
		$ladpcon = $modeladp->directorioactivo();
		
		if($ladpcon[2]=="false"){
			
			$recordar = "<a class='color-white' href='' data-toggle='modal' data-target='#recordarpass'>Olvidaste tu contraseña?</a>";
		}
		
		if($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
			
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);			
		}
		
		if($model->load(Yii::$app->request->post())){
		if($model->validate()){
			
			//Yii::$app->params['usuario'] = $model->usuario;
			//Yii::$app->params['clave'] = $model->clave;
			
			return $this->redirect(['site/logueo','usuario'=>$model->usuario,'clave'=>$model->clave,'operacion'=>'L']);
			
		}else{
			
			 return $this->goBack();
			 
			}		
		}
		
        return $this->render('index', ['model' => $model,'recordar' => $recordar]);
    }

	public function actionLogueo()
    {
		$modeladp = new Ldap;
		
		$ladpcon = $modeladp->directorioactivo();
		
		if(isset($ladpcon[0]) && $ladpcon[2]=="true"){
			
				return $this->redirect(['site/principal']);
				
		}elseif(isset($ladpcon[1]) && $ladpcon[2]=="true"){
			
			return $this->redirect(['site/index', "error"=>$ladpcon[1]]);
			
		}elseif($ladpcon[2]=="false"){
		
		$model = new TwPcIdentity;
		
		$twpcidentity = $model->procedimiento();
		
		if($twpcidentity[1]=="2"){
			
			return $this->redirect(['site/asignapassword', "error"=>$twpcidentity[2]]);
			
		}elseif($twpcidentity[1]=="1"){
			
			return $this->redirect(['site/principal']);
			
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
		
        return $this->render('principal');
		
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
			
		}else{
			
			 return $this->goBack();
			 
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
					
					return $this->redirect(['site/principal', "message"=>$twpcidentity[2]]);
					
				}else{
					
					return $this->redirect(['site/validapassword', "error"=>$twpcidentity[2], 'tokenreset'=>Yii::$app->request->get('tokenreset') , 'usuario'=>Yii::$app->request->get('usuario'), 'operacion'=>'F']);
				}	
	}
	
	public function actionOlvidapassword()
	{
				$model = new TwPcIdentity;
				
				$twpcidentity = $model->procedimiento();
				
			
	}
	public function actionActivapassword()
	{
				$model = new TwPcIdentity;
				
				$twpcidentity = $model->procedimiento();
								
				 if($_POST['activate'] AND Yii::$app->request->get('usuario') AND Yii::$app->request->get('clave')){					 			
							
					$datos = $twpcidentity[1];
							
					echo(($datos)?json_encode($datos):'');
				
				}else{
					
					$datos = 0; 
					
					echo(($datos)?json_encode($datos):''); 
				}			
	}
	public function actionCertificadolaboral()
    {				
		
        return $this->render('certificadolaboral');
		
    }
	public function actionCertificadosretencion()
    {				
		
        return $this->render('certificadosretencion');
		
    }
	public function actionComprobantespago()
    {				
		
        return $this->render('comprobantespago');
		
    }
	public function actionEquiponomina()
    {				
		
        return $this->render('equiponomina');
		
    }
	public function actionCronogramanomina()
    {				
		
        return $this->render('cronogramanomina');
		
    }
	public function actionActualidadlaboral()
    {				
		
        return $this->render('actualidadlaboral');
		
    }
}
