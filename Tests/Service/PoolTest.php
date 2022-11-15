<?php
namespace Liloi\Tools\Service;

use PHPUnit\Framework\TestCase;

/**
 * Check phpUnit testing ability.
 */
class PoolTest extends TestCase
{
    public function testAddGetPool(): void
    {
        $test = ['cg'];
        Pool::add('test', function () use ($test) {return $test;});
        $this->assertEquals($test, Pool::get('test'));
    }
}