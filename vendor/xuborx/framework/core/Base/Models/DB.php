<?php

namespace Xuborx\Framework\Base\Models;

use RedBeanPHP\R;
use Xuborx\Framework\Traits\SingletonTrait;

class DB
{

    use SingletonTrait;

    private $db;

    private function __construct() {
        if (USE_PHP_REDBEAN) {
            $this->redBeanConnect();
        } else {
            $this->pdoConnect();
        }
    }

    private function redBeanConnect() {
        $connectionData = require_once CONF_DIR . '/db.php';
        R::setup("{$connectionData['type']}:host={$connectionData['host']};port={$connectionData['port']}; dbname={$connectionData['name']}",$connectionData['username'],$connectionData['password']);
        if (R::testConnection()) {
            R::freeze(true);
        } else {
            throw new \Error('Database connection failed', 500);
        }
    }

    private function pdoConnect() {
        $connectionData = require_once CONF_DIR . '/db.php';
        $options = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];
        $this->db = new \PDO("{$connectionData['type']}:host={$connectionData['host']};port={$connectionData['port']}; dbname={$connectionData['name']}",$connectionData['username'],$connectionData['password'], $options);
    }

    public function query($sql) {
        if (!USE_PHP_REDBEAN) {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute();
        } else {
            throw new \Exception('Disable using the RedBeanPHP library to use methods of model of Xuborx Framework', 500);
        }

    }

    public function queryWithData($sql) {
        if (!USE_PHP_REDBEAN) {
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            if ($result) {
                return $stmt->fetchAll();
            }
            return [];
        } else {
            throw new \Exception('Disable using the RedBeanPHP library to use methods of model of Xuborx Framework', 500);
        }
    }

}