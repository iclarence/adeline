<?php

/**
 * Description of Age Group
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class AgeGroup extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'age_group';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}