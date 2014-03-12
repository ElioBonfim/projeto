<?

class Neo_View_Helper_LimitaTexto {



	public function LimitaTexto($texto, $limita) 		{

	

	$conta	=	strlen($texto);

	

	if ($conta > $limita){

	$mostra	=	substr($texto, 0, $limita).'...';

	

	} else {

		$mostra	=	$texto;

		}

	

	

	return $mostra;

	

	

	}

}

?>