<?php
class Neo_Controller_Plugin_ActionSetup extends Zend_Controller_Plugin_Abstract {
    public $_redirect 	= '';
	public $_conf 		= NULL;
	
	public function __construct()
	{
		$auth 		 = Zend_Auth::getInstance();
		$user        = $auth->getIdentity();
		$this->_conf = Zend_Registry::get('config');
	}
 	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request){
		
		if ($request->isXmlHttpRequest() || $this->_request->getParam('fc'))
		return false;
		
		if(Zend_Registry::isRegistered('db') != '1')
			return false;
		
		$sess 	   = new Zend_Session_Namespace('menu');
		$nav 	   = new Zend_Session_Namespace('navegacao');
		$menu  	   = new ConfigMenus();
		$arrayMenu = $menu->MenuTotal();
		
		// Dados do Acesso atual Modulo, Controlle e Action
		$module     = $request->getModuleName();
		$controller	= $request->getControllerName();
		$action		= $request->getActionName();
		
		//echo $sess->Modulo.' / '.$sess->Controle.' / '.$sess->Acao.' / '.$sess->ModuloReal;
		//	die();
		// Se não existir nenhuma sessão aberta para o módulo atual,
		// gravo a na Session o Módulo, Controller e Action		
		if(!isset($_SESSION['menu']))
		{
			$sess->Modulo 		= $module;
			$sess->Controle 	= $controller;
			$sess->Acao 		= $action;			
		
		// Se a configuração do Layout para o módulo atual, for DIFERENTE do módulo acessado
		// Adiciono o Módulo a session e ignoro os outros parametros.
		} elseif($this->_conf->layout->$module != $module){
			
			$sess->Modulo 	  = $this->_conf->layout->$module;
			
		// Caso nenhuma das condições acima seja verdadeira, simplesmente salvo os
		// dados de Módulo, Controller e Action			
			} else {
				$sess->Modulo 	  = $module;
				$sess->Controle   = $controller;
				$sess->Acao		  = $action;				
				$sess->ModuloReal = $module;
			}
		$sess->Link	= $str = substr_replace ($_SERVER['REQUEST_URI'], "", 0, 1);
		
		$arr = $this->searchLink($sess->Link, $arrayMenu);
		
		if($arr){
			$nav -> Lateral = $arr['menuLateral'];
			$nav -> Modulo  = $arr['modulo'];
			$nav -> Link    = $arr['link'];
		}
		
		if(isset($_SERVER['HTTP_REFERER'])) 
			$sess->Ref	= $_SERVER['HTTP_REFERER'];

		// Verifico se a URL que estou enviando é apenas um Módulo, ou uma Controller/Action
		// Se for apenas um MÓDULO, envio para o MENU do Módulo caso exista.
		$link = explode('/', $_SERVER['REQUEST_URI']);
		
		if(count($link) <= 2 and isset($arrayMenu[$module]))
			$sess->Modulo 	  = $module;
	
		Zend_Layout::startMvc(array('layoutPath'=>ROOT_DIR.'/app/'.$this->_conf->layout->$module.'/views/layout'));
	}
	
	public $Url = '';
	
	function searchLink($link, $array, $acho = false){
		if(is_array($array)){		
			foreach($array as $key => $indice){
				$chaves = array_keys($indice);
				for($j=0;$j<count($chaves);$j++){
					if($indice[$chaves[$j]] == $link){
						$this->Url = $indice;
						break;
					} else
						$this->searchLink($link, $indice[$chaves[$j]], $acho);
				}
			}
		}
		return $this->Url;
	}
	
}
