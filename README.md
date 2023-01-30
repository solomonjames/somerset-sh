# Somerset.sh

A simple and headless URL shortening service.

## Requirements

- Docker & Docker Compose ([colima](https://github.com/abiosoft/colima) is recommended for mac users)
- PHP 8.2
- [Composer](https://getcomposer.org/)

## Setup

1. First we need to install our PHP dependencies
    1. `composer install`
3. Next copy over the `.env.example` file and alter it as needed.
    1. `cp .env.example .env`
4. Generate a fresh app key
    1. `./vendor/bin/sail artisan key:generate`
5. Make sure you have Docker running, then we can run sail...
    1. `./vendor/bin/sail up -d`
    2. You may want to install this globally or create an alias. [Read more here](https://laravel.com/docs/9.x/sail)
6. Create the symlink to the storage directory
    1. `./vendor/bin/sail artisan storage:link`
7. Now lets prepare the DB
    1. Migrate: `./vendor/bin/sail artisan migrate`
    2. Seed: `./vendor/bin/sail artisan db:seed`
9. Lastly we need to run Laravel Horizon to consume any background events.
    1. `./vendor/bin/sail artisan queue:work`
