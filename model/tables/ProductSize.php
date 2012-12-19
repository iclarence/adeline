<?php

/**
 * Description of Product Size
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class ProductSize extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'product_size';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}