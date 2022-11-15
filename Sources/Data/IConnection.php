<?php

namespace Liloi\Tools\Data;

/**
 * IConnection interface.
 *
 * @package Liloi\Tools\Data
 */
interface IConnection
{
    /**
     * Get raw data manager.
     *
     * @return mixed
     */
    public function get();

    /**
     * Data request.
     *
     * @param mixed $command Data request.
     * @return mixed Data response.
     */
    public function request($command);
}