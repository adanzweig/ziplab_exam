<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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