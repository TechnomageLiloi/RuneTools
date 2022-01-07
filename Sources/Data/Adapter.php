<?php

namespace Liloi\Tools\Data;

/**
 * Abstract data adapter.
 * @package Liloi\Tools\Data
 */
abstract class Adapter
{
    /**
     * Instance of adapter.
     *
     * @var Adapter
     */
    protected static ?Adapter $instance = null;

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
     * Get instance of adapter.
     *
     * @return Adapter Instance of adapter.
     * @throws \Exception Something wrong with database.
     */
    abstract public static function get(): self;

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