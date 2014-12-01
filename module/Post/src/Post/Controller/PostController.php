<?php namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Post\Model\Post;          // <-- Add this import
use Zend\View\Model\ViewModel;
use Post\Form\PostForm;       // <-- Add this import
use Zend\Authentication\AuthenticationService;
use Zend\Captcha\AdapterInterface;
use Zend\Validator\File\Size;
use Zend\Http\PhpEnvironment\Request; // For Reanmee
use Zend\Filter\File\Rename;
use Zend\Filter\File\RenameUpload;

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
		//echo POST_IMG_DIR;
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
						
						

						$nonFile = $request->getPost()->toArray();
						$File    = $this->params()->fromFiles('images');
						$data = array_merge(
						$nonFile,
							array('fileupload'=> $_FILES['images'])
						);
						//set data post and file ...   
						$form->setData($data);

						//SAve Image Here
						$size = new Size(array('min'=>200)); //minimum bytes filesize
						$Extension = new \Zend\Validator\File\Extension('jpeg,jpg,png,gif');
						$imageSize = new \Zend\Validator\File\ImageSize(array(
							'minWidth' => 456, 'minHeight' => 248,
						));
						
						$adapter = new \Zend\File\Transfer\Adapter\Http();
					    $adapter->setValidators(array($size,$Extension,$imageSize),$File['name']);
					    //Validation for Image Size
					    if($adapter->isValid()){
						$fileInfo=$adapter->getFileInfo();
						
						//Get File Size i.e 34k
						$adapter->getFileSize();
						
						//Get Mime type of the file i.e images/jpeg
						$adapter->getMimeType(); 	
						
						//Get file Name i.e "/tmp/107_AustraliaReefwalkerHumpbackWhaleBreaching4905620_1280676783.jpg"
						$tempFileName=$adapter->getFileName();
						
						//Get Extention of the image
						$fileArr=explode('.',$tempFileName);
						$ext=end($fileArr);
						$trgetfileName=$this->get_rand_id(50).'.'.$ext;
						
						//Get Destination for saving files
						$adapter->setDestination(POST_IMG_DIR.'/');
						//$adapter->getDestination();
						
						$adapter->addFilter('Rename',
							array('target' => POST_IMG_DIR.'/'.$trgetfileName,
							'overwrite' => true)
						);
						$adapter->receive($File['name']);
						//$adapter->receive($trgetfileName);
						//Check is file is recived on server on Not
						if($adapter->isReceived()){
							//echo $adapter->getMessages();
						}else{
								//echo "File Not Recived";
							}
						//die;
						}else{
							$fileError=$adapter->getErrors();
								$str='';
								foreach($adapter->getErrors() as $key=>$value){
										$str.=$value;
										$str.= "<br/>";
								}
							$this->flashMessenger()->addMessage($str);
						}
						if($str=='')
						{
							$lastInsertedValue=$this->getPostTable()->savePost($post);
							if($lastInsertedValue > 0){
								$this->flashMessenger()->addMessage("Post has been created suucessfully.");
								return $this->redirect()->toRoute('post', array('controller' => 'user', 'action' => 'add'));
							}else{
								$this->flashMessenger()->addMessage("Post not created, Please try again.");
							}
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
	 

	private function get_rand_id($length)
	{
		if($length>0) 
		{ 
		$rand_id="";
		for($i=1; $i<=$length; $i++)
		{
		mt_srand((double)microtime() * 1000000);
		$num = mt_rand(1,36);
		$rand_id .= $this->assign_rand_value($num);
		}
		}
		return $rand_id;
	} 


	 
	 private function assign_rand_value($num)
{
// accepts 1 - 36
  switch($num)
  {
    case "1":
     $rand_value = "a";
    break;
    case "2":
     $rand_value = "b";
    break;
    case "3":
     $rand_value = "c";
    break;
    case "4":
     $rand_value = "d";
    break;
    case "5":
     $rand_value = "e";
    break;
    case "6":
     $rand_value = "f";
    break;
    case "7":
     $rand_value = "g";
    break;
    case "8":
     $rand_value = "h";
    break;
    case "9":
     $rand_value = "i";
    break;
    case "10":
     $rand_value = "j";
    break;
    case "11":
     $rand_value = "k";
    break;
    case "12":
     $rand_value = "l";
    break;
    case "13":
     $rand_value = "m";
    break;
    case "14":
     $rand_value = "n";
    break;
    case "15":
     $rand_value = "o";
    break;
    case "16":
     $rand_value = "p";
    break;
    case "17":
     $rand_value = "q";
    break;
    case "18":
     $rand_value = "r";
    break;
    case "19":
     $rand_value = "s";
    break;
    case "20":
     $rand_value = "t";
    break;
    case "21":
     $rand_value = "u";
    break;
    case "22":
     $rand_value = "v";
    break;
    case "23":
     $rand_value = "w";
    break;
    case "24":
     $rand_value = "x";
    break;
    case "25":
     $rand_value = "y";
    break;
    case "26":
     $rand_value = "z";
    break;
    case "27":
     $rand_value = "0";
    break;
    case "28":
     $rand_value = "1";
    break;
    case "29":
     $rand_value = "2";
    break;
    case "30":
     $rand_value = "3";
    break;
    case "31":
     $rand_value = "4";
    break;
    case "32":
     $rand_value = "5";
    break;
    case "33":
     $rand_value = "6";
    break;
    case "34":
     $rand_value = "7";
    break;
    case "35":
     $rand_value = "8";
    break;
    case "36":
     $rand_value = "9";
    break;
  }
return $rand_value;
}


 }


?>
