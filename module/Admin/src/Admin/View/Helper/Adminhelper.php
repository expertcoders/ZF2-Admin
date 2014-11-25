<?php namespace Admin\view\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;
class Adminhelper extends AbstractHelper
{
    /*public function __invoke($str)
    {
        $auth = new AuthenticationService();
	    if ($auth->hasIdentity()) {
			$auth = new AuthenticationService();
			return $auth->getIdentity($str);
			//print_r($authArr);
		}else{
			return false;
		}
    }
    */
    
    
    public function AuthIndentities(){
	    $auth = new AuthenticationService();
	    if ($auth->hasIdentity()) {
			$auth = new AuthenticationService();
			return $auth->getIdentity();
			//print_r($authArr);
		}else{
			return false;
		}
    
	}
	
	
	public function getUserAuthImage(){
		$auth = new AuthenticationService();
	    if ($auth->hasIdentity()) {
			$auth = new AuthenticationService();
			return $auth->getIdentity();
			//print_r($authArr);
		}else{
			return false;
		}
		
	}
	
}
?>
