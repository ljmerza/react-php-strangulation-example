// Vite Plugin for React-PHP Component System
import path from 'path';
import { writeFileSync, readFileSync } from 'fs';

export function reactPhpComponents(options = {}) {
  const {
    manifestPath = 'components.manifest.json',
    outputDir = '../public/dist',
    publicDir = '../public'
  } = options;

  let config;

  return {
    name: 'react-php-components',

    configResolved(resolvedConfig) {
      // Store config for later use
      config = resolvedConfig;
    },

    buildStart() {
      console.log('🚀 React-PHP Component System: Starting build...');
    },

    writeBundle(options, bundle) {
      try {
        // Read the base manifest template
        const manifestFullPath = path.resolve(config.root, manifestPath);
        const manifest = JSON.parse(readFileSync(manifestFullPath, 'utf8'));

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
        const distManifestPath = path.resolve(config.root, outputDir, 'components.manifest.json');
        const publicManifestPath = path.resolve(config.root, publicDir, 'components.manifest.json');

        const manifestJson = JSON.stringify(manifest, null, 2);
        writeFileSync(distManifestPath, manifestJson);
        writeFileSync(publicManifestPath, manifestJson);

        console.log('✅ Auto-generated manifest with updated asset paths');
        console.log('📄 Copied to: dist/ and public/');

      } catch (error) {
        console.error('❌ Failed to generate manifest:', error.message);
      }
    }
  };
}

export default reactPhpComponents;