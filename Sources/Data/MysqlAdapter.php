<?php

namespace Liloi\Tools\Data;

/**
 * Mysql database adapter.
 * @todo Test it.
 * @package Liloi\Tools\Data
 */
class MysqlAdapter extends Adapter
{
    /**
     * Get instance of adapter.
     *
     * @param string $host Database host.
     * @param string $user Database user.
     * @param string $database Database name.
     * @param string $password Database password.
     * @return static Mysql database adapter.
     * @throws \Exception
     */
    public static function get(
        string $host,
        string $user,
        string $database,
        string $password
    ): self
    {
        // @todo Split this at adapter and connector layers.
        $connection = self::getConnector($host, $user, $password, $database);

        if(!$connection) {
            // @todo Change exception at php-judex.
            throw new \Exception('Something wrong with database.');
        }

        $connection->set_charset('utf8');

        self::$instance = new self($connection);

        return self::$instance;
    }

    /**
     * @param string $host
     * @param string $user
     * @param string $database
     * @param string $password
     */
    public static function getConnector(
        string $host,
        string $user,
        string $database,
        string $password
    )
    {
        return \mysqli_connect($host, $user, $password, $database);
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