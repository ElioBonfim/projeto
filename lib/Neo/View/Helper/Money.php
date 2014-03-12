<?

class Neo_View_Helper_Money {

	

	public function Money($valor, $decimais = 2) { return number_format($valor, $decimais, ',', '.'); }	

	

}

?>