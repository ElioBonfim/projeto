<?

class Neo_View_Helper_Login

{

	protected $view;

	

	function setView($view){  $this->view	= $view; }

	

	function login(){

		

		$auth	= Zend_Auth::getInstance();

		

		if($auth->hasIdentity()){

			

			$logoutUrl	= $this->view->url(array('controller' => 'auth', 'action' => 'logout'));

			$user		= $auth->getIdentity();

			$string		= $user->login;

					

			} else {

				

				$string		= 'Não LOgado';		

						

				}

				

		return $string;

	}

}



?>