<?php

namespace Liloi\Tools\Data;

/**
 * Abstract data adapter.
 */
class Adapter
{
    static private ?IConnection $connection = null;

    public static function getConnection(): IConnection
    {
        return self::$connection;
    }

    public static function setConnection(IConnection $connection): void
    {
        self::$connection = $connection;
    }

    /**
     * @inheritDoc
     */
    public static function request($command)
    {
        return self::$connection->request($command);
    }
}