// react-frontend/vite.config.js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';
import { reactPhpComponents } from './lib/vite-plugin.js';

export default defineConfig({
  server: {
    host: '0.0.0.0', // Listen on all network interfaces
    port: 5173,
    strictPort: true, // Don't try other ports if 5173 is occupied
  },
  plugins: [
    react(),
    // React-PHP Component System Plugin
    reactPhpComponents({
      manifestPath: 'components.manifest.json',
      outputDir: '../public/dist',
      publicDir: '../public'
    })
  ],
  define: { 'process.env.NODE_ENV': '"production"' },
  build: {
    rollupOptions: {
      input: {
        discover: path.resolve(__dirname, 'lib/discover.js'), // Discovery system
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
