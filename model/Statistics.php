<?php

/**
 * Description of Statistics
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Statistics {

    /**
     * Statistics calculation set to on.
     */
    const STATS_ON = TRUE;

    /**
     * The instance of this class.
     *
     * @var Statistics
     */
    private static $instance;

    /**
     * An array of counters.
     * @var array
     */
    private $counters;

    /**
     * An array of timers.
     *
     * @var array
     */
    private $timers;

    /**
     * An array of monitors: for monitoring various parameters.
     *
     * @var array
     */
    private $monitors;

    /**
     * The constructor.
     */
    private function __construct() {
        $this->counters = array();
        $this->timers = array();
        $this->monitors = array();
    }

    /**
     * The singleton method.
     *
     * @return Statistics
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
     * Initialising the counter for $key.
     *
     * @param string $key
     */
    public function initialiseCounter($key = NULL) {
        $this->counters[$key] = 0;
    }

    /**
     * Setter for the monitor.
     *
     * @param string $key
     * @param string $monitor
     */
    private function setMonitor($key = NULL, $monitor = NULL) {
        $this->monitors[$key][$this->counters[$key]] = $monitor;
    }

    /**
     * Starting the timer for $key.
     *
     * @param string $key
     */
    public function startTimer($key = NULL, $monitor = NULL) {
        if (!self::STATS_ON) {
            return;
        }
        $this->timers[$key][$this->counters[$key]] = Utils::getMicrotime();
        $this->setMonitor($key, $monitor);
    }

    /**
     * Stopping the timer for $key, and incrementing the counter by 1.
     *
     * @param string $key
     */
    public function stopTimer($key = NULL, $monitor = NULL) {
        if (!self::STATS_ON) {
            return;
        }
        $this->timers[$key][$this->counters[$key]] = Utils::getMicrotime() - $this->timers[$key][$this->counters[$key]];
        // $this->setMonitor($key, $monitor);
        $this->counters[$key]++;
    }

    /**
     * Getting the count for $key.
     *
     * @param string $key
     * @return int
     */
    private function getCount($key = NULL) {
        if (!self::STATS_ON) {
            return NULL;
        }
        return $this->counters[$key];
    }

    /**
     * Getting the total time for $key.
     *
     * @param string $key
     * @return int
     */
    private function getTotalTime($key) {
        if (!self::STATS_ON) {
            return NULL;
        }
        $totalTime = 0;
        foreach ($this->timers[$key] as $timerKey => $timer) {
            $totalTime += $timer;
        }
        return $totalTime;
    }

    /**
     * Getting the mean time for $key.
     *
     * @param string $key
     * @return int
     */
    private function getMeanTime($key = NULL) {
        if (!self::STATS_ON) {
            return NULL;
        }
        return $this->counters[$key] > 0 ? getTotalTime($key) / $this->counters[$key] : 0;
    }

    /**
     *
     * @param string $key
     * @return array
     */
    private function getMonitors($key = NULL) {
        return $this->monitors[$key];
    }

    /**
     * Getting parameters for view.
     * 
     * @param string $key
     * @return array
     */
    public function getViewFields($key = NULL) {        
        $viewFields = array();
        $viewFields["count"] = $this->getCount($key);
        $viewFields["totalTime"] = $this->getTotalTime($key);
        if (count($this->getMonitors($key)) > 0) {
            $viewFields["monitors"] = Utils::arrayDuplicateElements($this->getMonitors($key));
        }
        // $output["meanTime"] = $this->getMeanTime($key);
        return $viewFields;
         
    }

}