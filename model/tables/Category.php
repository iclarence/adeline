<?php

/**
 * Description of Category
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Category extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'category';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}