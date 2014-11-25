<?php
/**
 * Configuration file generated by ZFTool
 * The previous configuration file is stored in application.config.old
 *
 * @see https://github.com/zendframework/ZFTool
 */
ini_set('display_errors',1);
define('SITEPATH',substr($_SERVER['PHP_SELF'], 0, -9));
$env = getenv('APP_ENV') ?: 'production';
$modules=array('Application');
if($env=='development'){
	$modules[]='Album';
	$modules[]='ZFTool';
}
$modules[]='User';
$modules[]='Post';
$modules[]='Admin';
return array(
    'modules' =>$modules,
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor'
        ),
        'config_glob_paths' => array(
            './config/autoload/{,*.}{global,local}.php'
        ),
    ),
);
