#!/bin/bash

set -e

if [ -z "$1" ]; then
    LARAVEL_DIR="hello"
else
    LARAVEL_DIR=$1
fi

composer create-project laravel/laravel "$LARAVEL_DIR"

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

cd "$LARAVEL_DIR"

if [ ! -f "Dockerfile" ]; then
    cp "$SCRIPT_DIR/Dockerfile" .
fi

if [ ! -f "docker-compose.yml" ]; then
    cp "$SCRIPT_DIR/docker-compose.yml" .
fi

if [ ! -d "nginx" ] && [ -d "$SCRIPT_DIR/nginx" ]; then
    cp -r "$SCRIPT_DIR/nginx" .
fi

docker-compose up -d --build

sleep 15

DOCKER_EXEC="docker-compose exec app"

RETRY_COUNT=0
MAX_RETRIES=6

while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
    if $DOCKER_EXEC php -r "
        try { 
            new PDO('mysql:host=db;dbname=laravel_db', 'laravel_user', 'MyP@ssw0rd123!'); 
            exit(0);
        } catch(Exception \$e) { 
            exit(1);
        }" 2>/dev/null; then
        break
    else
        RETRY_COUNT=$((RETRY_COUNT + 1))
        sleep 10
    fi
done

if [ $RETRY_COUNT -eq $MAX_RETRIES ]; then
    echo "ERROR: Database connection failed after $MAX_RETRIES attempts."
    exit 1
fi

if ! $DOCKER_EXEC php artisan key:generate --no-interaction; then
    echo "ERROR: Failed to generate Laravel application key."
fi

if ! $DOCKER_EXEC php artisan migrate --no-interaction --force; then
    echo "ERROR: Database migrations failed."
fi