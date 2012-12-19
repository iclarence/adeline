<?php

/**
 * Description of Customer
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Customer extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'customer';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}