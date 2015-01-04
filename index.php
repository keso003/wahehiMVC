<?php




define('ENVIRONMENT', 'development');

if (defined('ENVIRONMENT')) {
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
		break;
	
		case 'testing':
		case 'production':
			error_reporting(0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}


$_base_url = 'http://localhost/';

if (isset($_SERVER['HTTP_HOST'])) {
	$base_url = (empty($_SERVER['HTTPS']) OR strtolower($_SERVER['HTTPS']) === 'off') ? 'http' : 'https';
	$base_url .= '://'. $_SERVER['HTTP_HOST'];
	$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
}



define('BASE_URL', $_base_url);
define('APPPATH', './app/');

define('CONFIG_PATH', './config/');
define('LIBRARY_PATH', './library/');

set_include_path(implode(PATH_SEPARATOR,array(
	'.',         
	LIBRARY_PATH, 
	LIBRARY_PATH . 'core/',
	APPPATH . '/controllers/',
	APPPATH . '/models/',
	get_include_path()
)));


require_once('core/Loader.php');


//sanitize controller/action request
$controller = (isset($_GET['controller']))? preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['controller'] ) : 'home';
$action = (isset($_GET['action']))? preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['action']) : 'index';

//load controller
$current_url = $_GET;



$oLoader = new Loader();
$oLoader->loadClass('Controller');
$oLoader->loadClass('View');
$oLoader->loadClass($controller);



function &load_class($name) {
	static $oClass = array();
	$oLoader = new Loader();
	$oLoader->loadClass($name);
	
	$instance = new $name();
	$oClass[$name] = $name;
	return $instance;
}

function &get_instance() {
	return Controller::get_instance();
}

$controller = ucfirst($controller);


if(class_exists($controller)){
    $oController = new $controller();
} else{
    die("Internal Server Error: {$controller} does not exists.");
}


call_user_func_array(array(&$oController, $action), array_slice($current_url, 2));