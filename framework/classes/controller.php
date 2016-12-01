<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Transition MVC
*
* An open source application development framework for PHP
* @package  Transition MVC
* @author Adan J. Zweig
* @license  http://opensource.org/licenses/MIT  MIT License
* @since  Version 1.0.0
*/


 /**

 * Controller Class

 *
 * This class is the Controller handler.
 *
 */
class Controller {

	/*
   * ----------------------------------------------------------------------
   *  Variable that contains the controller instance for further use
   * ----------------------------------------------------------------------
   */
	private static $instance;

 	/**
   * Constructor
   *
   * Controller initializer
   *
   * @return RedBean element StdObject
   */
	public function __construct(){
		
		/*
	   * ----------------------------------------------------------------------
	   *  Instantiate $this and add keys like config, loader, routes and more
	   * ----------------------------------------------------------------------
	   */
		$inst = &get_instance();
		foreach($inst as $key=>$i){
			$this->$key = $i;
		}
		
		foreach ($this->loader as $route=>$classes)
		{
			foreach($classes as $class){
				/*
			   * ----------------------------------------------------------------------
			   *  Instantiates required classes
			   * ----------------------------------------------------------------------
			   */
				if($route == 'core'){
					$path = BASEPATH.'classes/';
				}else{
					$path = APPPATH.$route.'/';
				}
				if(file_exists($path.$class.'.php')){
					require_once($path.$class.'.php');
					$ucFirstClass = ucfirst($class);
					$this->$class = new $ucFirstClass();
				}

				
			}

		}


	}

  /**
   * Get the CI singleton
   *
   * @static
   * @return  object
   */
	public static function &get_instance(){

		return self::$instance;

	}

}
