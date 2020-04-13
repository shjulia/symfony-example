start: docker-down-clear ready-clear docker-build docker-up init

init: composer-install assets-install wait-db migrations-migrate fixtures ready

docker-up:
	docker-compose up -d

docker-build:
	docker-compose build

docker-down-clear:
	docker-compose down -v --remove-orphans

test:
	docker-compose run --rm php-cli php bin/phpunit
fixtures:
	docker-compose run --rm php-cli php bin/console doctrine:fixtures:load --no-interaction

dump-autoload:
	docker-compose exec php-cli composer dump-autoload

composer-install:
	docker-compose run --rm php-cli composer install

assets-install:
	docker-compose run --rm nodejs npm install

assets-dev:
	docker-compose run --rm nodejs npm run dev

assets-watch:
	docker-compose run --rm nodejs npm run watch

wait-db:
	until docker-compose exec -T postgres pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done

migrations-generate:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:diff

migrations-migrate:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:migrate --no-interaction

ready-clear:
	docker run --rm -v ${PWD}:/app --workdir=/app alpine rm -f .ready

ready:
	docker run --rm -v ${PWD}:/app --workdir=/app alpine touch .ready
