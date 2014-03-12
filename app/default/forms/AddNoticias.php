<? class AddNoticias extends Zend_Form {

		public $db		 = '';		// Banco Principal
		public $redirect = NULL;	// Pagina para Redirecionamento
		public $view 	 = NULL;    // Vou atribuir os Helpers de Visão aqui.
		public $imagem 	 = array('y' => '800', 'x' => '800', 'dir' => 'img/noticias/');
		public $bancos   = array('Form' => 'Form');


		public function init()	{
			// Arquivos de Inicialização Padrão -------------------------------------------------------------------------------------------
			$viewRenderer 	= Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
			$viewRenderer	->init();
			$this->view		= $viewRenderer->view;	// Atribuo os Helper de Visão para  $this->view													            
			//-----------------------------------------------------------------------------------------------------------------------------

			$rand 			= date('YmdHis');
			$this->db 		= new  $this->bancos['Form']; // BANCO de dados de Módulos
			
			$this->setAction	(''); 					        // Adiciona a Action ao Formulário. Caso não seja declarado, envia para $_SELF
			$this->setMethod	('post'); 				        // Define o Metodo.
			$this->setAttribs	(array('id' => 'AddNoticias', 'nome' => 'addNoticias', 'role' => 'form')); // Attribs (Arr com varios) Attrib (Um par de attr e valor)
			$this->setAttrib 	('enctype', 'multipart/form-data');

			//-----------------------------------------------------------------------------------------------------------------------------
			//-----------------------------------------------------------------------------------------------------------------------------
			//-----------------------------------------------------------------------------------------------------------------------------
			//-----------------------------------------------------------------------------------------------------------------------------



		// VINCULO PARA ARQUIVOS   ................................................................
			
			foreach($this->db->fetchAll()->toArray() as $forConfig):
			
				print_r($forConfig);
				$elemento =  $this->createElement($forConfig['type'], $forConfig['name'], array('id' => $forConfig['idName'], 'label'=> $forConfig['label'] ));
				$elemento 	  -> setRequired(true);
				
     			if($forConfig['filterAlnum'])  				$elemento -> addFilter	('Alnum', array('allowwhitespace' => true));
	     		if($forConfig['filterAlpha'])  					$elemento -> addFilter	('Alpha', array('allowwhitespace' => true));
				if($forConfig['filterDigits']) 					$elemento -> addFilter	('Digits');
				if($forConfig['filterInt']) 	 				$elemento -> addFilter	('Int');
				if($forConfig['filterLocalizedToNormalized']) 	$elemento -> addFilter	('LocalizedToNormalized');
				
				if($forConfig['filterNull']) 			 $elemento -> addFilter	('Null');
				if($forConfig['filterStringTrim']) 		 $elemento -> addFilter	('StringTrim', 	  array ('charlist' => ''));
				if($forConfig['filterStringToUpper']) 	 $elemento -> addFilter	('StringToUpper', array ('encoding' => 'ISO-8859-1'));
				if($forConfig['filterStringToLower']) 	 $elemento -> addFilter	('StringtoLower', array ('encoding' => 'ISO-8859-1'));
				if($forConfig['filterBaseName']) 		 $elemento -> addFilter	('BaseName');
			
				if($forConfig['validatorStringLength'])  $elemento-> addValidator   ('StringLength', false, array(1, 150));
				if($forConfig['validatorAlnum'])  	     $elemento-> addValidator	('Alnum', array('allowWhiteSpace' => true));
				if($forConfig['validatorAlpha'])  	     $elemento-> addValidator	('Alpha', array('allowWhiteSpace' => true));
				if($forConfig['validatorDigits'])  	     $elemento-> addValidator	('Digits');
				if($forConfig['validatorFloat'])  	     $elemento-> addValidator	('Float');
				if($forConfig['validatorInt'])  		 $elemento-> addValidator	('Int');
				if($forConfig['validatorNotEmpty'])  	 $elemento-> addValidator	('NotEmpty');
				
				if($forConfig['validatorDate'])  		 $elemento-> addValidator	('Date', array('format' => 'dd/mm/YYYY', 'locale' => 'pt-br'));
				if($forConfig['validatorEmailAddress'])  $elemento-> addValidator	('EmailAddress', array('allow' => Zend_Validate_Hostname::ALLOW_DNS, 'deep' => true, 'domain' => false, 'hostname' => '', 'mx' => true));
				if($forConfig['validatorRecordExists'])  $elemento-> addValidator	('RecordExists', array('table' => 'users', 'field' => 'emailaddress'));
				if($forConfig['validatorLessThan'])  	 $elemento-> addValidator	('LessThan', array('max' => 10));
				if($forConfig['validatorGreaterThan'])   $elemento-> addValidator	('GreaterThan', array('min' => 10));
				if($forConfig['validatorIdentical'])  	 $elemento-> addValidator	('Identical', false, array('token' => 'NomeDoCampo'));
				if($forConfig['validatorInArray'])  	 $elemento-> addValidator	('InArray', array('key' => 'value', 'otherkey' => 'othervalue'));
						
				if($forConfig['errorMessage']) 			 $elemento-> addErrorMessage ('Mensagem de Erro Aqui');
				//
//				if($forConfig['titulo']) $elemento->addDecorators(array(
//							array('ViewHelper'),
//							array('Errors'),
//							array('Description', array('tag' => 'p', 'class' => 'description')),
//							array('HtmlTag', array('tag' => 'dd')),
//							array('Label', array('tag' => 'dt')),
//						));				
				
					
				$this 	  -> addElement($elemento);				
			
			endforeach;	
	
	
//	
//		// Imagens ....................................................................................
//
//			$elemento = $this->createElement('file','imagens', array('label' => 'Imagens', 'id' => 'imagens', 'rel' => $rand));
//			   try {
//				   $elemento ->setDestination($this->imagem['dir']);
//			   } catch (Exception $e){
//				   mkdir($this->imagem['dir']);
//				   $elemento ->setDestination($this->imagem['dir']);
//			   }
//			   
//			if($_POST)
//				$this 	 ->Upload($elemento);
//				$this	 ->addElement($elemento);

			
		// Submit  ......................................................................................
			$submit	=  $this->createElement('submit', 'Enviar');
			$submit -> removeDecorator('HtmlTag')->removeDecorator('Label');
			$this	-> addElement($submit);


		// Adicionando os Elementos um GRUPO (Config) .............................................................................
		//	$this->addDisplayGroup(array('id', 'data', 'titulo', 'imagens',  'texto', 'fonte', 'Enviar'), 'noticias', array('removeDecorator' => 'Label', 'class' => 'col-sm-6 panel panel-default'));
		//	$this->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));
		}



		// Funções Auxiliares PADRÕES ------------------------------------------------------------------------------------------------------
		// ---------------------------------------------------------------------------------------------------------------------------------

		public function redirect($url)
		{
			$this->redirect = $url;
		}


		public function insert()
		{
			//print_r($_POST); die(); 
			$data   = $_POST;  // Recupero os Valores inseridos no Formulário.
			$this->db->insert($data);	 // Insiro no banco Principal do Formulário.
			
			/*echo '<script>parent.location.reload();</script>';*/
			if($this->redirect != NULL){ $this->Redireciona($this->redirect);} else { $this->Redireciona();}  // Redireciono o Formulário para a mesma página ou para página definida no $this->redirect();

		}

		
		public function Redireciona($url)
		{
			/* Função responsável por redirecionar o formulário assim que ele for submetido. Evitando assim o Reenvio no F5
			*  Caso seja não seja passado o parametro URL ele redireciona pro Mesmo formulário para uma nova inserção.   */
			$redir 	= Zend_Controller_Action_HelperBroker::getStaticHelper('Redireciona');
			$redir -> Redireciona($url);
		}

		

		public function Edita($id)
		{
			if(isset($id))
			{
				$sql = $this->db->select()->where('id ='.$id);
				$res = $this->db->fetchRow($sql)->toArray();
				$res['data'] = $this->view->ConverteData('-',$res['data'],4);
				return $this->populate($res);
			}
		}



		public function Upload($campo = NULL)
		{
			$config 	= array('nomeAleatorio' => true);
			$arquivo	=  Zend_Controller_Action_HelperBroker::getStaticHelper('Upload')-> Upload($campo, $config);
			
			if(!$arquivo) return false;
			$vinculo = $_POST['vinculoRand'];

			$imagens = new NoticiasImagens();
			$imagens-> insert(array('imagem'=>$arquivo['novoNome'], 'vinculo'=>$vinculo));
		}
}