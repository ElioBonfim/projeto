<?php
class Neo_View_Helper_Permissao {
	
	public function Permissao($array, $permissao = NULL){
		
            if(!($permissao)){
                $auth  = Zend_Auth::getInstance();
                $user = $auth->getIdentity();

                if($user->grupo == 1)
                        return true;

                $model     = new AdminLoginPermissao();
                $permissao = $model->ListaPermissoes($user->id, '', $user->grupo);	
            }

		
            foreach($array as $key => $value)
                if(is_string($value) and $value == trim($value))
                    $array[$key] = strtolower($value);
	

	
            foreach($permissao as $key => $indice){
                if(($indice['module'] == $array['module']) && ($indice['controller'] == $array['controller']) && ($indice['action'] == $array['action']))
                    return $indice['permission'];
			}

            // SE NAO ENCONTRAR NADA RETORNO FALSE PQ SE TRATA DE UMA AREA
            return false;
	}
	
}