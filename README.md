## Автоматизация документов на предприятии 

--- 


### Требования к установке проекта 
- PHP -> 8.2
- Composer
- Node.js & npm
- MySQL
- OpenServer (6.x.x)


Запуск проекта происходит через OpenServer


## Установка

---

1. Клонируйте репозиторий:

   ```bash
   git clone https://github.com/TikhonovIvan/dip_file.git
   cd dip_file
   ```

2. Установить зависимости PHP
    ```bash
   composer install
   ```
   
3. Создать папку .osp и перейти в нее
    ```bash
   cd .osp
   ```
    Создать файл project.ini и добавить следующие данные   
    ```bash
   [name-project]

    php_engine = PHP-8.2
    public_dir = {base_dir}\public
   ```
4. Настроить подключение к БД

   Скопируйте файл среды:

    ```bash
    cp .env.example .env
   ```
   В результате должен появиться файл .env


5. Настроить файл .env

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1 // или DB_HOST="MySQL-8.x"
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```
6. Запустить миграции 

    ```bash
    php artisan migrate
   ```
   
7. Запустить сидеры
    ```bash
    php artisan db:seed    
   ```
    
8. Сгенерировать ключ приложения
    ```bash
    php artisan key:generate 
   ```

9. Запустить проект через OpenServer
   
    Данный для входа

    Email: admin@gmail.com <br>
    Пароль: password
   
