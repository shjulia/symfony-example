docker-up:
	docker-compose up -d

test:
	docker-compose run --rm php-cli php bin/phpunit

dump-autoload:
	docker-compose exec php-cli composer dump-autoload
