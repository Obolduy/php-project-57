### Hexlet tests and linter status:
[![Actions Status](https://github.com/Obolduy/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Obolduy/php-project-57/actions)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Obolduy_php-project-57&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=Obolduy_php-project-57)

## Task Manager

**Демо:** https://php-project-57-pnph.onrender.com

## Требования

- PHP >= 8.3
- npm 20+
- composer

## Установка

```bash
# Клонировать репозиторий
git clone https://github.com/Obolduy/php-project-57.git
cd php-project-57

# Установить зависимости
make install

cp .env.example .env

# Сгенерировать ключ приложения
php artisan key:generate

# Запустить миграции
php artisan migrate

# Запустить сидеры (опционально)
php artisan db:seed
```

## Использование

```bash
docker compose up -d --build
```
