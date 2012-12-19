<?php

/**
 * Description of Order Product
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class OrderProduct extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'order_product';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}