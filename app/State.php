<?php
namespace App;

class State
{
    private static $instance = null;
    private static $env = [];

    public static function getInstance()
    {
        return static::$instance;
    }

    public static function setInstance($instance)
    {
        if (! is_null(static::$instance)) return false;
        static::$instance = $instance;
    }
    
    public static function env($name, $value = null)
    {
        if (is_string($name)) return static::$env[$name] ?? $value;
        if (is_array($name)) static::$env[$name[0]] = $name[1];
    }
}