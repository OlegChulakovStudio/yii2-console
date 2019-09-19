<?php
/**
 * Файл класса Migration
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\console;

/**
 * Класс миграции с переопределением параметров
 */
class Migration extends \yii\db\Migration
{
    /**
     * @var string
     */
    public $charset = 'utf8';
    /**
     * @var string Кодировка базы данных
     */
    public $encode = 'utf8_unicode_ci';
    /**
     * @var string Движок
     */
    public $engine = 'InnoDB';

    /**
     * @inheritdoc
     */
    public function createTable($table, $columns, $options = null)
    {
        if (empty($options) && $this->isMysql()) {
            $options = "CHARACTER SET {$this->charset} COLLATE {$this->encode} ENGINE={$this->engine}";
        }
        parent::createTable($table, $columns, $options);
    }

    /**
     * Проверка драйвера на MySQL
     *
     * @return bool
     */
    public function isMysql()
    {
        return $this->db->driverName === 'mysql';
    }

    /**
     * Создание индекса с именованием согласно требований установленного регламента
     *
     * @param string $table
     * @param string|array $columns
     * @param bool $unique
     */
    public function createIndexNamed($table, $columns, $unique = false)
    {
        $this->createIndex(
            $this->makeIndexName($table, $columns, $unique),
            $table, $columns, $unique
        );
    }

    /**
     * Удаление индекса добавленного без указания имени индекса
     *
     * @param string $table
     * @param string|array $columns
     * @param bool $unique
     */
    public function dropIndexNamed($table, $columns, $unique = false)
    {
        $this->dropIndex(
            $this->makeIndexName($table, $columns, $unique),
            $table
        );
    }

    /**
     * Создание первичного ключа
     *
     * @param string $table
     * @param string|array $columns
     */
    public function addPrimaryKeyNamed($table, $columns)
    {
        $this->addPrimaryKey(
            $this->makePrimaryName($table, $columns),
            $table, $columns
        );
    }

    /**
     * Удаление первичного ключа
     *
     * @param string $table
     * @param string|array $columns
     */
    public function dropPrimaryKeyNamed($table, $columns)
    {
        $this->dropPrimaryKey(
            $this->makePrimaryName($table, $columns),
            $table
        );
    }

    /**
     * Создание внешнего ключа с именованием согласно требований установленного регламента
     *
     * @param string $table
     * @param string|array $columns
     * @param string $refTable
     * @param string|array $refColumns
     * @param string $delete
     * @param string $update
     */
    public function addForeignKeyNamed($table, $columns, $refTable, $refColumns, $delete = 'RESTRICT', $update = 'CASCADE')
    {
        $this->addForeignKey(
            $this->makeForeignKeyName($table, $columns, $refTable, $refColumns),
            $table, $columns, $refTable, $refColumns, $delete, $update
        );
    }

    /**
     * Удаление внешнего ключа добавленного без указания имени ключа
     *
     * @param string $table
     * @param string|array $columns
     * @param string $refTable
     * @param string|array $refColumns
     */
    public function dropForeignKeyNamed($table, $columns, $refTable, $refColumns)
    {
        $this->dropForeignKey(
            $this->makeForeignKeyName($table, $columns, $refTable, $refColumns),
            $table
        );
    }

    /**
     * Именование индекса
     *
     * @param string $table
     * @param string|array $columns
     * @param bool $unique
     * @return string
     */
    protected function makeIndexName($table, $columns, $unique = false)
    {
        return $this->makeName(array_merge(
            [$unique ? 'unq' : 'idx', $table], (array)$columns
        ));
    }

    /**
     * Именование первичного индекса
     *
     * @param string $table
     * @param string|array $columns
     * @return string
     */
    protected function makePrimaryName($table, $columns)
    {
        return $this->makeName(array_merge(
            ['pk', $table], (array)$columns
        ));
    }

    /**
     * Именование внешнего ключа
     *
     * @param string $table
     * @param string|array $columns
     * @param string $refTable
     * @param string|array $refColumns
     * @return string
     */
    protected function makeForeignKeyName($table, $columns, $refTable, $refColumns)
    {
        return $this->makeName(array_merge(
            ['fk', $table], (array)$columns, [$refTable], (array)$refColumns
        ));
    }

    /**
     * Именование полей индексов
     *
     * @param array $params
     * @return string
     */
    protected function makeName($params)
    {
        $params = array_map(function($value) {
            return preg_replace('/[^a-zA-Z0-9_]+/i', '', $value);
        }, $params);
        return implode('-', $params);
    }
}
