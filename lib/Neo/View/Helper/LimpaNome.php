<?
class Neo_View_Helper_LimpaNome {
	public function LimpaNome($string = NULL, $tipo = NULL, $qnt_caracteres = 10){
			if($this->codificacao($string) == 'UTF-8') $string = utf8_decode($string);
				$CaracteresAceitos 	= 'abcdxywzABCDZYWZ0123456789';
				$caracteres			= array("Ç", "ç","~","^","]","[","{","}",";",":","´",",",">","<","/","|","@","$","%","ã","â","á","à","é","è","ó","ò","+","=","*","&","(",")","!","#","?","`","ã","©", "õ", " ", "  ", "‡", "‰", "ú", "ü");
				$subistitue 		= array("c", "c",""	,""	,""	,""	,""	,""	,""	,""	,""	,""	,""	,""	,""	,""	,""	,""	,""	,"a","a","a","a","e","e","o","o","","","","","","","","","","","a","", "o", "-", "-", "", "", "u", "u");
				
				if($tipo == 'limpa'){
					$string = str_replace($caracteres,$subistitue,$string);
					$expReg = preg_replace('/\s[\s]+/'	,'-' ,$string);    // Procurando por MULTIPLOS espaços
					$expReg = preg_replace('/\_[\_]+/'	,'-' ,$expReg);    // Procurando por MULTIPLOS underlines
					$expReg = preg_replace('/[\s\W]+/'	,'-' ,$expReg);    // Strip off spaces and non-alpha-numeric
					$expReg = preg_replace('/^[\-]+/'	,''	 ,$expReg);	   // Strip off the starting hyphens
					$expReg = preg_replace('/[\-]+$/'	,''	 ,$expReg);	   // Strip off the ending hyphens
					$expReg = strtolower($expReg);
					$novo_nome 	= $expReg;
				}
			  	else {
				  	$novo_nome 		 = null;
					$max 			 = strlen($CaracteresAceitos)-1;
				  	for($i=0; $i < $qnt_caracteres; $i++) {  $novo_nome .= $CaracteresAceitos{mt_rand(0, $max)};  }
				}
				return $novo_nome;
	}
	//CREDITO: Rafael Jaques
	// http://www.phpit.com.br/artigos/detectandodescobrindo-o-charsetcodificacao-de-uma-string-utf-8-iso-8859-1-etc.phpit
	function codificacao($string) {
        return mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
    }
}
