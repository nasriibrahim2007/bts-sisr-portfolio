FROM php:8.2-apache

# Activation du module rewrite pour Apache (utile pour les routes propres)
RUN a2enmod rewrite

# Copie de tout le code du portfolio dans le dossier du serveur web
COPY . /var/www/html/

# Sécurisation : Empêcher l'accès direct au dossier data via le web
RUN echo '<Directory "/var/www/html/data">\n    Order deny,allow\n    Deny from all\n</Directory>' >> /etc/apache2/apache2.conf
RUN echo '<Directory "/var/www/html/api">\n    Options -Indexes\n</Directory>' >> /etc/apache2/apache2.conf

# Ajustement des permissions pour que PHP puisse écrire dans le fichier JSON (admin)
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html/data

EXPOSE 80