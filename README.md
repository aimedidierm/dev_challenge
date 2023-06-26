# Laravel dev challenge

This is a simple full stack web application for tools management made in Laravel 10

## Installation

Clone this repository

```bash
git clone https://github.com/aimedidierm/dev_challenge_web.git
```

Enter in project folder

```bash
cd dev_challenge_web
```

Install dependencies

```bash
composer install
```

Create your database (You can Use MySQL or PostgreSQL)

Create .env file with the following configuration

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_user_password
```

Run migration and seeds

```bash
php artisan migrate --seed
```

#Run project

```bash
php artisan serve
```
And don't forget to install Laravel\Passport
