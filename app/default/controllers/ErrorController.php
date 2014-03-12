<?  class ErrorController extends Zend_Controller_Action{

	
	public $erro = NULL;
 
	public function init(){
	        // limpa o conteúdo gerado antes do erro
	        $this->getResponse()->clearBody();
	 
	 		//if(getenv('LOCAL') == 'desenvolvimento'){
		        // pega a exceção e manda para o template
		        $errors 				= $this->_getParam('error_handler');
				if($errors )
		        $this->erro 		 	= $errors->exception;
			//}
	}

    public function errorAction(){
			
			// Desabilita o Layout e Redireciona para o Layout de ERRO.
			$this->_helper->layout->disableLayout();

	        $errors = $this->_getParam('error_handler');
			$motivo = '';
	        // escolhe a view de acordo com o erro
	        switch ($errors->type) {
	 
	            // página não encontrada (404)
	            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
					$this->_forward('EXCEPTION-NO-CONTROLLER');	
					$motivo[0] = 'Página não encontrada (404)';
	            break;
				
				// Ação não encontrada
	           	case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
					$this->_forward('EXCEPTION-NO-ACTION');
					$motivo[0] = 'Ação não encontrada';
				break;
				
				// ROuter não encontrado
				case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE;
					$this->_forward('EXCEPTION-NO-ROUTE');
					$motivo[0] = 'Rota não encontrado';
				break;
				
				// Outros Erros Encontrados.
				case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER:  
					$this->_forward('EXCEPTION-OTHER');
					$motivo[0] = 'Outro Erro Encontrado';
				break;
	 
	            // erro no programa, exceção não tratada
	            // deixa renderizar o template padrão (error/error.phtml)
	            default:
				
	 
	        }
			
			// Nossa senha do G-Mail  login: error.primage@gmail.com  senha: errorzend999
			 $motivo [1] = $this->erro;
			 $motivo [2] = $_SERVER['HTTP_HOST']; 		// Endereço do Site
			 $motivo [3] = $_SERVER['HTTP_USER_AGENT']; // Navegador do Cliente
			 $motivo [4] = $_SERVER['REDIRECT_URL']; 	// Página Acessada que enviou o erro.
			 $motivo [5] = $_SERVER['REQUEST_METHOD']; 	// Metodo
			 
			 if($_POST)
			 {
				foreach($_POST as $key => $value):
					$motivo[6] .= " [$key] => '$value' ";
				endforeach; 
			 }

			 if($_GET)
			 {
				foreach($_GET as $key => $value):
					$motivo[6] .= " [$key] => '$value' ";
				endforeach; 
			 }
			 
			 $this->view->motivo = $motivo;
			 /*
			 $config     = array('auth' => 'login', 'username' => 'error.primage@gmail.com', 'password' => 'errorzend999', 'ssl' => 'ssl','port' => 995);					  
			 $transport  = new Zend_Mail_Transport_Smtp();
		
			 $mail = new Zend_Mail();
 			 $mail -> setBodyText($motivo [1]);
			 $mail->setBodyHtml  ($this->view->render("error/email.phtml"));
			 $mail -> setFrom	 ('error.primage@gmail.com', 'Site com Problema');
			 $mail -> addTo		 ('programador@primage.com.br', 'Thiago Mello');
			 $mail -> addBcc	 ('elio.primage@gmail.com', 'Elio Bonfim Júnior');
			 $mail -> addBcc	 ('adam@gmail.com', 'Adam Mazzei');
			 $mail -> setSubject ("ERRO DETECTADO ! ".$motivo [2]);
			 $mail -> send		 ($transport);
			 
			//$this->_helper->redirector('index', 'index', 'default');
			 */
	}
	
	
	// Não Axou o Controlador................................................
	public function exceptionNoControllerAction(){
				
		$this->view->error = $this->erro;
		
	}
	// Não axou a function.
    public function exceptionNoActionAction(){
		// renderiza a view "error/404.phtml" no lugar da view padrão
			$this->view->error = $this->erro;
	}
	
    public function exceptionNoRouteAction(){
			$this->view->error = $this->erro;
	}
	
	public function exceptionOtherAction(){
			$this->view->error = $this->erro;
	}
	
	
	
	
} // Fim da CLASSE