## Installation

Clone project from zip archive

With docker:

> Make sure you have docker & docker-compose installed (https://docs.docker.com/get-docker/).

```bash
docker-compose up -d
docker-compose exec -T php composer install --no-interaction
docker-compose exec -T php php ./bin/console cache:clear --no-warmup
docker-compose exec -T php php ./bin/console cache:warmup
docker-compose exec -T php php ./bin/console doctrine:migrations:migrate --no-interaction
```

This will start all the required services (check docker-compose.yml for the list of services), clear cache & apply
migrations.

Without Docker:

- Install PostgreSQL or other database
- Install PHP and required dependencies for sql, etc (see .docker/php/Dockerfile for list of dependencies)
- Install & configure Nginx or Apache
- Make sure you change environment variables in `.env` file

## Run Application

See application be URL: [http://localhost:10000](http://localhost:10000).

If port `10000` doesn't work, check `APP_PORT` variable in `.env` for the correct port.  
