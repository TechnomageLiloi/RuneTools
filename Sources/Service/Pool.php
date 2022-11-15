<?php

namespace Liloi\Tools\Service;

use Judex\Assert;

/**
 * Pool service.
 */
class Pool
{
    /**
     * @var array Components.
     */
    protected static array $data = [];

    /**
     * @var array List of functions, defining component (for lazy load).
     */
    protected static array $functions = [];

    /**
     * Add component to the pool.
     *
     * @param string $key Component key.
     * @param callable $component Function defining component (for lazy load).
     */
    public static function add(string $key, callable $component): void
    {
        self::$functions[$key] = $component;
    }

    /**
     * Add component to the pool.
     *
     * @param string $key Component key.
     * @return mixed Component.
     */
    public static function get(string $key)
    {
        if(!isset(self::$data[$key]))
        {
            $call = self::$functions[$key];
            self::$data[$key] = $call();
        }

        return self::$data[$key];
    }
}