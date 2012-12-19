<?php

/**
 * Description of Colour
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Colour extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'colour';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}