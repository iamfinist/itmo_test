docker-compose up -d --build
docker-compose exec -T php-service composer install
docker-compose exec -T php-service php bin/console doctrine:migrations:migrate --no-interaction