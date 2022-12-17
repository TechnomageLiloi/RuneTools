<?php

namespace Liloi\Tools;

use Liloi\Config\Pool;
use Judex\Exceptions\GeneralException;

/**
 * Abstract manager.
 */
class Manager
{
    /**
     * Configuration pool.
     * `null` if not given.
     *
     * @var Pool|null
     */
    private static ?Pool $configuration = null;

    /**
     * Gets configuration pool.
     *
     * @return Pool Configuration pool.
     */
    public static function getConfiguration(): Pool
    {
        if(is_null(self::$configuration))
        {
            // @ToDo: [rune:judex:] Add NotDefinedException
            throw new GeneralException('Configuration is not defined.');
        }

        return self::$configuration;
    }

    /**
     * Gets configuration pool.
     * @param Pool $configuration
     */
    public static function setConfig(Pool $configuration): void
    {
        // @ToDo: [rune:config:] Pool must not be fully static.
        self::$configuration = $configuration;
    }
}