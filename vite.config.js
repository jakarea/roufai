import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.jsx',
                'resources/css/website.css',
                'resources/js/website.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    esbuild: {
        jsx: 'automatic',
        jsxImportSource: 'react',
    },
    optimizeDeps: {
        esbuildOptions: {
            jsx: 'automatic',
            jsxImportSource: 'react',
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        strictPort: false,
        host: true,
    },
});
