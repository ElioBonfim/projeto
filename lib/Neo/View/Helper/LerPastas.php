<?

class Neo_View_Helper_LerPastas

{

	

	public function LerPastas($pasta, $lista=array()){

				$ponteiro  = opendir($pasta);

				while ($arquivo = readdir($ponteiro)) {

					if($arquivo!="." && $arquivo!="..")

					if(is_dir($pasta.$arquivo)){ 

						if($arquivo != '_notes'){

							$lista[$arquivo] = Pasta($pasta.$arquivo.'/'); }

						}

					else { $lista[$arquivo] = $arquivo;}

				}

				

				return $lista;

			}

	





}

?>