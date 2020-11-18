<?php

namespace Xuborx\Framework;

use Xuborx\Framework\Base\Models\Model;
use Xuborx\Framework\Traits\SingletonTrait;

class App {

    use SingletonTrait;

    public static function start() {
        $query = trim($_SERVER['QUERY_STRING'], '/');
        $queryType = $_SERVER['REQUEST_METHOD'];
        new ErrorHandler();
        Router::routeHandler($query, $queryType);
    }

}