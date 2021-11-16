# symfony
Инструкция по установке.
  
- sudo apt install docker-compose (устанавливаем докер).
- git clone git@github.com:Arago666/symfony.git (копируем проект).
- docker-compose build (запускаем докер)
- docker-compose up -d 
- docker exec -tiu0 symfony_php-fpm_1 composer install
- docker exec -tiu0 symfony_php-fpm_1 php bin/console doctrine:migrations:migrate
- docker exec -tiu0 symfony_php-fpm_1 php bin/console doctrine:fixtures:load
- переходим на сайт http://localhost/booking

Тестирование
- в файле .env устанавливаем APP_ENV=test
- sudo docker exec -tiu0 symfony_php-fpm_1 php bin/console doctrine:database:create
- sudo docker exec -tiu0 symfony_php-fpm_1 php bin/console doctrine:migrations:migrate -n
- sudo docker exec -tiu0 symfony_php-fpm_1 php bin/console doctrine:fixtures:load -nx
- sudo docker exec -tiu0 symfony_php-fpm_1 php bin/phpunit