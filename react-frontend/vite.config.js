// react-frontend/vite.config.js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [react()],
  define: { 'process.env.NODE_ENV': '"production"' },
  build: {
    rollupOptions: {
      input: {
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
