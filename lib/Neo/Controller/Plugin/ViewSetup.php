<?php
class Neo_Controller_Plugin_ViewSetup extends Zend_Controller_Plugin_Abstract
{
	protected $_view;

	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
	{

		$viewRenderer	= Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer   ->init();
		//$viewRenderer->setViewSuffix('php');

		$view	     = $viewRenderer->view;
		$this->_view = $view;

		$view->originalModule 		= $request->getModuleName();
		$view->originalController	= $request->getControllerName();
		$view->originalAction		= $request->getActionName();


		$prefix = 'Neo_View_Helper';
		$dir	= dirname(__FILE__).'/../../View/Helper';
		$view  -> addHelperPath($dir, $prefix);



		//$view    = new Zend_View();
		$view    ->setEncoding('iso-8859-1');
		//$viewRenderer->setView($view);;
	}

}