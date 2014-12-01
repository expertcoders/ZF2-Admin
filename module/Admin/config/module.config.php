<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
            'Admin\Controller\User' => 'Admin\Controller\UserController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Admin',
                        'action'     => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'user' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/user[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\User',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'admin/user' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'admin/user[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\User',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
  
    
    'view_manager' => array(
        'display_not_found_reason' => false,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
         'template_path_stack' => array(
            'admin' => __DIR__ . '/../view/',
            'paginator-slide' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),    
    'view_helpers' => array(
        'invokables'=> array(
            'admin_helper' => 'Admin\View\Helper\Adminhelper',  
            'baseUrl' => 'Admin\View\Helper\BaseUrl'  
        )
    ),
    'module_layouts' => array(
        'Application' => array(
            'default' => 'layout/default'
        )
    ),
    'bjyauthorize'=>array(
		'guards'=>array(
			'BjyaAuthorize\Guard\Controller'=>array(
				//
			),
		),
    ),
);
