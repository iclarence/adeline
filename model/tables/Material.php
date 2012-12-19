<?php

/**
 * Description of Material
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Material extends ActiveRecord {

    /**
     * The table name.
     */
    const TABLE = 'material';

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        parent::__construct($fields);
    }

}