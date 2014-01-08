NetID
=====

Administrative tool for validated identities used in DemocracyOS/app

## Install
1. Fork and/or clone or even just download this repository.
2. Copy `./app/config/parameters.yml.dist` file to `./app/config/parameters.yml`.
3. Set your configuration keys for database driver, host, port, name, user and password on `./app/config/parameters.yml`.
The parameters.yml file is ignored by git (see .gitignore) so that machine-specific settings like database passwords aren't committed.
By creating the parameters.yml.dist file, new developers can quickly clone the project, copy this file to parameters.yml, customize it, and start developing.
4. On the project root directory, run `php app/console doctrine:database:create` command to create the database and `php app/console doctrine:schema:update --force` to create the Net ID database schema.

Note on #3: Either replace parameters variables on `./app/config/parameters.yml` or set them as environment variables as shown below.

##  Settings

### Config variables
Symfony will grab any environment variable prefixed with SYMFONY__ and set it as a parameter in the service container.
Double underscores are replaced with a period, as a period is not a valid character in an environment variable name.
e.g.: a parameter with value %database.driver% should have a config variable named SYMFONY__DATABASE__DRIVER

## Production Settings

### Heroku buildpack
In order to install this application you must use `heroku-buildpack-php`.
Use the `--buildpack` parameter when creating a new app:

    heroku create --buildpack https://github.com/CHH/heroku-buildpack-php myapp

Or set the `BUILDPACK_URL` config var on an existing app:

    heroku config:set BUILDPACK_URL=https://github.com/CHH/heroku-buildpack-php
    
Dependencies on `./composer.json` will be installed when pushed to heroku server.
Procfile runs install.sh file which does the following tasks:

1. Clears the production cache.
2. Install bundles' assets.
3. Dumps compiled assets to /web public folder
4. Updates doctrine database schema
5. Craetes the root user if there is no one already. It uses the `root_username` and `root_password` parameters
6. It loads Groups and LegalIdType fixtures
7. Finally, runs the app

### Heroku Settings
First of all enable environment variables through `heroku labs:enable user-env-compile`
In order to install this application you shoud set the following config variables.

#### MySQL Database
* SYMFONY__DATABASE__DRIVER: Database driver `pdo_mysql` for MySQL Server.
* SYMFONY__DATABASE__HOST: Database host url.
* SYMFONY__DATABASE__PORT: Database port. Add it as `null` for default driver port.
* SYMFONY__DATABASE__NAME: Database name.
* SYMFONY__DATABASE__USER: Database login user.
* SYMFONY__DATABASE__PASS: Database login password.

#### MongoDB
* SYMFONY__MONGO__DBHOST: mongodb://<dbusername>:<dbpassword>@alex.mongohq.com:10057/<dbname>
* SYMFONY__MONGO__DBNAME: database name

#### Admin
* SYMFONY__ROOT__USERNAME: Root username to access to the admin dashboard.
* SYMFONY__ROOT__PASSWORD: Root password to access to the admin dashboard.
These should be set before deploying the app as they are referenced in the `install.sh` process to create the root admin.

## Useful links

* [PDR Site](http://partidodelared.org): The `Net Party` official site.
* [PDR Wiki](http://wiki.partidodelared.org): The `Net Party` official wiki.
* [PDR Facebook](http://facebook.com/partidodelared): The `Net Party` official Facebook page.
* [PDR Twitter](http://twitter.com/partidodelared): The `Net Party` official Twitter account.

## Active Contributors
* [Sacha Lifszyc](http://twitter.com/slifszyc)  

## License 

MIT
