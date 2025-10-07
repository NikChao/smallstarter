#!/usr/bin/env bash
set -e

# --- VARIABLES ---
DOMAIN="example.com"    # change to your domain
EMAIL="you@example.com" # email for Let's Encrypt notifications
WEB_ROOT="/var/www/myapp/public"

# --- UPDATE SYSTEM ---
curl -fsSL https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo gpg --dearmor -o /usr/share/keyrings/pgdg-archive-keyring.gpg
echo "deb [signed-by=/usr/share/keyrings/pgdg-archive-keyring.gpg] https://apt.postgresql.org/pub/repos/apt \
  $(lsb_release -cs)-pgdg main" | sudo tee /etc/apt/sources.list.d/pgdg.list >/dev/null
sudo apt update
sudo apt upgrade -y

# --- INSTALL NGINX + PHP + REQUIRED MODULES ---
sudo apt install -y nginx php-fpm php-cli php-mbstring php-pgsql php-curl php-xml unzip curl software-properties-common \
  ca-certificates gnupg lsb-release

# --- CREATE WEB ROOT ---
sudo mkdir -p "$WEB_ROOT"
sudo chown -R $USER:$USER "$WEB_ROOT"

# --- NGINX CONFIG ---
PROJECT_NGINX_CONF="$PWD/nginx.conf" # your local nginx.conf file
NGINX_TARGET="/etc/nginx/sites-available/myapp"

if [ -f "$PROJECT_NGINX_CONF" ]; then
  sudo cp "$PROJECT_NGINX_CONF" "$NGINX_TARGET"
  sudo ln -sf "$NGINX_TARGET" /etc/nginx/sites-enabled/
  sudo nginx -t
  sudo systemctl reload nginx
  echo "Nginx config copied and reloaded from $PROJECT_NGINX_CONF"
else
  echo "Error: $PROJECT_NGINX_CONF not found!"
  exit 1
fi

# --- INSTALL CERTBOT (Let's Encrypt) ---
sudo apt install -y certbot python3-certbot-nginx

# Obtain certificate
sudo certbot --nginx -d "$DOMAIN" --non-interactive --agree-tos -m "$EMAIL"

# --- ENABLE AUTO-RENEWAL (usually installed with certbot) ---
sudo systemctl enable certbot.timer

# --- FIREWALL (optional) ---
sudo ufw allow 'Nginx Full'
sudo ufw enable

echo "Setup complete! Your site should be live at https://$DOMAIN"

# --- Postgres ---
PG_VERSION="18"
POSTGRES_PASSWORD="YourStrongPasswordHere"

echo "Installing PostgreSQL ${PG_VERSION}..."
sudo apt install -y "postgresql-${PG_VERSION}" "postgresql-client-${PG_VERSION}" "postgresql-contrib"

echo "Enabling and starting PostgreSQL service..."
sudo systemctl enable "postgresql"
sudo systemctl start "postgresql"

echo "Waiting a bit for service to start..."
sleep 3

echo "Setting password for postgres user..."
sudo -u postgres psql -v ON_ERROR_STOP=1 <<-EOSQL
ALTER USER postgres WITH PASSWORD '${POSTGRES_PASSWORD}';
EOSQL

echo "Done. PostgreSQL ${PG_VERSION} should be running."
