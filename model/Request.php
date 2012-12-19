<?php

/**
 * Request handler.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Request {

    /**
     * The instance of this class.
     *
     * @var Request
     */
    private static $instance;

    /**
     * The constructor.
     */
    private function __construct() {
    }

    /**
     * The singleton method.
     *
     * @return Request
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    /**
     * Preventing users from cloning the instance.
     */
    public function __clone() {
        trigger_error('Cannot clone a singleton.', E_USER_ERROR);
    }

    /**
     * Getting request variables.
     *
     * @param mixed $name
     * @return mixed
     */
    public static function getVariable($name = NULL) {
        
        /**
         * Name not specified: return the whole array. 
         */
        if ($name == NULL) {
            return $_REQUEST;
        }
        
        /**
         * No value corresponding to requested name. 
         */
        if (!isset($_REQUEST[$name])) {
            return NULL;
        }
        
        /**
         * Return the required request variable. 
         */
        return $_REQUEST[$name];
    }

}