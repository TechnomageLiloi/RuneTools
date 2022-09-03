<?php

namespace Liloi\Tools\Data;

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

    public function setUp(): void
    {
        Adapter::setConnection($this->getConnection());
    }

    public function testSetGetConnection(): void
    {
        $this->assertEquals($this->getConnection(), Adapter::getConnection());
    }

    public function testRequest(): void
    {
        $result = Adapter::request('select database() as the_db');
        $row = $result->fetch_assoc();
        $this->assertEquals('rune', $row['the_db']);
    }
}