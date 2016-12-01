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

 * Loader Class

 *
 * This class is the Loader handler.
 *
 */
Class Loader{

	/**
   * Load model
   *
   * Model strategy load
   *
   * @param string $model model name
   *
   * @return void
   */
	public function model($model){
		$this->loadFile(APPPATH.'models/'.$model.'.php');
	}

	/**
   * Load library
   *
   * Model strategy load
   *
   * @param string $library library name
   *
   * @return void
   */
	public function library($library){
		$this->loadFile(APPPATH.'libraries/'.$library.'.php');
	}

	/**
   * Load file
   *
   * Strategy action load file
   *
   * @return void
   */
	public function loadFile($path){
		/*
	   * ----------------------------------------------------------------------
	   *  Include the actual class
	   * ----------------------------------------------------------------------
	   */
		if(file_exists($path)){
			include($path);
		}
	}
}