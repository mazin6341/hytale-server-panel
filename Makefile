CONTAINER ?= hytale-web-panel
container = $(CONTAINER)

exec:
	docker-compose exec $(container) /bin/sh

first-boot:
	@echo Setting up project image and installing composer packages
	touch .docker/.env
	docker-compose build
	docker-compose run --rm --entrypoint "/bin/sh /firstboot.sh" -v $(shell realpath ./.docker/php/firstboot.sh):/firstboot.sh $(container)

build:
	@echo Building all containers
	docker-compose build

start:
	@echo Starting all containers
	docker-compose up -d

restart:
	@echo Restarting all containers
	docker-compose down
	sleep 2
	docker-compose up -d

stop:
	@echo Stopping all containers
	docker-compose down

logs-all:
	docker-compose logs -f

ps:
	@echo Getting status of all containers
	docker-compose ps

logs:
	docker-compose logs -f $(container)

laravel-logs:
	@echo Watching laravel logs
	tail -n 200 -f src/storage/logs/laravel.log