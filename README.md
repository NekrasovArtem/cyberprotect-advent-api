# Киберпротект новогодний адвент API
API, написанное на хакатоне для новогоднего адвента по цифровой гигиене "Кибербезопасный новый год" от заказчика Киберпротект. 

## Содержание
- [Архитектура](#архитектура)
- [Использование](#использование)
- [Документация](#документация)
- [Обработка ошибок](#обработка-ошибок)

## Архитектура
- PHP 8
- Laravel 10
- MySQL 8

## Использование
1. Клонируйте репозиторий:
    ```sh
    git clone https://github.com/NekrasovArtem/cyberprotect-advent-api.git
    ```

2. Перейти в директорию проекта:
    ```sh
    cd cyberprotect-advent-api
    ```

3. Запустить проект на Docker:
    ```sh
    docker-compose up -d
    ```

4. Откройте интерфейс командной строки Laravel:
    ```sh
    docker exec -it app bash
    ```

5. Установите пакеты:
    ```sh
    composer update
    ```

6. Выполните миграции:
    ```sh
    php artisan migrate
    ```

## Документация
Адрес для отправки запросов - http://localhost:8876/api 

### Тестовый запрос
Запрос для проверки работоспособности api.

Пример запроса:
```sh
curl -X GET http://localhost:8876/api/test
```

Пример ответа:
```json
{
    "success": true,
    "message": "API is working"
}
```

### Аутентификация
Запрос на аутентификацию пользователя. Обязательный параметр - email. Присылает на переданную почту письмо с одноразовым кодом для авторизации, состоящий из четырех рандомных цифр. 

Пример запроса: 
```sh
curl -X POST http://localhost:8876/api/auth -d '{
    "email": "Your email"
}'
```

Пример ответа:
```json
{
    "success": true,
    "message": "A one-time code has been sent to your email"
}
```

### Авторизация
Запрос на авторизацию пользователя. Принимает обязательные параметры - email и password. В ответе отдает токен.

Пример запроса: 
```sh
curl -X POST http://localhost:8876/api/login -d '{
    "email": "Your email",
    "password": "0000"
}'
```

Пример ответа:
```json
{
    "success": true,
    "message": "Authorized successfully",
    "token": "Your token"
}
```


## Обработка ошибок

### 403 - Ошибка авторизации
Пример ответа:
```sh
{
    'success' => false,
    'message' => 'Incorrect email or password',
}
```

### 404 - Объект не найден
Пример ответа:
```sh
{
    'success' => false,
    'message' => 'Not found',
}
```

### 422 - Ошибка валидации
Пример ответа:
```sh
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "field": [
            "Error message",
        ],
        ...
    }
}
```
