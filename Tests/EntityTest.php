<?php
namespace Liloi\Tools;

use PHPUnit\Framework\TestCase;

/**
 * Check phpUnit testing ability.
 */
class EntityTest extends TestCase
{
    public function testSetGet(): void
    {
        $data = [
            'a' => 'test-a',
            'b' => 'test-b'
        ];

        $entity = Entity::create($data);
        $this->assertEquals($data, $entity->get());
    }
}