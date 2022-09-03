<?php

namespace Liloi\Tools\Data;

/**
 * Abstract data adapter.
 */
class Adapter
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
        return new self($connection);
    }
}