<?php
use PHPUnit\Framework\TestCase;

/**
 * Check phpUnit testing ability.
 */
class CheckTest extends TestCase
{
    /**
     * Tests true is indeed true :-)
     */
    public function testCheck()
    {
//        $this->assertTrue(false);
        $this->assertTrue(true);
    }
}