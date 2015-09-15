<?php

namespace tourze\Db\Component;

use tourze\Base\ComponentInterface;

/**
 * 基础的DB组件接口
 *
 * @package tourze\Db\Component
 */
interface DbInterface extends ComponentInterface
{

    /**
     * 查询和返回单条记录
     *
     * @param string $sql
     * @param array  $params
     * @return mixed
     */
    public function fetch($sql, $params = []);

    /**
     * 返回多行记录
     *
     * @param string $sql
     * @param array  $params
     * @return mixed
     */
    public function fetchAll($sql, $params = []);

    /**
     * 执行指定的sql
     *
     * @param string      $sql
     * @param array       $params
     * @param null|string $type
     * @return mixed
     */
    public function query($sql, $params = [], $type = null);

    /**
     * 更新记录
     *
     * @param string     $table
     * @param array      $values
     * @param null|array $conditions
     * @return mixed
     */
    public function update($table, $values, $conditions = null);

    /**
     * 创建记录
     *
     * @param string $table
     * @param array  $values
     * @return mixed
     */
    public function insert($table, $values);

    /**
     * 删除记录
     *
     * @param string   $table
     * @param mixed    $conditions
     * @param int|null $limit
     * @return mixed
     */
    public function delete($table, $conditions, $limit = null);
}
