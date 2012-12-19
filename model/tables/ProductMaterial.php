<?php

/**
 * Description of Product Material
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class ProductMaterial extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'product_material';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}