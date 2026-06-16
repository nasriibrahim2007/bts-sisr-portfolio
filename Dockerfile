FROM php:8.2-apache

# Activation du module rewrite pour Apache (utile pour les routes propres)
RUN a2enmod rewrite

# Copie de tout le code du portfolio dans le dossier du serveur web
COPY . /var/www/html/

# Ajustement des permissions pour que PHP puisse écrire dans le fichier JSON (admin)
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html/data

EXPOSE 80