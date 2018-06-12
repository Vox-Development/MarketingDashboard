## Installation

Install this package by running cloning this repository and install like you normally install Laravel.

- Run `composer install` and `npm install` and generate the assets with `gulp`
- Copy .env.example to .env and fill your values (`php artisan key:generate`, database, pusher values etc)
- Run `php artisan migrate --seed`, this will seed a user based on your `BASIC_AUTH` `.env` values
- Start you queue listener and setup the Laravel scheduler.
- Open the dasboard in your browser, login and wait for the update events to fill the dasboard.

