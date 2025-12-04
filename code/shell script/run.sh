#!/bin/bash
#based on https://github.com/nkuase/ase230/blob/main/module2/code/1_Laravel/7.%20View%20and%20Controllers/run1-7.sh


SOURCE_DIR="/mnt/c/Users/gecko/Downloads/project2/project2/code/Laravel"
TARGET_DIR="project2-api"
MYSQL_PASSWORD=MyP@ssw0rd123!
DB_NAME="project1apis"
DB_USER="laravel_user"
DB_PASSWORD="MyP@ssw0rd123!"

set -e

if [ -z "$MYSQL_PASSWORD" ]; then
    echo "Creating database..."
    read -s -p "Enter MySQL root password: " MYSQL_PASSWORD
    echo
fi

echo "Creating MySQL user for Laravel..."

# Create database and user
if [[ "$OSTYPE" == "darwin"* ]]; then
  MYSQL="mysql"
else
  MYSQL="sudo mysql"
fi

$MYSQL -u root -p$MYSQL_PASSWORD << EOF
CREATE DATABASE IF NOT EXISTS $DB_NAME;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
EOF

echo "Creating Laravel project..."
composer create-project laravel/laravel $TARGET_DIR
cd $TARGET_DIR

echo "Updating .env file..."
# Cross-platform sed compatibility  
if [[ "$OSTYPE" == "darwin"* ]]; then
    sed -i '' 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env
    sed -i '' "s/# DB_DATABASE=laravel/DB_DATABASE=$DB_NAME/" .env
    sed -i '' "s/# DB_PASSWORD=/DB_PASSWORD=$DB_PASSWORD/" .env
    sed -i '' 's/# DB_HOST=127.0.0.1/DB_HOST=127.0.0.1/' .env
    sed -i '' 's/# DB_PORT=3306/DB_PORT=3306/' .env
    sed -i '' "s/# DB_USERNAME=root/DB_USERNAME=$DB_USER/" .env
    sed -i '' 's/SESSION_DRIVER=database/SESSION_DRIVER=file/' .env
    sed -i '' 's/CACHE_DRIVER=database/CACHE_DRIVER=file/' .env
else
    sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env
    sed -i "s/# DB_DATABASE=laravel/DB_DATABASE=$DB_NAME/" .env
    sed -i "s/# DB_PASSWORD=/DB_PASSWORD=$DB_PASSWORD/" .env
    sed -i 's/# DB_HOST=127.0.0.1/DB_HOST=127.0.0.1/' .env
    sed -i 's/# DB_PORT=3306/DB_PORT=3306/' .env
    sed -i "s/# DB_USERNAME=root/DB_USERNAME=$DB_USER/" .env
    sed -i 's/SESSION_DRIVER=database/SESSION_DRIVER=file/' .env
    sed -i 's/CACHE_DRIVER=database/CACHE_DRIVER=file/' .env 
fi

CONTROLLER_DIR=app/Http/Controllers
mkdir -p $CONTROLLER_DIR/Api

echo "Generating controller and model..."
php artisan make:controller BookController --api
php artisan make:controller api/BookController --api
php artisan make:model Book -m

echo "Copying Controllers..."
SRC_PATH=$CONTROLLER_DIR/Api/BookController.php
cp "$SOURCE_DIR/$SRC_PATH" $SRC_PATH 
SRC_PATH=$CONTROLLER_DIR/BookController.php
cp "$SOURCE_DIR/$SRC_PATH" $SRC_PATH 

echo "Copying Models..."
SRC_PATH=app/Models/Book.php
cp "$SOURCE_DIR/$SRC_PATH" $SRC_PATH 

echo "Copying bootstrap/app.php with API routes enabled..."
SRC_PATH=bootstrap/app.php
cp "$SOURCE_DIR/$SRC_PATH" $SRC_PATH 

echo "Copying routes/api.php with test routes..."
SRC_PATH=routes/api.php
cp "$SOURCE_DIR/$SRC_PATH" $SRC_PATH 
SRC_PATH=routes/web.php
cp "$SOURCE_DIR/$SRC_PATH" $SRC_PATH 
echo "Copying Views..."
SRC_PATH=resources/views/layouts
mkdir -p $SRC_PATH
cp $SOURCE_DIR/$SRC_PATH/* $SRC_PATH/ 
SRC_PATH=resources/views/books
mkdir -p $SRC_PATH
cp $SOURCE_DIR/$SRC_PATH/* $SRC_PATH/ 

# Apply migration template
echo "Setting up migration..."
php artisan make:migration books_table --create=books --quiet
MIGRATION_FILE=$(find database/migrations -name "*books_table.php" | sort | tail -1)
TEMPLATES="$SOURCE_DIR/database/books_migration_template.php"
cp "$TEMPLATES" "$MIGRATION_FILE"

echo "Running migrations..."
php artisan migrate:fresh --force

# Clear cache
echo "Clearing cache..."
php artisan optimize:clear

echo "Verifying API routes..."
php artisan route:list --path=api