dev-start:
	docker-compose up --build --remove-orphans

dev-start-database:
	docker-compose up --build -d postgres

dev-shell:
	docker-compose exec php sh

dev-artisan-tinker:
	docker-compose exec php php artisan tinker

dev-exec:
	docker-compose exec -T php $(command)

# dev-database-import:
# 	cat $(path) | docker-compose exec -T db psql -u hello_django -d pipeline < db/pipeline_db.sql

dev-stop:
	docker-compose down

dev-composer-install:
	docker-compose exec php composer install

dev-migrate:
	docker-compose exec php php artisan migrate --force