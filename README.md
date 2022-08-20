# Trial Task

## Installation

Run the following commands:

1. Create .env file
```bash
cp .env.example .env
```

2. Define API_KEY in .en
```bash
API_KEY=PASTE_API_KEY_HERE
```

3. Create app database
```bash
CREATE DATABASE `app` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. Import located in `/db/app.sql` SQL dump into the app database

## Using Docker

Make sure you have Docker installed on your system, and then run the following commands:

1. Install Composer dependencies
```bash
composer install
```

2. Build and run Docker containers
```bash
docker-compose up -d --build
```

Now application is available on http://localhost

PhpMyAdmin: http://localhost:8080

To log into apache container use the following command:
```bash
docker exec -it apache sh
```

## Without Docker to Apache

### Server requiements

1. PHP >= 8.1
2. MySQL >= 8.0

### Installation

4. Copy `/composer.json` and `/composer.lock` to `/var/www`

5. Install composer dependencies
```bash
composer install
```

3. Define your database config in `.env`
```bash
DB_HOST=PASTE_DB_HOST_HERE
DB_USER=PASTE_DB_USER_HERE
DB_PASSWORD=PASTE_DB_PASSWORD_HERE
```

4. Copy `/.env` to `/var/www`
5. Copy `/scripts` to `/var/www`
6. Copy `/public` contents to `/var/www/html`

## Properties update from API script

To run script
```bash
php /var/www/scripts/update_properties.php
```

## SCSS

To build SCSS:

```bash
sass scss:public/css --style compressed
```

To run SCSS:
```bash
sass --watch scss:public/css --style compressed
```
