# ==============================================================
#  Book Catalog — Makefile
# ==============================================================

.DEFAULT_GOAL := help
SHELL := /bin/bash

# Цвета для вывода
GREEN  := \033[0;32m
YELLOW := \033[0;33m
CYAN   := \033[0;36m
RESET  := \033[0m

.PHONY: help
help: ## Показать список команд
	@printf "\n"
	@printf "$(CYAN)Book Catalog — доступные команды$(RESET)\n"
	@printf "\n"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | \
		awk 'BEGIN {FS = ":.*?## "}; {printf "  $(GREEN)%-18s$(RESET) %s\n", $$1, $$2}'
	@printf "\n"

# ==============================================================
#  Docker lifecycle
# ==============================================================
.PHONY: up
up: ## Запустить контейнеры
	docker compose up -d

.PHONY: down
down: ## Остановить и удалить контейнеры
	docker compose down

.PHONY: restart
restart: ## Перезапустить контейнеры
	docker compose restart

.PHONY: build
build: ## Пересобрать образы без кэша
	docker compose build --no-cache

.PHONY: rebuild
rebuild: ## Полная пересборка: down + build + up
	docker compose down
	docker compose build --no-cache
	docker compose up -d

.PHONY: ps
ps: ## Показать статус контейнеров
	docker compose ps

.PHONY: logs
logs: ## Смотреть логи app
	docker compose logs -f app

.PHONY: logs-all
logs-all: ## Смотреть логи всех сервисов
	docker compose logs -f

# ==============================================================
#  Shell access
# ==============================================================
.PHONY: sh
sh: ## Зайти в контейнер app
	docker compose exec app bash

.PHONY: sh-db
sh-db: ## Зайти в MySQL
	docker compose exec db mysql -u book_catalog -psecret book_catalog

.PHONY: sh-redis
sh-redis: ## Зайти в Redis CLI
	docker compose exec redis redis-cli

# ==============================================================
#  Laravel
# ==============================================================
.PHONY: migrate
migrate: ## Запустить миграции
	docker compose exec app php artisan migrate

.PHONY: seed
seed: ## Заполнить БД сидерами
	docker compose exec app php artisan db:seed

.PHONY: fresh
fresh: ## Пересоздать БД и заполнить сидерами
	docker compose exec app php artisan migrate:fresh --seed

.PHONY: rollback
rollback: ## Откатить последнюю миграцию
	docker compose exec app php artisan migrate:rollback

.PHONY: key
key: ## Сгенерировать APP_KEY
	docker compose exec app php artisan key:generate

.PHONY: cache-clear
cache-clear: ## Очистить весь кэш
	docker compose exec app php artisan optimize:clear

.PHONY: cache-warm
cache-warm: ## Прогреть кэш (config, route, view)
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache

.PHONY: storage-link
storage-link: ## Создать symlink storage
	docker compose exec app php artisan storage:link

.PHONY: tinker
tinker: ## Открыть Laravel Tinker
	docker compose exec app php artisan tinker

# ==============================================================
#  Dependencies
# ==============================================================
.PHONY: composer
composer: ## Установить composer-зависимости
	docker compose exec app composer install

.PHONY: composer-update
composer-update: ## Обновить composer-зависимости
	docker compose exec app composer update

.PHONY: npm
npm: ## Установить npm-зависимости
	docker compose exec app npm install

.PHONY: build-assets
build-assets: ## Собрать фронтенд
	docker compose exec app npm run build

# ==============================================================
#  Tests
# ==============================================================
.PHONY: test
test: ## Запустить PHPUnit
	docker compose exec app php artisan test

.PHONY: test-filter
test-filter: ## Запустить конкретный тест: make test-filter F=BookTest
	docker compose exec app php artisan test --filter=$(F)

.PHONY: dusk-driver
dusk-driver: ## Установить ChromeDriver для Dusk
	docker compose exec app php artisan dusk:chrome-driver --detect

.PHONY: dusk
dusk: ## Запустить Laravel Dusk
	docker compose exec app php artisan dusk

# ==============================================================
#  Reset
# ==============================================================
.PHONY: reset
reset: ## Полный сброс: удалить volumes и пересобрать
	docker compose down -v
	docker compose build --no-cache
	docker compose up -d

.PHONY: clean
clean: ## Удалить неиспользуемые docker-объекты
	docker system prune -f
