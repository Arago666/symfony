# symfony
Инструкция по установке.
  
- sudo apt install docker-compose (устанавливаем докер).
- git clone git@github.com:Arago666/symfony.git (копируем проект).
- docker-compose build (запускаем докер)
- docker-compose up -d
- docker exec -tiu0 symfony_php-fpm_1 composer install
- docker exec -tiu0 symfony_php-fpm_1 php bin/console doctrine:migrations:migrate
- переходим на сайт http://localhost/booking
