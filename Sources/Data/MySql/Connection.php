<?php

namespace Liloi\Tools\Data\MySql;

use Liloi\Tools\Data\IConnection;

/**
 * MySql connection.
 */
class Connection implements IConnection
{
    /**
     * Connection with database.
     */
    private ?\mysqli $connection = null;

    /**
     * Construct adapter object.
     *
     * @param \mysqli $connection Connection with MySql database.
     */
    private function __construct(\mysqli $connection) {
        $this->connection = $connection;
    }

    /**
     * Connection to the MySql server.
     *
     * @param string $host Can be either a host name or an IP address.
     * @param string $user Database user name.
     * @param string $database Database name.
     * @param string $password Database password.
     * @param int|null $port MyuSql server port number.
     * @param string|null $socket User socket.
     * @return Connection
     */
    public static function create(
        string $host,
        string $user,
        string $database,
        string $password,
        ?int $port = null,
        ?string $socket = null
    ): self
    {
        return new self(\mysqli_connect(
            $host,
            $user,
            $password,
            $database,
            $port,
            $socket
        ));
    }

    /**
     * @inheritDoc
     */
    public function request($command)
    {
        return $this->connection->query($command);
    }

    /**
     * @inheritDoc
     */
    public function get()
    {
        return $this->connection;
    }
}