<?php
/**
 * Файл класса AssetsController
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\console;

use yii\console\Controller;
use yii\helpers\Console;

class AssetsController extends Controller
{
    /**
     * @var string Базовое действие
     */
    public $defaultAction = 'clear';

    /**
     * @var array Проекты, подвергаемые очистке
     */
    public $projects = ['@frontend', '@backend'];
    /**
     * @var string Относительный путь до поиска ассетов
     */
    public $assetsPath = 'web/assets';

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), [
            'projects', 'assetsPath'
        ]);
    }

    /**
     * Действие очистки ассетов
     */
    public function actionClear()
    {
        if (empty($this->projects)) {
            $this->stdout('Not projects to clear assets.' . PHP_EOL, Console::FG_YELLOW);
        }
        foreach ($this->projects as $project) {
            if ($path = \Yii::getAlias($project)) {
                $path .= DIRECTORY_SEPARATOR . $this->assetsPath;
                if (!is_dir($path)) {
                    $this->stdout('Not found asset directory: ' . $path . PHP_EOL, Console::FG_YELLOW);
                    continue;
                }
                $this->stdout('Clear asset from: ' . $path . PHP_EOL, Console::FG_GREEN);
                $this->clearAsset($path, false);
            }
        }
        $this->stdout('Success clear all asset.' . PHP_EOL, Console::FG_GREEN);
    }

    /**
     * Очистка директории
     *
     * @param string $path
     * @param bool $removeParent
     */
    protected function clearAsset($path, $removeParent = true)
    {
        foreach (glob($path . '/*') as $file) {
            if (is_link($file)) {
                $this->stdout($file . ' is symlink! Not be deleted.' . PHP_EOL, Console::FG_YELLOW);
                continue;
            }
            if (is_dir($file)) {
                $this->clearAsset($file);
            } else {
                @unlink($file);
            }
        }
        if ($removeParent) {
            @rmdir($path);
        }
    }
}
