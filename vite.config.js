import { defineConfig } from 'vite';
import legacy from '@vitejs/plugin-legacy';

export default defineConfig({
    plugins: [
        legacy({
            targets: ['defaults', 'not IE 11'],
        }),
    ],

    root: './',

    base: process.env.NODE_ENV === 'development'
    ? '/'
    : '/wp-content/themes/landingpadtheme/dist/',

    build: {
        outDir: './dist',
        emptyOutDir: true,
        sourcemap: false,
        manifest: true,
        rollupOptions: {
            input: {
                main: './src/js/main.js',
                styles: './src/scss/main.scss'
            },
        },
    },

    server: {
        origin: 'http://localhost:5173',
        host: true,
        port: 5173,

        hmr: {
            host: 'localhost',
            port: 5173,
            protocol: 'ws',
        },
    },

    css: {
        devSourcemap: true,
        postcss: {
            plugins: [
                require('autoprefixer'),
            ],
        },
    },
});