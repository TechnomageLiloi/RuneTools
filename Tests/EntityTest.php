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
        $this->assertEquals($data['a'], $entity->getField('a'));
        $this->assertEquals($data['b'], $entity->getField('b'));
    }

    public function testMagicCall(): void
    {
        $test = '1ї524jkh0ґ-3asd,.bjk';
        $entity = Entity::create([]);
        $entity->setTest($test);
        $this->assertEquals($test, $entity->getTest());
    }
}