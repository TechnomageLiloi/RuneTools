<?php

namespace Liloi\Tools\Data;

class MysqlAdapter extends Adapter
{
    /**
     * Get instance of adapter.
     *
     * @return Adapter Instance of adapter.
     * @throws \Exception Something wrong with database.
     */
    public static function get(
        string $host,
        string $user,
        string $database,
        string $password
    ): self
    {
        if(null === self::$instance)
        {
            $connection = \mysqli_connect($host, $user, $password, $database);

            if(!$connection) {
                // @TODO Change exception at php-judex.
                throw new \Exception('Something wrong with database.');
            }

            $connection->set_charset('utf8');

            self::$instance = new self($connection);
        }

        return self::$instance;
    }

    /**
     * Construct adapter object.
     *
     * @param \mysqli $connection Connection with MySql database.
     */
    private function __construct(\mysqli $connection) {
        $this->connection = $connection;
    }

    /**
     * Destruct adapter object.
     */
    public function __destruct() {
        $this->connection->close();
    }
}