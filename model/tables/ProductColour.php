<?php

/**
 * Description of Product Colour
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class ProductColour extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'product_colour';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}