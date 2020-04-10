migrations-generate:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:diff

migrations-migrate:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:migrate --no-interaction

docker-up:
	docker-compose up -d

test:
	docker-compose run --rm php-cli php bin/phpunit

fixtures:
	docker-compose run --rm php-cli php bin/console doctrine:fixtures:load --no-interaction

dump-autoload:
	docker-compose exec php-cli composer dump-autoload

assets-install:
	docker-compose run --rm nodejs npm install

assets-dev:
	docker-compose run --rm nodejs npm run dev

assets-watch:
	docker-compose run --rm nodejs npm run watch
