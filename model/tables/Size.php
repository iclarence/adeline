<?php

/**
 * Description of Size
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Size extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'size';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}