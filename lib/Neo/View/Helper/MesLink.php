<?php

class Neo_View_Helper_MesLink

{

	

		public function MesLink($dia, $mes, $ano, $conta, $link){

		// $mes 	= Mes atual, � a partir dele que a fun��o monta o Proximo link

		// $conta 	= Qual conta matematica a fun��o deve fazer. Almentar o Link ou Diminuir ?  Ex:  - ou +

		// $link	= Se for passado o Link, a fun��o manda pra la. Se n�o for passado � usado o Link atual.

				

			if($mes < '12' || $mes > 1){

				if($conta == '+'){ $mostra = $mes+1; }

				if($conta == '-'){ $mostra = $mes-1; }

		

			} 

			

			if($mes == 1){

				if($conta == '+'){ $mostra = $mes+1; 	}

				if($conta == '-'){ $mostra = 12; $ano--; }

		

			} 

			

			

			if($mes == 12) {

				if($conta == '+'){ $mostra = 1; $ano++ ;	}

				if($conta == '-'){ $mostra = $mes-1; 		}

			}

			

			return $link.'dia/'.$dia.'/mes/'.$mostra.'/ano/'.$ano;

		}

	

}