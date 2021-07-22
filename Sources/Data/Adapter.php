<?php

namespace Liloi\Tools\Data;

class Adapter
{
    /**
     * Instance of adapter.
     *
     * @var Adapter
     */
    private static $instance = null;

    /**
     * Connection with MySql database.
     *
     * @var \mysqli
     */
    private $connection = null;

    /**
     * Construct adapter object.
     *
     * @param \mysqli $connection Connection with MySql database.
     */
    private function __construct(\mysqli $connection) {
        $this->connection = $connection;
    }

    public function connectionGet() {
        return $this->connection;
    }

    /**
     * Destruct adapter object.
     */
    public function __destruct() {
        $this->connection->close();
    }

    /**
     * Get instance of adapter.
     *
     * @return Adapter Instance of adapter.
     * @throws \Exception Something wrong with database.
     */
    public static function get(): self
    {
        if(null === self::$instance)
        {
            $connection = \mysqli_connect("", "", "", "");

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
     * Get info in associative array form.
     *
     * @param string $query Request query.
     * @return array Associative array form.
     */
    public function formArrayGet(string $query): array {
        $request = $this->connection->query($query);

        if(!$request) {
            return [];
        }

        $list = [];

        while($row = $request->fetch_assoc()) {
            $list[] = $row;
        }

        return $list;
    }

    /**
     * Get info in row array form.
     *
     * @param string $query Request query.
     * @return array Row array form.
     */
    public function formRowGet(string $query): array {
        $request = $this->connection->query($query);

        if(!$request->num_rows) {
            return [];
        }

        return $request->fetch_assoc();
    }

    public function single(string $query) {
        $request = $this->connection->query($query);

        if(!$request->num_rows) {
            return false;
        }

        $row = $request->fetch_assoc();
        return reset($row);
    }

    /**
     * Execute query.
     *
     * @param string $query Request query.
     */
    public function query(string $query) {
        $this->connection->query($query);

        // @TODO check for errors: database connection to exeptions.
    }

    /**
     * Execute query.
     *
     * @param string $query Request query.
     */
    public function update(string $table, array $update, string $where) {

        $data = [];
        foreach ($update as $k => $v) {
            $data[] = sprintf("%s = '%s'", $k, $v);
        }

        $query = sprintf(
            'update %s set %s where %s',
            $table,
            implode(', ', $data),
            $where
        );

        $this->connection->query($query);
    }

    /**
     * Get database name.
     *
     * @return string
     */
    public function databaseNameGet(): string {
        return $this->formArrayGet('select database() as the_db')[0]['the_db'];
    }

    /**
     * @return mixed
     */
    public function lastInsertIdGet() {
        return $this->connection->insert_id;
    }
}