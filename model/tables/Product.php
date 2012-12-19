<?php

/**
 * Description of Product
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Product extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'product';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}