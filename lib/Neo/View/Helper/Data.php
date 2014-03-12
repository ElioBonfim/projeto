<?

class Neo_View_Helper_Data

{

	

	

	

	public function Data($data1, $oque){

		

		if(isset($data1)) { $data1 = explode('-',$data1); }

		if(!isset($data1)){ $dia = date('d'); } else { $dia = $data1[1]; }

		if(!isset($data1)){ $mes = date('m'); } else { $mes = $data1[2]; }

		if(!isset($data1)){ $ano = date('Y'); } else { $ano = $data1[0]; }

				 

		$semana = array(0 => 'Domingo', 1 => 'Segunda', 2 => 'Terça', 3 => 'Quarta', 4 => 'Quinta', 5 => 'Sexta', 6 => 'Sábado');

		

		if($oque == 'DiaSemanaNumero'){

			return $DiaSemana 	= date("w", mktime(0,0,0,$mes,$dia,$ano) );

		}



		if($oque == 'DiaSemana'){

			return $DiaSemana 	= $semana[date("w", mktime(0,0,0,$mes,$dia,$ano))];

		}

		

		

	}

	





}

?>