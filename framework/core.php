<?php
/**
* Transition MVC
*
* An open source application development framework for PHP
* @package	Transition MVC
* @author	Adan J. Zweig
* @license	http://opensource.org/licenses/MIT	MIT License
* @since	Version 1.0.0
*/

/*
 * ------------------------------------------------------
 *  Load the framework core classes
 * ------------------------------------------------------
 */
	include ('classes/rb.php');
	include ('classes/controller.php');
	include ('classes/router.php');
	include ('classes/session.php');
	include ('classes/loader.php');
	include ('classes/viewer.php');
	include ('classes/model.php');

/*
 * ------------------------------------------------------
 *  Load the application config files
 * ------------------------------------------------------
 */
	foreach(glob(APPPATH.'config/*') as $file) {
	    // var_dump($file);
	    include(FCPATH.$file);
	}

/*
 * ------------------------------------------------------
 *  Load the Controller Singleton
 * ------------------------------------------------------
 */
	$controller = &get_instance();
	if(empty($controller)){
		$controller = new stdClass();
	}
/*
 * ------------------------------------------------------
 *  Make the Controller load this Dependencies
 * ------------------------------------------------------
 */
	$loader['core'][] =  "viewer";
	$loader['core'][] =  "loader";
	$controller->loader = $loader;

/*
 * ------------------------------------------------------
 *  Add Methods to the Controller Parent
 * ------------------------------------------------------
 */
	$controller->routes = $routes;
	$controller->headers = $headers;

/*
 * ------------------------------------------------------
 *  ORM Red Bean Setup
 * ------------------------------------------------------
 */
	R::setup( DBTYPE.':host='.HOSTNAME.';dbname='.DBNAME, DBUSERNAME, DBPASSWORD );

/*
 * ------------------------------------------------------
 *  Router to launch the controller and method
 * ------------------------------------------------------
 */
	$router = new ROUTER();
	$router->callRoute();

/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
function &get_instance()
{
	return Controller::get_instance();
}