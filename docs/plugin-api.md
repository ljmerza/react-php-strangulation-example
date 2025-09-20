# Plugin API Reference

> Complete reference for the React Strangler Vite plugin configuration and API.

## Plugin Configuration

### Basic Setup

```typescript
import { reactStrangler } from 'vite-plugin-react-strangler';

export default defineConfig({
  plugins: [
    react(),
    reactStrangler({
      outputDir: '../public/dist',
      publicDir: '../public'
    })
  ]
});
```

### Configuration Options

```typescript
interface ReactStranglerOptions {
  /** Output directory for built assets */
  outputDir?: string;
  /** Public directory for manifest copying */
  publicDir?: string;
  /** Discovery system entry point */
  discoveryEntry?: string;
}
```

#### `outputDir`
- **Type:** `string`
- **Default:** `'../public/dist'`
- **Description:** Directory where built component assets will be placed
- **Example:** `'./build'`, `'../static/js'`, `'./public/assets'`

#### `publicDir`
- **Type:** `string`
- **Default:** `'../public'`
- **Description:** Directory where the component manifest will be copied
- **Example:** `'./public'`, `'../web'`, `'./static'`

#### `discoveryEntry`
- **Type:** `string`
- **Default:** `'lib/discover.ts'`
- **Description:** Entry point for the discovery system
- **Example:** `'src/discover.js'`, `'lib/strangler.ts'`

## Automatic Features

### CSS Export Injection

The plugin automatically injects CSS exports for any component with a corresponding `.module.css` file:

**Your component:**
```tsx
// UserCard.tsx
import styles from './UserCard.module.css';

export default function UserCard({ name }: { name: string }) {
  return <div className={styles.card}>{name}</div>;
}
```

**Auto-generated during build:**
```typescript
// Added automatically by plugin
import usercardwidgetCSSText from './UserCard.module.css?inline';
export const usercardwidgetCSS = usercardwidgetCSSText;
```

### Component Discovery

Components are automatically discovered and registered:

1. **File scanning:** All `.jsx` and `.tsx` files in `components/` directory
2. **Tag name generation:** `UserCard.tsx` → `usercard-widget`
3. **Special cases:** `DataTable.tsx` → `data-table` (not `datatable-widget`)
4. **Manifest generation:** Complete component manifest with asset paths

### Manifest Structure

Auto-generated `components.manifest.json`:

```json
{
  "version": "1.0.0",
  "components": {
    "usercard-widget": {
      "path": "./assets/UserCard-abc123.js",
      "version": "1.0.0",
      "dependencies": ["react", "react-dom"],
      "description": "UserCard component",
      "category": "card",
      "props": {
        "className": "string"
      }
    }
  },
  "paths": {
    "base": "./",
    "components": "./components/",
    "dist": "../public/dist"
  },
  "metadata": {
    "created": "2024-01-15",
    "framework": "react",
    "bundler": "vite",
    "plugin": "react-strangler"
  }
}
```

## Build Process

### 1. Transform Phase
- Scans all component files (`.jsx`, `.tsx`)
- Detects corresponding CSS modules
- Injects CSS exports automatically
- Logs injection process

### 2. Bundle Phase
- Builds components with Vite/Rollup
- Generates hashed asset filenames
- Creates discovery system bundle

### 3. Manifest Generation
- Maps component names to asset paths
- Creates component definitions
- Copies manifest to output directories

## Integration with Discovery System

### Component Registration

```typescript
// Auto-generated registration
registerReactComponent(
  'usercard-widget',           // Tag name
  UserCardComponent,           // React component
  usercardwidgetCSS           // Scoped CSS
);
```

### Usage in PHP

```html
<!-- Individual attributes (recommended) -->
<usercard-widget
  name="John Doe"
  email="john@example.com"
  role="admin">
</usercard-widget>

<!-- JSON props (legacy support) -->
<usercard-widget
  data-props='{"name": "John Doe", "email": "john@example.com"}'>
</usercard-widget>
```

## File Structure Requirements

### Required Structure
```
your-project/
├── components/              # Required: Component source files
│   ├── ComponentName.tsx    # Component implementation
│   ├── ComponentName.module.css  # Optional: Scoped styles
│   └── NestedComponents/
│       ├── SubComponent.tsx
│       └── SubComponent.module.css
├── lib/                     # Required: Plugin files
│   ├── vite-plugin.ts
│   ├── registerReactComponent.ts
│   ├── ComponentRegistry.ts
│   ├── discover.ts
│   └── index.ts
└── vite.config.js          # Required: Plugin configuration
```

### Generated Structure
```
output-directory/
├── discover.js             # Main discovery system
├── components.manifest.json # Component registry
└── assets/
    ├── ComponentName-hash.js   # Individual component bundles
    └── ComponentName-hash.css  # Extracted CSS (separate files)
```

## Advanced Configuration

### Custom Build Configuration

The plugin automatically configures Vite build settings, but you can override:

```javascript
export default defineConfig({
  plugins: [
    react(),
    reactStrangler({
      outputDir: '../dist',
      publicDir: '../public'
    })
  ],
  build: {
    // These settings are auto-configured by the plugin,
    // but can be overridden if needed
    rollupOptions: {
      // Custom rollup options
    }
  }
});
```

### Multiple Component Directories

For complex projects with multiple component sources:

```typescript
// Multiple plugin instances (advanced usage)
export default defineConfig({
  plugins: [
    react(),

    // Admin components
    reactStrangler({
      outputDir: '../admin/dist',
      publicDir: '../admin'
    }),

    // Public components
    reactStrangler({
      outputDir: '../public/dist',
      publicDir: '../public'
    })
  ]
});
```

## Plugin Hooks

### Available Hooks

```typescript
// Custom plugin extending React Strangler
function customStranglerPlugin() {
  return {
    name: 'custom-strangler',

    // Hook into component discovery
    'react-strangler:component-discovered'(componentInfo) {
      console.log('New component discovered:', componentInfo);
    },

    // Hook into CSS processing
    'react-strangler:css-processed'(cssInfo) {
      // Custom CSS processing
    },

    // Hook into manifest generation
    'react-strangler:manifest-generated'(manifest) {
      // Add custom metadata to manifest
      manifest.custom = { timestamp: Date.now() };
    }
  };
}
```

## Troubleshooting

### Common Issues

**Components not loading:**
- Check that `discover.js` is included in your PHP page
- Verify component files are in `components/` directory
- Check browser console for discovery system errors

**CSS not applied:**
- Ensure CSS Modules are named `ComponentName.module.css`
- Check that components use `styles.className` syntax
- Verify CSS is being injected into shadow DOM

**Build failures:**
- Check that all components export default functions
- Verify TypeScript types are correct
- Ensure CSS files exist for components that reference them

### Debug Mode

Enable debug logging:

```javascript
// In browser console
window.componentDiscovery.debug = true;

// View discovery stats
console.log(window.componentDiscovery.getStats());

// List available components
console.log(window.componentDiscovery.listAvailable());
```

## Performance Considerations

### Bundle Optimization
- Components are code-split automatically
- CSS is scoped and tree-shaken
- Only used components are loaded per page

### Lazy Loading
- Components load on-demand when found in DOM
- MutationObserver watches for dynamically added components
- Zero initial bundle size for pages without React components

### Caching Strategy
- Component bundles have content-based hashes
- Manifest updates only when components change
- Browser caching optimized for long-term storage