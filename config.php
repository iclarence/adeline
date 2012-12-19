<?php

/**
 * Configuration: constants, autoloading classes and error handling.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */

/**
 * Constants file.
 */
require_once 'constants.php';

/**
 * Autoload function
 */
function __autoload($className) {

    /**
     * Search classes in controller/ and subdirectories.
     */
    $path = findClass('controller', $className);

    /**
     * Search classes in model/ and subdirectories.
     */
    if ($path == NULL) {
        $path = findClass('model', $className);
    }

    /**
     * Load matching class.
     */
    require_once $path;
}

/**
 * Finding a class "$className" within a directory structure "$dir".
 * Returns the full filepath of the file in which the class is found.
 *
 * @param string $dir
 * @param string $className
 * @return string
 */
function findClass($dir, $className) {
    $handle = opendir($dir);
    $found = FALSE;
    $path = NULL;
    while (($file = readdir($handle)) && ($found == FALSE)) {
        if ($file != "." && $file != ".." && $file[0] != '.') {
            if (is_dir($dir . "/" . $file)) {
                $path = findClass($dir . "/" . $file, $className);
            }
            else if ($file == $className . ".php") {
                $path = $dir . "/" . $file;
            }
            $found = $path != NULL;
        }
    }
    closedir($handle);
    return $path;
}

/**
 * Setting the error reporting level.
 */
error_reporting(E_ALL);

/**
 * Error handler function.
 */
function errorHandler(
    $errno,
    $errstr,
    $errfile,
    $errline,
    array $errorcontext
) {
    try {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
    catch (ErrorException $e) {
         die('Error no ' . $errno . ': ' . $errstr . ', in file ' . $errfile . ' on line ' . $errline);
    }
}

/**
 * Setting the error handling function.
 */
set_error_handler('errorHandler');

/**
 * Inintialising the system class, which contains database, session and statistics.
 */
// $system = System::getInstance();