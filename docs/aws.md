ssh saluteora
cd /var/www/html/base_saluteora/laravel
php -d memory_limit=-1 composer.phar selfupdate
php -d memory_limit=-1 composer.phar update -W
php artisan vendor:publish --all
rm -rf database/migrations
php artisan migrate
lanciamo piu' volte php artinsa migrate finche' non esce
INFO  Nothing to migrate.

<<<<<<< HEAD
<<<<<<< HEAD

per vedere 
http://ec2-54-194-72-103.eu-west-1.compute.amazonaws.com/it

=======
=======

-----
url:http://ec2-54-194-72-103.eu-west-1.compute.amazonaws.com/
>>>>>>> 0734d5c9 (.)
----

se si vedono dei |--35--
dalla cartella laravel
php artisan filament:upgrade
php artisan filament:optimize
php artisan optimize
>>>>>>> 74e04743 (tips)
