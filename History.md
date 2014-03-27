
0.1.0 / 2014-03-27 
==================

 * [user admin] - Update plainPassword to a password input
 * [routing] - Add root redirect to /admin to show the dashboard or the login page depending on the user being authenticated or not
 * Remove 'access_token_lifetime' from config and paramter.yml.dist
 * [travis] - Add access token liftetime parameter
 * [config] - Add new parameter for access token lifetime
 * [config] - Add new parameter for access token lifetime
 * [config] - Add new parameter for access token lifetime
 * [config] - Add new parameter for access token lifetime
 * [config] - Add new config parameter for access token lifetime
 * [parameters] - Add new parameter for access token lifetime
 * Bump sonata-project/cache-bundle to version 2.1.6
 * Bump sonata-project/cache-bundle to version 2.1.6
 * [api] - Add logic to update the foreignId on an identity's application. Foreign id is a nullable field and a read_only one as well
 * [delete template] - Fix typo
 * [admin] - Fix showing an Identity. Closes #39
 * [district fixtures] - Fix creating a Buenos Aires City district each time the fixture is run
 * Debugging netid integration
 * Debugging netid integration
 * Debugging netid integration
 * Debugging netid integration
 * Debugging netid integration
 * Debugging netid integration
 * Fix for setting emailValidated
 * Fix for setting emailValidated
 * Fix for setting emailValidated
 * Fix getallheaders function
 * Fix getallheaders function
 * Fix getallheaders function
 * [api] - Fix getallrequestheaders for nginx
 * [parameters] - Add locale parameter
 * [identity admin] - When creating/editing an identity, no blank email is shown
 * [identity] - Add email to emails array only when it is set
 * [api] - Creating an existing identity now results in an update of their attributes
 * [parameters] - Fix typo in mongodb test database parameters
 * [translations] - Add translations to successfuly in/validate identity
 * [translations] - Add translations for identity in/validation
 * [api] - Return a descriptive message when an identity is not validated
 * [admin] - Refactor IdentityRepository method to find an identity by one of their emails
 * [democracyos] - Add api method to verify an identity's email
 * [api] - Add foreignId d and application when creating an identity
 * [democracyos] - Add api to create a new identity receiving email, firstname and lastname. Returns the newly identity's id
 * [tests] - Add newline at end of .travis.yml file
 * [tests] - Add test to assert a log creation when a user logs in #35
 * remove mongo starting up on before_script
 * add db parameters on .travis.yml file
 * add missing travis_config.ini file and update secret parameter on parameters.yml.travis file
 * add travis parameters fileto be copied on before_script
 * add travis parameters fileto be copied on before_script
 * refactor travis envs
 * renamed myconfig.ini to travis_config.ini in .travis.yml file
 * moved travis_config.ini file
 * add travis config file for php ini directives
 * add composer update command on travis
 * update travis file
 * remove composer install from travis file
 * add composer self-update command on before_script
 * Update travis with env vars and doctrine commands on before_script
 * Add travis image build status to README.md
 * Merge branch 'tests'
 * [tests] - Add test to assert a log is created when deleting an identity
 * Merge branch 'tests'
 * [tests] - Add test to assert a log was created when updating an identity. Refactored tests
 * [identity] - Fix initializing emails collection
 * [tests] - Add remaining users to fixture for testing
 * =[tests] - Fix user wasn't being logged in correctly. Starting test to assert correctly log generation when creating an identity
 * [tests] - Remove old test file
 * Merge branch 'master' into tests
 * [identity] - Fix old IdentityController namespace
 * [tests] - Refactor tests adding an abstract test to test common access to different admins by different user roles
 * Merge branch 'master' into tests
 * [identity] - Fix old IdentityController namespace
 * [tests] - Refactor tests, more encapsulation in each method
 * Merge branch 'master' into tests
 * [admin] - Update group admin to display comma separated roles in listing and add user enabled by default
 * [translations] - Fix translation for 'breadcrumb dashboard'
 * [user] - Remove unnecesary fields from user admin
 * [tests] - Add tests to assert an auditor cannot access either the application, user or group admins
 * [tests] - Add test to assert an auditor can't access the identities list
 * [test] - Add tests config
 * [tests] - Add test to assert an auditor can't access identity creation route
 * Merge branch 'translations'
 * [validate] - Fix comma separated emails to add a space after the comma
 * [translations] - Add identity validation translations
 * [identity] - Update __toString() method to print the id followed by the fullname
 * [identity controller] - Fix audit when marking as suspicious identity
 * [user] - Add __toString() method to print the user id followed by their username
 * [translations] - Add audit translations
 * [translations] - Add application spanish translations
 * [app admin] - Remove batch column from listing
 * Merge branch 'master' into translations
 * [identity admin] - Add show mapper
 * [config] - Fix admin searching
 * [translations] - Add identity and common spanish translations
 * [readme] - Missing new line to display listed items correctly under install.sh details
 * [readme] - Updated readme file
 * [log] - Log ordered by datetime desc on landing
 * [log] - Update how client ip is got to log
 * [parameters] - Fix mongodb parameters
 * [heroku] - Fix fixtures loading now appending
 * Merge branch 'mongo-log'
 * [heroku] - Add fixtures loading on heroku deploy
 * [log] - Add log roles to Audit group and update fixtures.
 * [log] - Add LogRecord document to store logs in mongo
 * [audit] - Add new audit config, admin and document (mongodb entity)
 * [audit] - Remove old audit block, service and template
 * [dependencies] - Add doctrine/mongodb-odm, doctrine/mongodb-odm-bundle and sonata/doctrine-mongodb-admin-bundle dependencies configurations
 * [dependencies] - Add doctrine/mongodb-odm, doctrine/mongodb-odm-bundle and sonata/doctrine-mongodb-admin-bundle dependencies configurations
 * [dependencies] - Add doctrine/mongodb-odm, doctrine/mongodb-odm-bundle and sonata/doctrine-mongodb-admin-bundle dependencies to AppKernel file
 * [dependencies] - Add doctrine/mongodb-odm, doctrine/mongodb-odm-bundle and sonata/doctrine-mongodb-admin-bundle dependencies
 * Merge branch 'amazons3'
 * [admin] - Fix output for audit logger to console, to log messages to stdout instead of a file
 * Merge branch 'fix-identity-search'
 * [identity validation] - Fix for searching identities that now have multiple emails. Closes #31
 * [admin] - Groups schema for super admin, admin, operator r and auditor roles. Closes #30
 * Fix on install.sh to run the root user creation command
 * Add command and parameters required to create the root user when deploying
 * [parameters] - Add parameters configuration for heroku deployment
 * Add heroku deployment config on composer.json file
 * Add Procfile and install.sh files for heroku deployment
 * Merge branch 'identity-emails'
 * [admin] - Add multiple emails for each identity
 * Few more adjustments for refactor update
 * Merge from refactor
 * Merge branch 'oauth'
 * [admin] - Remove application admin config
 * [admin] - Fix OAuth client creation
 * [admin] - Application admin to work with FOSOAuthBundle
 * [admin] - Fixing FOSOAuthBundle. Missing calling ClientManager client creation
 * [admin] - Add audit feature
 * Merge branch 'log'
 * [admin] - Add log feature
 * [admin] - Fix Suspicious identity translation
 * [admin] - Add email field for identity admin
 * [admin] - Add identity mark as suspicious
 * [admin] - Add identity validation
 * [admin] - Add identity validation block and identity search.
 * [admin] - Add relationship between identity and application
 * [admin] - Add districts and ApplicationAdmin
 * [admin] - Add LegalIdType entity and fixture
 * [admin] - Add identity admin with basic identity fields
 * [admin] - Add new standard_layout.html.twig layout override to remove SonataProject footer and add DemocracyOS logo
 * [admin] - Add SonataUserBundle integration
 * [admin] - SonataUserBundle integration
 * [security] - Add invalidate_session: true when logging out
 * [sonata admin bundle] - Add SonataAdminBundle support
 * [initial commit] - Add DemocracyOS/NetIdAdminBundle. Add FOS/UserBundle support.
 * [security] - Fix typo
 * [identity admin] - Remove checking permissions in identity admin. In roles schema.
 * [translations] - Add translation messages, fixing typos
 * [translations] - Add translation messages
 * [identity log] - Remove create route
 * Merge branch 'verify-endpoint'
 * [netid api] - Add verify endpoint. Closes #25
 * Merge branch 'export-checksum'
 * [identity validation] - Fix missing 'exceeded' parameter when rendering the identity search
 * [export checksum] - Add xls and csv checksum before exporting #21
 * [export checksum] - Add csv support for exporting with a checksum
 * Merge branch 'limit-validation-search'
 * [identity validation] - Add search limit to a top of 4 identities listed
 * Merge branch 'identity-validation-confirm'
 * [identity validation] - Add validation confirmation previous to actually validating an identity
 * Merge branch 'identity-log'
 * [identity-log] - Log identity in/validation
 * Merge branch 'identity-validation-not-admins'
 * [identity validation] - Admins and Super Admins are not listed to be validated. If an identity is marked as suspicious then it can't be validated and a sign sais 'Suspicious identity' instead of the buttons to in/validate them
 * Merge branch 'validate-identities'
 * [identity validation] - Add 'Clear search' button #20
 * [identity validation] - Validate and invalidate identities #20
 * [identity admin] - Fix save subject roles instead of object roles
 * [identity validation] - Add Identity validation block on dashboard
 * Merge branch 'auditor'
 * [auditor] - Add log when a user logs in using entity IdentityLog instead of LoginLog, which was removed. Add IP, UserAgent, Roles schema to IdentityLog
 * [auditor] - AIdentity log lists actions performed on identities #22
 * Merge branch 'master' into export-checksum
 * [identity-log] - Log identity export. Closes #19
 * Merge branch 'log-identity-list'
 * [identity-log] - Log identity listing #19
 * Merge branch 'log-identity-deletion'
 * [identity log] - Identity deletion logged #19
 * Merge branch 'log-identity-creation'
 * [log identity] - Identity insert and update logged #19
 * [identity admin] - Add export formats only in csv and xls
 * Merge branch 'log-login'
 * [login-log] - Add audit feature.
 * [Role] - Add unique name constraint. Add ROLE_ACCESS action to let the user access the dashboard. It is required for every user
 * [Readme] - Add instruction to add heroku lab for exposing config variables during app deploy
 * [composer.json] - Add incenteev parameters bundle to copy parameters.yml.dist to parameters.yml
 * [composer.json] - Remove incenteev parameters bundle to copy parameters.yml.dist to parameters.yml
 * [composer.json] - Add incenteev parameters bundle to copy parameters.yml.dist to parameters.yml
 * [composer.json] - Remove incenteev parameters bundle to copy parameters.yml.dist to parameters.yml
 * Merge branch 'identity-softdelete'
 * [softdelete] - Add softdelete features. When a SUPER_ADMIN deletes a user, it gets physically deleted. But if an admin does, then the deletedAt field is set to the current datetime
 * [db/orm] - Change database table names to lowercase
 * Translations and adjustmanents to use DeR instead of PdR
 * Merge branch 'rename-pdr'
 * [DeRNetIdBundle] - Rename all classses to change bundle alias
 * [identity] - Rename remaining classes and files with Identity prefix or suffix. Closes #15
 * Merge branch 'users-to-identities'
 * [identity] - Rename User class to Identity and all of its references. Close #14
 * [user-admin] - Add user export fields
 * [user-admin] - Add ADMIN_ROLE or SUPER_ADMIN_ROLE to mark as suspicious permission
 * Merge branch 'operator-role'
 * [user-admin] - Add mark as unsuspicious. Fix typos and string messages.
 * [user-admin] - Add mark as suspicious button. Missing an unmark as suspicious as well. #10
 * [user-admin] - Add find an identity by legalId #10
 * Merge branch 'user-log'
 * [user-role] - Fix typos
 * [user-log] - Logging more user fields
 * Merge branch 'dynamic-roles'
 * [user admin] - Assign roles to users
 * [role-admin] - Fixturess and role administration
 * An Admin can't list Superadmins in User list and can't edit them
 * Removed staff from User.
 * role management in security.yml
 * admin parameters in parameters.yml.dist file
 * [UserAdmin] - birthday displayed correctly when showing a user
 * Role hierarchy
 * [i18n] - Translated words
 * simplified Procile in install.sh
 * simplified Procile in install.sh
 * simplified Procile in install.sh
 * changed parameters %admin_username% and %admin_password% for %admin.username% and %admin.password%
 * Admin Username and password in README.md
 * admin username and password form two parameters
 * two step login, using in_memory provider for now
 * admin routes moved to /admin
 * User email insert on /api/user by POSTing the email in a json format
 * Removed batch operations in Users list. Validator to check if legal id is set when a legal id type is selected. The duplicated client error is shown in each duplicated client on the clients list, besides showing it on top only once. Normal font weight for the login title
 * reponse to post request to check if a user has enough permissions to perform an action
 * starting allowed url
 * User's staff field editable
 * Merge branch 'login-pdr-ui'
 * Close #7 PdR styled login finished
 * UsersClients and Client nos shown in admin dashboard
 * starting login ui
 * User model updated to include their applications and foreignIds used in those applicattions
 * UsersClient in User creation/update.
 * Redirect on root to /login route
 * User controller to insert new users via api.
 * User controller to insert new users via api.
 * /users route secured
 * User model serializer
 * District entity.
 * Removed actions from User list
 * Legal id validation to create/edit. Translations for validations. Email field in user list. Verb entity
 * renamed 'pdr logo.png' to 'logo.png'
 * Merge branch 'master' of heroku.com:netid
 * renamed 'pdr logo.png' to 'logo.png'
 * logo renamed to 'pdr logo' in config.yml
 * PdR logo
 * PdR logo
 * Procfile
 * Procfile
 * Procfile
 * Procfile
 * Procfile
 * Procfile
 * Procfile
 * Procfile
 * Procfile
 * Procfile
 * Procfile
 * Procfile
 * Procfile
 * emptied Procfile
 * emptied Procfile
 * php version set to 5.5.3
 * php version >= 5.4.0
 * no compile command in composer.json
 * Procfile
 * composer.json file
 * composer.json file for heroku
 * composer.json file to deploy on heroku
 * composer.json file to deploy on heroku
 * composer.json for heroku deploy
 * composer.json to install assets
 * composer.json to install assets
 * composer.json to install assets
 * composer.json to install assets
 * absolute path to php in composer.json file
 * composer.json compile option for heroku
 * Restored files
 * Empty procfile
 * Empty procfile
 * assetic filters disabled
 * assetic filters disabled
 * assetic filters disabled
 * Procfile and install.sh files to instal bundle assets
 * Procfile and install.sh files to instal bundle assets
 * Procfile and install.sh files to instal bundle assets
 * Procfile and install.sh files to instal bundle assets
 * Procfile and install.sh files to instal bundle assets
 * Procfile and install.sh files to instal bundle assets
 * Procfile and install.sh files to instal bundle assets
 * Procfile and install.sh files to instal bundle assets
 * Procfile and install.sh files to instal bundle assets
 * .htaccess restored
 * .htaccess for heroku deployment
 * removed bundles: [] from assetic config fil
 * debug mode off to heroku
 * debug mode on to test heroku
 * Removed .htaccess file
 * .htaccess to gain access of /web folder in heroku
 * doctrine:schema:update --force, php app/console assets:install web --symlink, php app/console cache:clear commands added to composer.json file
 * Removed Sonata footer. Removed ROLE_REMEBERED_USER.
 * Login and logout from admin section
 * All user model fields to create/edit one. Validation translations.
 * Starting users admin
 * File permissions changed
 * Left ManyToMany Relationship. Removed for now.
 * user model: name, lastname, email, foreignId, birthDate, createdAt
 * Removed ClientApplication entity. Renamed CreateClientApplicationCommand. Application property added to Client entity
 * added php datetime/zone in php.ini on composer.json file
 * OAuth2 routing and config for seeing hardcoded users in /users
 * FOSOAuthServerBundle config
 * Update README.md
 * README.md
 * Initial commit
 * Initial commit
 * Initial commit
 * Initial commit
