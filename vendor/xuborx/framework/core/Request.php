<?php
declare(strict_types=1);

namespace Xuborx\Framework;

class Request
{

    private static $requestPararmeters = [];

    public static function setParameter($key, $value) {
        self::$requestPararmeters[$key] = $value;
    }

    public static function getParameter($key) {
        return self::$requestPararmeters[$key];
    }

    public static function getParameters() {
        return self::$requestPararmeters;
    }

    public static function removeRequestParametersFromQuery(string $query): string
    {
        $parameters = array_merge($_GET, $_POST);
        array_shift($parameters);
        foreach ($parameters as $key => $value) {
            self::setParameter($key, $value);
        }
        if (!empty($parameters)) {
            $query = trim(substr($query, 0, strpos($query, '&')), '/');
        }
        return $query;
    }

}