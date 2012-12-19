<?php

/**
 * Description of Order
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Order extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'order';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}