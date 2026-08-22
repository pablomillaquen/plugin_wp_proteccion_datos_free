# Docker Development Environment

Entorno de desarrollo WordPress + WooCommerce para el plugin Chilean Data Protection (FREE).

## Servicios

| Servicio | Puerto | Descripción |
|----------|--------|-------------|
| WordPress | 8080 | Sitio principal |
| phpMyAdmin | 8081 | Gestión de base de datos |
| MySQL | 3306 | Base de datos |

## Inicio Rápido

```bash
# 1. Copiar variables de entorno
cp docker/.env.example docker/.env

# 2. Levantar servicios
make -C docker up

# 3. Instalar WooCommerce y Query Monitor
make -C docker install-wc

# 4. Acceder a WordPress
# http://localhost:8080
# Usuario: admin / Contraseña: admin (se crea en primer acceso)
```

## Comandos Útiles

```bash
# Ver logs
make -C docker logs

# Shell en contenedor WordPress
make -C docker shell

# Shell en base de datos
make -C docker db-shell

# Ejecutar tests
make -C docker test

# Parar servicios
make -C docker down

# Limpiar todo (incluye volúmenes)
make -C docker clean

# Reconstruir imágenes
make -C docker build

# Estado de contenedores
make -C docker status

# WP-CLI passthrough
make -C docker wp plugin list
```

## Estructura de Volúmenes

```
src/                    # Código del plugin (montado en /wp-content/plugins/chilean-data-protection)
docker/uploads.ini      # Configuración PHP para uploads
docker/php.ini          # Configuración PHP personalizada
```

## WP-CLI

WP-CLI está preinstalado en el contenedor WordPress:

```bash
# Listar plugins
wp plugin list --allow-root

# Activar plugin
wp plugin activate chilean-data-protection --allow-root

# Crear usuario admin
wp user create admin admin@example.com --role=administrator --user_pass=admin --allow-root
```

## Base de Datos

- **Host**: db (interno) / localhost:3306 (externo)
- **Database**: wp_cl_data_protection
- **User**: wp_user
- **Password**: wp_password
- **Root Password**: root_password

## phpMyAdmin

Accesible en http://localhost:8081
- Servidor: db
- Usuario: wp_user
- Contraseña: wp_password

## Debug

WP_DEBUG está habilitado. Los logs se escriben en:
- Docker logs: `make -C docker logs`
- WordPress debug.log: `/var/www/html/wp-content/debug.log` (dentro del contenedor)

## XDebug (Opcional)

Descomenta la sección XDebug en `docker/php.ini` y configura tu IDE para puerto 9003.