echo "about to clear cache"
php app/console cache:clear --env=prod
echo "cache cleared"
php app/console assets:install --symlink
php app/console assetic:dump --env=prod


php app/console doctrine:schema:update --force