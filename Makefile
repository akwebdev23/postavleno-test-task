up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down docker-pull docker-build docker-up app-init

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

app-init: app-composer-update app-composer-install

app-composer-install:
	docker-compose run --rm app-php-cli composer install

app-composer-update:
	docker-compose run --rm app-php-cli composer update