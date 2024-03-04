init: docker-down-clear build up
restart: down up

build:
	docker-compose build --pull

up:
	docker-compose up -d

down:
	docker-compose down

docker-down-clear:
	docker-compose down --remove-orphans --volumes

sh:
	docker-compose exec php sh
