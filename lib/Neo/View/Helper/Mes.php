<?php
class Neo_View_Helper_Mes
{
	public function Mes($mes, $tipo = NULL){
		if($mes > 12){ $mes	= 1;}
		if($mes < 1) { $mes	= 12;}
		if($mes == 1){ $mostra = 'Janeiro';   }
		if($mes == 2){ $mostra = 'Fevereiro'; }
		if($mes == 3){ $mostra = 'Março';     }
		if($mes == 4){ $mostra = 'Abril';     }
		if($mes == 5){ $mostra = 'Maio';      }
		if($mes == 6){ $mostra = 'Junho';     }
		if($mes == 7){ $mostra = 'Julho';     }
		if($mes == 8){ $mostra = 'Agosto';    }
		if($mes == 9){ $mostra = 'Setembro';  }
		if($mes == 10){ $mostra = 'Outubro';  }
		if($mes == 11){ $mostra = 'Novembro'; }
		if($mes == 12){ $mostra = 'Dezembro'; }
		
		if($tipo == 'abreviado'){
			if($mes > 12){ $mes	= 1;}
			if($mes < 1) { $mes	= 12;}
			if($mes == 1){ $mostra = 'Jan';   }
			if($mes == 2){ $mostra = 'Fev'; }
			if($mes == 3){ $mostra = 'Mar';     }
			if($mes == 4){ $mostra = 'Abr';     }
			if($mes == 5){ $mostra = 'Mai';      }
			if($mes == 6){ $mostra = 'Jun';     }
			if($mes == 7){ $mostra = 'Jul';     }
			if($mes == 8){ $mostra = 'Ago';    }
			if($mes == 9){ $mostra = 'Set';  }
			if($mes == 10){ $mostra = 'Out';  }
			if($mes == 11){ $mostra = 'Nov'; }
			if($mes == 12){ $mostra = 'Dez'; }
		}
		
		return $mostra;
	}
}
