// react-frontend/vite.config.js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { reactPhpComponents } from './lib/vite-plugin.js';

export default defineConfig({
  server: {
    host: '0.0.0.0', // Listen on all network interfaces
    port: 5173,
    strictPort: true, // Don't try other ports if 5173 is occupied
  },
  plugins: [
    react(),
    // React-PHP Component System Plugin (fully automatic!)
    reactPhpComponents({
      outputDir: '../public/dist',
      publicDir: '../public'
    })
  ]
});
