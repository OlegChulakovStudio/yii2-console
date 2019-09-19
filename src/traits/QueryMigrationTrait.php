<?php
/**
 * Файл класса QueryMigrationTrait
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\console\traits;

use yii\db\Query;
use yii\db\Migration;
use yii\db\ExpressionInterface;

/**
 * Примесь выборки данных в миграции
 *
 * @mixin Migration
 */
trait QueryMigrationTrait
{
    /**
     * Выборка одной записей
     *
     * @param string $table
     * @param array|string|ExpressionInterface $columns
     * @param array|string $condition
     * @param array $params
     * @return array
     */
    protected function queryOne($table, $columns, $condition = '', $params = [])
    {
        return $this->buildQuery($table, $columns, $condition, $params)->limit(1)->one();
    }

    /**
     * Выборка всех записей
     *
     * @param string $table
     * @param array|string|ExpressionInterface $columns
     * @param array|string $condition
     * @param array $params
     * @return array
     */
    protected function queryAll($table, $columns, $condition = '', $params = [])
    {
        return $this->buildQuery($table, $columns, $condition, $params)->all();
    }

    /**
     * Выборка скалярного значения
     *
     * @param string $table
     * @param array|string|ExpressionInterface $columns
     * @param array|string $condition
     * @param array $params
     * @return mixed
     */
    protected function queryScalar($table, $columns, $condition = '', $params = [])
    {
        return $this->buildQuery($table, $columns, $condition, $params)->limit(1)->scalar();
    }

    /**
     * Построитель запроса
     *
     * @param string $table
     * @param array|string|ExpressionInterface $columns
     * @param array|string $condition
     * @param array $params
     * @return Query
     */
    protected function buildQuery($table, $columns, $condition = '', $params = [])
    {
        $query = new Query();

        $query->select($columns)->from($table);
        if (!empty($condition)) {
            $query->where($condition, $params);
        }

        return $query;
    }
}
