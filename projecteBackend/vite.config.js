import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/login.css', 'resources/js/app.js', 'resources/css/index.css', 'resources/js/index.js','resources/css/DarAltaBaja.css','resources/css/header.css','resources/css/CreateEditDarAltaBaja.css','resources/css/DarAltaAntiguoUser.css','resources/css/AsignUsers.css'],
            refresh: true,
        }),
    ],
});
