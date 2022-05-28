sql:
	docker compose exec db bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'
cp:
	cp .env.example .env
	cp src/.env.example src/.env
up:
	docker compose build --no-cache --force-rm
	docker compose up -d
misc:
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan storage:link
	docker compose exec app chmod -R 777 storage bootstrap/cache
	docker compose exec app php artisan migrate:fresh
cache:
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache
cache-clear:
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan route:clear
	docker compose exec app php artisan view:clear
	docker compose exec app php artisan event:clear
	docker compose exec app php artisan cache:clear
	docker compose exec app php artisan clear-compiled
create-project:
	mkdir -p src
	@make up
	@make misc
init:
	@make up
	docker compose exec app composer install
	@make misc
deploy:
	@make up
	docker compose exec app composer install --optimize-autoloader --no-dev
	@make cache-clear
	@make cache
	@make misc
