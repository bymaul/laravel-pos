<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Getting Started

1. Clone the repository:

```bash
git clone https://github.com/bymaul/laravel-pos
```

2. Navigate to the project directory:

```bash
cd laravel-pos
```

3. Install dependencies:

```bash
composer install
```

4. Copy the example environment file and adjust configuration values:

```bash
cp .env.example .env
php artisan key:generate
```

5. Create a database and update the `.env` file with your database credentials

6. Run database migrations:

```bash
php artisan migrate
```

**Usage**

-   Describe how to use your application (starting the development server, common commands, API endpoints if applicable)

**Example**

```bash
php artisan serve
```

**Running Tests**

```bash
php artisan test
```

**Running Tests with Coverage**

-   export into clover.xml

```bash
composer test:coverage
```

-   export into html

```bash
composer test:coverage-html
```
