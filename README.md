# DDDsymfony
Инструкция по установке.

- git clone git@github.com:Arago666/DDDsymfony.git
- docker-compose build
- docker-compose up -d
- composer install

- Конфигурируем .env (например, DATABASE_URL="mysql://root:@127.0.0.1:3306/db?serverVersion=5.1")
- php bin/console doctrine:database:create
- php bin/console make:migration
- php bin/console doctrine:migrations:migrate
