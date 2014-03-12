<?php
class Neo_Form_ContasPagar extends Zend_Form{
	
	
	public function init(){
		
		$this->setMethod('post');
		$this->setOptions(array('id'=>'ContasPagar'));

		$id				= $this->createElement('hidden', 	'id');
		$tipo			= $this->createElement('hidden', 	'tipo', 		array('value' => '1'));			
		$codigo			= $this->createElement('text', 		'codigo', 		array('label'=>'Código'));
		$descricao		= $this->createElement('text', 		'descricao', 	array('label' => 'Descrição'));
		$contacaixa		= $this->createElement('text', 		'contacaixa',	array('label'=>'Conta Caixa', 'value'=>'1'));
		$centrocusto	= $this->createElement('text', 		'centro_custo', array('label'=>'Centro de Custo', 'value'=>'1'));
		$fornecedor		= $this->createElement('text', 		'fornecedor',	array('label'=>'Fornecedor', 'value'=>'1'));
		$data			= $this->createElement('text', 		'vencimento', 	array('label'=>'Data de Vencimento'));
		$valor			= $this->createElement('text', 		'valor',		array('label'=>'Valor'));
		$parcelas		= $this->createElement('text', 		'parcelas',		array('label'=>'Parcelas'));
		$periodicidade	= $this->createElement('text', 		'periodicidade',array('label'=>'Vence Em:', 'value'=>'1'));
		$portador		= $this->createElement('text', 		'portador', 	array('label'=>'Portador:'));
		$anotacoes		= $this->createElement('textarea', 	'anotacoes', 	array('label'=>'Anotações'));
		$datacriacao	= $this->createElement('text', 		'data_criacao', array('value'=> date('Y-m-d')));
		
		
		$submit			= new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		
		$this->addElements(array($tipo, $codigo, $descricao, $contacaixa, $data, $centrocusto, $fornecedor, $data, $valor, $parcelas, $periodicidade, $portador, $anotacoes, $datacriacao, $submit));
		
	}
	
	
}