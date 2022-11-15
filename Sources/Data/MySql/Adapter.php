<?php

namespace Liloi\Tools\Data\MySql;

use Liloi\Tools\Data\Adapter as DataAdapter;

/**
 * Abstract data adapter.
 */
class Adapter extends DataAdapter
{
    /**
     * Insert tuple in table.
     *
     * @param string $table Table name.
     * @param array $params Column values.
     */
    public function insert(string $table, array $params): void
    {
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

        $this->getConnection()->request($query);
    }

    /**
     * Update tuple in table.
     *
     * @param string $table Table name.
     * @param array $params Column values.
     * @param string $where What tuples to update.
     */
    public function update(string $table, array $params, string $where) {

        $data = [];
        foreach ($params as $k => $v) {
            $data[] = sprintf("%s = '%s'", $k, $v);
        }

        $query = sprintf(
            'update %s set %s where %s',
            $table,
            implode(', ', $data),
            $where
        );

        $this->getConnection()->request($query);
    }

    /**
     * Delete tuple from table.
     *
     * @param string $table Table name.
     * @param string $where What tuples to delete.
     */
    public function delete(string $table, string $where): void
    {
        $query = sprintf('delete from %s where %s', $table, $where);
        $this->getConnection()->request($query);
    }

    /**
     * Get info in row array form.
     *
     * @param string $query Request query.
     * @return array Row array form.
     */
    public function getRow(string $query): array {
        $request = $this->getConnection()->request($query);

        if(!$request->num_rows) {
            return [];
        }

        return $request->fetch_assoc();
    }

    /**
     * Get info in associative array form.
     *
     * @param string $query Request query.
     * @return array Associative array form.
     */
    public function getArray(string $query): array {
        $request = $this->getConnection()->request($query);

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
     * Get info in associative column form.
     *
     * @param string $query Request query.
     * @return array Associative array form.
     */
    public function getColumn(string $query): array {
        $request = $this->getConnection()->request($query);

        if(!$request) {
            return [];
        }

        $list = [];

        while($row = $request->fetch_assoc()) {
            $list[] = reset($row);
        }

        return $list;
    }
}