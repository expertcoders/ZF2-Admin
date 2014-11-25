<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\User;          // <-- Add this import
use Admin\Form\UserForm;       // <-- Add this import
use Zend\View\Helper\UserHelper;
use Zend\Http\Request;
use Zend\Stdlib\ParametersInterface;
use Zend\Http\Response;
use Zend\Authentication\Result;
use Zend\Authentication\Adapter\DbTable  as AuthAdapter;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\StorageInterface;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class UserController extends AbstractActionController
{


    protected $userTable;
    
    protected $dbAdapter;
    
    protected $authAdapter;

    public function  __construct(){
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
        //print_r($this->authAdapter);
        //die;
	}
	
  /********************************Index Action Start Here*************************************/
	
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
    
    
    public function indexAction()
    {
         if($this->isUserInAuth()){
         $this->layout('layout/admin_default');
          if($this->flashMessenger()->hasCurrentSuccessMessages()){
            $messageClass='success';
         }elseif($this->flashMessenger()->hasCurrentErrorMessages()){
            $messageClass='error';
         }else{
            $messageClass='';
         }
         $title="User List";
         
         $view = new ViewModel();
         $identity=$this->getAuthIdentities();
          
         // Set the view file for the nevigtaion of the page
         $nevigation = new ViewModel(array('UserAuth'=>$identity));
         $view = new ViewModel(array());
         // this is not needed since it matches "module/controller/action"
         $headerView=new ViewModel(array('UserAuth'=>$identity));
         $headerView->setTemplate('admin/admin/header');

         $leftSideBar=new ViewModel(array('UserAuth'=>$identity));
         $leftSideBar->setTemplate('admin/admin/leftsidebar');

         $mainDashboard=new ViewModel(array(
            'users' => $this->getUserTable()->fetchAll(),
            'title'=>$title,
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'messageClass'=>$messageClass,  
         ));
         $mainDashboard->setTemplate('admin/user/userlist');
         // Variable=>$headerView, Filename=>header

         $view->addChild($headerView,'header')
         ->addChild($leftSideBar,'leftsidebar')
         ->addChild($mainDashboard,'maindashboard');

          return $view;
         }else{
            return $this->redirect()->toRoute('admin', array('action' => 'index'));
         }
    }
    
    
    
    
    /*Delete this user using ajax call
     * Post Data @Id
     * return true of success else send failuer
     */
    public function deleteAction(){
       if($this->isUserInAuth()){
       $request=new Request();
       $request->setMethod('POST');
       $request->getMethod();
       if ($request->getMethod()==(string) 'POST') {
          $userId=(int)$_POST['e'];
          //check If User is exixts
          if($this->getUserTable()->deleteUser($userId)){
             echo "YES";
          }else{
             echo "No";
          }
          if($userId){
             
          }
       }else{
          echo "URL Methods";
       }
      
       }else{
            echo "Please try after sometime";
        }
        die;
    }
    
    
    
    /*
     * Edit Action
     * @pass id of the user
     */
    
    public function editAction(){
        error_reporting(0);
        if($this->isUserInAuth()){
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('user', array('action' => 'add'));
        }
        
        $user = $this->getUserTable()->getUser($id);
      
        $form  = new UserForm();
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Save');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getUserTable()->saveUser($form->getData());
                // Redirect to list of albums
                //return $this->redirect()->toRoute('admin/user',array('action'=>'index'));
                return $this->redirect()->toRoute('admin/user');
            }
        }

        
         $this->layout('layout/admin_default');
         if($this->flashMessenger()->hasCurrentSuccessMessages()){
            $messageClass='success';
         }elseif($this->flashMessenger()->hasCurrentErrorMessages()){
            $messageClass='error';
         }else{
            $messageClass='';
         }
         $title="User Edit";
         
         $view = new ViewModel();
         $identity=$this->getAuthIdentities();
          
         // Set the view file for the nevigtaion of the page
         $nevigation = new ViewModel(array('UserAuth'=>$identity));
         $view = new ViewModel(array());
         // this is not needed since it matches "module/controller/action"
         $headerView=new ViewModel(array('UserAuth'=>$identity));
         $headerView->setTemplate('admin/admin/header');

         $leftSideBar=new ViewModel(array('UserAuth'=>$identity));
         $leftSideBar->setTemplate('admin/admin/leftsidebar');

         $mainDashboard=new ViewModel(array(
            'users' => $this->getUserTable()->fetchAll(),
            'title'=>$title,
            'form'=>$form,
            'id'=>$id,
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'messageClass'=>$messageClass,  
         ));
         $mainDashboard->setTemplate('admin/user/useredit');
         // Variable=>$headerView, Filename=>header

         $view->addChild($headerView,'header')
         ->addChild($leftSideBar,'leftsidebar')
         ->addChild($mainDashboard,'maindashboard');
         
          return $view;
         }else{
            return $this->redirect()->toRoute('admin', array('action' => 'index'));
         }
    }
    
    
    
    
    /********************************Admin Section Ends Here*************************************/

   
    
    public function getUserTable()
    {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('User\Model\UserTable');
        }
        return $this->userTable;
    }
    
    
    
    
    
    
    
 }

