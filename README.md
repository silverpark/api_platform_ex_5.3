# api platform

## installation

[Install project symfony](https://stackoverflow.com/questions/25749655/how-do-i-create-a-project-based-on-a-specific-version-of-symfony-using-composer#27766284)
install symfony project
symfony new --webapp sf_project

install component api
composer require api

install dependencies
yarn install
yarn build

run server
symfony serve
go localhost:8000/api

## configuration

.env
DATABASE_URL=mysql://api:nopassword@127.0.0.1:3306/api

run docker
docker-compose -f docker-compose.mysql.yml down ; docker-compose -f docker-compose.mysql.yml up

## exercice

### Add entities
php bin/console make:entity Customer firstName string no null lastName string no null email string no null company string null
php bin/console make:entity Invoice amount float not null sentAt datetime not null status string not null customer relation Customer ManyToOne 

### Migration
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate

### Add fixtures

Générer des données aléatoire
composer require orm-fixtures fzaninotto/faker --dev

Nous ajoutons un nouvel attibut à invoice
php bin/console make:entity Invoice chrono integer not null

Migration
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate

Launch fixtures in src/DataFixtures/AppFixtures.php
bin/console doctrine:fixtures:load --no-interaction

### Add authentication

bin/console make:user User yes(in database) email(name of the user) yes(password) yes(algorythme argon2i)
bin/console d:m:m
bin/console make:entity User firstName string not null lastname string no null customers relation Customer OneToMany

Migration
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate

Launch fixtures in src/DataFixtures/AppFixtures.php
bin/console doctrine:fixtures:load --no-interaction

### API Rest

install postman with account dan.boetsch@gmail.com to recover collections