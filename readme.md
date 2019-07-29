![Moe HEMIS](logo.png)

## About HEMIS

A Data Collection and Report System for public Universities of Ethiopia.

## Installation

1. **Requirements**
    * Apache php server
    * MySql database server v5.7
    * Composer package manager: [get here](https://getcomposer.org/download/).
    * Node.js: [get here](https://nodejs.org/en/download/).

2. **Running the Project**

    * Clone/Download the Project 
    * Run it on your php server to be able to view it, view the `/public` directory
    * In order to develop, Create a database (and user). As an option you can run the `create_db.sql` file provided in the root directory
    * Copy the `.env.example` file and rename it to `.env`
    * Provide your database name, user, and password in the `.env` file

    * Install composer dependencies: `composer install`
    * Generate Application Key: `php artisan key:generate`
    * Install node dependencies: `npm install`
    * Migrate Database Tables and Seed them: `php artisan migrate:fresh --seed`
    * If thie previous step doesn't work, try redoing it after clearing your composer caches: `composer dump-autoload`
    * Start working from there
