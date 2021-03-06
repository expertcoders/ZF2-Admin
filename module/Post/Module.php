<?php
namespace Post;
use Post\Model\Post;
use Post\Model\PostTable;
use Post\Model\Postcomment;
use Post\Model\CommentTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

 class Module
 {
     
     
     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
     
     
     
	
	public function getAutoloaderConfig()
     {
         return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
            'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }
     
     
      // Add this method:
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Post\Model\PostTable' =>  function($sm) {
                     $tableGateway = $sm->get('PostTableGateway');
                     $table = new PostTable($tableGateway);
                     return $table;
                 },
                 'PostTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Post());
                     return new TableGateway('post', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Post\Model\CommentTable' =>  function($sm) {
                     $tableGateway = $sm->get('CommentTableGateway');
                     $table = new CommentTable($tableGateway);
                     return $table;
                 },
                 'CommentTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototypes = new ResultSet();
                     $resultSetPrototypes->setArrayObjectPrototype(new Postcomment());
                     return new TableGateway('postcomments', $dbAdapter, null, $resultSetPrototypes);
                 },
           
             ),
         );
     }



 }
 
?>
