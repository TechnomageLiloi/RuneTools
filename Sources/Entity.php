<?php

namespace Liloi\Tools;

use Judex\Assert;

/**
 * Abstract entity.
 */
class Entity
{
    /**
     * @var array Fields data.
     */
    protected array $data = [];

    /**
     * Create entity.
     *
     * @param array $data Fields data.
     * @return static Created entity.
     */
    public static function create(array $data): self
    {
        return new self($data);
    }

    /**
     * Entity constructor.
     *
     * @param array $data Fields data.
     */
    private function __construct(array $data)
    {
        $this->set($data);
    }

    /**
     * Set all fields data.
     *
     * @param array $data Fields data.
     */
    public function set(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Set all fields data.
     *
     * @return array Fields data.
     */
    public function get(): array
    {
        return $this->data;
    }
}