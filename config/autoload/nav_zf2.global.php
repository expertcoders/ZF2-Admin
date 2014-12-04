<?php 
return array(  
 'navigation' => array(
     'default' => array(
         array(
             'label' => 'Home',
             'route' => 'home',
         ),
		
         array(
             'label' => 'Account',
             'route' => 'user',
             'pages' => array(
                 array(
                     'label' => 'User Login',
                     'route' => 'user',
                     'action' => 'login',
                 ),
                 array(
                     'label' => 'Admin Login',
                     'route' => 'admin',
                     'action' => 'login',
                 ),
             ),
            
         ),
         array(
             'label' => 'Blog',
             'route' => 'user',
             'pages' => array(
                 array(
                     'label' => 'All Post',
                     'route' => 'post',
                     'action' => 'all',
                 ),
             ),
            
         ),
	     
     ),
 ),
 
 
);
