import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/home.scss',
                'resources/css/manage.scss',
                'resources/css/table.scss',
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/echo.js',
                'resources/js/bootstrap.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: true
    }
});
