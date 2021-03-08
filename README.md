# Test Envase Group

Use the following commands to run app on http://localhost:8000

`php -r "file_exists('.env') || copy('.env.example', '.env');"`

`composer install`

Not necessary needs :

`mysql -uroot -e"create database envase"`

`npm install -g maildev`

Continue with the following commands 

`php artisan key:generate`

`php artisa migrate`

`php artisan serve`

