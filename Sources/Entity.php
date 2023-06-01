<?php

namespace Liloi\Tools;

use Liloi\Judex\Assert;

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
        return new static($data);
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

    /**
     * Get field from data.
     *
     * @param string $key Field key.
     * @return mixed Field data.
     */
    public function getField(string $key)
    {
        return $this->data[$key];
    }

    /**
     * Set field to data.
     *
     * @param string $key Field key.
     * @param mixed $value
     * @return mixed Field data.
     */
    public function setField(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Magic call for set/get methods.
     *
     * @param $function
     * @param $args
     * @return mixed
     */
    public function __call($function, $args) {

        if(str_starts_with($function, 'get'))
        {
            return $this->getField(strtolower(str_replace('get', '', $function)));
        }

        if(str_starts_with($function, 'set'))
        {
            $key = strtolower(str_replace('set', '', $function));
            $this->data[$key] = reset($args);
        }
    }
}