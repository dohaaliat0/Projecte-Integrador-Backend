## **Instalación**

Sigue los siguientes pasos para configurar y ejecutar el proyecto en tu entorno local:

1. Clona el repositorio:
    ```sh
    git clone https://github.com/cipfpbatoi-dawb/projectes-laravel-MarkDaw.git
    ```

2. Navega al directorio del proyecto:
    ```sh
    cd projectes-laravel-MarkDaw/futbol-femeni/
    ```

3. Instala las dependencias de PHP:
    ```sh
    composer install
    ```

4. Copia el archivo de configuración de entorno:
    ```sh
    cp .env.example .env
    ```

5. Levanta los servicios con Docker:
    ```sh
    ./vendor/bin/sail up -d
    ```

6. Instala las dependencias de Node.js:
    ```sh
    npm install
    ```

7. Compila los activos del frontend:
    ```sh
    npm run build
    ```

8. Crea el enlace simbólico para el almacenamiento:
    ```sh
    ./vendor/bin/sail artisan storage:link
    ```

9. Realiza las migraciones y ejecuta los seeders:
    ```sh
    ./vendor/bin/sail artisan migrate:fresh --seed
    ```
