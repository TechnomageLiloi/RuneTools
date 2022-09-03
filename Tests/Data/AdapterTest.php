<?php

namespace Liloi\Tools\Data;

use Liloi\Tools\Data\Adapter;
use PHPUnit\Framework\TestCase;
use Liloi\Tools\Data\MySql\Connection;

/**
 * Test mysql adapter set.
 */
class AdapterTest extends TestCase
{
    private ?IConnection $connection = null;

    public function getConnection(): IConnection
    {
        if(is_null($this->connection))
        {
            $this->connection = Connection::create(
                'localhost',
                'liloi',
                'rune',
                '1q2w3e4r5t'
            );
        }

        return $this->connection;
    }

    public function testSetGetConnection(): void
    {
        Adapter::setConnection($this->getConnection());
        $this->assertEquals($this->getConnection(), Adapter::getConnection());
    }
}