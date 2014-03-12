<?
class Neo_View_Helper_RegExp {

	public function RegExp($str){
		if($str){
			//Transformando tudo em minúsculas
			$str = trim(strtolower($str));
		
			//Tirando espaços extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
			while ( strpos($str,"  ") )
				$str = str_replace("  "," ",$str);
			
			//Agora, vamos trocar os caracteres perigosos "ã,á..." por coisas limpas "a"
			$caracteresPerigosos = array ("Ã","ã","Õ","õ","á","Á","é","É","í","Í","ó","Ó","ú","Ú","ç","Ç","à","À","è","È","ì","Ì","ò","Ò","ù","Ù","ä","Ä","ë","Ë","ï","Ï","ö","Ö","ü","Ü","Â","Ê","Î","Ô","Û","â","ê","î","ô","û","!","?",",",'"','"',"-","\"","\\","/");
			$caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
			$str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
			
			//Agora que não temos mais nenhum acento em nossa string, e estamos com ela toda em "lower",
			//vamos montar a expressão regular para o MySQL
			$caractresSimples = array("a","e","i","o","u","c");
			$caractresEnvelopados = array("[a]","[e]","[i]","[o]","[u]","[c]");
			$str = str_replace($caractresSimples,$caractresEnvelopados,$str);
			
			$caracteresParaRegExp = array(
				"(a|ã|á|à|ä|â|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|Ã|Á|À|Ä|Â|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
				"(e|é|è|ë|ê|&eacute;|&egrave;|&euml;|&ecirc;|É|È|Ë|Ê|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
				"(i|í|ì|ï|î|&iacute;|&igrave;|&iuml;|&icirc;|Í|Ì|Ï|Î|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
				"(o|õ|ó|ò|ö|ô|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|Õ|Ó|Ò|Ö|Ô|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
				"(u|ú|ù|ü|û|&uacute;|&ugrave;|&uuml;|&ucirc;|Ú|Ù|Ü|Û|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
				"(c|ç|Ç|&ccedil;|&Ccedil;)" );
			$str = str_replace($caractresEnvelopados,$caracteresParaRegExp,$str);
			
			//Trocando espaços por .*
			$str = str_replace(" ",".*",$str);
			
			
			
			//Retornando a String finalizada!
			return $str; 
		}else {
			return " ";
		}
	}
}
