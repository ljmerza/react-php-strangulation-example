# API Reference

> Complete technical reference for React Strangler components, methods, and APIs.

## Component Registration API

### `registerReactComponent(tagName, Component, componentCSS?)`

Registers a React component as a web component.

**Parameters:**
- `tagName: string` - The custom element tag name (e.g., 'user-card')
- `Component: ComponentType<any>` - React component function or class
- `componentCSS?: string` - Optional CSS to inject into shadow DOM

**Example:**
```typescript
import { registerReactComponent } from 'react-strangler';
import UserCard from './UserCard';
import userCardCSS from './UserCard.module.css?inline';

registerReactComponent('user-card', UserCard, userCardCSS);
```

### `isComponentRegistered(tagName)`

Check if a component is already registered.

**Parameters:**
- `tagName: string` - The custom element tag name

**Returns:** `boolean`

**Example:**
```typescript
if (isComponentRegistered('user-card')) {
  console.log('UserCard is already registered');
}
```

### `getRegisteredComponents()`

Get list of all registered component tag names.

**Returns:** `string[]`

**Example:**
```typescript
const registered = getRegisteredComponents();
console.log('Registered components:', registered);
// Output: ['user-card', 'data-table', 'hello-widget']
```

## Discovery System API

### ComponentDiscovery Class

Main class for component discovery and loading.

#### Methods

##### `init(): Promise<void>`

Initialize the discovery system.

```typescript
await componentDiscovery.init();
```

##### `autoLoad(): Promise<LoadResult>`

Auto-load all components found in the current DOM.

**Returns:**
```typescript
interface LoadResult {
  loaded: string[];
  failed: Array<{ tagName: string; error: Error }>;
}
```

**Example:**
```typescript
const result = await componentDiscovery.autoLoad();
console.log('Loaded:', result.loaded);
console.log('Failed:', result.failed);
```

##### `loadComponent(tagName): Promise<boolean>`

Load a specific component on-demand.

**Parameters:**
- `tagName: string` - Component tag name to load

**Returns:** `Promise<boolean>` - Success status

**Example:**
```typescript
const success = await componentDiscovery.loadComponent('user-card');
if (success) {
  console.log('UserCard loaded successfully');
}
```

##### `loadAll(): Promise<LoadResult>`

Load all available components.

**Example:**
```typescript
const result = await componentDiscovery.loadAll();
console.log(`Loaded ${result.loaded.length} components`);
```

##### `getStats(): ComponentStats`

Get detailed statistics about the discovery system.

**Returns:**
```typescript
interface ComponentStats {
  totalComponents: number;
  loadedComponents: number;
  unloadedComponents: number;
  components: ComponentInfo[];
  performance: PerformanceMetrics;
}
```

**Example:**
```typescript
const stats = componentDiscovery.getStats();
console.log(`${stats.loadedComponents}/${stats.totalComponents} components loaded`);
```

##### `listAvailable(): string[]`

Get list of all available component tag names.

**Example:**
```typescript
const available = componentDiscovery.listAvailable();
console.log('Available components:', available);
```

##### `getComponentInfo(tagName): ComponentInfo | null`

Get detailed information about a specific component.

**Parameters:**
- `tagName: string` - Component tag name

**Returns:**
```typescript
interface ComponentInfo {
  tagName: string;
  loaded: boolean;
  registeredAt: number;
  loadedAt?: number;
  source?: string;
  path?: string;
}
```

## Component Registry API

### ComponentRegistry Class

Low-level component registry for advanced usage.

#### Methods

##### `register(tagName, loader, metadata?): void`

Register a component loader function.

**Parameters:**
- `tagName: string` - Component tag name
- `loader: () => Promise<any>` - Function that returns component module
- `metadata?: Partial<ComponentMetadata>` - Optional metadata

##### `load(tagName): Promise<void>`

Load and register a specific component.

##### `loadMultiple(tagNames): Promise<LoadResult>`

Load multiple components in parallel.

##### `subscribe(callback): () => void`

Subscribe to registry events.

**Parameters:**
- `callback: (event: RegistryEvent) => void` - Event handler

**Returns:** Unsubscribe function

**Example:**
```typescript
const unsubscribe = componentRegistry.subscribe((event) => {
  console.log('Registry event:', event.type, event.data);
});

// Later...
unsubscribe();
```

## Event System

### Component Events

All web components emit standardized events:

#### `input-changed`
Emitted when component input values change.

**Detail:**
```typescript
{
  value: any;          // New input value
  component: string;   // Component tag name
}
```

**Usage:**
```javascript
document.querySelector('hello-widget').addEventListener('input-changed', (e) => {
  console.log('Input changed to:', e.detail.value);
});
```

#### `form-submitted`
Emitted when form components are submitted.

**Detail:**
```typescript
{
  data: Record<string, any>;  // Form data
  component: string;          // Component tag name
}
```

#### `row-clicked`
Emitted when data table rows are clicked.

**Detail:**
```typescript
{
  row: any;      // Row data
  index: number; // Row index
}
```

### Registry Events

Subscribe to component lifecycle events:

#### Event Types
- `manifest-loaded` - Component manifest loaded
- `component-loading` - Component is being loaded
- `component-loaded` - Component successfully loaded
- `component-load-error` - Component failed to load
- `discovery-completed` - Discovery phase completed

