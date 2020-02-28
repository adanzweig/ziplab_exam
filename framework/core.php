<?php
/*
 * ------------------------------------------------------
 *  Load the framework core classes
 * ------------------------------------------------------
 */
	include ('classes/rb.php');
	include ('classes/controller.php');
	include ('classes/router.php');
	include ('classes/loader.php');
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
	$loader['core'][] =  "loader";
	$controller->loader = $loader;

/*
* ------------------------------------------------------
*  Make the Controller load Body requests
* ------------------------------------------------------
*/
    $controller->request = json_decode(file_get_contents('php://input'), true);

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
	$router = new Router($routes);
	$router->routeCaller();
/*
 * ------------------------------------------------------
 *  Models Loader
 * ------------------------------------------------------
 */


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