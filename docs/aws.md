ssh saluteora
cd /var/www/html/base_saluteora/laravel
php -d memory_limit=-1 composer.phar selfupdate
php -d memory_limit=-1 composer.phar update -W
php artisan vendor:publish --all
rm -rf database/migrations
php artisan migrate
lanciamo piu' volte php artinsa migrate finche' non esce
INFO  Nothing to migrate.


per vedere 
http://ec2-54-194-72-103.eu-west-1.compute.amazonaws.com/it

