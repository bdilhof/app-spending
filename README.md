# Local

docker compose -f docker-compose.yml -f docker-compose.override.yml up -d
docker compose exec app bash # vstúpiš do containera

# Production

docker compose -f docker-compose.yml up -d

# Run app

php artisan serve --host=0.0.0.0 --port=8000
