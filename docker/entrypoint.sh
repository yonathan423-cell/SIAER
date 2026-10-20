#!/bin/sh
set -e

# Puerto que asigna la plataforma (Render usa 10000 por defecto)
PORT="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Certificado CA de Aiven: se pega completo en la variable DB_SSL_CA_PEM
if [ -n "$DB_SSL_CA_PEM" ]; then
  printf '%s\n' "$DB_SSL_CA_PEM" > /etc/ssl/db-ca.pem
  export DB_SSL_CA=/etc/ssl/db-ca.pem
fi

exec "$@"
