<?php

/**
 * Description of Payment
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Payment extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'payment';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}