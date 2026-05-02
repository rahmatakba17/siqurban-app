import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    define: {
        // Expose env vars to browser via import.meta.env
        __REVERB_APP_KEY__: JSON.stringify(process.env.REVERB_APP_KEY),
    },
});
