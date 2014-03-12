<?php

class Zend_Controller_Action_Helper_Emails extends Zend_Controller_Action_Helper_Abstract {

	

	public 	$view = '';

	

	public function __construct(){

		$viewRenderer 	= Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');

		$viewRenderer	->init();

		$this->view		= $viewRenderer->view;

	}

	

    public function Emails($type = 'default', $destino, $dados, $assunto, $copia, $copiaOculta = false){

		

		$config = $this->getConfig($type);

		

		$this->view->dados = $dados;

		
		#require_once 'Zend/Mail/Transport/Smtp.php';
		

		#$authenticate = array('auth' => 'login',

        #		        'username'   => 'site@haward.com.br',

        #        		'password'   => 'haward123'

												

		#				);

 

		#$transport = new Zend_Mail_Transport_Smtp('mail.haward.com.br', $authenticate);

		 

		$mail = new Zend_Mail();

		$mail->setBodyText("");

		$mail->setBodyHtml($this->view->render($dados['render']));

		$mail->setFrom($config->email, $config->nome);

		if($copia){

			foreach($copia as $key => $cc){

				$mail->addCc($cc['endereco']);

			}

		}

		$mail->addTo($destino['email'], $destino['nome']);
		#$mail->addBcc('elio@primage.com.br', 'Oculto');

		$mail->setSubject($assunto);

		if(!$mail->send()){

			echo $mail->getMessage();

		}

			

	}

	

	public function getConfig($local){

		return new Zend_Config_Ini(ROOT_DIR.'/app/config-email.ini', $local);

	}

	

}