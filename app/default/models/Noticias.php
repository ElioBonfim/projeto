<?php
class Form extends Zend_Db_Table {
	protected $_name 			= 'config_forms_input';
	protected $_primary			= 'id';
	public 	  $_view;
	public function init()
	{
		$viewRenderer 	= Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer	->init();
		$this->_view		= $viewRenderer->view;	// Atribuo os Helper de Visão para  $this->view
	}
	
}