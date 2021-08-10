cp .env.example .env
echo ".env file generated"

composer install
echo "composer install executed"

npm install
echo "npm install executed"

php artisan key:generate
echo "app key generated"

php artisan dev:database
php artisan dev:stripe
php artisan migrate
php artisan dev:init

php artisan serve