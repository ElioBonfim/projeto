<?
class Neo_View_Helper_EspacoMaiuscula {



	public function EspacoMaiuscula($inicio, $caracter = ' ') {

			$n_caracteres = strlen($inicio);
			$final 		  = '';

			for( $i=0; $i < $n_caracteres ; $i++ ){
				$letra = substr($inicio, $i, 1);

				if(ctype_upper($letra)){
					$final.=$caracter.substr($inicio, $i, 1);
				} else {
					$final.=substr($inicio, $i, 1);
				}
			}

			$final = strtolower($final);

			if($caracter == ' ')
			    return ucfirst(str_replace("-", " ", $final));

			      else
			        return $final;


	}



}

?>