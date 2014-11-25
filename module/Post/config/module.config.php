<?php 
return array(
'controllers' => array(
    'invokables' => array(
        'Post\Controller\Post' => 'Post\Controller\PostController',
    ),
),
    
    
     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'post' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/post[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Post\Controller\Post',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'post' => __DIR__ . '/../view',
         ),
     ),
 );
?>
