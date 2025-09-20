import { registerReactComponent } from './registerReactComponent.jsx';

export class ComponentRegistry {
  constructor() {
    this.components = new Map();
    this.loadedComponents = new Set();
    this.observers = [];
    this.manifest = null;
  }

  // Load component manifest
  async loadManifest() {
    if (!this.manifest) {
      try {
        const response = await fetch('./components.manifest.json');
        this.manifest = await response.json();
        this.notifyObservers('manifest-loaded', this.manifest);
      } catch (error) {
        console.warn('Could not load component manifest:', error);
        this.manifest = { components: {} };
      }
    }
    return this.manifest;
  }

  // Register a component loader
  register(tagName, componentLoader, metadata = {}) {
    this.components.set(tagName, {
      loader: componentLoader,
      metadata: {
        loaded: false,
        registeredAt: Date.now(),
        ...metadata
      }
    });
    this.notifyObservers('component-registered', tagName);
    return this;
  }

  // Auto-discover components from manifest
  async discoverFromManifest() {
    const manifest = await this.loadManifest();
    const discovered = [];

    for (const [tagName, config] of Object.entries(manifest.components)) {
      if (!this.components.has(tagName)) {
        // Create dynamic loader for component
        const componentLoader = () => import(config.path);
        this.register(tagName, componentLoader, {
          version: config.version,
          description: config.description,
          props: config.props,
          source: 'manifest'
        });
        discovered.push(tagName);
      }
    }

    this.notifyObservers('discovery-completed', { source: 'manifest', discovered });
    return discovered;
  }

  // Auto-discover components from file system (Vite glob)
  async discoverFromFiles() {
    const componentModules = import.meta.glob('../components/**/*.jsx');
    const discovered = [];

    for (const [path, moduleLoader] of Object.entries(componentModules)) {
      const componentName = path.match(/\/([^/]+)\.jsx$/)?.[1];
      if (componentName) {
        const tagName = `${componentName.toLowerCase()}-widget`;

        if (!this.components.has(tagName)) {
          this.register(tagName, moduleLoader, {
            path,
            source: 'filesystem',
            autoDiscovered: true
          });
          discovered.push(tagName);
        }
      }
    }

    this.notifyObservers('discovery-completed', { source: 'filesystem', discovered });
    return discovered;
  }

  // Discover components already in the DOM
  discoverFromDOM() {
    const customElements = document.querySelectorAll('*');
    const discovered = new Set();

    customElements.forEach(el => {
      const tagName = el.tagName.toLowerCase();
      if (tagName.includes('-')) {
        discovered.add(tagName);
      }
    });

    const discoveredArray = Array.from(discovered);
    this.notifyObservers('discovery-completed', { source: 'dom', discovered: discoveredArray });
    return discoveredArray;
  }

  // Get list of all available components
  getAvailableComponents() {
    return Array.from(this.components.keys());
  }

  // Get component metadata
  getComponentInfo(tagName) {
    const component = this.components.get(tagName);
    if (component) {
      return {
        tagName,
        loaded: this.loadedComponents.has(tagName),
        ...component.metadata
      };
    }
    return null;
  }

  // Load and register a specific component
  async load(tagName) {
    const componentEntry = this.components.get(tagName);

    if (!componentEntry) {
      throw new Error(`Component ${tagName} not found in registry`);
    }

    if (this.loadedComponents.has(tagName)) {
      return; // Already loaded
    }

    try {
      this.notifyObservers('component-loading', tagName);

      const module = await componentEntry.loader();
      const Component = module.default;

      // Extract component CSS if available (exported as tagNameCSS)
      const cssExportName = `${tagName.replace('-', '')}CSS`;
      const componentCSS = module[cssExportName] || '';

      registerReactComponent(tagName, Component, componentCSS);
      this.loadedComponents.add(tagName);

      componentEntry.metadata.loaded = true;
      componentEntry.metadata.loadedAt = Date.now();

      this.notifyObservers('component-loaded', tagName);
    } catch (error) {
      this.notifyObservers('component-load-error', { tagName, error });
      throw new Error(`Failed to load component ${tagName}: ${error.message}`);
    }
  }

  // Load multiple components
  async loadMultiple(tagNames) {
    const results = await Promise.allSettled(
      tagNames.map(tagName => this.load(tagName))
    );

    const loaded = [];
    const failed = [];

    results.forEach((result, index) => {
      if (result.status === 'fulfilled') {
        loaded.push(tagNames[index]);
      } else {
        failed.push({ tagName: tagNames[index], error: result.reason });
      }
    });

    return { loaded, failed };
  }

  // Load all discovered components
  async loadAll() {
    const tagNames = this.getAvailableComponents();
    return this.loadMultiple(tagNames);
  }

  // Auto-load components found in DOM
  async autoLoad() {
    const domComponents = this.discoverFromDOM();
    const toLoad = domComponents.filter(tagName =>
      this.components.has(tagName) && !this.loadedComponents.has(tagName)
    );

    if (toLoad.length > 0) {
      return this.loadMultiple(toLoad);
    }

    return { loaded: [], failed: [] };
  }

  // Observer pattern for events
  subscribe(callback) {
    this.observers.push(callback);
    return () => {
      const index = this.observers.indexOf(callback);
      if (index > -1) {
        this.observers.splice(index, 1);
      }
    };
  }

  notifyObservers(eventType, data) {
    this.observers.forEach(callback => {
      try {
        callback({ type: eventType, data, timestamp: Date.now() });
      } catch (error) {
        console.error('Observer error:', error);
      }
    });
  }

  // Get registry statistics
  getStats() {
    const components = this.getAvailableComponents().map(tagName => this.getComponentInfo(tagName));
    return {
      totalComponents: this.components.size,
      loadedComponents: this.loadedComponents.size,
      unloadedComponents: this.components.size - this.loadedComponents.size,
      components,
      performance: this.getPerformanceMetrics(components)
    };
  }

  // Get performance metrics
  getPerformanceMetrics(components) {
    const loaded = components.filter(c => c.loaded);
    const unloaded = components.filter(c => !c.loaded);

    return {
      loadedComponents: loaded.map(c => ({
        name: c.tagName,
        loadTime: c.loadedAt - c.registeredAt,
        source: c.source
      })),
      unloadedComponents: unloaded.map(c => ({
        name: c.tagName,
        savedBandwidth: true,
        source: c.source
      })),
      totalLoadTime: loaded.reduce((total, c) => total + (c.loadedAt - c.registeredAt), 0),
      bandwidthSavings: unloaded.length > 0 ? `${unloaded.length} components not loaded` : 'All components loaded'
    };
  }
}

// Global singleton instance
export const componentRegistry = new ComponentRegistry();