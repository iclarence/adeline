<?php

/**
 * Description of Google Product Category
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class GoogleProductCategory extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'google_product_category';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}