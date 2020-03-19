docker-up:
	docker-compose up -d

web-composer:
	docker-compose exec php-cli composer install

web-migrate:
	docker-compose exec php-cli php artisan migrate

web-migrate-rollback:
	docker-compose exec php-cli php artisan migrate:rollback

npm-install:
	docker-compose exec nodejs npm install

npm-watch:
	docker-compose exec nodejs npm run watch-poll

npm-prod:
	docker-compose exec nodejs npm run production

perm:
	sudo chmod 777 -R bootstrap/cache && sudo chmod 777 -R storage

dump-autoload:
	docker-compose exec php-cli composer dump-autoload
