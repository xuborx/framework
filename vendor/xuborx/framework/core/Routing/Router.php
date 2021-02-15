<?php
declare(strict_types=1);

namespace Xuborx\Framework\Routing;

use Xuborx\Framework\Request;
use Xuborx\Framework\Inspector;
use Xuborx\Framework\Registry;

class Router
{

    private static Route $route;
    private static array $routes = [];

    public function __construct($query, $queryType)
    {
        $this->routeHandler($query, $queryType);
    }

    public static function addRoute
    (
        string $type = 'GET',
        string $prefix = '',
        string $query = '',
        string $controller = '',
        string $action = '',
        string $inspector = ''
    ) {
        $type = strtoupper($type);
        $query = trim($query, '/');
        $prefix = trim($prefix, '/');
        self::$routes[$query] = new Route($type, $prefix, $query, $controller, $action, $inspector);
    }

    public function getRoutes(): array
    {
        return self::$routes;
    }

    private function routeHandler(string $query, string $queryType): void
    {
        $query = Request::removeRequestParametersFromQuery($query);
        if (self::searchRoute($query, $queryType)) {
            if (Inspector::inspect(self::$route->getInscpector())) {
                $controller = '\App\Controllers\\' . self::$route->getPrefix() . '\\' . self::$route->getController();
                $controller = str_replace('\\\\', '\\', $controller);
                if (class_exists($controller)) {
                    $controllerObject = new $controller(self::$route);
                    $action = self::$route->getAction();
                    if (method_exists($controllerObject, $action)) {
                        self::runStatics();
                        $controllerObject->$action(Request::getParameters());
                    } else {
                        throw new \Exception("Action $controller::$action not found", 500);
                    }
                } else {
                    throw new \Exception("Controller $controller not found", 500);
                }
            } else {
                throw new \Exception('Access denied', 403);
            }
        } else {
            throw new \Exception('Page not found', 404);
        }
    }

    private static function searchRoute(string $query, string $queryType): bool
    {
        if (isset(self::$routes[$query]) && self::$routes[$query]->getType() == $queryType) {
            if (self::$routes[$query]->getController() !== '' && self::$routes[$query]->getAction() !== '') {
                self::$route = self::$routes[$query];
                return true;
            } else {
                throw new \Exception('Controller and/or action not specified for the route ' . $route, 500);
            }
        } else {
            throw new \Exception('Page not found', 404);
        }
    }

    private static function runStatics(): void
    {
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