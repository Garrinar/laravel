<?php
namespace Garrinar\Helpers;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class Config
 * @package Garrinar\Helpers
 *
 *
 * @method getAppKey($default = null)
 * @method getDateFormat($default = null)
 *
 */
class Env
{
    public static function __callStatic($name, $attributes)
    {
        if(Str::startsWith('get', $name)) {
            $method = Str::camel($name);
            if(method_exists(static::class, $method)) {
                $class = static::class;
                if(Arr::exists($attributes, 0)) {
                    return $class::$method($attributes[0]);
                }
                return $class::$method();
            }
        }
        return env(Str::upper(Str::snake(Str::substr($name, 3))));
    }
}