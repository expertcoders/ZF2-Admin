<?php
/**
 * ZF2 Admin Application
 * File Name:: Admin Controller
 * Created By: Pradeep Kumar
 * Last Modified :: 20 Nov 2014
 **/
namespace Admin\Controller;
use Zend\I18n;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\Admin;          // <-- Add this import
use Admin\Form\AdminForm;       // <-- Add this import
use Zend\Http\Request;
use Zend\Stdlib\ParametersInterface;
use Zend\Http\Response;
use Zend\Authentication\Result;
use Zend\Authentication\Adapter\DbTable  as AuthAdapter;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class AdminController extends AbstractActionController
{


    protected $adminTable;
    
    protected $dbAdapter;
    
    protected $authAdapter;
    /**
    * Set All the default layout
    * this layout will be called from
    * module/Application/view/layout/admin_default.phtml
    * this is because, we can call this layout in other controller also. 
    **/
    public $layout;

    public function  __construct(){
	   // Default layout for all the action of this controller.
	   $this->layout='layout/admin_default'; 
       $diverArray=array(
                  'driver' => 'Mysqli',
                  'database' => 'zend',
                  'username' => 'root',
                  'password' => 'sparx'
      );
       $dbAdapter=new DbAdapter($diverArray);
       $this->dbAdapter=$dbAdapter;
       $authAdapter = new AuthAdapter($this->dbAdapter,'users','username','password');
       $authAdapter
            ->setTableName('user')
            ->setIdentityColumn('username')
            ->setCredentialColumn('password')
            ;
        $this->authAdapter=$authAdapter;		
	}
	
	
	public function loginsubmitAction(){
       $request = $this->getRequest();
        if ($request->isPost()) {
           // instantiate the authentication service
           // Set up the authentication adapter
           //print_r($request->getPost());
           //die;
           $username=$request->getPost('username');
           $password=md5($request->getPost('password'));
           if($username!='' && $password!=''){
           $result=$this->authAdapter
                   ->setIdentity($username)
                   ->setCredential($password);       
           // Print the result row
           $columnsToReturn = array('id', 'username', 'first_name','last_name');
           
           
           /* Authentication for the user here, $this->authAdapter->authenticate
            * will authenticatae the user is valid or not.
            */
           $res=$this->authAdapter->authenticate($username,$password);
           if($res->isValid()){
					$msg="Successful Login.";
					
					//Set Auth Values into the storage
					$auth = new AuthenticationService();
					$storage = $auth->getStorage();
					$storage->write($this->authAdapter->getResultRowObject(null,'password'));

					$this->flashMessenger()->addSuccessMessage()->addMessage($msg);
                    return $this->redirect()->toRoute('admin', array(
						'controller'=>'admin',
						'action'=>'dashboard'
					));
           }else{
                  $msg="Invalid Credentials";
                  $this->flashMessenger()->addErrorMessage()->addMessage($msg);
                  return $this->redirect()->toRoute('admin', array(
                    'controller'=>'admin',
                    'action'=>'login'
                ));
           }
        }else{
           
                  $msg="Invalid Input, Please try again";
                  $this->flashMessenger()->addErrorMessage()->addMessage($msg);
                  return $this->redirect()->toRoute('admin', array(
                    'controller'=>'admin',
                    'action'=>'login'
                ));
        }
        
        }
        die;
    }
    
    
    
    
  	/**
    * 	Admin LogOut Action
    */
	public function logoutAction()
		{
			$auth = new AuthenticationService();
			// or prepare in the globa.config.php and get it from there
			// $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
			if ($auth->hasIdentity()) {
				$identity = $auth->getIdentity();
			}
			$auth->clearIdentity();
			//	$auth->getStorage()->session->getManager()->forgetMe(); // no way to get the sessionmanager from storage
			$sessionManager = new \Zend\Session\SessionManager();
			$sessionManager->forgetMe();
			$this->flashMessenger()->addSuccessMessage()->addMessage("You have successfully logout.");
			return $this->redirect()->toRoute('admin', array('controller' => 'admin', 'action' => 'login'));
		} 



	
	/**
    * 	Admin Login Action
    */
    public function loginAction()
    {
       $this->layout('layout/admin_login');
       if($this->isUserInAuth()){
			return $this->redirect()->toRoute('admin', array('action' => 'dashboard'));
	   }
       //Add Admin Form
       $title="Administrator Login";
       $heading="Member Login";
       if($this->flashMessenger()->hasCurrentSuccessMessages()){
            $messageClass='success';
         }elseif($this->flashMessenger()->hasCurrentErrorMessages()){
            $messageClass='error';
         }else{
            $messageClass='error';
        }

       $form=new AdminForm();
       return $view = new ViewModel(array(
		'title'=>$title,
		'heading'=>$heading,
		'form'=>$form,
		'flashMessages' => $this->flashMessenger()->getMessages(),
		'messageClass'=>$messageClass,
       ));
    }
    
     /*
	 * Check Auth for the User if Its needs 
	 */
	 private function isUserInAuth(){
		$auth = new AuthenticationService();
	    if ($auth->hasIdentity()) {
			return true;
		}else{
			return false;
		}
	 }
	 
	 
	 /*
	 * Check Auth for the User if Its needs 
	 * @return Object Identities OF Auth
	 */
	 private function getAuthIdentities(){
		 $auth = new AuthenticationService();
		 return $auth->getIdentity();;
	 }
    
    
    
    
    /**
    * Admin Dashboard Action
    */
    public function dashboardAction(){
			if($this->isUserInAuth()){
				$this->layout('layout/admin_default');
				//Check Authentication for the admin
				$view = new ViewModel();
				$identity=$this->getAuthIdentities();
				// Set the view file for the nevigtaion of the page
				$nevigation = new ViewModel(array('UserAuth'=>$identity));
			
			
				
				$view = new ViewModel();
				// this is not needed since it matches "module/controller/action"
				$headerView=new ViewModel(array('UserAuth'=>$identity));
				$headerView->setTemplate('admin/admin/header');
				
				$leftSideBar=new ViewModel(array('UserAuth'=>$identity));
				$leftSideBar->setTemplate('admin/admin/leftsidebar');
				
				$mainDashboard=new ViewModel();
				$mainDashboard->setTemplate('admin/admin/maindashboard');
				
				// Variable=>$headerView, Filename=>header
				
				$view->addChild($headerView,'header')
				 ->addChild($leftSideBar,'leftsidebar')
				 ->addChild($mainDashboard,'maindashboard');
				return $view;
			}else{
				return $this->redirect()->toRoute('admin', array('action' => 'index'));
			}
       }
    
   
    
    public function getAdminTable()
    {
        if (!$this->adminTable) {
            $sm = $this->getServiceLocator();
            $this->adminTable = $sm->get('Admin\Model\AdminTable');
        }
        return $this->adminTable;
    }
    
    	
    /**
     * Default Action of Admin Controller
     **/
    public function indexAction()
    {
        return $this->redirect()->toRoute('admin', array('action' => 'login'));
    }
    
    
        
 }

