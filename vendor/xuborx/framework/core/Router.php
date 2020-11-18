<?php

namespace Xuborx\Framework;

use Xuborx\Framework\Base\Models\Model;

class Router
{

    private static $route = [];
    private static $routes = [];

    public static function addRoute($type = 'GET', $prefix = '', $route = '', $controller = '', $action = '') {
        $type = strtoupper($type);
        $route = trim($route, '/');
        $prefix = ucfirst(trim($prefix, '/'));
        self::$routes[$route] = array(
            'type' => $type,
            'prefix' => $prefix,
            'controller' => $controller,
            'action' => $action
        );
    }

    public static function getRoutes() {
        return self::$routes;
    }

    public static function routeHandler($route, $queryType) {
        if (self::searchRoute($route, $queryType)) {
            $controller = '\App\Controllers\\' . self::$route['prefix'] . '\\' . self::$route['controller'];
            $controller = str_replace('\\\\', '\\', $controller);
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = self::$route['action'];
                if (method_exists($controllerObject, $action)) {
                    self::runStatics();
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Action $controller::$action not found", 500);
                }
            } else {
                throw new \Exception("Controller $controller not found", 500);
            }

        } else {
            throw new \Exception('Page not found', 404);
        }
    }

    private static function searchRoute($route, $queryType) {
        if (isset(self::$routes[$route]) && !empty(self::$routes[$route]) && self::$routes[$route]['type'] == $queryType) {
            if (!empty(self::$routes[$route]['controller']) && !empty(self::$routes[$route]['action'])) {
                self::$route['route'] = $route;
                self::$route['type'] = $queryType;
                self::$route['prefix'] = self::$routes[$route]['prefix'];
                self::$route['controller'] = self::$routes[$route]['controller'];
                self::$route['action'] = self::$routes[$route]['action'];
                return true;
            } else {
                throw new \Exception('Controller and/or action not specified for the route ' . $route, 500);
            }
        } else {
            throw new \Exception('Page not found', 404);
        }
    }

    private static function runStatics() {
        $statics = glob(STATICS_DIR. '/*Static.php');
        $registry = Registry::instance();
        foreach ($statics as $static) {
            $staticClass = 'App\Statics\\' . str_replace('.php', '', basename($static));
            if (class_exists($staticClass)) {
                $staticObject = new $staticClass;
                if (method_exists($staticObject, 'setStatic')) {
                    $staticData = $staticObject->setStatic();
                    if (is_array($staticData)) {
                        foreach ($staticData as $key => $value) {
                            $registry->setProperty($key, $value);
                        }
                    } else {
                        throw new \Exception("The method setStatic() must return an array with data in $staticClass", 500);
                    }
                } else {
                    throw new \Exception("Method setStatic() not found in $staticClass", 500);
                }
            } else {
                throw new \Exception("Static $staticClass not found", 500);
            }
        }
    }

}