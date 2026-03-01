# Local
local:
	docker compose -f docker-compose.yml -f docker-compose.override.yml up -d --build

# Bash
bash:
	docker exec -it app bash

# Production
production:
	docker compose -f docker-compose.yml up -d

# Prune
prune:
	docker stop $(docker ps -aq)
	docker rm $(docker ps -aq)
	docker rmi -f $(docker images -aq)
	docker volume rm $(docker volume ls -q)
	docker network prune -f
