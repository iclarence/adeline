<?php

/**
 * Database handler.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */

class Database {

    /**
     * The instance of this class.
     *
     * @var Database
     */
    private static $instance;

    /**
     * The link identifier.
     * 
     * @var resource
     */
    private $resource;

    /**
     * Statistics key
     */
    const STATS_KEY = 'DATABASE_CALLS';

    /**
     * The constructor.
     */
    private function __construct() {

        /**
         * Connecting to the server, and then selecting the database.
         */
        $this->connect(DB_SERVER, DB_USER, DB_PASSWORD);
        if (!$this->selectDb(DB)) {
            $this->triggerError();
        }
    }

    /**
     * The singleton method.
     * 
     * @return Database
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
     * Establishing connection.
     *
     * @param string $server
     * @param string $user
     * @param string $password
     */
    private function connect($server, $user, $password) {
        $this->resource = mysql_connect($server, $user, $password);
    }

    /**
     * Selecting a database.
     *
     * @param string $database
     * @return bool
     */
    private function selectDb($database) {
        return mysql_select_db($database, $this->resource);
    }

    /**
     * Running an SQL query.
     *
     * @param Query $query
     * @return resource
     */
    private function query(Query $query) {
        $sql = $query->getSql();
        $stats = System::getStats();
        $stats->startTimer(self::STATS_KEY, $sql);
        $result = mysql_query($sql);
        $stats->stopTimer(self::STATS_KEY);
        return $result;
    }

    /**
     * Fetching results as an associative array.
     *
     * @param resource $result
     * @return array
     */
    private function fetchAssoc($result) {
        return mysql_fetch_assoc($result);
    }

    /**
     * Escaping a string before entering it into the database.
     * Prevents SQL injection.
     * 
     * @param string $unescaped_string
     * @return string
     */
    public function realEscapedString($unescaped_string) {
        return mysql_real_escape_string($unescaped_string, $this->resource);
    }

    /**
     * Submitting a query and returning an associative array.
     *
     * @param Query $query
     * @param bool $oneRow
     * @return array
     */
    public function queryArray(Query $query, $oneRow = FALSE) {
        $result = $this->query($query);
        if ($result === FALSE) {
            $this->triggerError($query);
            return FALSE;
        }
        $values = array();
        while ($assoc = $this->fetchAssoc($result)) {
            if (is_array($assoc)) {
                if ($oneRow) {
                    return $assoc;
                }
                $values[] = $assoc;
            }
        }
        return $values;
    }

    /**
     * Getting the last inserted id.
     *
     * @return int
     */
    private function insertId() {
        return mysql_insert_id($this->resource);
    }

    /**
     * Submitting a query and returning the inserted id.
     *
     * @param Query $query
     * @return int
     */
    public function queryId(Query $query) {
        if ($this->query($query) !== FALSE) {
            return $this->insertId();
        }
        else {
            $this->triggerError($query);
            return FALSE;
        }
    }

    /**
     * Submitting a query where no result is expected, and there is no inserted id.
     *
     * @param Query $query
     * @return bool
     */
    public function queryOnly(Query $query) {
        if ($this->query($query) !== FALSE) {
            return TRUE;
        }
        else {
            $this->triggerError($query);
            return FALSE;
        }
    }

    /**
     * Getting the MySQL error.
     *
     * @return string
     */
    private function error() {
        return mysql_error($this->resource);
    }

    /**
     * Getting the MySQL error number.
     *
     * @return int
     */
    private function errno() {
        return mysql_errno($this->resource);
    }

    /**
     * Triggering the error. 
     * If the error is the result of a query, then it may be entered as a parameter, 
     * so that it can be listed with the error.
     *
     * @param Query $query
     * @return string
     */
    public function triggerError(Query $query = NULL) {
        $output = 'ERROR ' . $this->errno() . ': ' . $this->error();
        if ($query != NULL) {
            $output .= "\nQUERY: " . $query->getSql();
        }
        trigger_error($output, E_USER_ERROR);
        return $output;
    }

}