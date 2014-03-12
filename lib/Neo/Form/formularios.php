<?php
class Neo_Form_Formularios extends Zend_Form
{

	public function init()
	{
	
		$this->setAction('/insere');
		$this->setMethod('post');
		
		//Criando os Elementos.
		$this->addElement('text','descricao');
		
		
	}	
	
	
	public function Nome(){
		$nome	= $this->createElement('text', 'nome', array(
					'label'		=>'Nome',
					'required'	=> true,
					'filters'	=> array()
		));
		return $nome;
	}
			
	
	public function Email(){
		$email	= $this->createElement('text', 'email', array('label'=>'E-Mail'));	
		$email	-> setRequired(true);	
		return $email;
	}
	
	public function Id(){
		$id = $this->createElement('text', 'id', array('label'=>'Esse é o ID'));
		return $id;
	}
	
	public function Senha(){
		$senha	= $this->createElement('password', 'Senha',
			array('alnum'	=> array('regex', false, '/^[a-z]/i'),
			'required' 		=> true,
			'filters'		=> array('StringtoLower'),
			'label'			=> 'Senha'
		));
			return	$senha;
	}
	
}