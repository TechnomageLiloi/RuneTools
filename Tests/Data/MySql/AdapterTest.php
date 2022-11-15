<?php

namespace Liloi\Tools\Data\MySql;

use PHPUnit\Framework\TestCase;
use Liloi\Tools\Data\IConnection;

/**
 * Test mysql adapter set.
 */
class AdapterTest extends TestCase
{
    private ?IConnection $connection = null;

    private ?Adapter $adapter = null;

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
        $this->adapter = Adapter::create($this->getConnection());
        $this->getAdapter()->request('drop table if exists test');
        $this->getAdapter()->request('create table test(
            key_record bigint unsigned not null,
            title varchar(250) not null,
            summary text not null,
            primary key(key_record) 
        );');
    }

    public function getAdapter(): Adapter
    {
        return $this->adapter;
    }

    public function testSetGetConnection(): void
    {
        $this->assertEquals($this->getConnection(), $this->getAdapter()->getConnection());
    }

    public function testRequest(): void
    {
        $result = $this->getAdapter()->request('select database() as the_db');
        $row = $result->fetch_assoc();
        $this->assertEquals('rune', $row['the_db']);
    }

    public function testInsert(): void
    {
        $this->getAdapter()->insert('test', [
            'key_record' => 1,
            'title' => 'Test',
            'summary' => 'Test'
        ]);

        $result = $this->getAdapter()->request('select * from test;');
        $row = $result->fetch_assoc();

        $this->assertEquals(1, $row['key_record']);
        $this->assertEquals('Test', $row['title']);
        $this->assertEquals('Test', $row['summary']);
    }

    public function testUpdate(): void
    {
        $this->getAdapter()->insert('test', [
            'key_record' => 1,
            'title' => 'Test',
            'summary' => 'Test'
        ]);

        $this->getAdapter()->update('test', [
            'key_record' => 1,
            'title' => 'Test New',
            'summary' => 'Test New'
        ], sprintf('key_record=%s', 1));

        $result = $this->getAdapter()->request('select * from test;');
        $row = $result->fetch_assoc();

        $this->assertEquals(1, $row['key_record']);
        $this->assertEquals('Test New', $row['title']);
        $this->assertEquals('Test New', $row['summary']);
    }

    public function testRemove(): void
    {
        $this->getAdapter()->insert('test', [
            'key_record' => 1,
            'title' => 'Test',
            'summary' => 'Test'
        ]);

        $this->getAdapter()->delete('test', sprintf('key_record=%s', 1));

        $result = $this->getAdapter()->request('select * from test;');
        $row = $result->fetch_assoc();

        $this->assertNull($row);
    }

    public function testGetRow(): void
    {
        $this->getAdapter()->insert('test', [
            'key_record' => 1,
            'title' => 'Test',
            'summary' => 'Test'
        ]);

        $row = $this->getAdapter()->getRow('select * from test;');

        $this->assertEquals(1, $row['key_record']);
        $this->assertEquals('Test', $row['title']);
        $this->assertEquals('Test', $row['summary']);
    }
}