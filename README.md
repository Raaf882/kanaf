# Kanaf
<p align="center">كنف </p>
<p align="center">
<image src="public/images/kanaf-logo.png"></p>




<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Installation and Setup Instructions

####
Requirements

Before starting, make sure you have installed:

PHP
Composer
Node.js & npm
MySQL
Git


## Installation Steps
1. Open Your Local Server Directory
Go to your www or htdocs folder using the VS Code terminal.

2. Clone the Repository
`git clone https://github.com/Raaf882/kanaf.git`

4. Enter the Project Folder
`cd kanaf`

6. Install PHP Dependencies
`composer install`

8. Install Node.js Dependencies
`npm install`

10. Create the Environment File
Copy the example environment file:
cp .env.example .env

7. Configure Database Connection
Create a new database.
Open the .env file.
Update the database credentials:
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

9. Generate Application Key
`php artisan key:generate`

11. Run Migrations and Seeders
`php artisan migrate --seed`

13. Build Frontend Assets
`npm run build`
`Run the Project`

Start the Laravel development server:
`php artisan serve`

Finally: Run the project in the browser
####

