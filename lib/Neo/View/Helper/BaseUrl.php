<? class Neo_View_Helper_BaseUrl extends Zend_Controller_Action_Helper_Abstract {

	public function BaseUrl($arquivo){

		$uri	 = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $host	 = 'http://'.$_SERVER['HTTP_HOST'].$uri;

	    $config  = Zend_Registry::get('config');
	    $url     = Zend_Controller_Action_Helper_Abstract::getRequest();
	    $fc      = Zend_Controller_Front::getInstance();
		$base    = $fc->getBaseUrl();

		$modulo  = $url->getModuleName();
        $layout  = '';
        $ex		 = explode('/', $arquivo);
        $arq 	 = explode('.', $arquivo);

				
		/* Se a Variavel $arquivo existe, significa que a URL passada no parametro foi a URL completa. */
		if(file_exists(ROOT_DIR.'/public_html/'.$arquivo) || file_exists(ROOT_DIR.'/public_html'.$arquivo) || file_exists(ROOT_DIR.'/'.$arquivo))
			return '/'.$arquivo;	
			
			
        // Se conseguir explodir na ARQ é porque é um arquivo.
        if(count($arq) > 1){

        	// Se existir a declaração para Layout no arquivo CONFIG.ini
			if(is_string($config->layout) || is_string($config->layout->$modulo)){

			    if(isset($config->layout->$modulo->pasta))
					$layout = $config->layout->$modulo->pasta.'/';
						else 
							$layout = 'default/';
				
				// Se for arquivo de lib ele monta o LINk na default
			    if(in_array("lib", $ex) || $modulo == 'default' || in_array("imgTMP", $ex)){
			        $retorno = $base.'/'.$arquivo;
			    } else {
			        $retorno = $base.'/_'.$modulo.'/'.$layout.$arquivo;
			    }

			} else {

			        if(is_string($config->layout->$modulo->espelho)){
			                $espelho = $config->layout->$modulo->espelho; // Ex: Primage, Admin e etc...
			                $retorno = $base.'/_'.$config->layout->$modulo->espelho.'/'.$config->layout->$espelho.'/'.$arquivo;
			        } else
				        $retorno = $base.'/'.$arquivo;

			}

        } else
	        $retorno = $base.$arquivo;

	   // Se no Arquivo de Configuração, estiver pedindo FULL URL, adiciono o $HOST ao retorno.
	   if($config->FullUrl && $retorno)
        	return  $host.$retorno;
       			else
        	  		return $retorno;

	}
}