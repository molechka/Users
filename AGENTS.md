# Users (users.bugred.ru)

Сайт пользователей на Yii 2 и движке noiframework. Точка входа — `index.php` в корне. Данные лежат в MongoDB, база `bugusers`.

## Как устроено

- PHP 5.6, расширение `mongo` (старое, не `mongodb`). В `composer.json` указано `php >= 5.4`.
- MongoDB 3.0, без авторизации. Подключение собирается в `noiframework/config/db.php` из `conf/db.php`.
- Корень сайта — каталог репозитория. Apache/nginx должны отдавать его как document root и пробрасывать все запросы, кроме существующих файлов, на `index.php` (правила уже в `.htaccess`).
- Плагины: `bugs`, `companys`, `form`, `historyop`, `html`, `mg`, `pay`, `search`, `sitemap`, `tasks`, `ulogin`, `user`.
- Зависимости уже лежат в `noiframework/vendor`. Заново ставить их через Composer не нужно: пакеты рассчитаны на PHP 5.x и старый `fxp/composer-asset-plugin`.

## Конфигурация

- `conf/config.php` — режим отладки, язык, логин админки. В репозитории пароль заменён на `change-me`. Рабочая копия конфига есть только в локальном бэкапе.
- `conf/db.php` — имя базы (`bugusers`), хост MongoDB.
- `config_admin['document_root']` на бою перекрывается document root веб-сервера. `index.php` меняет его только если задан `$config['mustbe']`.

## Чего нет в git

Логи, `tmp/files`, `tmp/image` и дамп MongoDB. Они лежат в `C:\backup` (`users-code.tgz`, `mongo.tgz`) и нужны для восстановления, но это не исходный код.

## Проверка

Поднять MongoDB 3.x, восстановить базу `bugusers`, выставить document root на этот каталог и открыть `/`. Админка плагина пользователей ожидает учётку из `conf/config.php`.
