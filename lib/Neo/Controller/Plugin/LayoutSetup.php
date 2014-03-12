<?php
class Neo_Controller_Plugin_LayoutSetup extends Zend_Controller_Plugin_Abstract {

    public $_redirect = '';

 	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request){

		$topico		= clone($request);
		$modulo     = $topico-> getModuleName();
		$controle	= $topico-> getControllerName();
		$action		= $topico-> getActionName();
	    $config		= Zend_Registry::get('config');



		// Se existir a declaração para Layout no arquivo CONFIG.ini
		if(is_string($config->layout) || is_string($config->layout->$modulo))
		    $modulo = $config->layout->$modulo;
				else
					$modulo = 'default';

		//$fp  = fopen("logCaminho.txt", "a");
		//fwrite($fp, $modulo.'/'.$controle.'/'.$action.'   |   ');

		if($request->isXmlHttpRequest())
				// Se for uma Requisição AJAX inicializo Outro LAYOUT
				Zend_Layout::startMvc(array('layout'=>'layout_empty', 'layoutPath'=>ROOT_DIR.'/app/'.$modulo.'/views/layout'));

		elseif ($request->getParam('fc')){
				// Se encontrar o Parametro FC no get da URL, redireciono para o Layout Janelas.
				Zend_Layout::startMvc(array('layout'=>'layout_janelas', 'layoutPath'=>ROOT_DIR.'/app/'.$modulo.'/views/layout'));

		} else {  // Caso contrario, Inicializo o Layout Padrão.

				Zend_Layout::startMvc(array('layoutPath'=>ROOT_DIR.'/app/'.$modulo.'/views/layout'));
		}

		//fclose($fp);

	} // Fim da dispatchLoopStartup

}
