# SpudBot API
API for the SpudBot Discord bot client


## Configuration

1. Install composer packages, ```composer install ```
2. Copy env config, ```cp .env.example .env```
3. Generate Laravel key, ```php artisan key:generate```
4. Run database migrations, ```php artisan migrate```
5. Run database seeder to create admin account, ```php artisan db:seed```
6. Retrieve the database token for the bot via POST `/api/auth`
