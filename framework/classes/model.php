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

 * Model Class

 *
 * This class is the Model handler.
 *
 */
Class Model{
  /*
   * ----------------------------------------------------------------------
   *  Variable that contains the redbean instance called attribute for UX
   * ----------------------------------------------------------------------
   */
	public  $attribute;
   
   /**
   * Constructor
   *
   * Model initializer
   *
   * @return RedBean element StdObject
   */
	public function __construct($id =''){
		$t = &get_instance();
		/*
	   * ----------------------------------------------------------------------
	   *  Declare model name as child model name
	   * ----------------------------------------------------------------------
	   */
		$model = get_class($this);

		/*
	   * ----------------------------------------------------------------------
	   *  Get RedBean element
	   * ----------------------------------------------------------------------
	   */
		if(empty($id)){
			$this->attribute = R::dispense( static::$table );	

		}else{
			$this->attribute = R::load( static::$table,$id );
		}
		
		return $this->attribute;
		
	}

	/**
   * Save instance
   *
   * Saves instance (Update, Insert)
   *
   * @return integer $id
   */
	public function save(){
		return R::store($this->attribute);
	}

	/**
   * Search
   *
   * Find one or more coincidences
   *
   * @param string $compare where clause
   * @param string[] $param array variables to match
   *
   * @return Model[] elements
   */
	public static function find($compare,$param){
		/*
	   * ----------------------------------------------------------------------
	   *  Call Redbean Find method
	   * ----------------------------------------------------------------------
	   */
		$elems = R::find(static::$table,$compare,$param);
		$elemList = array();
		/*
	   * ----------------------------------------------------------------------
	   *  Run every result and create a new RedBean element per each result
	   * ----------------------------------------------------------------------
	   */
		return Self::getRBElements($elems);
	}

	/**
   * Get All
   *
   * Get every element from table with order and limit params
   *
   * @param string $order Order by or Limit clause
   *
   * @return Model[] elements
   */
	public static function findAll($order=''){
		/*
	   * ----------------------------------------------------------------------
	   *  Call Redbean FindAll method
	   * ----------------------------------------------------------------------
	   */
		$elems = R::findAll(static::$table,$order);
		$elemList = array();
		/*
	   * ----------------------------------------------------------------------
	   *  Run every result and create a new RedBean element per each result
	   * ----------------------------------------------------------------------
	   */
		return Self::getRBElements($elems);
	}

	/**
   * RawQuery
   *
   * Run a raw query
   *
   * @param string $order Query
   *
   * @return Model[] elements
   */
	public static function rawQuery($query){
		/*
	   * ----------------------------------------------------------------------
	   *  Call Redbean getAll method (Raw SQL)
	   * ----------------------------------------------------------------------
	   */
		$elems = R::getAll($query);
		
		/*
	   * ----------------------------------------------------------------------
	   *  Run every result and create a new RedBean element per each result
	   * ----------------------------------------------------------------------
	   */
		return Self::getRBElements($elems);
	}

	/**
   * Get RedBean elements
   *
   * Run every result and create a new RedBean element per each result
   *
   * @param string $order Query
   *
   * @return Model[] elements
   */
	private static function getRBElements($elements){
		$elemList = array();
		$model = ucfirst(get_called_class());
		foreach($elements as $elem){
			$elemList[] = new $model($elem->id);
		}
		return $elemList;
	}

	/**
   * Delete RedBean Element
   *
   * delete the element from database
   *
   */
	public function delete(){
		R::trash($this->attribute);
	}

   /**
   * Get the CI singleton
   *
   * @static
   * @return  object
   */
	public static function &get_instance(){
		return Controller::$instance;
	}
}