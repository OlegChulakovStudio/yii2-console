<?php
/**
 * Файл класса SchemaMigrationTrait
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\console\traits;

use yii\db\Migration;
use yii\db\ColumnSchemaBuilder;

/**
 * Trait SchemaMigrationTrait
 *
 * @mixin Migration
 */
trait SchemaMigrationTrait
{
    /**
     * Поле среднего размера текста.
     * Размерность поля: 16,777,215 (2^24 − 1) bytes = 16 MiB
     *
     * @return ColumnSchemaBuilder
     */
    public function mediumtext()
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext');
    }

    /**
     * Поле большого размера текста.
     * Размерность поля: 4,294,967,295 (2^32 − 1) bytes =  4 GiB
     *
     * @return ColumnSchemaBuilder
     */
    public function longtext()
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext');
    }
}
