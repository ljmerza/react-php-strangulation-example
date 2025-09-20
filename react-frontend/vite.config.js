// react-frontend/vite.config.js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { reactStrangler } from './lib/vite-plugin.ts';

export default defineConfig({
  server: {
    host: '0.0.0.0', // Listen on all network interfaces
    port: 5173,
    strictPort: true, // Don't try other ports if 5173 is occupied
  },
  plugins: [
    react(),
    // React Strangler Plugin (fully automatic!)
    reactStrangler({
      outputDir: '../public/dist',
      publicDir: '../public'
    })
  ]
});
