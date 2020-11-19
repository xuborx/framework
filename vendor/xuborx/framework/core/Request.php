<?php

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

    public static function removeRequestParametersFromRoute($route) {
        $parameters = $_GET;
        array_shift($parameters);
        foreach ($parameters as $key => $value) {
            self::setParameter($key, $value);
        }
        if (!empty($parameters)) {
            $route = trim(substr($route, 0, strpos($route, '&')), '/');
        }
        return $route;
    }

}