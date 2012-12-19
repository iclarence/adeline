<?php

/**
 * The active record class.
 *
 * The naming convention which this class assumes is as follows:
 * The table names are lowercase with underscores (e.g. page_type).
 * The corresponding classes are pascal case (e.g. PageType).
 * Names of all foreign keys contain the string '_ref_',
 * and the string following it is the name of the table referenced by the key.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class ActiveRecord extends Component {

    /**
     * The table name.
     * A dummy name given here, since this class does not correspond to a database table.
     * However, its subclasses do correspond to tables,
     * and in each case the table name will be replaced using late static binding.
     */
    const TABLE = 'record';

    /**
     * The following properties are associative arrays, whose elements correspond to each field in the database.
     * The key for each is the column name, converted to camel case.
     *
     * The value of $fields (in Component) is the value of the field, unless the column is a foreign key,
     * in which case the value is an object.
     *
     * The value of $areNumeric is a boolean: TRUE if the data type of the field is numeric
     * (e.g. INT, FLOAT, etc), FALSE otherwise.
     *
     * @var array
     */
    protected $areNumeric;

    /**
     * The value of $areNull is a boolean: TRUE if the field may be null in the database,
     * FALSE otherwise.
     *
     * @var array
     */
    protected $areNull;

    /**
     * The value of $areMulKeys is a boolean: TRUE if the field is a multiple key in the database,
     * FALSE otherwise.
     *
     * @var array
     */
    protected $areMulKeys;

    /**
     * The value of $isPrimaryKey is a boolean: TRUE if the field isb the primary key,
     * and auto increments in the database, FALSE otherwise.
     *
     * @var array
     */
    protected $isPrimaryKey;

    /**
     * The constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = array()) {
        /**
         * Now examine the table columns, to see which ones have numeric datatype:
         * inserting or updating those fields will not require quotes, as do the others.
         */
        $apcKey = static::TABLE . 'columns';
        $params = array('table' => static::TABLE);
        $callback = function($params) {
            $query =  new Query('
                SHOW COLUMNS
                FROM :table;
            ');
            $query->bindFieldName('table', $params['table']);
            return System::getDB()->queryArray($query);         
        };        
        $columns = Utils::apcCache($apcKey, $callback, STORED_AS_CACHE == YES, $params);
        
        $this->areNumeric = array();
        $this->areNull = array();
        $this->areMulKeys = array();
        $this->isPrimaryKey = array();
        /**
         * Looping over each field.
         */
        if (is_array($columns)) {
            foreach ($columns as $column) {
                $fieldKey = $column['Field'];
                $set = 'set' . Utils::underscoreToCamelCase($fieldKey, TRUE);
                // echo $set . "<br />\n";
                /**
                 * Initialise all the fields: if not set, set to null.
                 */
                if (isset($fields[$fieldKey])) {
                    $this->$set($fields[$fieldKey]);
                }
                // $this->fields[$fieldKey] = isset($fields[$fieldKey]) ? $fields[$fieldKey] : NULL;

                /**
                 * Fields with numerical values, rather than string.
                 */
                $this->areNumeric[$fieldKey] = Utils::isNumericalMySqlDataType($column['Type']);

                /**
                 * Fields which may be null in the database.
                 */
                $this->areNull[$fieldKey] = $column['Null'] == 'YES';

                /**
                 * Foreign keys.
                 */
                $this->areMulKeys[$fieldKey] = $column['Key'] == 'MUL';

                /**
                 * Primary key, also auto-increment.
                 */
                $this->isPrimaryKey[$fieldKey] = ($column['Key'] == 'PRI') && ($column['Extra'] == 'auto_increment');
            }
        }
    }

    /**
     * Loading a record from the database, if the id is specified: could be another column (such as 'name').
     *
     * @param mixed $searchField
     * @param string $searchFieldKey
     * @param bool $cascade
     */
    public function load($searchField, $searchFieldKey = 'id', $cascade = FALSE) {
        if (!$searchField) {
            return NULL;
        }
        
        $apcKey = static::TABLE . 'fields_' . $searchFieldKey . '_' . $searchField;
        $params = array(
            'table' => static::TABLE, 
            'search_field_key' => $searchFieldKey, 
            'search_field' => $searchField, 
            'numeric' => $this->areNumeric[$searchFieldKey]
        );
        $callback = function($params) {
            $database = System::getDB();
            $query = new Query('
                SELECT *
                FROM :table
                WHERE :searchFieldKey = :searchField
                LIMIT 1;
            ');
            $query->bindFieldName('table', $params['table']);
            $query->bindFieldName('searchFieldKey', $params['search_field_key'], TRUE, TRUE, $database);
            $query->bindVariable('searchField', $params['search_field'], !$params['numeric'], !$params['numeric'], $database);
            return $database->queryArray($query, TRUE);      
        };        
        $this->fields = Utils::apcCache($apcKey, $callback, STORED_AS_CACHE == YES, $params);

        if (count($this->fields) == 0) {
            return NULL;
        }

        /**
         * Getting the foreign keys for the table into an associative array $indexes,
         * where the key is the column name, and the value is the table which the foreign key references.
         */
        $indexes = self::getIndexes();

        /**
         * Looping over each field. $fieldKey is the column name in the database.
         */
        if (is_array($this->fields)) {
            foreach ($this->fields as $fieldKey => $field) {
                if ($field != NULL) {

                    /**
                     * Strip the added slashes from non-numeric fields.
                     */
                    if (!$this->areNumeric[$fieldKey]) {
                        $this->fields[$fieldKey] = stripslashes($field);
                    }

                    /**
                     * If the field is a foreign key: it will reference another table.
                     */
                    if (isset($indexes[$fieldKey])) {

                        /**
                         * Find the table which the foreign key references, according to the naming convention.
                         */
                        $table = $indexes[$fieldKey];

                        /**
                         * Find the class corresponding to the table which the foreign key references.
                         */
                        $class = Utils::underscoreToCamelCase($table, TRUE);

                        /**
                         * Instantiate the class, and assign the field to it.
                         */
                        $this->fields[$fieldKey] = new $class;

                        /**
                         * If 'cascading', then populate the entire class from its table.
                         * This should only be done when absolutely necessary, because that could be time consuming.
                         */
                        if ($cascade) {
                            $this->fields[$fieldKey]->load($field, 'id', FALSE);
                        }

                        /**
                         * Otherwise, just assign the id value.
                         */
                        else {
                            $this->fields[$fieldKey]->id = $field;
                        }
                    }
                }
            }
        }
    }     

    /**
     * If a record is only loaded as far as its id, then load the whole record.
     * 
     * @param bool $cascade
     */
    public function loadAll($cascade = FALSE) {
        if (is_numeric($this->id)) {
            $this->load($this->id, 'id', $cascade);
        }
    }

    /**
     * Searching for records on a search term $searchFieldKey whose value is $searchField.
     *
     * @param mixed $searchField
     * @param string $searchFieldKey
     * @param bool $isNumeric
     * @param bool $cascade
     * @param object $object
     * @param bool $prioritise
     * @return array
     */
    public static function search(
        $searchField,
        $searchFieldKey,
        $isNumeric = TRUE,
        $cascade = FALSE,
        $object = NULL,
        $prioritise = FALSE
    ) {
        $class = Utils::underscoreToCamelCase(static::TABLE, TRUE);

        // echo "Searching table `" . static::TABLE . "` for all records where `" . $searchFieldKey . "` is equal to '" . ($searchField instanceof $class ? $searchField->getId() : $searchField) . "'<br />\n";

        if (!isset($searchFieldKey)) {
            return FALSE;
        }

        /**
         * Select a given row from the table in the database.
         */
        $searchField = $searchField ? ($searchField instanceof $class ? $searchField->getId() : $searchField) : NULL;
        
        $apcKey = static::TABLE . 'search_' . $searchFieldKey . '_' . ($searchField == NULL ? 'NULL' : $searchField) .
            static::apcKeySuffix($object);
        $params = array(
            'table' => static::TABLE, 
            'search_field_key' => $searchFieldKey, 
            'search_field' => $searchField, 
            'is_numeric' => $isNumeric, 
            'search_where' => static::searchWhere($object), 
            'prioritise' => $prioritise
        );
        $callback = function($params) {
            $database = System::getDB();
            $query = new Query('
                SELECT `id`
                FROM :table
                WHERE :searchFieldKey :equals :searchField :searchWhere
                :orderby;
            ');
            $query->bindFieldName('table', $params['table']);
            $query->bindFieldName('searchFieldKey', $params['search_field_key'], TRUE, TRUE, $database);
            if ($params['search_field']) {
                $query->bindTextString('equals', '=');
                $query->bindVariable('searchField', $params['search_field'], !$params['is_numeric'], !$params['is_numeric'], $database);
            }
            else {
                $query->bindTextString('equals', 'IS');
                $query->bindVariable('searchField', 'NULL', FALSE);
            }
            $query->bindTextString('searchWhere', $params['search_where']);
            $query->bindTextString('orderby', ($params['prioritise'] ? 'ORDER BY `priority` ASC' : ''));
            
            return $database->queryArray($query);
        };        
        $values = Utils::apcCache($apcKey, $callback, STORED_AS_CACHE == YES, $params);
        
        $records = array();
        if (is_array($values)) {
            foreach ($values as $valueKey => $value) {
                $records[$valueKey] = new $class();
                if ($cascade) {
                    $records[$valueKey]->load($value['id']);
                }
                else {
                    $records[$valueKey]->id = $value['id'];
                }
            }
        }
        return $records;
    }

    /**
     * Provides a 'where' clause for the search method to be used in subclasses by late static binding.
     *
     * @param Record $object
     * @param bool $includeWhere
     * @return string
     */
    protected static function searchWhere($object, $includeWhere = FALSE) {
        return '';
    }

    /**
     * Provides a suffix for APC keys relating to queries where 'searchWhere' is used.
     *
     * @param Record $object
     * @return string
     */
    protected static function apcKeySuffix($object) {
        return '';
    }

    /**
     * Searching for an array of objects corresponding to a foreign key in a table.
     *
     * @param mixed $searchField
     * @param string $searchedField
     * @param string $searchFieldKey
     * @param bool $prioritise
     * @return array
     */
    public static function searchFor($searchFieldKey, $searchField, $searchedField, $prioritise = FALSE) {
        
        // echo "Searching table `" . static::TABLE . "` for values of `" . $searchedField . "` where `" . $searchFieldKey . "` is equal to '" . $searchField . "'<br />\n";

        /**
         * Ensuring that the searched field is a foreign key, if not return false.
         */
        $indexes = self::getIndexes();
        if (!isset($indexes[$searchedField])) {
            return FALSE;
        }

        /**
         * Finding the class corresponding to the table to which the foreign key references.
         */
        $class = Utils::underscoreToCamelCase($indexes[$searchedField], TRUE);

        /**
         * Finding the name of the property of this class corresponding to the foreign key.
         */
        //$property = Utils::underscoreToCamelCase($searchedField);
        $property = $searchedField;

        /**
         * Searching this table for relevent records.
         */
        $records = static::search($searchField, $searchFieldKey, TRUE, TRUE, NULL, $prioritise);

        /**
         * Initialise the output array.
         */
        $output = array();

        /**
         * Looping over each record.
         */
        if (is_array($records)) {
            foreach ($records as $recordKey => $record) {
                /**
                 * Instantiate the class, and assign an array element to it.
                 */
                $output[$recordKey] = new $class;

                /**
                 * Populate the class.
                 */
                $output[$recordKey]->load($record->$property->getId(), 'id', FALSE);
            }
        }

        /**
         * Return the output array.
         */
        // echo "Found " . count($output) . "<br />\n";
        return $output;
    }

    /**
     * Saving a record to the database, and returning the $id value.
     *
     * @param array $fields
     * @return int
     */
    public function save() {
        $database = System::getDB();

        /**
         * If the id field is not set, then insert a new row with the fields that are set.
         */
        if ($this->fields['id'] == NULL) {
            $sql = '
                INSERT INTO :table (
            ';
            $count = 0;
            if (is_array($this->fields)) {
                foreach ($this->fields as $fieldKey => $field) {
                    if ((($field != NULL) || (!$this->areNull[$fieldKey])) && (!$this->isPrimaryKey[$fieldKey])) {
                        $sql .= $count == 0 ? '' : ', ';
                        $sql .= '`' . $database->realEscapedString($fieldKey) . '`';
                        $count++;
                    }
                }
            }
            $sql .= '
                ) VALUES (
            ';
            $count = 0;
            if (is_array($this->fields)) {
                foreach ($this->fields as $fieldKey => $field) {
                    if ((($field != NULL) || (!$this->areNull[$fieldKey])) && (!$this->isPrimaryKey[$fieldKey])) {
                        $sql .= ($count == 0 ? '' : ',
                            ') . ':' . $database->realEscapedString($fieldKey);
                        $count++;
                    }
                }
            }
            $sql .= ');';
            $this->fields['id'] = $database->queryId($this->makeQuery($sql, $database));
        }

        /**
         * Otherwise update that row.
         */
        else {
            $sql = '
                UPDATE :table
                SET
            ';
            $count = 0;
            if (is_array($this->fields)) {
                foreach ($this->fields as $fieldKey => $field) {
                    if ($fieldKey != 'id') {
                        $sql .= ($count == 0 ? '' : ',
                            ');
                        $sql .= '`' . $database->realEscapedString($fieldKey);
                        $sql .= '` = :' . $database->realEscapedString($fieldKey);
                        $count++;
                    }
                }
            }
            $sql .= '
                WHERE `id` = :id;
            ';
            $database->queryOnly($this->makeQuery($sql, $database));
        }
        apc_clear_cache('user');
        return $this->fields['id'];
    }

    /**
     * Forming the query for inserting or updating the record.
     *
     * @param string $sql
     * @return Query
     */
    private function makeQuery($sql, Database $database) {
        $indexes = self::getIndexes();
        $query = new Query($sql);
        $query->bindFieldName('table', static::TABLE);
        if (is_array($this->fields)) {
            foreach ($this->fields as $fieldKey => $field) {
                if (isset($indexes[$fieldKey])) {
                    $class = Utils::underscoreToCamelCase($indexes[$fieldKey], TRUE);
                    $field = $field instanceof $class ? $field->getId() : $field;
                }
                $notNumeric = !$this->areNumeric[$fieldKey];
                if ($field == NULL && $this->areNull[$fieldKey]) {
                    $query->bindVariable($fieldKey, 'NULL', FALSE);
                }
                else if ($field != NULL) {
                    $query->bindVariable(
                        $fieldKey,
                        $field,
                        $notNumeric,
                        $notNumeric,
                        $database
                    );
                }
                else if ((!$this->areNull[$fieldKey]) && (!$this->isPrimaryKey[$fieldKey])) {
                    if ($notNumeric) {
                        $query->bindVariable($fieldKey, '');
                    }
                    else {
                        $query->bindVariable($fieldKey, 0, FALSE);
                    }
                }
            }
        }
        return $query;
    }

    /**
     * Deleting a record from the database.
     *
     * @param integer $id
     * @return bool
     */
    public static function delete($id) {
        apc_clear_cache('user');

        /**
         * Delete a given row from the table in the database.
         */
        $query = new Query('
            DELETE
            FROM :table
            WHERE `id` = :id;
        ');
        $query->bindFieldName('table', static::TABLE);
        $query->bindVariable('id', $id, FALSE);
        return System::getDB()->queryOnly($query);
    }

    /**
     * Retrieving the foreign keys to the table, according to the naming convention.
     *
     * @return array
     */
    protected static function getIndexes() {

        /**
         * Retrieving all the keys in the table.
         */
        $apcKey = static::TABLE . 'keys';
        $params = array('table' => static::TABLE);
        $callback = function($params) {
            $query = new Query ('
                SHOW KEYS
                FROM :table;
            ');
            $query->bindFieldName('table', $params['table']);
            return System::getDB()->queryArray($query);
        };        
        $indexes = Utils::apcCache($apcKey, $callback, STORED_AS_CACHE == YES, $params);

        /**
         * If there are none, return.
         */
        if (count($indexes) == 0) {
            return FALSE;
        }

        /**
         * Otherwise, loop over each key.
         */
        $output = array();
        if (is_array($indexes)) {
            foreach ($indexes as $index) {
                $keyName = $index['Key_name'];
                $parts = explode('_ref_', $keyName);
                if (count($parts) > 1) {
                    $output[$index['Column_name']] = $parts[1];
                }
            }
        }
        return $output;
    }

    /**
     * Return a list of the entire table.
     * Setting $activeOnly to TRUE will return just the rows where `active` = 1.
     * Setting $prioritise to TRUE will display in descending (by default) order of `priority`.
     * Setting $ascending to TRUE will display ascending order of `priority`.
     *
     * @params bool $activeOnly
     * @params bool $prioritise
     * @return array
     */
    public static function getList($activeOnly = FALSE, $prioritise = FALSE, $ascending = FALSE) {
        $apcKey = static::TABLE . 'list_' . ($activeOnly ? '1' : '0') . ($prioritise ? '1' : '0') . ($ascending ? '1' : '0');
        $params = array(
            'table' => static::TABLE, 
            'active_only' => $activeOnly, 
            'prioritise' => $prioritise, 
            'ascending' => $ascending
        );
        $callback = function($params) {
            $query = new Query('
                SELECT *
                FROM :table :where :order;
            ');
            $query->bindFieldName('table', $params['table']);
            $query->bindTextString('where', $params['active_only'] ? 'WHERE `active` = 1' : '');
            if ($params['ascending']) {
                $query->bindTextString('order', $params['prioritise'] ? 'ORDER BY `priority` ASC' : '');
            }
            else {
                $query->bindTextString('order', $params['prioritise'] ? 'ORDER BY `priority` DESC' : '');
            }
            return System::getDB()->queryArray($query);
        };        
        return Utils::apcCache($apcKey, $callback, STORED_AS_CACHE == YES, $params);
    }

    /**
     * Returning an associative array listing all the field parameters.
     * If any of the fields is an object, then just return the id value instead of the object.
     * 
     * @return array
     */
    public function getFields() {
        $output = array();
        $indexes = self::getIndexes();
        if (is_array($this->fields)) {
            foreach ($this->fields as $fieldKey => $field) {
                $output[$fieldKey] = $field;
                if (isset($indexes[$fieldKey])) {
                    $class = Utils::underscoreToCamelCase($indexes[$fieldKey], TRUE);
                    if ($field instanceof $class) {
                        $output[$fieldKey] = $field->getId();
                    }
                }
            }
        }
        return $output;
    }

    /**
     * Listing of field parameters from an array of records.
     * 
     * @param array $records
     * @return array
     */
    public static function getFieldsFromRecords($records) {        
        $class = get_class();
        if (is_array($records)) {
            $output = array();
            foreach ($records as $recordKey => $record) {
                if ($record instanceof $class) {
                    $output[] = $record->getFields();
                }
            }
            return $output;
        }
        return NULL;         
    }

    /**
     * Getting record parameters for passing into a view.
     * Differs from getFields() in that in subclasses, other parameters are added
     * when appropriate for the purpose of passing them into the view.
     *
     * @return array
     */
    public function getViewFields() {
        return $this->getFields();
    }
    
    /**
     * Getting all viewfields from the Id value of a given class.
     * 
     * @param integer $id
     * @return array
     */
    public static function getFieldsFromId($id) {
        $class = static::TABLE;
        $object = new $class;
        $object->load($id);
        return $object->getViewFields();
    }

}