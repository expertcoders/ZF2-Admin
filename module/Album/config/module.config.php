<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
   'service_manager' => array(
     'factories' => array(
         'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory', // <-- add this
     ),
 ),
    
 'navigation' => array(
     'default' => array(
         array(
             'label' => 'Home',
             'route' => 'home',
         ),
         array(
             'label' => 'Album',
             'route' => 'album',
             'pages' => array(
                 array(
                     'label' => 'Level-1',
                     'route' => 'album',
                     'action' => 'add',
                     'pages'=> array(
                         array(
                           'label' => 'Level-2',
                           'route' => 'album',
                           'action' => 'edit',
                           'pages'=> array(
                                    array(
                                       'label' => 'Level-2',
                                       'route' => 'album',
                                       'action' => 'edit',
                                 ),
                  ),

                      ),
                  ),
                 ),
                 array(
                     'label' => 'Edit',
                     'route' => 'album',
                     'action' => 'edit',
                 ),
                 array(
                     'label' => 'Delete',
                     'route' => 'album',
                     'action' => 'delete',
                 ),
                 
             ),
            
         ),
           array(
             'label' => 'User',
             'route' => 'user',
             'pages' => array(
                 array(
                     'label' => 'Add',
                     'route' => 'user',
                     'action' => 'add',
                 ),
                 array(
                     'label' => 'Edit',
                     'route' => 'user',
                     'action' => 'edit',
                 ),
                 array(
                     'label' => 'Delete',
                     'route' => 'user',
                     'action' => 'delete',
                 ),
                 
             ),
            
         ),
         
     ),
 ),
);
