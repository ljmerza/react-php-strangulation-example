// react-frontend/vite.config.js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';
import { writeFileSync, readFileSync } from 'fs';

export default defineConfig({
  server: {
    host: '0.0.0.0', // Listen on all network interfaces
    port: 5173,
    strictPort: true, // Don't try other ports if 5173 is occupied
  },
  plugins: [
    react(),
    // Plugin to auto-generate manifest with correct asset paths
    {
      name: 'auto-generate-manifest',
      writeBundle(options, bundle) {
        try {
          // Read the base manifest template
          const manifestPath = path.resolve(__dirname, 'components.manifest.json');
          const manifest = JSON.parse(readFileSync(manifestPath, 'utf8'));

          // Find the actual built asset paths
          const assetMap = {};
          Object.keys(bundle).forEach(fileName => {
            const chunk = bundle[fileName];
            if (chunk.type === 'chunk' && chunk.facadeModuleId) {
              const modulePath = chunk.facadeModuleId;
              const componentName = path.basename(modulePath, path.extname(modulePath));
              if (modulePath.includes('/components/')) {
                assetMap[componentName] = `./${fileName}`;
              }
            }
          });

          console.log('🔍 Found component assets:', assetMap);

          // Update manifest paths with actual built asset paths
          Object.keys(manifest.components).forEach(componentKey => {
            const component = manifest.components[componentKey];
            const originalPath = component.path;

            // Extract component name from original path
            if (originalPath.includes('/components/')) {
              const componentName = path.basename(originalPath, '.jsx');
              if (assetMap[componentName]) {
                component.path = assetMap[componentName];
                console.log(`📦 Updated ${componentKey}: ${originalPath} → ${component.path}`);
              } else {
                console.warn(`⚠️  No asset found for component: ${componentName}`);
              }
            }
          });

          // Write updated manifest to both dist and public
          const distManifestPath = path.resolve(__dirname, '../public/dist/components.manifest.json');
          const publicManifestPath = path.resolve(__dirname, '../public/components.manifest.json');

          const manifestJson = JSON.stringify(manifest, null, 2);
          writeFileSync(distManifestPath, manifestJson);
          writeFileSync(publicManifestPath, manifestJson);

          console.log('✅ Auto-generated manifest with updated asset paths');
          console.log('📄 Copied to: dist/ and public/');

        } catch (error) {
          console.error('❌ Failed to generate manifest:', error.message);
        }
      }
    }
  ],
  define: { 'process.env.NODE_ENV': '"production"' },
  build: {
    rollupOptions: {
      input: {
        discover: path.resolve(__dirname, 'discover.js'), // Discovery system
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
