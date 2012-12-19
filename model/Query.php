<?php

/**
 * SQL query handler.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Query {

    /**
     * The prefix.
     */
    const PREFIX = ':';

    /**
     * The SQL string.
     *
     * @var string
     */
    private $sql;

    /**
     * The constructor.
     *
     * @param string $sql
     */
    public function __construct($sql) {
        $this->sql = $sql;
    }

    /**
     * Binding a variable to the SQL.
     *
     * @param string $key
     * @param string $variable
     * @param bool $addQuotes
     * @param bool $escape
     * @param Object $object
     * @param callback $escapeFunction
     * @return bool
     */
    public function bindVariable(
        $key,
        $variable,
        $addQuotes = TRUE,
        $escape = FALSE,
        $object = NULL,
        $escapeFunction = 'realEscapedString'
    ) {
        $values = explode(self::PREFIX . $key, $this->sql);
        $delimiter = $addQuotes ?
            Utils::encloseInQuotes(
                $escape ?
                    call_user_func(
                        $object == NULL ? $escapeFunction : array($object, $escapeFunction),
                        $variable
                    ) :
                    $variable
            ) :
            $variable;
        if (!is_string($delimiter) && !is_numeric($delimiter) && ($delimiter != NULL)) {
            echo "<br />Key {$key}. This should be a string..<br />\n";
            Utils::dump($delimiter);
        }
        $this->sql = implode($delimiter, $values);
        return count($values) > 1;
    }

    /**
     * Same as bindVariable, but instead for a field name: can be enclosed in backticks or not.
     *
     * @param string $key
     * @param string $fieldName
     * @param bool $addBackticks
     * @param bool $escape
     * @param Object $object
     * @param callback $escapeFunction
     * @return bool
     */
    public function bindFieldName(
        $key,
        $fieldName,
        $addBackticks = TRUE,
        $escape = FALSE,
        $object = NULL,
        $escapeFunction = 'realEscapedString'
    ) {
        $values = explode(self::PREFIX . $key, $this->sql);
        $delimiter = $addBackticks ? 
            Utils::encloseInBackticks(
                $escape ?
                    call_user_func(
                        $object == NULL ? $escapeFunction : array($object, $escapeFunction),
                        $fieldName
                    ) :
                    $fieldName
            ) :
            $fieldName;
        $this->sql = implode($delimiter, $values);
        return count($values) > 1;
    }

    /**
     * Same as bindVariable and bindFieldName, but instead for a simple text string.
     *
     * @param string $key
     * @param string $textString
     * @return bool
     */
    public function bindTextString($key, $textString) {
        $values = explode(self::PREFIX . $key, $this->sql);
        $this->sql = implode($textString, $values);
        return count($values) > 1;
    }

    /**
     * Getting the SQL string.
     * @return string
     */
    public function getSql() {
        return $this->sql;
    }

}