<? class Neo_View_Helper_Img {

 	public function Img($img, $lar_maxima = NULL, $alt_maxima = NULL, $qualidade = NULL) {
		
		
		
		$viewRenderer 	= Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer	->init();
		$_view	        = $viewRenderer->view;
		
		$pastaDestino 	= 'imgTMP/';
		$caminhoCompleto= ROOT_DIR.'/public_html';

		// Caso não encontre a imagem ORIGINAL retorna IMEDIATAMENTE false
		if(!is_file($caminhoCompleto.$_view->BaseUrl($img)))
			return false;
		
		// Armazeno todas as informações do Arquivo Original para comparações futuras
		$arquivoOriginal = $caminhoCompleto.$_view->BaseUrl($img);
		$dimensao		 = getimagesize($arquivoOriginal);
		$widthOriginal	 = $dimensao[0];
		$heightOriginal	 = $dimensao[1];
		
		// Caso a Largura passada como parametro NÃO FOR numérica ou caso ela seja MENOR ou IGUAL a Zero defino a largura Original do Arquivo
		if(!is_numeric($lar_maxima) or $lar_maxima <= 0)
			$lar_maxima 	= $widthOriginal;
		
		// Caso a Altura passada como parametro NÃO FOR numérica ou caso ela seja MENOR ou IGUAL a Zero defino a altura Original do Arquivo
		if(!is_numeric($alt_maxima) or $alt_maxima <= 0)
			$alt_maxima 	= $heightOriginal;

		// Caso não tenha sido definido uma QUALIDADE como parametro ou a QUALIDADE for MENOR ou IGUAL a Zero defino como 100%			
		if(!is_numeric($qualidade) or $qualidade <= 0)
			$qualidade		= 100;

		// Se o tamanho ORIGINAL for o mesmo tamanho fornecido como PARAMETRO e a QUALIDADE seja 100 retorno false e exibo a imagem original
		if(($widthOriginal == $lar_maxima and $heightOriginal == $alt_maxima) and $qualidade == 100)
			return $_view->BaseUrl($img);

		// TRATANDO o NOME da imagem ---------------------------------------------------------------------------------------------------
		$imagem 		= explode('/', $img); // Pego apenas o NOME da IMAGEM
		$qnt			= count($imagem)-1;	  // Conto qual a ULTIMA BARRA da imagem
		$extensao		= explode('.', $imagem[$qnt]);    		  // Explodo o PONTO da Extensão do arquivo
		$extensao		= $extensao[count($extensao)-1]; 		  // QNT de caracteres da Extensão.  Ex: .jpg (3)  .jpeg (4)
		$imagem			= substr($imagem[$qnt], 0, (strlen($imagem[$qnt])-(strlen($extensao)+1))); 	 // Retorno o NOME da imagem removendo a extensão
		$imgFinal		= 'l'.$lar_maxima.'a'.$alt_maxima.'q'.$qualidade.'_'.$imagem;	  			 // Nome TRATADO da Imagem
		// ---------------------------------------------------------------------------------------------------------------------------------

		// Se existir o Arquivo TEMPORÁRIO retorno o endereço.
		if(file_exists($pastaDestino.$imgFinal.'.'.$extensao))
			return $_view->BaseUrl($pastaDestino.$imgFinal.'.'.$extensao);

		// Adiciono a BASE URL no arquivo e removo a Barra Inicial.
		$file    = $_view->BaseUrl($img);
		$file	 = substr($file, 1, strlen($file));


		// INICIO do Processo.
		// Chamo a Classe Upload que realiza uma cópia da imagem para a memória
		// Confiro se a Imagem é Retrato ou Paisagem para redimensionar para o melhor tamanho
		// Configuro Qualidade e Salvo o arquivo tratado para a PASTA DE DESTINO  ($pastaDestino)

		// Class Upload para trabalhar com Imagens.
		$handle =  Zend_Controller_Action_HelperBroker::getStaticHelper('ClassUpload');
		$handle -> Upload($file);
					
		// Caso não seja Possível realizar a Cópia do arquivo para a memória cancelo a operação
		if (!$handle->uploaded)
			return false;
					
				$handle 	-> image_resize      = true;	 // Aceitar redimensionamento.
				$handle 	-> image_ratio       = true; 	 	// Manter a Proporção	
				$handle 	-> image_x           = $lar_maxima;	// Defino um Array no TOPO da Classe, passando X Maximo da Imagem
				$handle 	-> image_y           = $alt_maxima; // Defino um Array no TOPO da Classe, passando Y Maximo da Imagem
				
				$handle		-> file_overwrite		 = true;
				$handle 	-> jpeg_quality			 = $qualidade.'%';
				$handle 	-> file_new_name_body    = $imgFinal ;	// Renomeio a Imagem com um Nome Aleatório.
				$handle 	-> process($pastaDestino);				// Envio a Imagem, para o DESTINO marcado no Filtro do Campo.

			// Nome TRATADO da Imagem
			$imgFinal		= 'l'.$lar_maxima.'a'.$alt_maxima.'q'.$qualidade.'_'.$imagem;
			return $retorna = $_view->BaseUrl('imgTMP/'.$imgFinal.'.'.$extensao);
	}

}