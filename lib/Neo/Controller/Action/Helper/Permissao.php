<?php
class Zend_Controller_Action_Helper_Permissao extends Zend_Controller_Action_Helper_Abstract {
    
	public function Permissao($array, $permissao = NULL){
		
		if(!($permissao)){
			$auth  = Zend_Auth::getInstance();
			$user = $auth->getIdentity();
			
			$model     = new AdminLoginPermissao();
			$permissao = $model->ListaPermissoes($user->id);
			
		}
		
		foreach($permissao as $key => $indice){
			
			if(($indice['module'] == $array['module']) && ($indice['controller'] == $array['controller']) && ($indice['action'] == $array['action'])){
				return $indice['permission'];
			}
		}

		// SE NAO ENCONTRAR NADA RETORNO FALSE PQ SE TRATA DE UMA AREA TOTALMENTE RESTRITA
		return false;
		
	}
	
}