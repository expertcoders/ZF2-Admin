<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Post;
use Application\Model\PostTable;

class Module 
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }



    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
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
                    // here begin the categoryTable factory
                'Application\Model\PostTable' =>  function($sm)
                {
                    //get the tableGateway just below in his own factory
                    $tableGateway = $sm->get('PostTableGateway');
                    //inject the tableGateway in the Table
                    $table = new PostTable($tableGateway);
                    return $table;
                },
                //here is the tableGateway Factory for the category
                'PostTableGateway' => function($sm)
                {
                    //get adapter to donnect dataBase
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    // create a resultSet
                    $resultSetPrototype = new ResultSet();
                    //define the prototype of the resultSet 
                    // => what object will be cloned to get the results
                    $resultSetPrototype->setArrayObjectPrototype(new Post());
                    //here you define your database table (post) 
                    //when you return the tableGateway to the PostTable factory
                    return new TableGateway('post', $dbAdapter, null, $resultSetPrototype);
                },
             ),
         );
     }

}
