<?php

namespace Xuborx\Framework\Traits;

trait SingletonTrait
{

    private static $instance;

    private function __construct() {}

    private function __clone() {}

    private function __wakeup() {}

    public static function instance(){
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

}