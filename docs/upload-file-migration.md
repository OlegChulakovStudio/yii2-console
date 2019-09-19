# Загрузка локальных файлов

Трейт `chulakov\console\traits\UploadFileMigrationTrait` позволяет загружать локальные файлы при
выполнении миграции с сохранением в таблице связей с моделью.

Загрузка происходит через компонент [FileStorage](https://github.com/OlegChulakovStudio/yii2-filestorage), 
перед началом работы необходимо убедиться, что компонент установлен и настроен правильно.

Метод загрузки принимает следующие параметры:

- `file` - путь к файлу
- `id` - идентификатор сущности, для которой будет установлена связь с файлом
- `group` - название группы файла
- `type` - название типа файла (`object_type` в таблице `file`)


