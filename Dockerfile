# Imagem base com PHP 8.2
FROM php:8.2-cli

# Instala extensões necessárias (ex: pdo_mysql)
RUN apt-get update && apt-get install -y git unzip zip \
    && docker-php-ext-install pdo pdo_mysql

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia todo o código do projeto
COPY . /var/www/html

# Expõe a porta 8000 (usada pelo servidor embutido do PHP)
EXPOSE 8000

# Comando padrão (inicia o servidor PHP)
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]
