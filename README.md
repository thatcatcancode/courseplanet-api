# Course Planet Api 

This application uses the latest Slim 3 framework api. It also uses the Monolog logger.

## Dependencies 

1. [Install Composer](https://getcomposer.org/download/), a PHP package manager
2. Make Composer global `cd usr mv composer /usr/local/bin/composer`
3. mySQL set up on localhost, see src/settings for user and password

## Install 

Run `composer install` to pull down dependencies into /vendor folder

## Run the Application

	cd courseplanet-api/public
	php -S localhost:8080

## Run the Tests

	composer test

