# Quick start for users

If you are a user that just plans to use phpReel for your own projects then you should download the latest stable version of the script. Along with the downloaded file, you are going to find a PDF documentation that showcases how you can install phpReel via the installer and also how to work with it. 

> Download link for the [release version](https://github.com/phpreel/phpreel/releases)

# Quick start for developers

If you plan on using phpReel as a starting point for your next project then you should first fork this [repository](https://github.com/phpreel/phpreel) so you can have your own version of it. Right after that you can clone the forked repository and start the setup of the app.

> At its core, phpReel is a Laravel app. This means that you have to follow the same steps as you would do with any Laravel app.

# Setup

Here is a quick summary of what you will have to do:

- Make sure you have previously installed on your computer: PHP, Composer, MySQL database, or other databases that work with Laravel, Laravel also provides an [instalation guide](https://laravel.com/docs/7.x/installation) which is fairly similar to what you will have to do here.
- Clone your forked repository.
- Get the contents of the `.env.example` file and save them to a `.env` file. After you save it make sure you configure your database and Stripe settings inside the `.env` file.
- Open the console, cd to the root of the project, and run the following commands.
- `composer install`
- `npm install`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan serve`
- Go to `yourdomain.com/install/dev` to seed the database. This replaces the installer by inserting mock data in the database. Once you open the link these are going to be your admin login details: 
- Email `admin@paulbalan.com`
- Password `123456789`
