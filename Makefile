install: 
	@make up
	@make composer-install

up: 
	@docker compose up -d --build

down: 
	@docker compose down --remove-orphans

re:
	@make down
	@make up

composer-install: 
	@docker compose exec --user=application app composer install

cc:
	@docker-compose exec app php artisan config:clear  
	@docker-compose exec app php artisan cache:clear 
	@docker-compose exec app php artisan route:clear

