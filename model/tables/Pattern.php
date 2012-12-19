<?php

/**
 * Description of Pattern
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Pattern extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'pattern';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}