requiere:

- Node 18.9.0
- Composer latest


Pasos para instalar:

    cp .env.example .env -> modificar .env con las credenciales de base de datos
    composer update
    npm install
    npm run build
    php artisan key:generate
    php artisan migrate --seed

Para iniciar el servidor de desarrollo, ejecutar:
    php artisan serve
