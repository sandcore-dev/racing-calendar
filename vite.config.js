// eslint-disable-next-line import/no-extraneous-dependencies
import { defineConfig } from 'vite';
// eslint-disable-next-line import/no-extraneous-dependencies
import laravel from 'laravel-vite-plugin';
// eslint-disable-next-line import/no-extraneous-dependencies
import vue from '@vitejs/plugin-vue2';
// eslint-disable-next-line import/no-extraneous-dependencies
import eslint from 'vite-plugin-eslint';
import { resolve } from 'path';

export default defineConfig({
    build: {
        sourcemap: true,
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        eslint({
            fix: process.env.NODE_ENV !== 'production',
        }),
    ],
    resolve: {
        alias: [
            {
                find: '@',
                replacement: resolve(__dirname, './resources/js'),
            },
        ],
    },
});
