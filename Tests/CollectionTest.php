<?php
namespace Liloi\Tools;

use PHPUnit\Framework\TestCase;

/**
 * Check phpUnit testing ability.
 */
class CollectionTest extends TestCase
{
    public function testSetGet(): void
    {
        $entity_a = Entity::create([
            'a' => 'test-a',
            'b' => 'test-a'
        ]);
        $entity_b = Entity::create([
            'a' => 'test-b',
            'b' => 'test-b'
        ]);

        $collection = new Collection();
        $collection[] = $entity_a;
        $collection[] = $entity_b;

        $this->assertEquals(2, $collection->count());
        $this->assertEquals($entity_a, $collection[0]);
        $this->assertEquals($entity_b, $collection[1]);
    }
}