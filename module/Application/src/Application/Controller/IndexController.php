<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Post\Model\Post;
use Post\Model\PostTable;

class IndexController extends AbstractActionController
{
	private $PostTable;
	 
	 
	public function getPostTable(){
        if(!$this->PostTable){
            return $this->PostTable = $this->getServiceLocator()
                ->get('Application\Model\PostTable');
        }
    }
    
    
    
    public function indexAction()
    {
        
        $view= new ViewModel();
        
        $header=new ViewModel();
        $header=$header->setTemplate('application/partials/header.phtml');
        
        
         //Get All the Post
		 $paginator = $this->getPostTable()->fetchall(true);
         // set the current page to what has been passed in query string, or to 1 if none set
         $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
         // set the number of items per page to 10
         $paginator->setItemCountPerPage(5);
         
         $latestPaginator=$this->PostTable->getLatestPost();
         //Latest Post Goes Here
         $latestPost=new ViewModel(array('latestPaginator'=>$latestPaginator));
         $latestPost=$latestPost->setTemplate('application/partials/latest_post.phtml');
        
         //Latest Post Goes Here
         $MorePost=new ViewModel(array('paginator'=>$paginator));
         $MorePost=$MorePost->setTemplate('application/partials/morepost.phtml');
        
         $view->addChild($header, 'header')
			 ->addChild($latestPost, 'latestPost')
			 ->addChild($MorePost, 'morepost')
			;
        return $view;
    }
    
    
    
}
