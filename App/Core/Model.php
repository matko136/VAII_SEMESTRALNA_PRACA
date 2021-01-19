<?php

namespace App\Core;

use App\Core\DB\Connection;
use PDOException;

/**
 * Class Model
 * Abstract class serving as a simple model example, predecessor of all models
 * Allows basic CRUD operations
 * @package App\Core\Storage
 */
abstract class Model implements \JsonSerializable
{
    private static $connection = null;
    abstract static public function setPkColumn();
    abstract static public function setDbColumns();
    abstract static public function setTableName();


    /**
     * Gets a db columns from a model
     * @return mixed
     */
    private static function getDbColumns()
    {
        return static::setDbColumns();
    }

    /**
     * Reads the table name from a model
     * @return mixed
     */
    private static function getTableName()
    {
        return static::setTableName();
    }

    private static function getPkColumn()
    {
        return static::setPkColumn();
    }


    /**
     * Gets DB connection for other model methods
     * @return null
     * @throws \Exception
     */
    private static function connect()
    {
        self::$connection = Connection::connect();
    }

    /**
     * Return an array of models from DB
     * @param string $whereClause Additional where Statement
     * @param array $whereParams Parameters for where
     * @return static[]
     * @throws \Exception
     */
    static public function getAll(string $whereClause = NULL, array $whereParams = [], string $joinTable = NULL)
    {
        self::connect();
        try {
            $sql = "SELECT * FROM " . self::getTableName() . ($joinTable=='' ? '' : " " . $joinTable) . ($whereClause=='' ? '' : " WHERE $whereClause");

            $stmt = self::$connection->prepare($sql);
            $stmt->execute($whereParams);

            $dbModels = $stmt->fetchAll();
            $models = [];
            foreach ($dbModels as $model) {
                $tmpModel = new static();
                $data = array_fill_keys(self::getDbColumns(), null);
                foreach ($data as $key => $item) {
                    $tmpModel->$key = $model[$key];
                }
                $models[] = $tmpModel;
            }
            return $models;
        } catch (PDOException $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    /**
     * Gets one model by primary key
     * @param $id
     * @throws \Exception
     */
    static public function getOne($id, string $whereClause = NULL)
    {
        if ($id == null) return null;

        self::connect();
        try {

            $sql = "SELECT * FROM " . self::getTableName() . ($whereClause=='' ? " WHERE " . self::getPkColumn() . "=?" : " WHERE $whereClause");
            $stmt = self::$connection->prepare($sql);
            $stmt->execute([$id]);
            $model = $stmt->fetch();
            if ($model) {
                $data = array_fill_keys(self::getDbColumns(), null);
                $tmpModel = new static();
                foreach ($data as $key => $item) {
                    $tmpModel->$key = $model[$key];
                }
                return $tmpModel;
            } else {
                throw new \Exception('Record not found!');
            }
        } catch (PDOException $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    /**
     * Saves the current model to DB (if model id is set, updates it, else creates a new model)
     * @return mixed
     */
    public function save(array $pkS = [], string $whereClause = NULL)
    {
        self::connect();
        try {
            $data = array_fill_keys(self::getDbColumns(), null);
            foreach ($data as $key => &$item) {
                $item = $this->$key;
            }
            $notYet = true;
            if(count($pkS) == 0){
                if($data[self::getPkColumn()] != null)
                    $notYet = false;
            }
            /*foreach ($pkS as $pk) {
                if($data[$pk] == null) {
                    $notYet = true;
                }
            }*/
            if ($notYet) {
                $arrColumns = array_map(fn($item) => (':' . $item), array_keys($data));
                $columns = implode(',', array_keys($data));
                $params = implode(',', $arrColumns);
                $sql = "INSERT INTO " . self::getTableName() . " ($columns) VALUES ($params)";
                $stmt = self::$connection->prepare($sql);
                $stmt->execute($data);
                return self::$connection->lastInsertId();
            } else {
                $arrColumns = array_map(fn($item) => ($item . '=:' . $item), array_keys($data));
                $columns = implode(',', $arrColumns);

                $sql = "UPDATE " . self::getTableName() . " SET $columns" .  ($whereClause=='' ? " WHERE " . self::getPkColumn() . "=:" .  self::getPkColumn() : " WHERE $whereClause");
                $stmt = self::$connection->prepare($sql);
                $stmt->execute($data);
                return $data[self::getPkColumn()];
            }
        } catch (PDOException $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    /**
     * Deletes current model from DB
     * @throws \Exception If model not exists, throw an exception
     */
    public function delete(string $whereClause = NULL)
    {
        if ($this->{self::getPkColumn()} == null) {
            return;
        }
        self::connect();
        try {
            $sql = "DELETE FROM " . self::getTableName() . ($whereClause=='' ? " WHERE " . self::getPkColumn() . "=?" : " WHERE $whereClause");
            $stmt = self::$connection->prepare($sql);
            if($whereClause=='') {
                $stmt->execute([$this->{self::getPkColumn()}]);
            } else {
                $stmt->execute([]);
            }
            if ($stmt->rowCount() == 0) {
                throw new \Exception('Model not found!');
            }
        } catch (PDOException $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    /**
     * @return null
     */
    public static function getConnection()
    {
        return self::$connection;
    }

    /**
     * Default implementation of JSON serialize method
     * @return array|mixed
     */

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}