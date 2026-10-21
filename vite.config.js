const { defineConfig } = require('vite');
const laravel = require('laravel-vite-plugin').default;

module.exports = defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
