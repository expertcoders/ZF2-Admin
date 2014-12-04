<?php namespace Application\Controller;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class JavascriptController extends AbstractActionController {

	public function indexAction(){
	    $this->_getHelper('HeadScript', $this->getServiceLocator())
	    ->appendFile('/js/modules/javascript/ajax.js');
	}
	
	public function processAjaxRequestAction(){
	    
	    $result = array('status' => 'error', 'message' => 'There was some error. Try again.');
	    
	    $request = $this->getRequest();
	    
	    if($request->isXmlHttpRequest()){
	    	
	        $data = $request->getPost();
	        
	        if(isset($data['tempData']) && !empty($data['tempData'])){
	        	$result['status'] = 'success';
	        	$result['message'] = 'We got the posted data successfully.';
	        }
	    }
	    
	    return new JsonModel($result);
	}
	
	public function getHtmlResponseAction(){
	    $request = $this->getRequest();
	    $view = new ViewModel();
	    if($request->isXmlHttpRequest()){
	    
	        $data = $request->getPost();
	        
	        if(isset($data['tempData']) && !empty($data['tempData'])){
	            $view->setVariable('tempData', $data['tempData']);
	        }
	    }	    
	    
	    $view->setTerminal(true);
	    return $view;
	}
	
}
