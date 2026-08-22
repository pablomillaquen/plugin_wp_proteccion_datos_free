# Makefile for Docker WordPress Development
# Usa docker compose v2 (plugin de Docker)

COMPOSE := docker compose -f docker/docker-compose.yml

.PHONY: up down restart logs shell db-shell install-wc test clean build status wp

# Start all services
up:
	$(COMPOSE) up -d

# Stop all services
down:
	$(COMPOSE) down

# Restart services
restart:
	$(COMPOSE) restart

# View logs
logs:
	$(COMPOSE) logs -f

# WordPress shell
shell:
	$(COMPOSE) exec wordpress bash

# Database shell
db-shell:
	$(COMPOSE) exec db mysql -u wp_user -pwp_password wp_cl_data_protection

# Install WooCommerce + Query Monitor + activate plugin
# NOTA: ejecutar después de cada 'make clean' o recreación de contenedores,
# porque los plugins instalados vía WP-CLI no persisten (solo lo hace la DB)
install-wc:
	$(COMPOSE) exec -T wordpress wp core is-installed --allow-root || \
		$(COMPOSE) exec -T wordpress wp core install --url=http://localhost:8080 --title="Chilean Data Protection Test" --admin_user=admin --admin_password=admin --admin_email=admin@test.local --skip-email --allow-root
	$(COMPOSE) exec -T wordpress wp plugin install woocommerce --version=8.9.0 --activate --allow-root
	$(COMPOSE) exec -T wordpress wp plugin install query-monitor --activate --allow-root
	$(COMPOSE) exec -T wordpress wp plugin activate chilean-data-protection --allow-root

# Run PHPUnit tests
test:
	$(COMPOSE) exec wordpress bash -c "cd /var/www/html/wp-content/plugins/chilean-data-protection && php vendor/bin/phpunit"

# Clean everything (volumes too - BORRA la base de datos)
clean:
	$(COMPOSE) down -v

# Build images
build:
	$(COMPOSE) build --no-cache

# Status
status:
	$(COMPOSE) ps

# WP-CLI passthrough: make wp CMD="plugin list"
wp:
	$(COMPOSE) exec wordpress wp $(CMD) --allow-root