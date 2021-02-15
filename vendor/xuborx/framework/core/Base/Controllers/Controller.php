<?php

namespace Xuborx\Framework\Base\Controllers;

use Xuborx\Framework\Routing\Route;
use Xuborx\Framework\Traits\TwigLoaderTrait;

class Controller
{

    use TwigLoaderTrait;

    private $route;

    public function __construct(Route $route) {
        $this->route = $route;
    }

    protected function getRoute() {
        return $this->route;
    }

}