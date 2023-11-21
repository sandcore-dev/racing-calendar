// eslint-disable-next-line import/no-extraneous-dependencies
import { defineConfig } from 'vite';
// eslint-disable-next-line import/no-extraneous-dependencies
import laravel from 'laravel-vite-plugin';
// eslint-disable-next-line import/no-extraneous-dependencies
import vue from '@vitejs/plugin-vue2';
// eslint-disable-next-line import/no-extraneous-dependencies
import eslint from 'vite-plugin-eslint';

export default defineConfig({
    plugins: [
        laravel([
            'resources/sass/app.scss',
            'resources/js/app.js',
        ]),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        eslint({
            fix: true,
        }),
    ],
});
