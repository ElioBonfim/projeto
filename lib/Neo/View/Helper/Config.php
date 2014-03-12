<?php
class Neo_View_Helper_Config{

	public function Config($parametro){
	    if($parametro){

	        $config = Zend_Registry::get('config');
	        $par    = explode('->', $parametro);
	        $cont   = count($par);


	        if($cont){
	            $metodo = $config->$par['0'];
	            for($i=1; $i < $cont; $i++){ $metodo = $metodo->$par[$i]; }

	        } else {
	            $metodo = $config->$parametro;
	        }

	        return $metodo;
	    }
	}

}