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
}