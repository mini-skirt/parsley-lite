<?php
namespace App;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Cache
{
    private static $pool = null;

    public static function get($name, $value = null)
    {
        $item = static::$pool->getItem($name);
        if ($item->isHit()) return $item->get();

        if (is_callable($value)) $value = $value();
        $item->set($value);
        static::$pool->save($item);

        return $value;
    }

    public static function remove($name)
    {
        static::$pool->deleteItem($name);
    }

    public static function init($ns = '', $ttl = 0, $path = null)
    {
        if (static::$pool === null) static::$pool = new FilesystemAdapter($ns, $ttl, $path);
    }
}