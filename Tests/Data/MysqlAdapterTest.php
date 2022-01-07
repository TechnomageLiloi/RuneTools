<?php

namespace Liloi\Tools\Data;

use PHPUnit\Framework\TestCase;

/**
 * Test mysql adapter set.
 */
class MysqlAdapterTest extends TestCase
{
    /**
     *
     */
    public function testCheck()
    {

        $target = MysqlAdapter::get('host', 'user', 'database', 'password');

        $this->assertTrue(false);
    }
}