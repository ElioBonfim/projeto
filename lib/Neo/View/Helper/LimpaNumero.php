<?



class Neo_View_Helper_LimpaNumero



{



	



	public function LimpaNumero($NUM){



		// exemplo limpanumero(1.200,00);



		// Retiro o ponto  



		$LIMP	= explode('.', $NUM);



		$count	= count($LIMP);



		$TEXT	= '';



		



		for($i = 0; $i < $count; $i++){



			  if($TEXT == ""){



					$TEXT = $LIMP[$i];



			  }else{



					$TEXT = $TEXT.$LIMP[$i];



			  }



		}



		



		



		//  Retiro a virgula e substituo as variáveis 



		$NUM  	= $TEXT;



		$LIMP 	= explode(',', $NUM);



		$count 	= count($LIMP);



		$TEXT 	= '';



			



			for($i = 0; $i < $count; $i++){ // faço o for para juntar a array 



			  if($TEXT == ""){



				  $TEXT = $LIMP[$i];



			  }else{



				  $TEXT = $TEXT.'.'.$LIMP[$i];



			  }



			}



			



		return $TEXT;



		 }



}



?>