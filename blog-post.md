# The Strangler Fig Pattern: Incrementally Migrating Legacy PHP to React

Your PHP application works. It serves customers, processes payments, and keeps the business running. But every time you need to add a new feature to the frontend, it feels like performing surgery on a patient who's awake.

The codebase is a maze of jQuery spaghetti, inline styles, and server-rendered HTML that breaks when you sneeze. Your team knows React, but rewriting the entire frontend would take months and risk breaking production. Sound familiar?

This is where the Strangler Fig pattern saves the day—allowing you to modernize incrementally while keeping the lights on.

## What is the Strangler Fig Pattern?

Named after the strangler fig trees that gradually grow around and eventually replace their host trees, the Strangler Fig pattern is an incremental approach to system modernization. Instead of a risky "big bang" rewrite, you systematically replace pieces of your legacy system with new implementations.

The beauty lies in coexistence: old and new code run side-by-side during the transition. Each piece you replace immediately delivers value while reducing technical debt. The legacy system continues working until it's no longer needed.

This pattern works because it:
- **Reduces risk**: Small, incremental changes vs. massive rewrites
- **Enables continuous delivery**: Ship improvements without waiting for completion
- **Preserves business continuity**: No downtime, no broken features
- **Allows learning**: Mistakes are small and recoverable

## Why Use It for PHP→React Migration?

PHP backends are often solid—they handle business logic, databases, and authentication well. The problem is usually the frontend: mixed server-rendered HTML with scattered JavaScript that's impossible to maintain or test.

The Strangler Fig pattern is perfect here because:

**Your PHP backend stays valuable**: Keep your battle-tested business logic, APIs, and data layer while modernizing just the UI.

**Team skill transition happens gradually**: Developers learn React on real features rather than contrived examples. Senior PHP developers can mentor while junior developers bring React expertise.

**ROI from day one**: Each component you migrate immediately improves user experience and developer productivity. No waiting months for a big launch.

**Zero downtime migration**: Users never notice the transition. Features work the same while becoming more maintainable under the hood.

## Implementation: Web Components as the Bridge

The key insight is using Web Components as a bridge between PHP and React. Here's how it works:

### 1. Wrap React Components as Web Components

Create a utility that converts React components into custom HTML elements:

```javascript
// registerReactComponent.jsx
import { createRoot } from 'react-dom/client';

export function registerReactComponent(tagName, Component) {
  class ReactCustomElement extends HTMLElement {
    connectedCallback() {
      this.attachShadow({ mode: 'open' });
      this._root = createRoot(this.shadowRoot);
      this._render();
    }
    
    _render() {
      const props = JSON.parse(this.getAttribute('data-props') || '{}');
      this._root.render(<Component {...props} />);
    }
  }
  
  customElements.define(tagName, ReactCustomElement);
}
```

### 2. Use Components in PHP Pages

Your PHP pages can now include React components as simple HTML tags:

```php
<!DOCTYPE html>
<html>
<head>
  <script type="module" src="dist/hello.js"></script>
</head>
<body>
  <h2>Legacy PHP Page</h2>
  
  <!-- React component embedded seamlessly -->
  <hello-widget data-props='{"name": "<?= $user->name ?>"}'></hello-widget>
  
  <!-- Rest of your PHP-rendered content -->
</body>
</html>
```

### 3. Enable Two-Way Communication

The real power comes from bidirectional data flow between PHP and React:

```javascript
// React → PHP communication via custom events
const emit = (eventName, data) => {
  this.dispatchEvent(new CustomEvent(eventName, { detail: data }));
};

// PHP → React communication via attribute changes
widget.setAttribute('data-props', JSON.stringify(newData));
```

### 4. Optimize with Code Splitting

Configure Vite to build separate bundles for each component:

```javascript
// vite.config.js
export default defineConfig({
  build: {
    rollupOptions: {
      input: {
        hello: 'hello.js',      // Only Hello component
        checkout: 'checkout.js', // Only Checkout component
        all: 'all.js'           // All components
      }
    }
  }
});
```

Now different PHP pages can load only the components they need, keeping bundle sizes minimal.

## Production Considerations

**SEO Impact**: Web Components render client-side, potentially affecting search rankings. For SEO-critical pages, consider server-side rendering or progressive enhancement.

**Performance Monitoring**: Track bundle sizes and loading times. Each new React component adds JavaScript overhead—measure the impact on your Core Web Vitals.

**Rollback Strategy**: Since components are isolated, rolling back a problematic React component is as simple as reverting to the old PHP-rendered version.

**Team Coordination**: Establish clear ownership boundaries. Who maintains the PHP-React bridge? How do you handle breaking changes in shared dependencies?

## When to Use This Pattern

The Strangler Fig pattern works best when:
- Your backend logic is solid but frontend needs modernization
- You can't afford extended development freezes
- Your team has mixed PHP/React skills
- You have complex, interactive UI components that would benefit from React's state management

Skip this approach if you're building a new application from scratch or if your PHP codebase has fundamental architectural problems that require a complete rewrite.

## Next Steps

Ready to try it yourself? Check out the [working demo](https://github.com/your-repo/react-php-strangulation-example) with complete source code, Docker setup, and multiple implementation examples.

Start small: pick one interactive component from your PHP app and migrate it to React. You'll be surprised how quickly the benefits compound.