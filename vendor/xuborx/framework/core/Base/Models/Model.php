<?php

namespace Xuborx\Framework\Base\Models;

class Model
{

    private $db;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct() {
        $this->db = DB::instance();
        $this->getTableName($this);
    }

    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->queryWithData($sql);
    }

    public function findOne($primaryKey) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = $primaryKey";
        return $this->db->queryWithData($sql);
    }

    public function add($valuesArray) {
        if (is_array($valuesArray) && !empty($valuesArray)) {
            $sql = "INSERT INTO {$this->table} (";
            foreach ($valuesArray as $key => $value) {
                $sql .= $key . ', ';
            }
            $sql = substr($sql, 0, -2);
            $sql .= ") VALUES (";
            foreach ($valuesArray as $value) {
                $sql .= '\'' . $value . '\'' . ', ';
            }
            $sql = substr($sql, 0, -2);
            $sql .= ")";
            $query =  $this->db->query($sql);
            if ($query) {
                return $query;
            } else {
                throw new \Exception("Failed to add new record to table {$this->table}", 500);
            }
        } else {
            throw new \Exception('Array of values is not correct for add() method', 500);
        }
    }

    public function findWhere($conditions, $select = []) {
        if (is_array($conditions) && !empty($conditions)) {
            $sql = "SELECT ";
            if (empty($select)) {
                $sql .= "*";
            } else {
                foreach ($select as $item) {
                    $sql .= "$item, ";
                }
                $sql = substr($sql, 0, -2);
            }
            $sql .= " FROM {$this->table} WHERE ";
            foreach ($conditions as $key => $value) {
                $sql .= "$key $value[0] '$value[1]' AND ";
            }
            $sql = substr($sql, 0, -4);
        } else {
            throw new \Exception('Conditions are not correct for findWhere() method');
        }
        return $this->db->queryWithData($sql);
    }

    public function update($valuesArray, $conditions = []) {
        if (is_array($valuesArray) && !empty($valuesArray)) {
            $sql = "UPDATE {$this->table} SET ";
            foreach ($valuesArray as $key => $value) {
                $sql .= "$key = '$value', ";
            }
            $sql = substr($sql, 0, -2);
            if (is_array($conditions) && !empty($conditions)) {
                $sql .= " WHERE ";
                foreach ($conditions as $key => $value) {
                    $sql .= "$key $value[0] '$value[1]' AND ";
                }
                $sql = substr($sql, 0, -4);
            }
            return $this->db->query($sql);
        } else {
            throw new \Exception('Array of values is not correct for update() method');
        }
    }

    public function query($sql) {
        return $this->db->query($sql);
    }

    public function queryWithData($sql) {
        return $this->db->queryWithData($sql);
    }

    private function getTableName($object) {
        if (!empty($object->table)) {
            $tableName = $object->table;
        } else {
            $tableName = explode('\\', get_class($object));
            $tableName = strtolower(str_replace('Model', '', end($tableName))) . 's';
        }
        $this->table = $tableName;
    }

}