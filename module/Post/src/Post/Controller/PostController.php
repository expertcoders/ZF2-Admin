<?php namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Post\Model\Post;          // <-- Add this import
use Zend\View\Model\ViewModel;
use Post\Form\PostForm;       // <-- Add this import
use Zend\Authentication\AuthenticationService;
use Zend\Captcha\AdapterInterface;

 class PostController extends AbstractActionController
 {
     
     protected $postTable;
     
     protected $dbAdapter;


    
     
     public function indexAction()
     {
	    if ($this->isUserInAuth()){
			// Identity exists; get it
			$identity = $this->getAuthIdentities()->getIdentity();
			$this->layout('layout/dashboard'); 
			$view = new ViewModel();
            
            //Data with pagination
            $paginator = $this->getPostTable()->fetchAll(true);
            // set the current page to what has been passed in query string, or to 1 if none set
            $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
            // set the number of items per page to 10
            $paginator->setItemCountPerPage(10);
     
     
        	$view = new ViewModel(array(
				'posts' => $this->getPostTable()->fetchAll(true),
                'paginator'=>$paginator,
                'flashMessages' => $this->getMessage('Message'),
				'messageClass'=>$this->getMessage('Class')
			));
 		    // Set the view file for the nevigtaion of the page
			$nevigation = new ViewModel(array('UserAuth'=>$identity));
			$nevigation->setTemplate('user/user/nevigation');
        
        	//Render All the view files on the page, by setting all the variable
			$view->addChild($nevigation,'nevigation');
			return $view;
		}else{
			return $this->redirectToAuth();
		}
     }
     
     
     public function editAction(){
    	if ($this->isUserInAuth()){
               
                $request = $this->getRequest();
				if ($request->isPost()) {
				   $savePost['id']=$request->getPost('id');
				   $savePost['title']=$request->getPost('title');
				   $savePost['post']=$request->getPost('post');				   
                   $savePost['status']=$request->getPost('status');				   
                   $this->getPostTable()->savePost($savePost);
                   $this->flashMessenger()->addSuccessMessage()->addMessage("Post has been updated successfully.");		
                   return $this->redirect()->toRoute('post', array('controller' => 'post', 'action' => 'index'));
                }
                $id = (int) $this->params()->fromRoute('id', 0);
                $post = $this->getPostTable()->getPost($id);
                $this->layout('layout/dashboard'); 
				$form = new PostForm();
                $form->bind($post);
                $form->get('submit')->setValue('Save');
               



			    $view = new ViewModel(array(
					'form'=>$form,
					'flashMessages' => $this->flashMessenger()->getMessages(),
					'messageClass'=>$messageClass
				));
				// Set the view file for the nevigtaion of the page
				$identity = $this->getAuthIdentities()->getIdentity();
				$nevigation = new ViewModel(array('UserAuth'=>$identity));
				$nevigation->setTemplate('user/user/nevigation');
        		$view->addChild($nevigation,'nevigation');
				return $view;
        }
	    
        		
		
                
                
     }
     
     
     public function getMessage($type){
          if($this->flashMessenger()->hasCurrentSuccessMessages()){
                $messageClass='success';
		  }elseif($this->flashMessenger()->hasCurrentErrorMessages()){
                  $messageClass='error';
		   }else{
                  $messageClass='success';
		   }
            if($type=='Message'){
               return $this->flashMessenger()->getMessages();
            }
            if($type=='Class'){
               return $messageClass;
            }
     }
     
     
     

     public function addAction()
     {
		if ($this->isUserInAuth()){
				$this->layout('layout/dashboard'); 
				$form = new PostForm();
			    $form->get('submit')->setValue('Save');
			    $request = $this->getRequest();
				if ($request->isPost()) {
                  	//$form->setInputFilter($user->getInputFilter());
  				    	$post['title']=$request->getPost('title');
						$post['post']=$request->getPost('post');
                        $post['status']=$request->getPost('status');
						$post['user_id']=$this->getAuthIdentities()->getIdentity()->id;
						$lastInsertedValue=$this->getPostTable()->savePost($post);
						if($lastInsertedValue > 0){
							$this->flashMessenger()->addMessage("Post has been created suucessfully.");
							return $this->redirect()->toRoute('post', array('controller' => 'user', 'action' => 'add'));
						}else{
							$this->flashMessenger()->addMessage("Post not created, Please try again.");
						}
					}
               $view = new ViewModel(array(
					'form'=>$form,
					'flashMessages' => $this->getMessage('Message'),
					'messageClass'=>$this->getMessage('Class'),
				));
				// Set the view file for the nevigtaion of the page
				$identity = $this->getAuthIdentities()->getIdentity();
				$nevigation = new ViewModel(array('UserAuth'=>$identity));
				$nevigation->setTemplate('user/user/nevigation');
        		$view->addChild($nevigation,'nevigation');
				return $view;
				
		}else{
			
			$this->redirectToAuth();
		}
		 
     }

     

     public function deleteAction()
     {
        if($this->isUserInAuth()){
         if($this->getRequest()->isXmlHttpRequest()) {
           $postId=$this->getRequest()->getPost('id');
           //Cross Check here post is from valid user
           // User can only delete this post if user_id will be same as logged User
           $this->getPostTable()->deletePost($postId);
           echo 1;
          }else{
           echo "Please try after Sometime.";
         }
        
        }
        exit;        
     }
     
     
     public function getPostTable()
     {
         if (!$this->postTable) {
             $sm = $this->getServiceLocator();
             $this->postTable = $sm->get('Post\Model\PostTable');
         }
         return $this->postTable;
     }


	private function redirectToAuth(){
		
		return $this->redirect()->toRoute('user', array('controller'=>'user','action'=>'login'));
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
	 
	 
	 private function getAuthIdentities(){
		 $auth = new AuthenticationService();
		 return $auth;
	 }


 }


?>
