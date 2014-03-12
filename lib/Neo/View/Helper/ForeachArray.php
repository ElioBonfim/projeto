<?
class Neo_View_Helper_ForeachArray{


	function ForeachArray($res, $campo = NULL) {

	    // $campo identifica QUAL campo deve ser retornado seguido por VIRGULA.

	    if(!$campo){
    		$array_final = array();
    		foreach($res as $arr):
			    array_push($array_final, $arr);
			endforeach;
		}

		else {
    		$array_final = '';
    		foreach($res as $arr):
    		        if($array_final) $array_final .= ', ';
    		            $array_final .= $arr[$campo];
			endforeach;
		}

		return $array_final;
	}

}