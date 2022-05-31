<?php

namespace Liloi\Tools\Data\MySql;

/**
 * Abstract data adapter.
 */
class Adapter
{
    /**
     * Instance of adapter.
     *
     * @var MysqlAdapter
     */
    protected static $instance = null;

    /**
     * Connection with database.
     */
    protected $connection = null;

    /**
     * Get connection with database.
     */
    public function getConnection() {
        return $this->connection;
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

        if(!$request) {
            return false;
        }

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
     * Execute query.
     *
     * @param string $query Request query.
     */
    public function insert(string $table, array $params) {

        $keys= [];
        $values= [];
        foreach ($params as $k => $v) {
            $keys[] = $k;
            $values[] = "'" . $v . "'";
        }

        $query = sprintf(
            'insert into %s(%s) values(%s)',
            $table,
            implode(', ', $keys),
            implode(', ', $values)
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

    public static function set($connection)
    {
        mysqli_set_charset($connection, 'UTF8');
        self::$instance = new self($connection);
    }

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
    public static function get(): self
    {
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
     * Execute query.
     *
     * @param string $query Request query.
     */
    public function check(string $table, string $where): bool {

        $sql = sprintf('select * from %s where %s', $table, $where);
        return (bool)$this->single($sql);
    }

    public function remove(string $table, string $where)
    {
        $query = sprintf('delete from %s where %s', $table, $where);
        $this->connection->query($query);
    }
}