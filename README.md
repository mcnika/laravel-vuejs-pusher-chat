# Laravel Vue.js Pusher Chat

This is a chat implementation using Laravel 5.8, Vue.js and Pusher.

# Installation
1. Clone the repository:
```
git clone https://github.com/mcnika/laravel-vuejs-pusher-chat.git
```

2. Move to the newly created folder:
```
cd laravel-vuejs-pusher-chat
```

3. Install all the dependencies:
```
composer install
```

4. Create a new database. Then rename .env.example to .env and provide your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

5. Migrate the database:
```
php artisan migrate
```

6. Visit URL: https://pusher.com/. Sign up for an account and create an app. Go to the App Keys section. Copy the keys into the .env file. 
```
PUSHER_APP_ID=app_id
PUSHER_APP_KEY=key
PUSHER_APP_SECRET=secret
PUSHER_APP_CLUSTER=cluster
```

7. Change the BROADCAST_DRIVER in the .env file.
```
BROADCAST_DRIVER=pusher 
```

8. Fill the user table with data:
```
php artisan db:seed --class=UsersTableSeeder
```

7. Generate the application key:
```
php artisan key:generate
``` 

Now open the browser and visit the app. 

Login credentials: 
User 1:
```
Email: demo1@example.com
Password: password
```

User 2:
```
Email: demo2@example.com
Password: password
```

Note! It is recommended to enable the encrypted options for production use. Open config/broadcasting.php file and set encrypted to true.
```
...
'options' => [
    ...
    'encrypted' => true,
],
```

# Screenshots
Demo:
![Demo](https://github.com/mcnika/laravel-vuejs-pusher-chat/raw/master/public/images/demo.gif)

# Community Links
* [Author Website](http://mcnika.com/)