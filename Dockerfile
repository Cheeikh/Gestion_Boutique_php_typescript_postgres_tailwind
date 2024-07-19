# Utiliser une image de base PHP avec Apache
FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Copier les fichiers de l'application dans le répertoire racine de l'Apache
COPY . /var/www/html/

# Configurer les permissions pour le répertoire
RUN chown -R www-data:www-data /var/www/html/

# Exposer le port 80
EXPOSE 80

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer les dépendances PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
