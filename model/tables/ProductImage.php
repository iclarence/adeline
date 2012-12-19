<?php

/**
 * Description of Product Image
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class ProductImage extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'product_image';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}