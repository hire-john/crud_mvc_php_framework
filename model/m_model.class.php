<?php

/**
 * 
 * m_model is the core model class and should NOT BE CHANGED (unless adding generic database calls). 
 * All generic database functionality should be piped through this class.
 * Interaction with this class should take place in the extended model: m_extended.class.php
 * 
 *
 */
class m_model {

    public $error = false;
    private $PDO;
    private $routeStatement;
    private $routePathStatement;

    function __construct() {
        try {
            $dsn = "mysql:host=" . APPLICATION_DATABASE_HOST . ";dbname=" . APPLICATION_DATABASE_SCHEMA;
            $this->PDO = new PDO($dsn, APPLICATION_DATABASE_USERNAME, APPLICATION_DATABASE_PASSWORD);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }

        if (!$this->error) {
            // set the get route prepared statements
            $this->routeStatement = $this->PDO->prepare("SELECT * FROM routes WHERE route=? AND application=?");
            $this->routePathStatement = $this->PDO->prepare("SELECT * FROM routes WHERE route=? AND path=? AND application=?");
        }
    }

    /**
     * 
     *
     * Generic insert statement
     *
     * @param $array array       	
     * @param $table string       	
     *
     */
    protected function createNewRecord($array, $table) {
        try {
            $values = array();
            $sql = "INSERT INTO $table" . " (";
            foreach ($array as $key => $value) {
                $sql .= $key . ",";
                $key = ":" . $key;
                $values [$key] = $value;
            }
            $sql = rtrim($sql, ",");
            $sql .= ") values(";
            foreach ($values as $key => $value) {
                $sql .= $key . ",";
            }
            $sql = rtrim($sql, ",");
            $sql .= ");";
            $statement = $this->PDO->prepare($sql);
            $result = $statement->execute($values);
            return $result;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     *
     *
     * Generic delete statement
     *
     * @param $id int       	
     * @param $column string       	
     * @param $table string       	
     *
     */
    protected function deleteRecordWhereID($id, $column, $table) {
        try {
            $sql = "DELETE FROM $table WHERE $column=?";
            return $this->PDO->prepare($sql)->execute(array($id));
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     *
     * Generic select statement
     *
     * @param $item string       	
     * @param $table string       	
     * @param $column string       	
     * @param $value string       	
     */
    protected function selectItemWhereColEquals($item, $table, $column, $value) {
        try {
            $sql = "SELECT $item FROM $table WHERE $column=?";
            $statement = $this->PDO->prepare($sql);
            $result = $statement->execute(array($value));
            if ($result) {
                return $statement->fetch();
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * This uses the prepared stored procedures to get route information.
     * There are two statements - one for calls with just the route variable
     * and one for calls where a path is requested as well.
     *
     * @param $route string       	
     * @param $path string       	
     */
    public function getRouteFromDB($route, $path) {
        try {
            if ($path) {
                $result = $this->routePathStatement->execute(array($route, $path, APPLICATION_NAME));
                if ($result) {
                    $result = $this->routePathStatement->fetch();
                    return $result;
                }
            } else {
                $result = $this->routeStatement->execute(array($route, APPLICATION_NAME));
                if ($result) {
                    $result = $this->routeStatement->fetch();
                    return $result;
                }
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function getSiteSettings($name) {
        return $this->selectItemWhereColEquals("ALL", "sites", "name", $name);
    }

}