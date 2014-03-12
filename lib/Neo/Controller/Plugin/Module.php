<?
class Neo_Controller_Plugin_Module extends Zend_Controller_Plugin_Abstract{
	
	public function routeShutdown(zend_Controller_Request_Abastract $request){
		
			Zend_Layout::getMvcInstance()->setLayout($request->getModuleName());
		
		}
	
	}

?>