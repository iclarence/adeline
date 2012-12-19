<?php

/**
 * Description of Product Pattern
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class ProductPattern extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'product_pattern';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}