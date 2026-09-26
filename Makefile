# ==============================================================
#  Book Catalog — Makefile
# ==============================================================

.DEFAULT_GOAL := help
SHELL := /bin/bash

# Colors for output
GREEN  := \033[0;32m
YELLOW := \033[0;33m
CYAN   := \033[0;36m
RESET  := \033[0m

.PHONY: help
help: ## Show available commands
	@printf "\n"
	@printf "$(CYAN)Book Catalog — available commands$(RESET)\n"
	@printf "\n"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | \
		awk 'BEGIN {FS = ":.*?## "}; {printf "  $(GREEN)%-18s$(RESET) %s\n", $$1, $$2}'
	@printf "\n"

# ==============================================================
#  Docker lifecycle
# ==============================================================
.PHONY: up
up: ## Start containers
	docker compose up -d

.PHONY: down
down: ## Stop and remove containers
	docker compose down

.PHONY: restart
restart: ## Restart containers
	docker compose restart

.PHONY: build
build: ## Rebuild images without cache
	docker compose build --no-cache

.PHONY: rebuild
rebuild: ## Full rebuild: down + build + up
	docker compose down
	docker compose build --no-cache
	docker compose up -d

.PHONY: ps
ps: ## Show container status
	docker compose ps

.PHONY: logs
logs: ## Follow app logs
	docker compose logs -f app

.PHONY: logs-all
logs-all: ## Follow logs of all services
	docker compose logs -f

# ==============================================================
#  Shell access
# ==============================================================
.PHONY: sh
sh: ## Open a shell in the app container
	docker compose exec app bash

.PHONY: sh-db
sh-db: ## Open MySQL shell
	docker compose exec db mysql -u book_catalog -psecret book_catalog

.PHONY: sh-redis
sh-redis: ## Open Redis CLI
	docker compose exec redis redis-cli

# ==============================================================
#  Laravel
# ==============================================================
.PHONY: migrate
migrate: ## Run migrations
	docker compose exec app php artisan migrate

.PHONY: seed
seed: ## Seed the database
	docker compose exec app php artisan db:seed

.PHONY: fresh
fresh: ## Recreate the database and seed it
	docker compose exec app php artisan migrate:fresh --seed

.PHONY: rollback
rollback: ## Roll back the last migration
	docker compose exec app php artisan migrate:rollback

.PHONY: key
key: ## Generate APP_KEY
	docker compose exec app php artisan key:generate

.PHONY: cache-clear
cache-clear: ## Clear all caches
	docker compose exec app php artisan optimize:clear

.PHONY: cache-warm
cache-warm: ## Warm up caches (config, route, view)
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache

.PHONY: storage-link
storage-link: ## Create the storage symlink
	docker compose exec app php artisan storage:link

.PHONY: tinker
tinker: ## Open Laravel Tinker
	docker compose exec app php artisan tinker

# ==============================================================
#  Dependencies
# ==============================================================
.PHONY: composer
composer: ## Install composer dependencies
	docker compose exec app composer install

.PHONY: composer-update
composer-update: ## Update composer dependencies
	docker compose exec app composer update

.PHONY: npm
npm: ## Install npm dependencies
	docker compose exec app npm install

.PHONY: build-assets
build-assets: ## Build frontend assets
	docker compose exec app npm run build

# ==============================================================
#  Tests
# ==============================================================
.PHONY: test
test: ## Run PHPUnit
	docker compose exec app php artisan test

.PHONY: test-filter
test-filter: ## Run a specific test: make test-filter F=BookTest
	docker compose exec app php artisan test --filter=$(F)

.PHONY: dusk-driver
dusk-driver: ## Install ChromeDriver for Dusk
	docker compose exec app php artisan dusk:chrome-driver --detect

.PHONY: dusk
dusk: ## Run Laravel Dusk
	docker compose exec app php artisan dusk

# ==============================================================
#  Reset
# ==============================================================
.PHONY: reset
reset: ## Full reset: remove volumes and rebuild
	docker compose down -v
	docker compose build --no-cache
	docker compose up -d

.PHONY: clean
clean: ## Remove unused Docker objects
	docker system prune -f
