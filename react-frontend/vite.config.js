// react-frontend/vite.config.js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [react()],
  define: { 'process.env.NODE_ENV': '"production"' },
  build: {
    lib: {
      entry: path.resolve(__dirname, 'index.js'),
      formats: ['iife'],
      name: 'MyComponents',
      fileName: () => 'main.js',
    },
    outDir: path.resolve(__dirname, '../public/dist'),
    emptyOutDir: true,
  }
});
