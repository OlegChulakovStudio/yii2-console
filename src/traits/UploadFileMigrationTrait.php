<?php
/**
 * Файл класса UploadFileMigrationTrain
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\console\traits;

use yii\db\Migration;
use yii\base\InvalidConfigException;
use chulakov\filestorage\params\UploadParams;
use chulakov\filestorage\uploaders\LocalUploadedFile;
use chulakov\filestorage\exceptions\NoAccessException;
use chulakov\filestorage\exceptions\NotUploadFileException;

/**
 * Примесь позволяющая загрузить локальный файл в проект
 *
 * @mixin Migration
 */
trait UploadFileMigrationTrait
{
    /**
     * @var string Наименование компонента загрузки файлов
     */
    protected $fileStorage = 'fileStorage';

    /**
     * Загрузка файла
     *
     * @param string $file
     * @param integer $id
     * @param string $group
     * @param string|null $type
     * @throws NoAccessException
     * @throws NotUploadFileException
     * @throws InvalidConfigException
     */
    protected function uploadFile($file, $id, $group, $type = null)
    {
        $time = $this->beginCommand("upload file {$file} to \"{$group}\" group for {$id}");

        /** @var \chulakov\filestorage\FileStorage $fileStorage */
        $fileStorage = \Yii::$app->get($this->fileStorage);

        $upload = new LocalUploadedFile($file);
        if ($upload->extension == 'svg') {
            $upload->setType('image/svg+xml');
        }

        $params = new UploadParams($group);
        $params->object_id = $id;
        if (!empty($type)) {
            $params->object_type = $type;
        }

        $fileStorage->uploadFile($upload, $params);

        $this->endCommand($time);
    }
}
