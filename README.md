# Smart Habit Tracker
Simple api for tracking habit user


## Main Features : 
- Authentication using JWT ✅
- Simple CRUD for Habit ✅
- Scheduler for reminder habit (daily, weekly, monthly) ✅
- Habit Checkins ✅
- Summary & data statistik for habits that have been done

## Tech Stack :
1. Laravel
2. PostgresDB
3. JWT (tymon/jwt-auth)
4. Laravel Scheduler
5. Laravel Broadcasting

## Setup :
1. clone repository : 
    ``` 
    https://github.com/hanifrobbani/smart-habit-tracker-api.git
    ```
2. Install all dependencies :
    ```
    composer install
    ```
3. Setup .env :
    ```
    cp .env.example .env
    ```
4. Generate JWT Key & app key:
    ```
    php artisan jwt:secret
    ```
    ```
    php artisan key:generate
    ```
5. Migrate all table :
    ```
    php artisan migrate
    ```
6. Seed the data :
    ```
    php artisan db:seed
    ```
<br />

## How to run the scheduler
1. Run local server :
    ```
    php artisan serve
    ```
2. Run laravel scheduler :
    ```
    php artisan schedule:work
    ```
3. Run queue :
    ```
    php artisan queue:work
    ```
4. Run event manualy (if you don't want to wait long):
    ```
    php artisan tinker
    ```
    ```
    event(new \App\Events\HabitReminderEvent(1, 'Test send habit message'))
    ```
<b><i>Note: </i></b>
make sure you already setup the `.env` file using credential from [pusher](https://pusher.com), just follow the instructions that have been given there