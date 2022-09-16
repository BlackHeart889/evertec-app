Requisitos de despliegue:

- Laravel 9
- Node 18.7.0
- Composer latest
- PostgreSQL o MySQL


Pasos para instalar:

    cp .env.example .env -> modificar .env con las credenciales de base de datos
    composer update
    npm install
    npm run build
    php artisan key:generate
    php artisan migrate --seed

Añade las siguientes lineas al archivo .env

    PCT_LOGIN="Su Login"
    PCT_SECRET_KEY="Su llave secreta"
    PCT_BASE_URL="Su URL Base"


Para iniciar el servidor de desarrollo, ejecutar:

    php artisan serve
