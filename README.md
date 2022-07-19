<div align="center">

  <h1 align="center">Simple Shop Api</h1>

  <p align="center">
    An application for managing categories and their products, which in this case are research, but you can create your own product context
  </p>
</div>



<!-- TABLE OF CONTENTS -->

## Table of Contents

* [Built With](#built-with)
* [Getting Started](#getting-started)
    * [Installation](#installation)
    * [Testing](#testing)
    * [Dummy data](#dummy-data)
* [Development](#development)
* [Api Documentation](#api-documentation)
* [Contact](#contact)

## Built With

* [Symfony 6.1](https://symfony.com/doc/6.1)

## Getting Started

To install the application you will need:

* PHP >= 8.1
* git
* [composer](https://getcomposer.org/)
* [symfony cli](https://symfony.com/download)

### Installation

1. Go to the folder where you want to create the project and clone the repository

```sh
git clone https://github.com/Janczur/SimpleShopApi.git .
```

2. Go to /app directory

```shell
cd app
```

3. Install dependencies

```sh
composer install
```

4. Change environment variables to your needs  
   (skip this part for default configuration)   
   [Information about configuring environment](https://symfony.com/doc/6.1/configuration.html#overriding-environment-values-via-env-local)  
   copy ".env" file to ".env.local.dev" and provide valid DB credentials

```dotenv
DATABASE_URL="mysql://symfony:ChangeMe@127.0.0.1:3306/shop?serverVersion=mariadb-10.8.3&charset=utf8mb4"
```

5. Run docker-compose to create database in container

```sh
docker-compose up
```

6. Create database and run migrations

```sh
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate --no-interaction
```

### Testing

Create test database if not exists

```sh
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:create --env=test
```

For tests run in the main project directory

```sh
php bin/phpunit
```

### Dummy data

If you want to populate database with dummy data run:

```sh
php bin/console doctrine:fixtures:load
```

It will create 5 Categories with 10 researches each and 10 researches without category

## Development

To start local server type in your project directory

```sh
symfony serve
```

## Api Documentation

Coming soon

## To do

- [ ] Move web server and php to docker
- [ ] Add swagger documentation
- [ ] Simplify installation process

## Contact

Jan Przybysz - jan.j.przybysz@gmail.com