<?
class Neo_View_Helper_DiferencaData {

	public function DiferencaData($data1, $data2="",$tipo=""){
				
		for($i=1;$i<=2;$i++){
			${"dia".$i}		 = substr(${"data".$i},8,2);
			${"mes".$i}		 = substr(${"data".$i},5,2);
			${"ano".$i}		 = substr(${"data".$i},0,4);
			${"horas".$i}    = substr(${"data".$i},11,2);
			${"minutos".$i}  = substr(${"data".$i},14,2);
			${"segundos".$i} = substr(${"data".$i},17,2);
			
		}
		
		$segundos = mktime($horas2,$minutos2,$segundos2,$mes2,$dia2,$ano2) - mktime($horas1,$minutos1,$segundos1,$mes1,$dia1,$ano1);

		$hours = floor($segundos / 3600);
		$segundos -= $hours * 3600;
		$minutes = floor($segundos / 60);
		$segundos -= $minutes * 60;
		
		if($hours < 10 && $hours > 0) $hours = '0'.$hours;
		if($minutes < 10) $minutes = '0'.$minutes;
		if($segundos < 10) $segundos = '0'.$segundos;
		
		return "$hours:$minutes:$segundos";
	}
				
}

?>