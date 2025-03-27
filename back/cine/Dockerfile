# Usar una imagen base oficial de PHP
FROM php:8.2-fpm

# Instalar dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git

# Instalar extensiones de PHP necesarias para Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql

# Instalar Composer (gestor de dependencias PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /var/www

# Copiar los archivos del proyecto al contenedor
COPY . .

# Instalar las dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Exponer el puerto donde corre la aplicación (por defecto Laravel usa el puerto 8000)
EXPOSE 8000

# Comando para iniciar Laravel (puedes usar el comando `php artisan serve` o configurar un servidor web)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
