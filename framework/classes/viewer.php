<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Transition MVC
*
* An open source application development framework for PHP
* @package	Transition MVC
* @author	Adan J. Zweig
* @license	http://opensource.org/licenses/MIT	MIT License
* @since	Version 1.0.0
*/


 /**

 * Viewer Class

 *
 * This class object is the super class that loads the views.
 *
 */
Class Viewer{

	/**
	 * Show view file
	 *
	 * Takes the filename and params and loads the specific view
	 *
	 * @param	string		$filename	View filename
	 * @param	string[]	$params     Params to send to the view
	 *
	 * @return	string	Frontend
	 */
	public function show($filename,$params){
		/*
		 * ------------------------------------------------------
		 *  Load older view if requested
		 * ------------------------------------------------------
		 */
			$this->loadOldViews($params);
		/*
		 * ------------------------------------------------------
		 *  Get controller instance
		 * ------------------------------------------------------
		 */
			$controller = &get_instance();

		/*
		 * ------------------------------------------------------
		 * 	Initialize header if requested
		 * ------------------------------------------------------
		 */	
			if($params['header']){
				echo '<html><head>';
				
				/*
				 * ------------------------------------------------------
				 * 	Load config.php header elements
				 * ------------------------------------------------------
				 */	
					$this->checkAndPrint($controller->headers);

				/*
				 * ------------------------------------------------------
				 * 	Load header elements sent via param
				 * ------------------------------------------------------
				 */	
					if(!empty($params['headers'])){
						$this->checkAndPrint($params['headers']);	
					}
				
				/*
				 * ------------------------------------------------------
				 * 	Get page title
				 * ------------------------------------------------------
				 */	
					if(empty($params['headers']['title'])){
						echo '<title>'.$controller->headers['title'].'</title>';
					}else{
						echo '<title>'.$params['headers']['title'].'</title>';
					}
				
				/*
				 * ------------------------------------------------------
				 * 	Close head and open body
				 * ------------------------------------------------------
				 */	
				echo '</head><body>';
			}
		/*
		 * ------------------------------------------------------
		 *  Load body from view file
		 * ------------------------------------------------------
		 */	
		if(file_exists(APPPATH.'/views/'.$filename.'.php')){
			echo file_get_contents(APPPATH.'/views/'.$filename.'.php');	
		}
		/*
		 * ------------------------------------------------------
		 *  Close body
		 * ------------------------------------------------------
		 */	
		if($params['header']){
			echo '</body></html>';
		}
	}
	/**
	 * Load old views
	 *
	 * If the url is called with an /old parameter it tryies to get older version 
	 * of the controller via the declarated name
	 *
	 * @param	string[]	$params     params sent to the view
	 *
	 * @return	calls to the router to re-route if any.
	 */
	private function  loadOldViews($params=''){
		/*
		 * ------------------------------------------------------
		 *  Load router
		 * ------------------------------------------------------
		 */	
		$router = Router::$router;
		/*
		 * ------------------------------------------------------------
		 *  Checks if old parameter was sent in the called controller
		 * ------------------------------------------------------------
		 */	
			if($router->params['0'] == 'old' && !empty($params['router']['old']['0'])){
				
				/*
				 * ------------------------------------------------------------
				 *  Checks the older version number
				 * ------------------------------------------------------------
				 */	
					if(empty($router->params['1'])){
						$olderVersion = 0;
					}else{
						$olderVersion = $router->params['1'];
					}
					/*
					 * ------------------------------------------------------------
					 *  Sets the new Controller Methods and Params
					 * ------------------------------------------------------------
					 */	
						$oldUrls = explode(SEPARATOR_BAR,$params['router']['old'][$olderVersion],3);
						$router->controller = $oldUrls['0'];
						if(!empty($oldUrls['1'])){
							$router->method = $oldUrls['1'];
						}
						if(!empty($oldUrls['2'])){
							$router->params = $oldUrls['2'];	
						}
						/*
						 * ------------------------------------------------------------
						 *  Calls the new Route
						 * ------------------------------------------------------------
						 */		
						
							$router->callRoute();
				
				die();
			}
		
	}
	/**
	 * Check and Print header elements
	 *
	 * Gets header parameters and print them if any
	 *
	 * @param	string[]	$headerParams	header elements 
	 *
	 * @return	string	Header elements
	 */
	function checkAndPrint($headerParams){
		/*
		 * ------------------------------------------------------------
		 *  Checks every header element type
		 * ------------------------------------------------------------
		 */		
			foreach($headerParams as $type=>$headers){
				switch($type){
					/*
					 * ------------------------------------------------------------
					 *  If CSS, get every css CDN url and prints the tag
					 * ------------------------------------------------------------
					 */		
					case 'css':
						foreach($headers as $header){
							echo '<link rel="stylesheet" href="'.$header.'">';	
						}
					break;
					/*
					 * ------------------------------------------------------------
					 *  If Script, get every js CDN url and prints the tag
					 * ------------------------------------------------------------
					 */		
					case 'script':
						foreach($headers as $header){
							echo '<script type="text/javascript" charset="utf-8" src="'.$header.'"></script>';
						}
					break;
					/*
					 * ------------------------------------------------------------
					 *  If Meta, get every meta and prints directly
					 * ------------------------------------------------------------
					 */		
					case 'meta':
						foreach($headers as $header){
							echo $header;
						}
					break;
				}
			}
	}
	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	function &get_instance(){
	    return Controller::get_instance();
	  }
}