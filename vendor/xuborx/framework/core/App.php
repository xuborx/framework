<?php
declare(strict_types=1);

namespace Xuborx\Framework;

use Xuborx\Framework\Base\Models\Model;
use Xuborx\Framework\Traits\SingletonTrait;
use Xuborx\Framework\Routing\Router;

class App {

    use SingletonTrait;

    public static function start(): void
    {
        $query = trim($_SERVER['QUERY_STRING'], '/');
        $queryType = $_SERVER['REQUEST_METHOD'];
        new ErrorHandler();
        new Router($query, $queryType);
    }

}