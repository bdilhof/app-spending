# Manna

# Build noveho imagu

```bash
VERSION=1.0.2
docker build --no-cache -f docker/Dockerfile -t ghcr.io/bdilhof/app-manna:$VERSION .
docker push ghcr.io/bdilhof/app-manna:$VERSION
```
