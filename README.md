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

### Validation constraints reference

Look this [here](https://symfony.com/doc/current/reference/constraints.html#apiplatform)

### Configure api access jwt

Info about jwt [here](https://jwt.io/#apiplatform)
Add jwt [here](https://api-platform.com/docs/core/jwt/#jwt-authentication)

Athentication needed for get and post on resources, you need to add authentication bearer token

### Doctrine collection and item on user restriction

For test it, add ROLE_ADMIN in column role of your user

### Adding automatic token postman environment

For exemple, when you login and you receive :
```
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NDc4Nzc4NzksImV4cCI6MTY0NzkxMzg3OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiam9obi5kb2UrMDFAYXBpLmNvbSIsImxhc3ROYW1lIjoiZG9lIn0.RvXuSKbXK4tsSLhwhXnjcOcY8GcmYWbw_B_V0iVKKc2r3i7a5b2HFj_fR32_2RM6jQE80umB5u8zWkGq8bRA5c-jSSTl9-93dqQeGwCKMix-QOBKCWofl4HqQHr-lqWSMiMJ10qQexJ8ICEk8XleC79i7m5ZFFi5G09zeT11A0YD0tW2LjbzxpZAxT0-HMda5zBVIf0jhJtwupVcfvHT27ieHMeMpbcLyW1wANzs9p4yeHDK7SxjISoyZgQFPWISRBcLvSZU7-_oNCFI5v27pvHHNX3yI_k2ZARyianqMS-TxOs2wPRcGFbch-EwQ30VvuKYQBZ1lFiU1sl42OIFLQ"
}
```

Add in test tab of your http request :
```
var jsonData = pm.response.json();
pm.environment.set("authToken", jsonData.token);
```

And in authorization bearer token you can add
```
{{authToken}}
```
