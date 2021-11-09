# symfony
Инструкция по установке.
  
- sudo apt install docker-compose (устанавливаем докер).
- git clone git@github.com:Arago666/symfony.git (копируем проект).
- docker-compose build (запускаем докер)
- docker-compose up -d
- sudo apt install composer (устанавливаем композер)
- sudo docker-compose exec php-cli composer install
- Конфигурируем .env (например, DATABASE_URL="mysql://root:@127.0.0.1:3306/db?serverVersion=5.7")
- sudo docker-compose exec php-cli  bin/console doctrine:database:create (создаем базу данных)
- sudo docker-compose exec php-cli  bin/console make:migration (создаем миграции)
- sudo docker-compose exec php-cli  bin/console doctrine:migrations:migrate (выполняем миграции)
- curl -sS https://get.symfony.com/cli/installer | bash (устанавливаем симфони)
- переходим на сайт http://127.0.0.1:8000/booking