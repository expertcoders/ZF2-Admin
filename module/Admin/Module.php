<?php
namespace Admin;

// Add these import statements:
use Admin\Model\Admin;
use Admin\Model\AdminTable;
use Zend\Mvc\ModuleRouteListener;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;    

class Module
{
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
                'Admin\Model\AdminTable' =>  function($sm) {
                    $tableGateway = $sm->get('AdminTableGateway');
                    $table = new AdminTable($tableGateway);
                    return $table;
                },
                'AdminTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                },
                'Admin\Model\UserTable' => function($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new Model\UserTable($tableGateway);
                    return $table;
                },
                'UserTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\User());
                    return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
    
    
     
    
    //Helper Registred Here
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'admin_helper' => function($sm) {
                    $helper = new View\Helper\Adminhelper;
                    return $helper;
                }
            )
        );  
   }
    
}
