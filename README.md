# Local

docker compose -f docker-compose.yml -f docker-compose.override.yml up -d
docker compose exec app bash

# Production

docker compose -f docker-compose.yml up -d
