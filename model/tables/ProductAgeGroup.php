<?php

/**
 * Description of Product Age Group
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class ProductAgeGroup extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'product_age_group';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}