# Контроллер очистки Asset

Для упрощения очистки `asset` папки проекта имеется консольный контроллер,
который можно настроить на удаление `asset` из любого приложения.

## Настройка

Необходимо зарегистрировать контроллер в настройках и сообщить ему правила очистки:

```
    'controllerMap' => [
        'assets' => \chulakov\console\AssetsController::class,
    ]
```

или с переопределеним дефолтных настроек контроллера:

```
    'controllerMap' => [
        'assets' => [
            'class' => \chulakov\console\AssetsController::class,
            'projects' => ['@frontend', '@backend'],
            'assetsPath' => 'web/assets',
        ],
    ]
```

## Запуск

Для запуска контроллера используется указанный `alias` в `controllerMap`,
если настройки соответствуют указанным выше, то это `assets`. Необходимо учитывать,
что в базовой поставке Yii идет уже контроллер `asset`, который занимается иными задачами.

Полная комманда запуска:

```
./yii assets/clear --projects=@frontend --assetsPath='web/assets'
```

где:
1. `--projects` - указание очищаемого проекта
2. `--assetsPath='web/assets'` - папка для очистки
