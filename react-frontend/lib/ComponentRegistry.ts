import { registerReactComponent } from './registerReactComponent';
import type { ComponentType } from 'react';

interface ComponentEntry {
  loader: () => Promise<any>;
  metadata: ComponentMetadata;
}

interface ComponentMetadata {
  loaded: boolean;
  registeredAt: number;
  loadedAt?: number;
  source?: string;
  path?: string;
  autoDiscovered?: boolean;
  version?: string;
  description?: string;
  props?: Record<string, string>;
}

interface ComponentInfo extends ComponentMetadata {
  tagName: string;
}

interface LoadResult {
  loaded: string[];
  failed: Array<{ tagName: string; error: Error }>;
}

interface RegistryStats {
  totalComponents: number;
  loadedComponents: number;
  unloadedComponents: number;
  components: ComponentInfo[];
  performance: PerformanceMetrics;
}

interface PerformanceMetrics {
  loadedComponents: Array<{
    name: string;
    loadTime: number;
    source?: string;
  }>;
  unloadedComponents: Array<{
    name: string;
    savedBandwidth: boolean;
    source?: string;
  }>;
  totalLoadTime: number;
  bandwidthSavings: string;
}

interface ComponentManifest {
  components: Record<string, any>;
}

type RegistryEventType = 'manifest-loaded' | 'component-loaded' | 'component-loading' | 'component-load-error' | 'discovery-completed';

interface RegistryEvent {
  type: RegistryEventType;
  data: any;
  timestamp: number;
}

type RegistryObserver = (event: RegistryEvent) => void;

export class ComponentRegistry {
  private components = new Map<string, ComponentEntry>();
  private loadedComponents = new Set<string>();
  private observers: RegistryObserver[] = [];
  private manifest: ComponentManifest | null = null;

  // Load component manifest
  async loadManifest(): Promise<ComponentManifest> {
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
  register(tagName: string, componentLoader: () => Promise<any>, metadata: Partial<ComponentMetadata> = {}): void {
    this.components.set(tagName, {
      loader: componentLoader,
      metadata: {
        loaded: false,
        registeredAt: Date.now(),
        ...metadata
      }
    });
  }

  // Auto-discover from manifest file
  async discoverFromManifest(): Promise<string[]> {
    const manifest = await this.loadManifest();
    const discovered: string[] = [];

    Object.entries(manifest.components).forEach(([tagName, config]) => {
      const componentLoader = () => import(config.path);

      if (!this.components.has(tagName)) {
        this.register(tagName, componentLoader, {
          version: config.version,
          description: config.description,
          props: config.props,
          source: 'manifest'
        });
        discovered.push(tagName);
      }
    });

    this.notifyObservers('discovery-completed', { source: 'manifest', discovered });
    return discovered;
  }

  // Auto-discover components from file system (Vite glob)
  async discoverFromFiles(): Promise<string[]> {
    const componentModules = import.meta.glob('../components/**/*.jsx');
    const discovered: string[] = [];

    for (const [path, moduleLoader] of Object.entries(componentModules)) {
      const componentName = path.match(/\/([^/]+)\.jsx$/)?.[1];
      if (componentName) {
        const tagName = `${componentName.toLowerCase()}-widget`;

        if (!this.components.has(tagName)) {
          this.register(tagName, moduleLoader, {
            source: 'filesystem',
            path: path,
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
  discoverFromDOM(): string[] {
    const discovered = new Set<string>();

    // Find all custom elements (contain hyphen)
    const customElements = document.querySelectorAll('*');
    customElements.forEach(element => {
      const tagName = element.tagName.toLowerCase();
      if (tagName.includes('-') && this.components.has(tagName)) {
        discovered.add(tagName);
      }
    });

    const discoveredArray = Array.from(discovered);
    this.notifyObservers('discovery-completed', { source: 'dom', discovered: discoveredArray });
    return discoveredArray;
  }

  // Get list of all available components
  getAvailableComponents(): string[] {
    return Array.from(this.components.keys());
  }

  // Get component metadata
  getComponentInfo(tagName: string): ComponentInfo | null {
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
  async load(tagName: string): Promise<void> {
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
      throw error;
    }
  }

  // Load multiple components
  async loadMultiple(tagNames: string[]): Promise<LoadResult> {
    const results = await Promise.allSettled(
      tagNames.map(tagName => this.load(tagName))
    );

    const loaded: string[] = [];
    const failed: Array<{ tagName: string; error: Error }> = [];

    results.forEach((result, index) => {
      const tagName = tagNames[index];
      if (result.status === 'fulfilled') {
        loaded.push(tagName);
      } else {
        failed.push({
          tagName,
          error: result.reason instanceof Error ? result.reason : new Error(String(result.reason))
        });
      }
    });

    return { loaded, failed };
  }

  // Load all available components
  async loadAll(): Promise<LoadResult> {
    const allComponents = this.getAvailableComponents();
    return this.loadMultiple(allComponents);
  }

  // Auto-load components found in current DOM
  async autoLoad(): Promise<LoadResult> {
    const domComponents = this.discoverFromDOM();
    const unloadedComponents = domComponents.filter(tagName => !this.loadedComponents.has(tagName));

    if (unloadedComponents.length === 0) {
      return { loaded: [], failed: [] };
    }

    return this.loadMultiple(unloadedComponents);
  }

  // Subscribe to registry events
  subscribe(callback: RegistryObserver): () => void {
    this.observers.push(callback);

    // Return unsubscribe function
    return () => {
      const index = this.observers.indexOf(callback);
      if (index > -1) {
        this.observers.splice(index, 1);
      }
    };
  }

  private notifyObservers(eventType: RegistryEventType, data: any): void {
    this.observers.forEach(callback => {
      try {
        callback({ type: eventType, data, timestamp: Date.now() });
      } catch (error) {
        console.error('Observer error:', error);
      }
    });
  }

  // Get registry statistics
  getStats(): RegistryStats {
    const components = this.getAvailableComponents().map(tagName => this.getComponentInfo(tagName)!);
    return {
      totalComponents: this.components.size,
      loadedComponents: this.loadedComponents.size,
      unloadedComponents: this.components.size - this.loadedComponents.size,
      components,
      performance: this.getPerformanceMetrics(components)
    };
  }

  // Get performance metrics
  private getPerformanceMetrics(components: ComponentInfo[]): PerformanceMetrics {
    const loaded = components.filter(c => c.loaded);
    const unloaded = components.filter(c => !c.loaded);

    return {
      loadedComponents: loaded.map(c => ({
        name: c.tagName,
        loadTime: (c.loadedAt || 0) - c.registeredAt,
        source: c.source
      })),
      unloadedComponents: unloaded.map(c => ({
        name: c.tagName,
        savedBandwidth: true,
        source: c.source
      })),
      totalLoadTime: loaded.reduce((total, c) => total + ((c.loadedAt || 0) - c.registeredAt), 0),
      bandwidthSavings: unloaded.length > 0 ? `${unloaded.length} components not loaded` : 'All components loaded'
    };
  }
}

// Global singleton instance
export const componentRegistry = new ComponentRegistry();