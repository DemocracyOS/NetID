php app/console cache:clear --env=prod
php app/console assets:install --env=prod
php app/console assetic:dump --env=prod
php app/console doctrine:schema:update --force
php app/console netid:root:create
sh ./bin/run