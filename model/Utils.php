<?php

/**
 * General utilities.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Utils {

    /**
     * The constructor
     */
    public function __construct() {
    }

    /**
     * Converting lowercase underscored strings to camel case or pascal case.
     *
     * @param string $textString
     * @param bool $pascalCase
     * @return string
     */
    public static function underscoreToCamelCase($textString, $pascalCase = FALSE) {
        if ($textString == NULL) {
            return NULL;
        }
        $values = explode('_', $textString);
        foreach ($values as $valueKey => $value) {
            $values[$valueKey] = ($valueKey > 0 || $pascalCase) ? ucfirst($value) : $value;
        }
        return implode('', $values);
    }

    /**
     * Listing an object: for diagnostic purposes. 
     * Causes execution to terminate by default.
     *
     * @param object $object
     * @param bool $die
     */
    public static function dump($object, $die = TRUE) {
        echo '<pre>\n';
        var_dump($object);
        if ($die) {
            die('</pre>');
        }
        else {
            echo '</pre>\n';
        }
    }

    /**
     * Testing whether a MySQL datatype is numeric.
     * 
     * @param string $dataType
     * @return bool
     */
    public static function isNumericalMySqlDataType($dataType) {        
        $numericalDataTypes = array(
            'TINYINT' => 'TINYINT',
            'SMALLINT' => 'SMALLINT',
            'MEDIUMINT' => 'MEDIUMINT',
            'INT' => 'INT',
            'BIGINT' => 'BIGINT',
            'FLOAT' => 'FLOAT',
            'DOUBLE' => 'DOUBLE',
            'REAL' => 'REAL',
            'NUMERIC' => 'NUMERIC',
            'BIT' => 'BIT'
        );
        $parts = explode('(', $dataType);
        return isset($numericalDataTypes[strtoupper($parts[0])]);
    }

    /**
     * Enclose a text string in double quotes.
     * 
     * @param string $textString
     * @return string
     */
    public static function encloseInQuotes($textString) {
        return '"' . $textString . '"';
    }

    /**
     * Enclose a text string in backticks: used for field names in MySQL .
     *
     * @param string $textString
     * @return string
     */
    public static function encloseInBackticks($textString) {
        return '`' . $textString . '`';
    }

    /**
     * If the current page is secure, return TRUE.
     *
     * @return bool
     */
    public static function getPageSecure() {
        return $_SERVER['SERVER_PORT'] == '443';
    }

    /**
     * Getting the host.
     * 
     * @return string
     */
    public static function getHost() {
        $host = $_SERVER['HTTP_HOST'];
        if ($host == '') {
            return NULL;
        }
        return $host;
    }
    
    /**
     * Getting the Id of the subdomain.
     * 
     * @return int
     */
    public static function getSubdomain() { 
        $records = ServerUrl::search(self::getHost(), 'www', FALSE);
        $fields = $records[0]->getFields();
        return $fields['id'];        
    }

    /**
     * For a multilingual site, returns the language code of the language set.
     * If no language is set, then return the default language code.
     * If not a multilingual site, then returns FALSE.
     * 
     * @return string
     */
    public static function getLanguage() {
        if (Registry::getVal('MULTILINGUAL_SITE') == 0) {
            return FALSE;
        }
        $session = System::getSession();
        $language = $session->getVariable('LANGUAGE');
        if (is_array($language) && $language['code'] != '') {
            return $language['code'];
        }
        return Registry::getVal('DEFAULT_LANGUAGE');
    }

    /**
     * Getting absolute time in microseconds.
     * 
     * @return float
     */
    public static function getMicrotime() {
        list($usec, $sec) = explode(' ', microtime());
        return (float)$usec + (float)$sec;
    }

    /**
     * Analysing an array for duplication of elements.
     * 
     * @param array $values
     * @return array
     */
    public static function arrayDuplicateElements(array $values) {
        $output = array();
        $counted = array();
        foreach ($values as $valueKey => $value) {
            $counted[$valueKey] = FALSE;
        }
        foreach ($values as $valueKey => $value) {
            if (!$counted[$valueKey]) {
                $count = 0;
                foreach ($values as $valKey => $val) {
                    if ($value == $val) {
                        $count++;
                        if ($count > 1) {
                            $counted[$valKey] = TRUE;
                        }
                    }
                }
                $output[] = array(
                    'value' => $value,
                    'count' => $count
                );
            }
        }
        return $output;
    }
    
    /**
     * Converting an array to an object of StdClass.
     * 
     * @param array $values
     * @return mixed
     * 
     */
    public static function arrayToObject($values) {

        /**
         * If the parameter is not an array, return it as is.
         */
        if (!is_array($values)) {
            return $values;
        }

        /**
         * If the parameter is an empty array, return it as it is.
         */
        if (count($values) == 0) {
            return new stdClass();
        }

        /**
         * If the parameter is not an associative array (i.e. the keys are numeric), return it as an array.
         */
        $numericKeys = TRUE;
        $output = array();
        foreach ($values as $valueKey => $value) {
            if (!is_numeric($valueKey)) {
                $numericKeys = FALSE;
            }
            $output[$valueKey] =  self::arrayToObject($value);
        }
        if ($numericKeys) {
            return $output;
        }

        /**
         * If the parameter is a non-empty associative array, return it as an object.
         */
        $output = new stdClass();
        foreach ($values as $valueKey => $value) {
            $name = self::underscoreToCamelCase($valueKey);
            if (!empty($name)) {
                $output->$name = self::arrayToObject($value);
            }
        }
        return $output;
    }
    
    /**
     * Getting page contents given the URL.
     * 
     * @param string $url
     * @return string
     */
    public static function getUrlContents($url){
        $crl = curl_init();
        $timeout = 5;
        curl_setopt ($crl, CURLOPT_URL,$url);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $output = curl_exec($crl);
        curl_close($crl);
        return $output;
    }
    
    /**
     * Storing or retrieving from cache.
     * 
     * @param string $apcKey
     * @param callable $callback
     * @param bool $useCache
     * @param array $params
     * @param bool $doAdd
     * @return array
     */
    public static function apcCache($apcKey, $callback, $useCache, $params = array(), $doAdd = TRUE) {
        if (apc_exists($apcKey) && $useCache) {
            $output = apc_fetch($apcKey);
        }
        else {
            $output = call_user_func($callback, $params);
            if ($doAdd) {
                apc_add($apcKey, $output);
            }
        }
        return $output;
        
    }

}