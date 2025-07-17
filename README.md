# Smart Habit Tracker
Simple api for tracking habit user


## Main Features : 
- Authentication using JWT ✅
- Simple CRUD for Habit ✅
- Scheduler for reminder habit (daily, weekly, monthly)
- Habit Checkins ✅
- Summary & data statistik for habits that have been done

## Tech Stack :
1. Laravel
2. PostgresDB
3. JWT (tymon/jwt-auth)
4. Laravel Scheduler


## Setup :
1. clone repository : 
    ``` 
    https://github.com/hanifrobbani/smart-habit-tracker-api.git
    ```
3. Install all dependencies :
    ```
    composer install
    ```
4. Setup .env :
    ```
    cp .env.example .env
    ```
5. Generate JWT Key & app key:
    ```
    php artisan jwt:secret
    ```
    ```
    php artisan key:generate
    ```
6. Migrate all table :
    ```
    php artisan migrate
    ```