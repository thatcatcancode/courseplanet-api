Download mysql database open source edition 
Will need to create an oracle account to sign in and download
Take note of the password when first installing
To verify installation, run the following command:
/usr/local/mysql/bin/mysql -uroot -p
Will be prompted for the root password
Download and install mySQL Work Bench
# Course Planet Api 

This application uses the latest Slim 3 framework api. It also uses the Monolog logger.

## Dependencies 

1. [Install Composer](https://getcomposer.org/download/), a PHP package manager
2. Make Composer global `cd usr mv composer /usr/local/bin/composer`
3. Set up mySQL on localhost
	1. Download mysql database open source edition 
	2. Will need to create an oracle account to sign in and download
	3. Take note of the password when first installing
	4. To verify installation, run the following command: `/usr/local/mysql/bin/mysql -uroot -p`
	5. Will be prompted for the root password
	6. Download and install mySQL Work Bench
	7. Create account called "dev" with same password in `/src/settings`
	8. Create schema named `cp`
	8. Run scripts in `/db_scripts` folder

## Install 

Run `composer install` to pull down dependencies into /vendor folder

## Run the Application

	cd courseplanet-api/public
	php -S localhost:8080

## Run the Tests

	composer test

