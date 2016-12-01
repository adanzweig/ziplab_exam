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

 * Session Class

 *
 * This class is the Session handler.
 *
 */
Class Session {
  /*
   * ------------------------------------------------------
   *  Exipiration time of the sessions
   * ------------------------------------------------------
   */
     private $expiration = 28800000; //8 Hours
  /*
   * ------------------------------------------------------
   *  Session hashing string
   * ------------------------------------------------------
   */
	   private $hash = 'SomeHash';
  
  /**
   * Constructor
   *
   * Session initializer
   *
   */
	public function __construct(){
		if (session_status() == PHP_SESSION_NONE) {
			@session_start();
  	}
	}

  /**
   * Set session
   *
   * Sets the new session or updates the oldone
   *
   * @param string    $name     session name
   * @param string    $value    session value
   * @param bool    $encrypt    encription flag
   *
   * @return  void
   */
    public function setSession($name,$value,$encrypt){
      if($encrypt){
        $sessionValue = md5($value);
        $_SESSION[md5($this->hash.$name)][$name]['encripted'] = true;
      }else{
        $sessionValue = $value;
        $_SESSION[md5($this->hash.$name)][$name]['encripted'] = false;
      }
  		$_SESSION[md5($this->hash.$name)][$name]['value'] = $sessionValue;
  		$_SESSION[md5($this->hash.$name)][$name]['created'] = time();
  	}

  /**
   * Get session
   *
   * gets the session value
   *
   * @param string    $name     session name
   *
   * @return  string session value
   */
  	public function getSession($name){
  		if(!$this->expired($name)){
  			return $_SESSION[md5($this->hash.$name)][$name]['value'];
  		}else{
        return null;
      }
  	}

  /**
   * Compare sessions
   *
   * Compare the sessions
   *
   * @param string    $name     session name
   * @param string    $value    value to check the session value
   *
   * @return  bool if session value equals to given value
   */
    public function compareSessionValue($name,$value){
  		if(!$this->expired($name)){
        if($_SESSION[md5($this->hash.$name)][$name]['encripted']){
          $valToCompare = md5($value);
        }else{
          $valToCompare = $value;
        }
  			return strcmp($_SESSION[md5($this->hash.$name)][$name]['value'], $valToCompare);
  		}else{
        return null;
      }
  	}

    /**
   * Is session expired
   *
   * Check if the session expired
   *
   * @param string    $name     session name
   *
   * @return  bool if session has expired
   */
  	private function expired($name){
  		return (!empty($_SESSION[md5($this->hash.$name)][$name]) && (($_SESSION[md5($this->hash.$name)][$name]['created']+$this->expiration) < time()));
  	}
}