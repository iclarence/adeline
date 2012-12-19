<?php

/**
 * Description of Subcategory
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Subcategory extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'subcategory';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}