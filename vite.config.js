import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import dotenv from 'dotenv';

dotenv.config();

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
    define: {
        'process.env': {},
    },
    esbuild: {
        legalComments: 'none',
    },
    server: {
        host: '0.0.0.0', // necessary for Docker
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost', // <--- this is what the browser connects to
            protocol: 'ws',
            port: 5173,
        },
    },
});
