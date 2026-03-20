import { defineConfig } from 'vite';
import symfonyPlugin from 'vite-plugin-symfony';

export default defineConfig({
    plugins: [
        symfonyPlugin({
            stimulus: true,
        }),
    ],
    root: '.',
    base: '/build/',
    build: {
        manifest: true,
        emptyOutDir: true,
        assetsDir: '',
        outDir: './public/build',
        rollupOptions: {
            input: {
                app: './assets/app.js',
            },
        },
    },
    server: {
        cors: true,
        strictPort: true,
        port: 5173,
        https: false,
    },
});
