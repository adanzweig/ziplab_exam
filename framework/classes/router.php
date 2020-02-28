<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /**

 * Router Class

 *
 * This class is the Router handler.
 *
 */
  Class Router {

  /*
   * ------------------------------------------------------
   *  Static instance for external use
   * ------------------------------------------------------
   */
    public static $router='';

  /*
   * ------------------------------------------------------
   *  Controller to call
   * ------------------------------------------------------
   */
    public $controller = '';

  /*
   * ------------------------------------------------------
   *  Method to call
   * ------------------------------------------------------
   */
    public $method = '';

  /*
   * ------------------------------------------------------
   *  Params sent via URL
   * ------------------------------------------------------
   */
    public $params = '';
  
  /*
   * ------------------------------------------------------
   *  $this controller instance
   * ------------------------------------------------------
   */
    private $instance = '';

  /**
   * Constructor
   *
   * Router initializer
   *
   */
    public function __construct($routes)
    {

      /*
     * ------------------------------------------------------
     *  Translate URL into controller, method and params
     * ------------------------------------------------------
     */
      if(empty($_SERVER['PATH_INFO'])){
          die('Invalid URL');
      }
        $routeInUse = null;
        $url = explode(SEPARATOR_BAR,$_SERVER['PATH_INFO'],4);
        foreach($routes[$_SERVER['REQUEST_METHOD']] as $key=>$route){
            preg_match('/'.str_replace(SEPARATOR_BAR,"\\".SEPARATOR_BAR,$key).'$/', $_SERVER['PATH_INFO'], $output_array);
            if(!empty($output_array)){
                $r = explode(SEPARATOR_BAR,$route,4);
                $this->controller = $r[0];
                $this->method = $r[1];
                break;
            }
        }
        if(empty($this->controller)){
            $this->controller = $url[1];
            @$this->method = $url[2];
        }
        if(!empty($url[2])){
            if(is_numeric($url[2])){
                @$this->params = explode(SEPARATOR_BAR,$url[2]);
            }else{
                @$this->params = explode(SEPARATOR_BAR,$url[3]);
            }
        }




    /*
     * ------------------------------------------------------
     *  Initialize pointers to Controller and Router
     * ------------------------------------------------------
     */  
        $this->instance = &Controller::get_instance();
        $this->instance->router = $this;
        Self::$router = &$this;
    }
  /**
   * Get controller
   *
   * Get controller string
   *
   *
   * @return  string   controller name
   */
    public function getController()
    {
      return $this->controller;
    }

   /**
   * Get Method
   *
   * Get method string
   *
   *
   * @return  string method name
   */
    public function getMethod()
    {
        return $this->method;
    }
  /**
   * Get Params
   *
   * Get params string
   *
   *
   * @return  string[] params
   */
    public function getParams()
    {
        return $this->params;
    }


  /**
   * Route Caller
   *
   * Calls the controller and method
   *
   *
   * @return  string[] params
   */
  public function routeCaller(){

    /*
     * ------------------------------------------------------
     *  Call the controller inside application
     * ------------------------------------------------------
     */  
      if(file_exists(APPPATH.'controllers/'.$this->getController().'.php')){
      /*
       * ------------------------------------------------------
       *  Include and instantiate controller
       * ------------------------------------------------------
       */  
        include_once(APPPATH.'controllers/'.$this->getController().'.php');
        $UcaseClass = ucfirst($this->getController());
        $newClass = new $UcaseClass();  
          /*
         * ------------------------------------------------------
         *  Call the controller's method
         * ------------------------------------------------------
         */  
          if(!empty($this->getMethod())){
            if(method_exists($newClass,$this->getMethod())){
              $newClass->{$this->getMethod()}($this->getParams());
            }else{
              /*
               * -------------------------------------------------------------
               *  Check alternative routes from config/routes.php file or DIE
               * -------------------------------------------------------------
               */  

                  die('Method does not exist');

            }
          }else{
              /*
               * ------------------------------------------------------
               *  If no method, call default index method
               * ------------------------------------------------------
               */  
                try{
                  $newClass->index();  
                }catch(Exception $e){
                  die('Method does not exist');
                }
              
          }
          
        }else{
          /*
           * -------------------------------------------------------------
           *  Check alternative routes from config/routes.php file or DIE
           * -------------------------------------------------------------
           */  
            die('Controller does not exist');
        }
  }


  /**
   * Check Alternative Routes
   *
   * Get routes params and check if called url is inside
   *
   *
   * @return  call route caller
   */
  public function checkAlternativeRoutes(){
    /*
     * -------------------------------------------------------------
     *  Get alternative routes
     * -------------------------------------------------------------
     */ 
      $alternativeRoute = $this->instance->routes;
    /*
     * -------------------------------------------------------------------
     *  Get method caller (GET, POST, DELETE, PUT, HEAD, PATCH, OPTIONS or ANY)
     * -------------------------------------------------------------------
     */ 
      $method = $_SERVER['REQUEST_METHOD'];
      
      if(!empty($alternativeRoute['ANY'][$this->getController().'/'.$this->getMethod()]) || !empty($alternativeRoute['ANY'][$this->getController()])){
        $methodCaller = 'ANY';
      }else if(!empty($alternativeRoute[$method][$this->getController().'/'.$this->getMethod()]) || !empty($alternativeRoute[$method][$this->getController()])){
        $methodCaller = $method;
      }else{
        die('Path problem');
      }
    /*
     * ----------------------------------------------------------------
     *  Replaces controller and method and calls again to route caller
     * ----------------------------------------------------------------
     */ 
      if(empty($this->getMethod())){
        $url = explode(SEPARATOR_BAR,$alternativeRoute[$methodCaller][$this->getController()]);  
      }else{
        $url = explode(SEPARATOR_BAR,$alternativeRoute[$methodCaller][$this->getController().'/'.$this->getMethod()]);
      }
      
      $this->controller = $url[0];
      $this->method = $url[1];
      $this->routeCaller(array(),0);
  }
}