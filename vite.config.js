import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

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
    build: {
        rollupOptions: {
            output: {
                manualChunks: undefined,
                inlineDynamicImports: true,
                // entryFileNames: '[name].js',   // currently does not work for the legacy bundle
                // assetFileNames: '[name].[ext]', // currently does not work for images
            },
        },
    },
});
