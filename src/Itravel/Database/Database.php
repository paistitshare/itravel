<?php

namespace Itravel\Database;

use PDO;

class Database
{
    private static $instance = null;
    private $pdo;
    private $error = false;

    private $results;
    private $count;
    private $recordId;

    private function __construct()
    {
        $dbConfig = new DatabaseConfig();
        try {
            $this->pdo =
                new PDO('mysql:host=' . $dbConfig->getHost() . ';dbname=' . $dbConfig->getDatabase() . ';charset=utf8',
                    $dbConfig->getUsername(),
                    $dbConfig->getPassword()
                );

        } catch (\Exception $ex) {
            die("Database connection error: " . $ex->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Inserts data to a specified database $table
     * @param string $table
     * @param array $fields
     * @return int | false
     */
    public function insert($table, $fields = array())
    {
        $keys = implode('`,`', array_keys($fields));
        $values = '';
        foreach (array_values($fields) as $value) {
            $values .= ($values == '' ? '' : ', ') . $this->escape($value);
        }
        //$values = left($values, strlen($values) - 2);

        $sql = "INSERT INTO {$table} (`{$keys}`) VALUES ({$values});";
        if (!$this->query($sql)->error()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    /**
     * Updates a field in the database.
     *
     * $condition1 can be full WHERE string or id
     * $condition2 is optional id value for id
     *
     * @param string $table
     * @param array $fields
     * @param string $condition1
     * @param string $condition2
     * @return Database|boolean
     */
    public function update($table, $fields = array(), $condition1, $condition2 = null)
    {
        $values = '';

        //if condition2 is filled in, then create a WHERE statement
        if ($condition2 != null) {
            $condition1 = " WHERE {$condition1} = " . $this->escape($condition2);
        }

        foreach ($fields as $field => $value) {
            $values .= ($values == '' ? '' : ', ') . "{$field} = " . $this->escape($value);
        }

        $sql = "UPDATE {$table} SET {$values} {$condition1}";
        if (!$this->query($sql)->error()) {
            return $this;
        }
        return false;

    }


    /**
     * Runs a SELECT statement on the database
     * @param string $table
     * @param array $fields
     * @param string $condition1
     * @param string $condition2
     * @return Database|boolean
     */
    public function select($table, $fields, $condition1, $condition2 = null)
    {

        //if condition2 is filled in, then create a WHERE statement
        if ($condition2 != null) {
            $condition1 = " WHERE {$condition1} = " . $this->escape($condition2);
        }

        $sql = "SELECT {$fields} FROM ${table} {$condition1}";
        if (!$this->query($sql)->error()) {
            return $this;
        }
        return false;
    }

    public function selectLimit($table, $fields, $condition, $limit, $offset)
    {

        $sql = "SELECT SQL_CALC_FOUND_ROWS {$fields} FROM {$table} {$condition} LIMIT {$limit} OFFSET {$offset}";

        if (!$this->query($sql, true)->error()) {
            return $this;
        }
        return false;

    }

    /**
     * Delete s field from database
     *
     * $condition1 can be full WHERE string or $id_identifier
     * $condition2 is optional id value for $id_identifier
     *
     * @param string $table
     * @param string $condition1
     * @param string $condition2
     * @return Database|boolean
     */
    public function delete($table, $condition1, $condition2 = null)
    {

        //if condition2 is filled in, then create a WHERE statement
        if ($condition2 != null) {
            $condition1 = " WHERE {$condition1} = " . $this->escape($condition2);
        }

        $sql = "DELETE FROM {$table} {$condition1}";
        if (!$this->query($sql)->error()) {
            return $this;
        }
        return false;

    }

    /**
     * Runs a raw SQL statment on the database
     * @param string $sql
     * @return Database|boolean
     */
    public function raw($sql)
    {
        if (!$this->query($sql)->error()) {
            return $this;
        }
        return false;
    }

    /**
     * Runs query in the database
     * @param string $sql
     * @param bool $paged
     * @return Database
     */
    private function query(String $sql, bool $paged = false)
    {
        $this->error = false;
        $this->count = 0;
        $this->results = null;

        if ($sqlQuery = $this->pdo->query($sql)) {
            $this->results = $sqlQuery->fetchAll(PDO::FETCH_OBJ);
            $this->recordId = $this->pdo->lastInsertId();
            if ($paged == false) {
                $this->count = $sqlQuery->rowcount();
            } else {
                $this->count = $this->pdo->query("SELECT FOUND_ROWS()")->fetchColumn();
            }
        } else {
            $this->error = true;
            if (ENVIRONMENT === 'development') {
                print_r($this->pdo->errorInfo());
                die();
            }
        }
        return $this;
    }

    public function escape($value){
        return $this->pdo->quote($value);
    }

    public function error(){
        return $this->error;
    }

    public function results(){
        return $this->results;
    }

    public function count(){
        return $this->count;
    }

    public function recordId(){
        return $this->recordId;
    }

    public function pdo(){
        return $this->pdo;
    }

}