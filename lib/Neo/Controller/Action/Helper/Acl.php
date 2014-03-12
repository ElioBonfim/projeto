<?
class Neo_Controller_Action_Helper_Acl extends Zend_Controller_Action_Helper_Abstract {
    protected $_auth;
    protected $_request;
    public function init() {
        $this->_auth = Zend_Auth::getInstance();
        $action = $this->getActionController();
        $this->_request = $action->getRequest();
		
    }
    public function preDispatch() {
		
        $controller = $this->_request->getControllerName();
        $action = $this->_request->getActionName();
        $module = $this->_request->getModuleName();
        $permissoes_sistema = Zend_Registry::get('config');
		
		if($module == 'primage'){
		
			$permissaoModule     = explode(',', $permissoes_sistema->permissao->full);
			$permissaoController = explode(',', $permissoes_sistema->permissao->$module);
			
			if ($this->_auth->hasIdentity())
				$papel = $this->_auth->getIdentity()->papel;
			
			
			if(stristr($action, 'ajax'))
				return false;
			
			if ((!isset($papel)) and ($module != 'login') ){
				$this->rediLogin('index', 'index', 'login');
			}
			if ($_SERVER['HTTP_USER_AGENT'] == 'Shockwave Flash' && substr($_SERVER['CONTENT_TYPE'], 0, 19) == 'multipart/form-data')
				return false;
			
			if (in_array($module, $permissaoModule) or in_array($controller, $permissaoController) or in_array($controller . '.' . $action, $permissaoController) or $papel == '1')
					return false;

			// Caso não seja um Recurso liberado, verifico se o Usuario esta Logado. Caso contrario redireciono ele.
			if (!$papel)
				$this->rediLogin('index', 'index', 'login');
			
			// Pego as Permissões que vieram do Banco quando o Usuário Efetuou o LOGIN.
			$permissao = new Zend_Session_Namespace('permissao');
			
			$permissao = $permissao->permissao;
			
			#print_r($permissao); die;
			
			if ($this->Permissao(array('module' => $module, 'controller' => $controller, 'action' => $action)))
				return false;
			
			if ($this->_request->getParam('fc'))
				echo '<script>parent.$.colorbox.close();</script>';
				
			
			
			$this->AcessoRestrito();
		
		}
    }
    public function AcessoRestrito() {
        $front = Zend_Controller_Front::getInstance();
        // Verifico se o Plugin ActionStack esta inicializado pelo sistema.
        // Caso necessário inicializo o Plugin para redirecionar o usuário
        if (!$front->hasPlugin('Zend_Controller_Plugin_ActionStack')) {
            $actionStack = new Zend_Controller_Plugin_ActionStack();
            $front->registerPlugin($actionStack, 97);
        }
        else
            $actionStack = $front->getPlugin('Zend_Controller_Plugin_ActionStack');
        	$request = clone($this->getRequest());
        	$request->setParam('URL', array(
            	'Modulo' => $this->_request->getModuleName(),
            	'Controller' => $this->_request->getControllerName(),
            	'Action' => $this->_request->getActionName()
			)
        );
        $request->setModuleName('login');
        $request->setControllerName('index');
        $request->setActionName('forbidden');
        $actionStack->forward($request);
    }
    public function rediLogin($acao, $controlador, $model) {
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
        $redirector->gotoSimpleAndExit($acao, $controlador, $model);
    }
    function Permissao($array) {
        
		// Pego as Permissões que vieram do Banco quando o Usuário Efetuou o LOGIN.
        $permissao = new Zend_Session_Namespace('permissao');
        $permissao = $permissao->permissao;
		
        foreach ($permissao as $key => $indice) {
            if (($indice['module'] == $array['module']) && ($indice['controller'] == $array['controller']) && ($indice['action'] == $array['action'])) {
                return $indice['permission'];
            }
        }
        // SE NAO ENCONTRAR NADA RETORNO FALSE PQ SE TRATA DE UMA AREA TOTALMENTE RESTRITA
        return false;
    }
}