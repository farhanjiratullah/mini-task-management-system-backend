<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Mini Task Management System Backend

A Laravel 13 REST API project featuring a Task resource (CRUD, search, and pagination) with an API response formatter.

## Requirements

Before installing, make sure the following are available on your machine:

- PHP >= 8.3 with the extensions Laravel requires (mbstring, openssl, pdo, tokenizer, xml, ctype, json, bcmath)
- Composer 2.x
- Node.js and npm
- Git

## Installation

Follow these steps in order.

### 1. Clone the repository

```bash
git clone <repository-url>
cd mini-task-management-system-backend
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install JavaScript dependencies

```bash
npm install
```

### 4. Create your environment file

```bash
cp .env.example .env
```

### 5. Generate the application key

```bash
php artisan key:generate
```

### 6. Configure the database

This project uses MySQL. Create a database (e.g. `mini_task_management_system`), then update your `.env` file with your connection details:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_task_management_system
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run migrations and seed the database

```bash
php artisan migrate --seed
```

This creates the required tables and seeds sample tasks via `TaskSeeder`.

### 8. Build frontend assets

```bash
npm run build
```

For active development with hot reloading, use `npm run dev` instead.

### 9. Start the application

```bash
composer run dev
```

This runs the Laravel server, queue listener, log watcher, and Vite dev server together. Alternatively, run just the server with:

```bash
php artisan serve
```

The API will be available at `http://localhost:8000` (or the URL shown in your terminal).

## API Overview

- `GET /api/tasks` — list tasks (supports search and pagination)
- `POST /api/tasks` — create a task
- `GET /api/tasks/{task}` — show a task
- `PUT/PATCH /api/tasks/{task}` — update a task
- `DELETE /api/tasks/{task}` — delete a task

## Agentic Development

This project supports AI coding agents via [Laravel Boost](https://laravel.com/docs/ai), already included as a dev dependency. Run:

```bash
php artisan boost:install
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
