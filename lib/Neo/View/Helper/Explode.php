<?

class Neo_View_Helper_Explode 

{

	

	

	

	public function Explode($simbolo, $array, $chave = ''){

		

		$explode	= explode($simbolo, $array);

		

		if($chave == ''){	

		

			return $explode;

			

		} else { return $explode[$chave]; }		



	}

	





}

?>