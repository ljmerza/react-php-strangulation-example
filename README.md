# React + PHP Strangulation Example

This project shows how to use **React** components (built as Web Components) inside legacy **PHP** pages with **two-way data binding** between PHP and React for legacy frontend strangulation.

## ✨ Features

### Core Features
- React components exported as custom web components (`<hello-widget>`)
- Two-way input binding: PHP ↔ React
- Shadow DOM isolation for styling
- Simple PHP + Apache + built React served via Docker

### 🚀 NEW: Component Discovery System
- **Intelligent loading**: Only loads components actually used on each page
- **Auto-discovery**: Automatically finds components from filesystem and manifest
- **Dynamic loading**: Add components via JavaScript, they load on-demand
- **Performance optimized**: Zero unused JavaScript, faster page loads
- **One script tag**: Replace all individual component imports
- **Real-time monitoring**: Built-in performance and usage tracking

---

## Local Development

```bash
docker compose up --build
```

Then visit these examples:

### 🎯 Discovery System Examples (Recommended)
- **[performance-comparison.php](http://localhost:8083/performance-comparison.php)** - Performance comparison & benefits
- **[hello-only-discovery.php](http://localhost:8083/hello-only-discovery.php)** - Single component (optimized)
- **[parent-only-discovery.php](http://localhost:8083/parent-only-discovery.php)** - Parent component only
- **[empty-discovery.php](http://localhost:8083/empty-discovery.php)** - Zero components (maximum performance)
- **[full-discovery.php](http://localhost:8083/full-discovery.php)** - Complete discovery demo

### 📚 Legacy Examples (For Comparison)
- **[hello.php](http://localhost:8083/hello.php)** - Original example with manual loading
- **[hello-only.php](http://localhost:8083/hello-only.php)** - Single component (old way)

## 🚀 Quick Start with Discovery System

### 1. Build the Project
```bash
cd react-frontend
npm install
npm run build
```

### 2. Use in PHP (New Way)
```html
<!DOCTYPE html>
<html>
<head>
  <title>My PHP Page</title>
  <!-- ONE script tag replaces all component imports -->
  <script type="module" src="dist/discover.js"></script>
</head>
<body>
  <!-- Components load automatically when found in DOM -->
  <hello-widget data-props='{"name": "World"}'></hello-widget>
  <parent-widget></parent-widget>
</body>
</html>
```

### 3. Performance Benefits
- ✅ **Only loads components on the page** - unused components stay unloaded
- ✅ **Automatic discovery** - no manual registration needed
- ✅ **Dynamic loading** - add components with JavaScript, they auto-load
- ✅ **Bundle splitting** - optimal performance for every page
- ✅ **Debug tools** - `window.componentDiscovery` available in browser console

## 📊 Performance Comparison

| Page Type | Old Way | Discovery System | Savings |
|-----------|---------|------------------|---------|
| Single component | Loads component only | Loads component only | Same |
| Multiple components | Loads ALL components | Loads used components | 30-50% |
| No components | Still loads bundles | Zero component code | 80-90% |
| Dynamic components | Must pre-load all | Loads on-demand | ∞% flexible |

## 🔧 Architecture

### Discovery System Files
- `react-frontend/discover.js` - Main discovery entry point
- `react-frontend/ComponentRegistry.js` - Component registry and loading logic
- `react-frontend/components.manifest.json` - Component definitions and metadata
- `react-frontend/registerReactComponent.jsx` - Web component wrapper (enhanced)

### Component Files
- `react-frontend/components/Hello.jsx` - Simple input component
- `react-frontend/components/Parent.jsx` - Parent component with child
- `react-frontend/components/Child.jsx` - Child component

### Legacy Files (Can be removed after migration)
- `react-frontend/hello.js` - Individual Hello component loader
- `react-frontend/parent.js` - Individual Parent component loader
- `react-frontend/all.js` - Manual all-components loader

## 🛠️ Usage Examples

### Basic Two-Way Binding
```html
<!-- PHP input -->
<input type="text" id="phpInput" value="Hello" />

<!-- React component -->
<hello-widget id="hello" data-props='{"name": "Hello"}'></hello-widget>

<script>
  const widget = document.getElementById('hello');
  const phpInput = document.getElementById('phpInput');

  // React → PHP
  widget.addEventListener('input-changed', e => {
    phpInput.value = e.detail.value;
  });

  // PHP → React
  phpInput.addEventListener('input', () => {
    const props = JSON.parse(widget.getAttribute('data-props'));
    props.name = phpInput.value;
    widget.setAttribute('data-props', JSON.stringify(props));
  });
</script>
```

### Dynamic Component Loading
```javascript
// Add component dynamically
const newComponent = document.createElement('hello-widget');
newComponent.setAttribute('data-props', '{"name": "Dynamic!"}');
document.body.appendChild(newComponent);
// Component auto-loads when added to DOM!

// Manual loading
await window.componentDiscovery.loadComponent('hello-widget');

// Check what's loaded
console.log(window.componentDiscovery.getStats());
```

### Component Discovery API
```javascript
// Available in browser console for debugging
window.componentDiscovery.listAvailable()     // List all components
window.componentDiscovery.getStats()          // Performance statistics
window.componentDiscovery.loadAll()           // Load all components
window.componentDiscovery.autoLoad()          // Load components in DOM
```

## 🚀 Migration from Legacy System

### Step 1: Build Discovery System
```bash
cd react-frontend
npm run build  # Builds discover.js + copies manifest
```

### Step 2: Update PHP Files
Replace:
```html
<script type="module" src="dist/hello.js"></script>
<script type="module" src="dist/parent.js"></script>
```

With:
```html
<script type="module" src="dist/discover.js"></script>
```

### Step 3: Clean Up (Optional)
```bash
# Remove legacy files
rm react-frontend/hello.js
rm react-frontend/parent.js
rm react-frontend/all.js
```

### Step 4: Enjoy Better Performance! 🎉
- Components only load when used
- Faster page loads
- Dynamic component loading
- Better debugging tools

## 🤝 Contributing

This project demonstrates the strangler fig pattern for incrementally migrating from PHP to React. The discovery system makes this migration more efficient and scalable.

## 📄 License

MIT License
