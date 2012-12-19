<?php

/**
 * Description of Brand
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Brand extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'brand';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}