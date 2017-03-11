# Inferno
This is a Laravel admin package built using AdminLTE theme and VueJs components.
The basic idea for this package is to get going with a ready made admin theme and
concentrate of the idea on which you want to work on and leave all the boilerplate
code to this package.

## Features
1. User login
2. Forgot password (uses Laravel mail to sendout emails)
3. Watchdog

## Requirements
The application uses Vue components for many of the widgets in the app. And many of
them needs the Laravel passport package installed and setup so that the package
can consume apis. For more details on how to install Laravel Passport, you can
refer to the docs: https://laravel.com/docs/5.4/passport

## Installation
The first step is to install this package using composer require and you need to
run the below command:

    composer require amitavdevzone/foundation

Once done, you will need to add the ServiceProvider to the app.php file inside
your config folder

    Inferno\Foundation\FoundationServiceProvider::class

Once, done you will need to run the publish command. Inferno has a lot of things
to publish like the migrations, seeders, assets for themes, views etc.

    php artisan vendor:publish --provider="Inferno\Foundation\FoundationServiceProvider" --force

Once this is done, you will need to make a few additions to your user model like
1. You need to add the Presentable trait to the User model. We will be using the Presenter package from Laracasts and so this setting is important.
2. You will need to add the profile relation with the user

Add the following code to your User model inside your app directory

    use PresentableTrait;
    protected $presenter = UserPresenter::class;

    public function profile()
    {
        return $this->hasOne('Inferno\Foundation\Models\Profile');
    }

Once these steps are done, you can run the migrations and run the seeders to get
started with your Inferno app and start coding for your next big idea.
