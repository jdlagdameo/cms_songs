
### Installation

Download/Clone the the project and copy to local directory and go to the path in terminal/cmd and and install plugins via composer.

Plugin Installation:
```sh
$ composer install
```

Setup the database credentails in config/database.php. After the database setup, run laravel migrate command.
```sh
$ php artisan migrate
```
(optional) Third:
To setup dummy data, run laravel db seed command
```sh
$ php artisan db:seed
```
#### Run
To run the project, use the artisan serve command
```sh
$ php artisan serve
```
After the command execute, go to the localhost:8000.

If problem occurs during php artisan server, dump the composer autoload.
```sh
$ composer dump-autoload
```

License
----

Open Source
