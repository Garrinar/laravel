<?php
/**
 * Created by PhpStorm.
 * User: Garrinar
 * Date: 28.06.2016
 * Time: 17:32
 */

namespace Garrinar\Helpers;


abstract class Singletone
{
    protected static $instance;

    protected $instantiated = [];

    protected function get($class, $params = null)
    {
        if (isset($this->instantiated[$class]) && $this->instantiated[$class] instanceof $class) {
            return $this->instantiated[$class];
        } else {
            $this->instantiated[$class] = new $class($params);
            return $this->instantiated[$class];
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}