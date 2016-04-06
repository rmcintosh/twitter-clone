# Twitter Clone

Twitter Clone is a one page, one user Twitter clone written
using Silex, Twig, Monolog, and Twitter Bootstrap and uses
MySQL / MariaDB.

## Application Directory Structure

* `web` - Webserver root directory - Contains application entry point and Twitter Bootstrap sources
* `schema` - Contains application database schema
* `log` - Contains application log file
* `src` - Contains application source code, templates, and other supporting files
* `src/templates` - Contains application Twig template
* `src/app/Controller` - Contains application controller source
* `src/app/Repository` - Contains application repository source

## Application Files
* `web/index.php` - Application entry point
* `schema/schema.sql` - Application database schema definition
* `src/routes.php` - Application routes
* `src/settings.php` - Configuration settings for Silex Service Providers, application specific services, and the application firewall
* `src/service_providers.php` - This is where Silex Service Providers are registered.
* `src/services.php` - This file contains the application controller, repository, form, and form constraint services.
* `src/app/Controller/TwitterCloneController.php` - Controller class that renders index view and manages form submission. Namespaced in App\Controller 
* `src/app/Repository/TwitterCloneRepository.php` - Class that encapsulates the retrieval of tweets from, and insertion of a tweet into, the database. Namespaced in App\Repository.

## Setup

Clone the git repository:

````
$ git clone https://github.com/rcmcintosh/twitter-clone.git
````

From the repository root of ``twitter-clone``, install the required packages using composer:

````
$ composer install
````

Create the database `twitter_clone` in your MySQL / MariaDB server.

````
$ echo "create database twitter_clone" | mysql -u db_user -p
````

Here `db_user` corresponds to your database account username.

Create the `tweet` table using the supplied schema. From the top level directory:

````
$ mysql -u db_user -p twitter_clone < schema/schema.sql
````

Edit the `db_host`, `db_user`, and `db_pass` parameters in the file `src/settings.php` so that they correspond to your server settings.

````
$app['config'] = array(
    'db' => array(
        'db_host' => '',
        'db_name' => 'twitter_clone',
        'db_user' => '',
        'db_pass' => ''
    ),
````

## Run

To run the application using the php built-in webserver, from the top level directory use:

````
php -S 127.0.0.1:8000 -t web
````

At the login prompt, use `user` for the user name and `foo` for the password.

