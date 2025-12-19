# htl-workshop

## Run the project locally

````bash
docker compose -f compose.development.yaml up
docker exec -it htl_workshop_dev_web bash
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
````
