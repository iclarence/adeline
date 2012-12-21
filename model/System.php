<?php

/**
 * Description of System
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class System {

    /**
     * The instance of this class.
     *
     * @var Statistics
     */
    private static $instance;

    /**
     * The constructor.
     */
    private function __construct() {

        /**
         * Initialising statistical analysis.
         */
        // $stats = self::getStats();
        // $stats->initialiseCounter("DATABASE_CALLS");
        // $stats->initialiseCounter("WHOLE_PAGE");
        // $stats->startTimer("WHOLE_PAGE");

        /**
         * Initialising the session.
         */
        $session = self::getSession();

        /**
         * Initialising the database.
         */
        $database = self::getDB();
    }

    /**
     * The singleton method.
     *
     * @return System
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
     * Returning a statistics object.
     *
     * @return Statistics
     */
    public static function getStats() {
        return Statistics::getInstance();
    }

    /**
     * Returning a database object.
     *
     * @return Database
     */
    public static function getDB() {
        return Database::getInstance();
    }

    /**
     * Returning a session object.
     *
     * @return Session
     */
    public static function getSession() {
        return Session::getInstance();
    }

}