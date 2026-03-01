# Local

docker compose -f docker-compose.yml -f docker-compose.override.yml up -d --build
docker compose exec app bash

# Production

docker compose -f docker-compose.yml up -d

# Prune all

docker stop $(docker ps -aq)
docker rm $(docker ps -aq)
docker rmi -f $(docker images -aq)
docker volume rm $(docker volume ls -q)
docker network prune -f
