<?php



class Neo_View_Helper_GeraSenha {

	

	

	public function GeraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){

		/**

		* Fun��o para gerar senhas aleat�rias

		*

		* @author    Thiago Belem <contato@thiagobelem.net>

		*

		* @param integer $tamanho Tamanho da senha a ser gerada

		* @param boolean $maiusculas Se ter� letras mai�sculas

		* @param boolean $numeros Se ter� n�meros

		* @param boolean $simbolos Se ter� s�mbolos

		*

		* @return string A senha gerada

		*/

		$lmin = 'abcdefghijklmnopqrstuvwxyz';

		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$num = '1234567890';

		$simb = '!@#$%*-';

		$retorno = '';

		$caracteres = '';

		 

		$caracteres .= $lmin;

		if ($maiusculas) $caracteres .= $lmai;

		if ($numeros) $caracteres .= $num;

		if ($simbolos) $caracteres .= $simb;

		 

		$len = strlen($caracteres);

		for ($n = 1; $n <= $tamanho; $n++) {

		$rand = mt_rand(1, $len);

		$retorno .= $caracteres[$rand-1];

		}

		

		return $retorno;

		

		}



	}