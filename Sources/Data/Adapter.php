<?php

namespace Liloi\Tools\Data;

use Judex\Assert;

/**
 * Abstract data adapter.
 */
abstract class Adapter
{
    private ?IConnection $connection = null;

    public function getConnection(): IConnection
    {
        return $this->connection;
    }

    public function setConnection(IConnection $connection): void
    {
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     */
    public function request($command)
    {
        return $this->connection->request($command);
    }

    private function __construct(IConnection $connection)
    {
        $this->setConnection($connection);
    }

    static public function create(IConnection $connection)
    {
        $classConnection = get_class($connection);
        $classAdapter = str_replace('Connection', 'Adapter', $classConnection);

        Assert::true(class_exists($classAdapter));

        return new $classAdapter($connection);
    }
}