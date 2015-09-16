<?php

namespace tourze\Db\Component;

/**
 * MySQL的支持，待实现
 *
 * @package tourze\Db\Component
 */
class MySQL extends DbBase implements DbInterface
{

    /**
     * {@inheritdoc}
     */
    public function fetch($sql, $params = [])
    {
        // TODO: Implement fetch() method.
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($sql, $params = [])
    {
        // TODO: Implement fetchAll() method.
    }

    /**
     * {@inheritdoc}
     */
    public function query($sql, $params = [], $type = null)
    {
        // TODO: Implement query() method.
    }

    /**
     * {@inheritdoc}
     */
    public function update($table, $values, $conditions = null)
    {
        // TODO: Implement update() method.
    }

    /**
     * {@inheritdoc}
     */
    public function insert($table, $values)
    {
        // TODO: Implement insert() method.
    }

    /**
     * {@inheritdoc}
     */
    public function delete($table, $conditions, $limit = null)
    {
        // TODO: Implement delete() method.
    }
}
