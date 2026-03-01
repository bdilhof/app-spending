# Manna

# Build & Push

```bash
VERSION=1.0.2
docker build --no-cache -f docker/Dockerfile -t ghcr.io/bdilhof/app-manna:$VERSION .
docker push ghcr.io/bdilhof/app-manna:$VERSION
```

# Pull & Deploy

```bash
docker compose -f docker-compose.yml down
docker pull ghcr.io/bdilhof/app-manna:1.0.2
APP_VERSION=1.0.2 docker compose -f docker-compose.yml up -d
```
