import { defineConfig } from 'vite';
import legacy from '@vitejs/plugin-legacy';
import inject from '@rollup/plugin-inject';

export default defineConfig(({ command }) => {
  const isDev = command === 'serve';

  return {
    base: isDev ? '/' : '/wp-content/themes/landingpadtheme/dist/',

    plugins: [
      legacy({
        targets: ['defaults', 'not IE 11'],
      }),
      inject({
        $: 'jquery',
        jQuery: 'jquery',
      }),
      {
        name: 'php',
        handleHotUpdate({ file, server }) {
          if (file.endsWith('.php')) {
            server.ws.send({ type: 'full-reload' });
          }
        },
      },
    ],

    build: {
      outDir: './dist',
      emptyOutDir: true,
      manifest: true,
      sourcemap: true,
      rollupOptions: {
        input: {
          main: './src/js/main.js',
          styles: './src/scss/main.scss',
        },
      },
    },

    server: {
      origin: 'http://localhost:5173',
      host: '0.0.0.0',
      port: 5173,
      strictPort: true,
    },

    css: {
      devSourcemap: true,
      preprocessorOptions: {
        scss: {
          silenceDeprecations: ['legacy-js-api', 'import', 'global-builtin'],
        },
      },
    },
  };
});