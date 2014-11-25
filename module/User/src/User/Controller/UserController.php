<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Model\User;          // <-- Add this import
use User\Form\UserForm;       // <-- Add this import
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
	
	
	public function loginsubmitAction(){
       $request = $this->getRequest();
        if ($request->isPost()) {
           // instantiate the authentication service
           // Set up the authentication adapter
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
                    return $this->redirect()->toRoute('user', array(
						'controller'=>'user',
						'action'=>'dashboard'
					));
           }else{
                  $msg="Invalid Credentials";
                  $this->flashMessenger()->addErrorMessage()->addMessage($msg);
                  return $this->redirect()->toRoute('user', array(
                    'controller'=>'user',
                    'action'=>'login'
                ));
           }
        }else{
           
                  $msg="Invalid Credentials2";
                  $this->flashMessenger()->addErrorMessage()->addMessage($msg);
                  return $this->redirect()->toRoute('user', array(
                    'controller'=>'user',
                    'action'=>'login'
                ));
        }
        
        }
        die;
    }
    
    
    
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
			return $this->redirect()->toRoute('user', array('controller' => 'user', 'action' => 'login'));
		} 



    public function loginAction()
    {
       
        $form = new UserForm();
        $form->get('submit')->setValue('Login');
        $this->layout('layout/login');
        if($this->flashMessenger()->hasCurrentSuccessMessages()){
            $messageClass='success';
         }elseif($this->flashMessenger()->hasCurrentErrorMessages()){
            $messageClass='error';
         }else{
            $messageClass='';
         }
        // print_r($this->flashMessenger()->getMessages());
         return $view = new ViewModel(array(
            'form' => $form,
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'messageClass'=>$messageClass));
         }      
    
    public function dashboardAction(){
       $this->layout('layout/dashboard');
       $auth = new AuthenticationService();
       if ($auth->hasIdentity()) {
		// Identity exists; get it
		$identity = $auth->getIdentity();
		}else{
			$identity=object(array());
		}
        $view = new ViewModel();

		// Set the view file for the nevigtaion of the page
	    $nevigation = new ViewModel(array('UserAuth'=>$identity));
        $nevigation->setTemplate('user/user/nevigation');
        
        // Set the view file for the main dashboard remainging page
        $main_content = new ViewModel();
        $main_content->setTemplate('user/user/main_dashboard');

		//Render All the view files on the page, by setting all the variable
        $view->addChild($nevigation,'nevigation')
        ->addChild($main_content,'main_content');
        return $view;
        
       }
    
   
    
    public function getUserTable()
    {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('User\Model\UserTable');
        }
        return $this->userTable;
    }
    
    
    
    
    
    
    
    
    
    
    /*
     * User Profile
     */
     public function profileAction(){
		$this->layout('layout/dashboard');
		$form = new UserForm();
		$auth = new AuthenticationService();
	    if ($auth->hasIdentity()) {
		// Identity exists; get it
		$identity = $auth->getIdentity();
		
		// Update Profile Data here
		$request = $this->getRequest();
		if($request->isPost()){
			$user->id=$request->getPost('id');
			$user->first_name=$request->getPost('first_name');
			$user->last_name=$request->getPost('last_name');
			$user->email_address=$request->getPost('email_address');
			
			//String Validator
			$error="Error :";
			$validator = new \Zend\Validator\StringLength(3);
			$validator->setMessage('The string \'%value%\' is too short; it must be at least %min% ' .'characters',\Zend\Validator\StringLength::TOO_SHORT);
			if (!$validator->isValid($user->first_name)) {
				foreach ($validator->getMessages() as $messageId => $message) {
					$error.=$message;
					$error.="<br>";
 			     }
			}
			//Email Validator
			$validator = new \Zend\Validator\EmailAddress();
			if (!$validator->isValid($user->email_address)) {
				foreach ($validator->getMessages() as $messageId => $message) {
					$error.=$message;
					$error.="<\br>";
				}

			}
			if($error!='Error :'){
				$this->flashMessenger()->addMessage($error);
			}else{
				// email appears to be valid
				$this->getUserTable()->userUpdate($user);
				$msg="Profile Update Successfully.";
				$this->flashMessenger()->addMessage($msg);
			}
			
			

		}
		
		//Set Updated Data Of the user profile
   	    $user = $this->getUserTable()->getUser($identity->id);
   	    $form->bind($user);

		}else{
			return $this->redirect()->toRoute('user', array('action' => 'login'));	
		}
		
		 if($this->flashMessenger()->hasCurrentSuccessMessages()){
            $messageClass='success';
         }elseif($this->flashMessenger()->hasCurrentErrorMessages()){
            $messageClass='error';
         }else{
            $messageClass='success';
         }
        
         
		$view = new ViewModel(array(
		'form' => $form,
		'messageClass'=>$messageClass,
		'flashMessages' => $this->flashMessenger()->getMessages())
		);

		 // Set the view file for the nevigtaion of the page
	    $nevigation = new ViewModel(array('UserAuth'=>$identity));
        $nevigation->setTemplate('user/user/nevigation');
        
		//Render All the view files on the page, by setting all the variable
        $view->addChild($nevigation,'nevigation');
        return $view;
	
	
	
		
 	 }
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
    

	 public function changepasswordAction(){
		$this->layout('layout/dashboard');
		$form = new UserForm();
        $form->get('submit')->setValue('Update');
        $auth = new AuthenticationService();
	    if ($auth->hasIdentity()) {
		// Identity exists; get it
		$identity = $auth->getIdentity();
		}else{
			$identity=object(array());
		}
        
        
         if($this->flashMessenger()->hasCurrentSuccessMessages()){
            $messageClass='success';
         }elseif($this->flashMessenger()->hasCurrentErrorMessages()){
            $messageClass='error';
         }else{
            $messageClass='error';
         }
        
         
		$view = new ViewModel(array('form' => $form,'messageClass'=>$messageClass,'flashMessages' => $this->flashMessenger()->getMessages()));

		 // Set the view file for the nevigtaion of the page
	    $nevigation = new ViewModel(array('UserAuth'=>$identity));
        $nevigation->setTemplate('user/user/nevigation');
        
		//Render All the view files on the page, by setting all the variable
        $view->addChild($nevigation,'nevigation');
        return $view;
	
	 
	 }
	/**
	 * Change Password of the user
	 */
	 public function changepasswordupdateAction(){
		$request = $this->getRequest();
        $auth = new AuthenticationService();
	    if ($request->isPost()) {
           $psotData=$request->getPost();
           $oldPassword=$request->getPost('old_password');
           $new_passowrd=$request->getPost('new_passowrd');
           $confirm_new_password=$request->getPost('confirm_new_password');
           if($oldPassword!='' && $new_passowrd!='' && $confirm_new_password!=''){
			     if($new_passowrd==$confirm_new_password){
				     $identity = $auth->getIdentity();
                     $user_id=$identity->id;
					 $user = new User();
					 $results=$this->getUserTable()->getUser($user_id);
					 if($results->password==md5($oldPassword)){
							$user->id=$identity->id;
							$user->password=md5($confirm_new_password);
							$this->getUserTable()->userUpdate($user);
							$msg='Password Update Successfully.';
							$this->flashMessenger()->clearCurrentMessages(); 
							$this->flashMessenger()->addMessage($msg);
							return $this->redirect()->toRoute('user', array('action' => 'changepassword'));
					 }else{
							$msg="Old Password didn't match, please try again";
							$this->flashMessenger()->clearCurrentMessages(); 
							$this->flashMessenger()->addMessage($msg);
							return $this->redirect()->toRoute('user', array('action' => 'changepassword'));
						 }
		       }else{
 					 $msg="New Password do not match.";
 					 $this->flashMessenger()->clearCurrentMessages(); 
  				     $this->flashMessenger()->addMessage($msg);
  				     return $this->redirect()->toRoute('user', array('action' => 'changepassword'));
               }
              
           }else{
					$msg="All Inputs are required.";
					$this->flashMessenger()->clearCurrentMessages(); 
					$this->flashMessenger()->addMessage('All Inputs are required.');
					return $this->redirect()->toRoute('user', array('action' => 'changepassword'));
           }
         }
        
        
        
	
	 }
   
   
    public function indexAction()
    {
         if($this->flashMessenger()->hasCurrentSuccessMessages()){
            $messageClass='success';
         }elseif($this->flashMessenger()->hasCurrentErrorMessages()){
            $messageClass='error';
         }else{
            $messageClass='';
         }
          return new ViewModel(array(
            'users' => $this->getUserTable()->fetchAll(),
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'messageClass'=>$messageClass,  
        ));


    }
    
    
    public function addAction()
    {
        return $this->redirect()->toRoute('user', array(
                    'controller'=>'user',
                    'action'=>'registration'
                ));


    }
    
    public function editAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('user', array('action' => 'add'));
        }
        
        $user = $this->getUserTable()->getUser($id);

        $form  = new UserForm();
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getUserTable()->saveUser($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('user');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
        
        
       echo $id;
       die;
    }

    public function editsatusAction(){
       $id =  $this->params()->fromRoute('id', 0);
       $strArr=explode('-',$id);
       $id=(int) $strArr[0];
       $status= (int) $strArr[1];
       if ($id!='') {
          $user = new User();
          $user->id=$id;
          $user->status=$status;
          $this->getUserTable()->saveUser($user,'Update');
          $this->flashMessenger()->addSuccessMessage()->addMessage('User successfully updated');
          return $this->redirect()->toRoute('user', array('action' => 'index'));
       }else{
          $this->flashMessenger()->addErrorMessage->addMessage('User Not Updated successfully, Please Try After Sometime.');
          return $this->redirect()->toRoute('user', array('action' => 'index'));
       }
    }

   
    
    /*
     * Forgot Password of the User
     */
    public function forgotpassowrdAction(){
       $form = new UserForm();
       $this->layout('layout/login');
       return $view = new ViewModel(array('form' => $form));
    }
    
    
    //Registration Action
    public function registrationAction()
    {
        $form = new UserForm();
        $form->get('submit')->setValue('Save User');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new User();
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user->exchangeArray($form->getData());
                $this->getUserTable()->saveUser($user);

                // Redirect to list of albums
                //return $this->redirect()->toRoute('album');
                $this->flashMessenger()->addSuccessMessage()->addMessage('User added successfully');
                return $this->redirect()->toRoute('user', array(
                    'controller'=>'user',
                    'action'=>'index'
                ));
            }
        }
        return array('form' => $form);
    }

    
    
    /*Delete this user using ajax call
     * Post Data @Id
     * return true of success else send failuer
     */
    public function deleteAction(){
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
       die;
    }
    
    
    
    
    
 }

