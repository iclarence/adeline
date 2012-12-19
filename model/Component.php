<?php

/**
 * Description of Component
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
abstract class Component {

    /**
     * An associative array, whose elements correspond to say fields in the database table.
     * The array keys are strings in camel case.
     *
     * @var array
     */
    protected $fields = array();

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        $this->fields = $fields;
    }

    /**
     * Accessing $this->property will access $this->fields["property"].
     *
     * @param string $fieldKey
     * @return mixed
     */
    public function __get($fieldKey) {
        return $this->fields[$fieldKey];
    }

    /**
     * Assigning $this->property will assign $this->fields["property"].
     *
     * @param string $fieldkey
     * @param mixed $field
     * @return bool
     */
    public function __set($fieldKey, $field) { 
        return $this->fields[$fieldKey] = $field;
    }

    /**
     * Unsetting $this->property will unset $this->fields["property"].
     *
     * @param string $fieldKey
     */
    public function __unset($fieldKey) {
        unset($this->fields[$fieldKey]);
    }

    /**
     * Checking whether $this->property is set will check whether $this->fields["property"] is set.
     *
     * @param string $fieldKey
     * @return bool
     */
    public function __isset($fieldKey) {
        return isset($this->fields[$fieldKey]);
    }

    /**
     * Calling getProperty() or setProperty($value) will respectively get or set $this->fields["property"].
     * Also used by sub-classes (ViewHtmlElement) to add HTML elements: addProperty($value) adds element <property>$value</property>.
     * Can also instantiate a class: genProperty($value) is the same as new Property($value).
     * 
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, array $arguments) {
        $action = substr($method, 0, 3);
        $prop = substr($method, 3);
        $property = lcfirst($prop);
        if ($action == 'get' || $action == 'set') {
            foreach ($this->fields as $fieldKey => $field) {
                if (Utils::underscoreToCamelCase($fieldKey) == $property) {
                    $selectedFieldKey = $fieldKey;
                    break;
                }
            }
        }
        switch ($action) {
            case 'get':
                return $this->fields[$selectedFieldKey];
            case 'set':
                return $this->fields[$selectedFieldKey] = current($arguments);
            default:
                trigger_error("Unknown method {$method}", E_USER_ERROR);
                return FALSE;
        }
    }
    
    /**
     * Bulk uploading an associative array.
     * 
     * @param array $fields  
     * @return bool
     */
    public function setAll($fields) {
        if (!is_array($fields)) {
            return FALSE;
        }
        if (count($fields == 0)) {
            return FALSE;
        }
        foreach ($fields as $fieldKey => $field) {
            if (is_numeric($fieldKey)) {
                return FALSE;
            }
            $set = 'set' . Utils::underscoreToCamelCase($fieldKey, TRUE);
            $this->$set($field);
        }
        return TRUE;
    }
    
    /**
     * Returning all the data.
     * 
     * @return mixed
     */
    public function getAll() {
        return $this->fields;
    }

}

