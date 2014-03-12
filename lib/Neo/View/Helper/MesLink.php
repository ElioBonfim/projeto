<?php

class Neo_View_Helper_MesLink

{

	

		public function MesLink($dia, $mes, $ano, $conta, $link){

		// $mes 	= Mes atual, é a partir dele que a função monta o Proximo link

		// $conta 	= Qual conta matematica a função deve fazer. Almentar o Link ou Diminuir ?  Ex:  - ou +

		// $link	= Se for passado o Link, a função manda pra la. Se não for passado é usado o Link atual.

				

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