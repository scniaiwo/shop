<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-19
 * Time: 下午1:43
 */

namespace services;
class AbstractService{
    private static $_models = array ();

    public static function factory($className = __CLASS__) {
        if (isset ( self::$_models [$className] ))
            return self::$_models [$className];
        else {
            $model = self::$_models [$className] = new $className ( null );
            return $model;
        }
    }
} 