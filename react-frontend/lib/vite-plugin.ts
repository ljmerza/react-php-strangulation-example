// Vite Plugin for React Strangler Pattern
import path from 'path';
import { writeFileSync, readFileSync, existsSync } from 'fs';
import type { Plugin, ResolvedConfig } from 'vite';

export interface ReactStranglerOptions {
  /** Output directory for built assets */
  outputDir?: string;
  /** Public directory for manifest copying */
  publicDir?: string;
  /** Discovery system entry point */
  discoveryEntry?: string;
}

interface ComponentDefinition {
  path: string;
  version: string;
  dependencies: string[];
  description: string;
  category: 'basic' | 'card' | 'composed';
  props: Record<string, string>;
}

interface ComponentManifest {
  version: string;
  components: Record<string, ComponentDefinition>;
  paths: {
    base: string;
    components: string;
    dist: string;
  };
  metadata: {
    created: string;
    framework: string;
    bundler: string;
    plugin: string;
  };
}

export function reactStrangler(options: ReactStranglerOptions = {}): Plugin {
  const {
    outputDir = '../public/dist',
    publicDir = '../public',
    discoveryEntry = 'lib/discover.ts'
  } = options;

  let config: ResolvedConfig;

  return {
    name: 'react-strangler',

    configResolved(resolvedConfig: ResolvedConfig) {
      // Store config for later use
      config = resolvedConfig;
    },

    config(userConfig, { command }) {
      // Auto-configure build settings for React Strangler components
      if (command === 'build') {
        return {
          build: {
            rollupOptions: {
              input: {
                discover: path.resolve(userConfig.root || process.cwd(), discoveryEntry)
              },
              output: {
                entryFileNames: '[name].js',
                format: 'es',
                dir: path.resolve(userConfig.root || process.cwd(), outputDir)
              }
            },
            outDir: path.resolve(userConfig.root || process.cwd(), outputDir),
            emptyOutDir: true
          }
        };
      }
    },

    buildStart() {
      console.log('🚀 React Strangler: Starting build...');
    },

    transform(code: string, id: string) {
      // Auto-inject CSS exports for component files
      if (id.endsWith('.jsx') && id.includes('/components/')) {
        // Check if corresponding .module.css file exists
        const cssPath = id.replace('.jsx', '.module.css');

        if (existsSync(cssPath)) {
          const componentName = path.basename(id, '.jsx');

          // Generate tag name (Card → card-widget, Hello → hello-widget)
          const tagName = componentName === 'DataTable'
            ? 'data-table'
            : `${componentName.toLowerCase()}-widget`;

          // Create CSS export name (card-widget → cardwidgetCSS)
          const exportName = `${tagName.replace('-', '')}CSS`;

          // Check if CSS export already exists to avoid duplication
          if (!code.includes(`export const ${exportName}`)) {
            const cssImportPath = `./${componentName}.module.css?inline`;

            // Add CSS import and export
            const cssExport = `
// Auto-generated CSS export
import ${exportName}Text from '${cssImportPath}';
export const ${exportName} = ${exportName}Text;`;

            console.log(`🎨 Auto-injecting CSS export: ${exportName} for ${componentName}`);
            return code + cssExport;
          }
        }
      }

      return null; // No transformation needed
    },

    writeBundle(options, bundle) {
      try {
        // Auto-generate manifest from discovered components
        const manifest: ComponentManifest = {
          version: '1.0.0',
          components: {},
          paths: {
            base: './',
            components: './components/',
            dist: outputDir
          },
          metadata: {
            created: new Date().toISOString().split('T')[0],
            framework: 'react',
            bundler: 'vite',
            plugin: 'react-strangler'
          }
        };

        // Find the actual built asset paths and auto-generate component definitions
        const assetMap: Record<string, string> = {};
        Object.keys(bundle).forEach(fileName => {
          const chunk = bundle[fileName];
          if (chunk.type === 'chunk' && chunk.facadeModuleId) {
            const modulePath = chunk.facadeModuleId;
            const componentName = path.basename(modulePath, path.extname(modulePath));
            if (modulePath.includes('/components/')) {
              assetMap[componentName] = `./${fileName}`;

              // Auto-generate component definition
              const tagName = componentName === 'DataTable'
                ? 'data-table'
                : `${componentName.toLowerCase()}-widget`;

              const category: ComponentDefinition['category'] =
                componentName === 'Hello' ? 'basic'
                : componentName.includes('Card') ? 'card'
                : 'composed';

              manifest.components[tagName] = {
                path: `./${fileName}`,
                version: '1.0.0',
                dependencies: ['react', 'react-dom'],
                description: `${componentName} component`,
                category: category,
                props: {
                  className: 'string'
                }
              };

              console.log(`📦 Auto-generated: ${tagName} → ${fileName}`);
            }
          }
        });

        console.log('🔍 Found component assets:', assetMap);

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

export default reactStrangler;