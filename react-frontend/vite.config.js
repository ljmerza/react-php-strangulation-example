// react-frontend/vite.config.js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';
import { copyFileSync } from 'fs';

export default defineConfig({
  server: {
    host: '0.0.0.0', // Listen on all network interfaces
    port: 5173,
    strictPort: true, // Don't try other ports if 5173 is occupied
  },
  plugins: [
    react(),
    // Plugin to copy manifest to dist directory
    {
      name: 'copy-manifest',
      writeBundle() {
        try {
          copyFileSync(
            path.resolve(__dirname, 'components.manifest.json'),
            path.resolve(__dirname, '../public/dist/components.manifest.json')
          );
          console.log('✓ Copied components.manifest.json to dist/');
        } catch (error) {
          console.warn('Could not copy manifest:', error.message);
        }
      }
    }
  ],
  define: { 'process.env.NODE_ENV': '"production"' },
  build: {
    rollupOptions: {
      input: {
        discover: path.resolve(__dirname, 'discover.js'), // New discovery system
        hello: path.resolve(__dirname, 'hello.js'),
        parent: path.resolve(__dirname, 'parent.js'),
        all: path.resolve(__dirname, 'all.js'),
        main: path.resolve(__dirname, 'index.js'), // Keep for backward compatibility
      },
      output: {
        entryFileNames: '[name].js',
        format: 'es',
        dir: path.resolve(__dirname, '../public/dist'),
      },
    },
    outDir: path.resolve(__dirname, '../public/dist'),
    emptyOutDir: true,
  }
});
