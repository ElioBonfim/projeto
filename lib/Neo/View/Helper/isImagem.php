<?
class Neo_View_Helper_BaseUrl extends Zend_Controller_Action_Helper_Abstract {


	public function BaseUrl($arquivo){

	    $config  = Zend_Registry::get('config');
	    $url     = Zend_Controller_Action_Helper_Abstract::getRequest();
	    $fc      = Zend_Controller_Front::getInstance();
		$base    = $fc->getBaseUrl();

		$modulo  = $url->getModuleName();
        $layout  = '';

        // Se existir a declaração para Layout no arquivo CONFIG.ini
		if($config->layout || $config->layout->$modulo){
            $layout = $config->layout->$modulo.'/';
		}

		$ex   = explode('/', $arquivo);

		// Se for arquivo de lib ele procura na default
	    if(in_array("lib", $ex) || $modulo == 'default'){
	        return $base.'/'.$arquivo;
	    } else {
	        return $base.'/_'.$modulo.'/'.$layout.$arquivo;
	    }


			//return $res.'/';
	}







}

