<?php

/**
 * Session handler.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Session {

    /**
     * The instance of this class.
     *
     * @var Session
     */
    private static $instance;

    /**
     * The constructor.
     */
    private function __construct() {
        if (!session_start()) {
            trigger_error("Session failed to start.", E_USER_ERROR);
        }
    }

    /**
     * The singleton method.
     *
     * @return Session
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
        trigger_error("Cannot clone a singleton.", E_USER_ERROR);
    }

    /**
     * Returning the session ID.
     *
     * @return int
     */
    public function getId() {
        return session_id();
    }

    /**
     * Validate by comparing a previously obtained session ID with the current one.
     * Used to validate form submissions.
     *
     * @return bool
     */
    public function validate($sessionId) {
        return session_id() == $sessionId;
    }

    /**
     * Setting session variables.
     *
     * @param mixed $name
     * @param mixed $value
     * @return bool
     */
    public function setVariable($name, $value = array()) {
        if (is_array($name)) {
            if (count($name) > 1) {
                $_SESSION[$name[0]][$name[1]] = $value;
                return TRUE;
            }
            else if (count($name) == 1) {
                $_SESSION[$name[0]] = $value;
                return TRUE;
            }
            return FALSE;
        }
        $_SESSION[$name] = $value;
        return TRUE;
    }

    /**
     * Getting session variables.
     *
     * @param mixed $name
     * @return mixed
     */
    public function getVariable($name = NULL) {
        if ($name == NULL) {
            return $_SESSION;
        }
        if (is_array($name)) {
            if (count($name) > 1) {
                if (!isset($_SESSION[$name[0]][$name[1]])) {
                    return FALSE;
                }
                return $_SESSION[$name[0]][$name[1]];
            }
            else if (count($name) == 1) {
                if (!isset($_SESSION[$name[0]])) {
                    return FALSE;
                }
                return $_SESSION[$name[0]];
            }
            return FALSE;
        }
        if (!isset($_SESSION[$name])) {
            return FALSE;
        }
        return $_SESSION[$name];
    }
    
    /**
     * Resetting all session variables. 
     */
    public function resetAll() {
        $_SESSION = array();
    }

}