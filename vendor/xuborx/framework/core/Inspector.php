<?php

namespace Xuborx\Framework;

class Inspector
{

    public static function inspect($inspectorName) {
        if (!empty($inspectorName)) {
            return self::findAndRunInspector($inspectorName);
        } else {
            return true;
        }
    }

    private static function findAndRunInspector($inspectorName) {
        $inspectorClass = 'App\Inspectors\\' . str_replace('.php', '', basename($inspectorName));
        if (class_exists($inspectorClass)) {
            $inspectorObject = new $inspectorClass;
            if (method_exists($inspectorObject, 'inspect')) {
                $inspectResult = $inspectorObject->inspect();
                return $inspectResult;
            } else {
                throw new \Exception("Inspector method $inspectorClass::inspect() not found", 500);
            }
        } else {
            throw new \Exception("Inspector class $inspectorClass not found", 500);
        }
    }
}