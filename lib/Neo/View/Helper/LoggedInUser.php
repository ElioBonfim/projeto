<?

class Neo_View_Helper_LoggedInUser

{

	protected $view;

	

	function setView($view){

		$this->view	= $view;

		}

		

	function loggedInUser(){

		

		$auth	= Zend_Auth::getInstance();

		if($auth->hasIdentity()){

			

			$logoutUrl	= $this->view->url(array('controller' => 'auth', 'action' => 'logout'));

			$user		= $auth->getIdentity();

			$string		= 'Logado como -> '.$user->login;

					

			} else {

				

				$string		= 'Não LOgado';				

				}

		return $string;

	}

}



?>