**Example:**
```typescript
componentRegistry.subscribe((event) => {
  switch (event.type) {
    case 'component-loaded':
      console.log('Component loaded:', event.data);
      break;
    case 'component-load-error':
      console.error('Load failed:', event.data.tagName, event.data.error);
      break;
  }
});
```

## CSS Modules Integration

### Automatic CSS Injection

Components with CSS Modules get automatic style injection:

```tsx
// Component automatically gets scoped styles
import styles from './MyComponent.module.css';

export default function MyComponent() {
  return <div className={styles.container}>Styled content</div>;
}
```

### CSS Export Pattern

The plugin automatically generates CSS exports:

```typescript
// Auto-generated by plugin
import mycomponentwidgetCSSText from './MyComponent.module.css?inline';
export const mycomponentwidgetCSS = mycomponentwidgetCSSText;
```

### Shadow DOM Styling

CSS is injected into each component's shadow DOM:

```javascript
// Automatic shadow DOM CSS injection
const style = document.createElement('style');
style.textContent = componentCSS;
shadowRoot.appendChild(style);
```

## Attribute Parsing

### Individual Attributes

Components receive props from HTML attributes:

```html
<usercard-widget
  name="John Doe"
  age="30"
  active="true"
  data='{"preferences": {"theme": "dark"}}'>
</usercard-widget>
```

**Parsed to React props:**
```typescript
{
  name: "John Doe",           // String
  age: 30,                    // Number (auto-converted)
  active: true,               // Boolean (auto-converted)
  data: {                     // JSON (auto-parsed)
    preferences: { theme: "dark" }
  }
}
```

### Type Conversion Rules

| HTML Attribute | React Prop |
|----------------|------------|
| `"true"` | `true` (boolean) |
| `"false"` | `false` (boolean) |
| `"123"` | `123` (number) |
| `'{"key": "value"}'` | `{key: "value"}` (JSON) |
| `"text"` | `"text"` (string) |

### Special Attributes

- `data-props` - Legacy JSON props (backward compatibility)
- `id`, `class` - Standard HTML attributes (preserved)
- `data-*` - Data attributes (ignored by parser)

## Web Component Lifecycle

### Custom Element Hooks

```typescript
class ReactCustomElement extends HTMLElement {
  // Called when element is added to DOM
  connectedCallback(): void {
    // Create shadow DOM
    // Inject CSS
    // Create React root
    // Render component
  }

  // Called when attributes change
  attributeChangedCallback(name: string, oldVal: string | null, newVal: string | null): void {
    // Re-parse attributes
    // Re-render component
  }

  // Called when element is removed from DOM
  disconnectedCallback(): void {
    // Cleanup React root
    // Remove event listeners
  }
}
```

### Shadow DOM Structure

```html
<usercard-widget name="John">
  #shadow-root (open)
    <style>/* Scoped CSS */</style>
    <div class="UserCard_card__abc123">
      <!-- React component renders here -->
    </div>
</usercard-widget>
```

## Error Handling

### Component Load Errors

```typescript
try {
  await componentDiscovery.loadComponent('invalid-component');
} catch (error) {
  console.error('Component load failed:', error.message);
  // Fallback to legacy implementation
}
```

### React Component Errors

Use React Error Boundaries:

```tsx
class ComponentErrorBoundary extends React.Component {
  componentDidCatch(error: Error, errorInfo: React.ErrorInfo) {
    console.error('React component error:', error, errorInfo);

    // Report to error tracking service
    errorTracker.captureException(error, {
      component: this.props.componentName,
      errorInfo
    });
  }

  render() {
    if (this.state.hasError) {
      return <div>Something went wrong. Using legacy fallback.</div>;
    }
    return this.props.children;
  }
}
```

## Performance Optimization

### Bundle Splitting

Components are automatically code-split:

```javascript
// Each component becomes its own bundle
const UserCard = () => import('./components/UserCard.tsx');
const DataTable = () => import('./components/DataTable.tsx');
```

### Lazy Loading

```typescript
// Components load only when needed
const observer = new MutationObserver((mutations) => {
  mutations.forEach((mutation) => {
    mutation.addedNodes.forEach((node) => {
      if (node.tagName?.includes('-')) {
        // Auto-load discovered component
        componentDiscovery.loadComponent(node.tagName.toLowerCase());
      }
    });
  });
});
```

### Memory Management

```typescript
// Automatic cleanup when components are removed
class ReactCustomElement extends HTMLElement {
  disconnectedCallback() {
    if (this._root) {
      this._root.unmount(); // Clean up React root
      this._root = null;
    }
  }
}
```

## Browser Compatibility

### Required Features
- **ES Modules** - Modern import/export syntax
- **Custom Elements** - Web components support
- **Shadow DOM** - Style encapsulation
- **MutationObserver** - Dynamic component detection

### Supported Browsers
- **Chrome/Edge** 63+
- **Firefox** 60+
- **Safari** 10.1+

### Fallback Strategy
```html
<script>
  if (!window.customElements) {
    // Load polyfill or show legacy content
    document.body.className += ' legacy-mode';
  }
</script>
```

## Global API

### Window Object Extensions

The discovery system adds global debugging utilities:

```typescript
declare global {
  interface Window {
    componentDiscovery: ComponentDiscovery;
  }
}

// Available in browser console
window.componentDiscovery.listAvailable();
window.componentDiscovery.getStats();
window.componentDiscovery.loadComponent('user-card');
```