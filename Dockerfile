FROM php:8-alpine
WORKDIR /deninho
COPY . .
RUN ./composer.phar install
RUN docker-php-ext-install pdo pdo_mysql
CMD ["php", "index.php"]
