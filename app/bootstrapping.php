<? class Bootstrap {
	public function __construct($local)
	{
		$rootDir = dirname(dirname(__FILE__));
		define('ROOT_DIR', $rootDir);
		set_include_path(self::IncludePath()); // Função que le as pastas e cria o Include Path das pastas (models)
		// Incluindo a biblioteca Principal e definindo o Zend Auto Load
		require_once 'Zend/Loader/Autoloader.php';
		$loader =  Zend_Loader_Autoloader::getInstance();
		$loader	-> setFallbackAutoloader(true);
		Zend_Session::start();
		// Carregando o Arquivo de Configurações.
		$db	  = new Zend_Config_Ini(ROOT_DIR.'/app/config.ini', $local);
		$conf = new Zend_Config_Ini(ROOT_DIR.'/app/config.ini', 'config');
		
		date_default_timezone_set($conf->date_default_timezone);

		Zend_Registry::set('config', $conf);
		$this->Bd($db);
		$this->_initTranslate();
	}
	protected function _initTranslate()
	{
				$translator = new Zend_Translate ( array (
				'adapter'	=> 'array',
				'content'	=> ROOT_DIR.'/lib/Neo/languages/pt_BR/',
				'locale' 	=> 'pt_BR',
				'scan' 		=> Zend_Translate::LOCALE_DIRECTORY
		) );
			Zend_Validate_Abstract::setDefaultTranslator ( $translator );
	}
	// Configurando a conecção com o Banco de dados. 1 ou mais Bancos.
	public function Bd($conf)
	{
			$db	= Zend_Db::factory($conf->db->adapter, $conf->db);
			Zend_Db_Table_Abstract::setDefaultAdapter($db);
			Zend_Registry::set('db', $db);
	}
	// Função de configuração do FrontController
	public function configFC()
	{
		$fc	=  Zend_Controller_Front::getInstance();
		$fc -> setControllerDirectory($this->MontaModulos());
		$fc -> throwExceptions(false);
	}
	// Inicializa o o FrontController e roda o Zend.
	public function runApp()
	{
		$aclHelper 	= new Neo_Controller_Action_Helper_Acl();
		Zend_Controller_Action_HelperBroker::addHelper($aclHelper);
		Zend_Controller_Action_HelperBroker::addPath(ROOT_DIR.'/lib/Neo/Controller/Action/Helper/');
		$this	-> configFC();
		$fc 	=  Zend_Controller_Front::getInstance();
	    #$fc		-> registerPlugin(new Neo_Controller_Plugin_ViewSetup());
		$fc		-> registerPlugin(new Neo_Controller_Plugin_LayoutSetup());
		#$fc		-> registerPlugin(new Neo_Controller_Plugin_ActionSetup(), 98);
		$fc		-> dispatch();
	}
	public function MontaModulos()
	{
			$diretorio = '../app/'; 			// pega o endereço do diretório
			$ponteiro  = opendir($diretorio);   // abre o diretório
			// Percorre a lista de arquivos e monta um array com os diretórios
			while ($nome_itens = readdir($ponteiro)) {
				if ($nome_itens!="." && $nome_itens!=".."){
					if (is_dir($diretorio.$nome_itens) and $nome_itens != '_notes'){
						$itens[$nome_itens] = ROOT_DIR.'/app/'.$nome_itens.'/controllers';
					}
				}
			}
		return $itens;
	}
	public function IncludePath(){
		$diretorio = '../app/'; 			// pega o endereço do diretório
		$ponteiro  = opendir($diretorio);   // abre o diretório
		$itens = PATH_SEPARATOR.ROOT_DIR.'/lib/';
		// Percorre a lista de arquivos e monta um array com os diretórios
		while ($nome_itens = readdir($ponteiro)) {
			if ($nome_itens!="." && $nome_itens!=".." && $nome_itens!="_notes"){
				if (is_dir($diretorio.$nome_itens)){
					$itens  = $itens.PATH_SEPARATOR.ROOT_DIR.'/app/'.$nome_itens.'/models';
					$itens  = $itens.PATH_SEPARATOR.ROOT_DIR.'/app/'.$nome_itens.'/forms';
				}
			}
		}
		$itens = $itens.PATH_SEPARATOR.get_include_path();
		return $itens;
	}
}