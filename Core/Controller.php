<?php

namespace Core;

use PDO;
use App\Config;


if(!isset($_SESSION)) 
    { 
        session_start();
    }

/**
 * Base controller
 *
 * PHP version 7.0
 */
abstract class Controller extends \Core\Model
{

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;

    }



    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
        
            if ($this->before() !== false) {       
                call_user_func_array([$this, $method], $args);
                $this->log(get_class($this),$method);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
       if(!isset($_SESSION['eduflix'])){
        header('Location: '.Config::HOST.Config::DIRECTORY.'Login/');
        exit; 
       }
        
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
       
        
    }


     /**
     * After filter - called after an action method.
     *
     * @return void
     */
    public function log($class,$method,$args="")
    {
        if(isset($_SESSION['eduflix'])){

        $db = static::getDB();
        $argumentos = implode(",",$this->route_params).":".$args;

        $stmt = $db->prepare("INSERT INTO log (id_usuario,clase,metodo,argumentos,ip) values (?,?,?,?,?);");
        $stmt->execute([$_SESSION['eduflix']['id'],$class,$method, $argumentos,$this->getIP()]);
        
    }

    }



    function getIP() 
    {
        
        $tmp = getenv("HTTP_CLIENT_IP");
        
        if ( $tmp && !strcasecmp( $tmp, "unknown"))
            return $tmp;
    
        $tmp = getenv("HTTP_X_FORWARDED_FOR");
        if( $tmp && !strcasecmp( $tmp, "unknown"))
            return $tmp;
    
        
        $tmp = getenv("REMOTE_ADDR");
        if($tmp && !strcasecmp($tmp, "unknown"))
            return $tmp;
    
        return("unknown");
    }


}
