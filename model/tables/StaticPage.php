<?php

/**
 * Description of Static Page
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class StaticPage extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'static_page';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}