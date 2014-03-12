<? class Neo_Controller_Action_Helper_Acl extends Zend_Controller_Action_Helper_Abstract {
    protected $_view;
    protected $_action;
    protected $_auth;
    protected $_acl;
    protected $_controllerName;
	protected $_moduleName;
	protected $_actionName;
	protected $_request;
	
	
    public function __construct(Zend_View_Interface $view = null, array $options = array())
    {
        $this->_auth = Zend_Auth::getInstance();
        $this->_acl  = $options['acl'];
	}
	
	
    public function init()
    {
        $this->_action 			= $this->getActionController();
		$this->_request 		= $this->_action->getRequest();
        $this->_moduleName 		= $this->_action->getRequest()->getModuleName(); 	  // Nome do Módulo da Requisição
        $this->_controllerName 	= $this->_action->getRequest()->getControllerName();  // Nome do Controller da Requisição
        $this->_actionName 		= $this->_action->getRequest()->getActionName();	  // Nome do Action da Requisição
        if(!$this->_acl->has($this->_controllerName))                         		  // Verifico se o Recurso Existe
            $this->_acl->add(new Zend_Acl_Resource($this->_controllerName));  		  // Caso não exista, crio o Recurso
    }
	
	
    public function preDispatch()
    {
		$controller = $this -> _request -> getControllerName ();
		$action 	= $this -> _request -> getActionName     ();
		$module 	= $this -> _request -> getModuleName     ();
		$resource 	= $controller;
		$privilege 	= $action;
		$permissoes_sistema = Zend_Registry::get('config');
		
		if($this->_auth->hasIdentity())
			$papel = $this->_auth->getIdentity()->papel;
	
	
		if ($_SERVER['HTTP_USER_AGENT'] == 'Shockwave Flash' && substr($_SERVER['CONTENT_TYPE'],0,19) == 'multipart/form-data')
		return false;
		
					
		// Verifico se o Recurso acessado é permitido por PADRÃO (no config.ini) pelo Aplicativo.
		if(!isset($permissoes_sistema->acesso->$module->$controller) && $permissoes_sistema->acesso->$module != 'full' && $papel != '1'){
		    // Caso não seja um Recurso liberado, verifico se o Usuario esta Logado. Caso contrario redireciono ele.
		    if(!$papel)	$this->rediLogin('index', 'logout', 'login');
			
			// Pego as Permissões que vieram do Banco quando o Usuário Efetuou o LOGIN.
			$permissao 	= new Zend_Session_Namespace('permissao');
			$permissao  = $permissao->permissao;
			
			
			//print_r($permissao[$module][$controller]);
			//die('Teste');
			
			// Se existir dados no array Permissão[Módulo][Controller] Varro as Actions
			// Função utilizada APENAS para definir os Níveis de acesso ao sistema concedidos para o Usuário.
			if(isset($permissao[$module][$controller]))
			{
					foreach($permissao[$module][$controller] as $per):
							for($i=2; $i < count($per); $i++){
								if($per['permission'] == 1)
								  $this->allow($per['Controller'], $papel, $per['Action']);
								    else
								      $this->deny($per['Controller'], $papel, $per['Action']);
							}
					endforeach;
			}
			
			//die();
			
			// Se não existir o Recurso, ele define como Vaziu
			if (!$this->_acl->has($resource)) { $resource = null; }
			
			// Nesse ponto verifico se o Usuário tem permissão para acessar a URL solicitada
			if (!$this->_acl->isAllowed($papel, $resource, $privilege)) 
			{
				/*echo '<script>alert("Atenção ! '.$module.' - '.$controller.' - '.$action.' Seu usuário não tem permissão para acessar esta área. Contate o Administrador do sistema");</script>';*/
			    // Se for um IFRAME  (ou seja, FC = 1) apenas fecho a Colorbox.
				// Se for uma Página (ou seja, FC não existe) eu retono a página anterior.
				
				echo $this->_acl->isAllowed($papel, $resource, $action).'<br>';
				//die($papel.'+'.$resource.'+'.$action);
				echo $module.' / '.$controller.' Finish </br>';
				print_r($_SESSION);

				if($this->_request->getParam('fc'))
					echo '<script>parent.$.colorbox.close();</script>';
				    $this->AcessoRestrito();
			}
		}
    }
	
	
    public function allow($resource = null, $role = null, $actions = null)
    {
		
		echo 'Allow '.($resource.' - '.$role.' - '.$actions).'</br>';
		//die();
		
        if(is_null($resource))
			$resource = $this->_controllerName;
		$this->_acl->allow($role, $resource, $actions);
        return $this;
    }
	
	
    public function deny($resource = null, $role = null, $actions = null)
    {
		echo 'Deny '.($resource.' - '.$role.' - '.$actions).'</br>';

        if(is_null($resource))
        	$resource = $this->_controllerName;
        $this->_acl->deny($role, $resource, $actions);
        return $this;
    }
	
	
    public function AcessoRestrito()
	{
		
		
		$controller = $this -> _request -> getControllerName ();
		$action 	= $this -> _request -> getActionName     ();
		$module 	= $this -> _request -> getModuleName     ();
        $front	    = Zend_Controller_Front::getInstance();
		
		//die($action .' - '.$module.' - '.$controller);
        
		
		// Verifico se o Plugin ActionStack esta inicializado pelo sistema.
        // Caso necessário inicializo o Plugin para redirecionar o usuário
	    if(!$front->hasPlugin('Zend_Controller_Plugin_ActionStack'))
	    {
			$actionStack = new Zend_Controller_Plugin_ActionStack();
		    $front->registerPlugin($actionStack, 97);
		} else {
		    $actionStack	= $front->getPlugin('Zend_Controller_Plugin_ActionStack');
		}
	      $request     = clone($this->getRequest());
          $request     -> setParam('URL',  array('Modulo' => $module, 'Controller' => $controller, 'Action' => $action));
	      $request     -> setModuleName    ('login');
	      $request     -> setControllerName('index');
          $request     -> setActionName    ('forbidden');
          $actionStack -> forward($request);
	}
	
	
	public function rediLogin($acao, $controlador, $model)
	{
		$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
		$redirector	->gotoSimpleAndExit($acao, $controlador, $model);
	}
}