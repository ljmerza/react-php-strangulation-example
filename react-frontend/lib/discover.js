import { componentRegistry } from './ComponentRegistry.js';

// Initialize the discovery system
class ComponentDiscovery {
  constructor() {
    this.registry = componentRegistry;
    this.initialized = false;
  }

  async init() {
    if (this.initialized) return;

    // Set up registry event listeners
    this.registry.subscribe((event) => {
      console.debug(`[ComponentDiscovery] ${event.type}:`, event.data);
    });

    try {
      // 1. Discover from manifest first (explicit definitions)
      console.debug('[ComponentDiscovery] Loading manifest...');
      await this.registry.discoverFromManifest();

      // 2. Discover from filesystem (auto-detect)
      console.debug('[ComponentDiscovery] Discovering from filesystem...');
      await this.registry.discoverFromFiles();

      // 3. Check DOM for components that need loading
      console.debug('[ComponentDiscovery] Scanning DOM for components...');
      this.registry.discoverFromDOM();

      this.initialized = true;
      console.debug('[ComponentDiscovery] Initialization complete');

    } catch (error) {
      console.error('[ComponentDiscovery] Initialization failed:', error);
    }
  }

  // Auto-load components found in the current DOM
  async autoLoad() {
    await this.init();
    const result = await this.registry.autoLoad();

    if (result.loaded.length > 0) {
      console.debug('[ComponentDiscovery] Auto-loaded components:', result.loaded);
    }

    if (result.failed.length > 0) {
      console.warn('[ComponentDiscovery] Failed to load components:', result.failed);
    }

    return result;
  }

  // Load specific component on-demand
  async loadComponent(tagName) {
    await this.init();
    try {
      await this.registry.load(tagName);
      console.debug(`[ComponentDiscovery] Loaded component: ${tagName}`);
      return true;
    } catch (error) {
      console.error(`[ComponentDiscovery] Failed to load ${tagName}:`, error);
      return false;
    }
  }

  // Load all available components
  async loadAll() {
    await this.init();
    const result = await this.registry.loadAll();
    console.debug('[ComponentDiscovery] Load all results:', result);
    return result;
  }

  // Get component information
  getComponentInfo(tagName) {
    return this.registry.getComponentInfo(tagName);
  }

  // Get registry statistics
  getStats() {
    return this.registry.getStats();
  }

  // List available components
  listAvailable() {
    return this.registry.getAvailableComponents();
  }
}

// Create global discovery instance
export const componentDiscovery = new ComponentDiscovery();

// DOM mutation observer to auto-load components
class ComponentObserver {
  constructor(discovery) {
    this.discovery = discovery;
    this.observer = null;
    this.processingQueue = new Set();
  }

  start() {
    if (this.observer) return;

    this.observer = new MutationObserver((mutations) => {
      const newElements = new Set();

      mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
          if (node.nodeType === Node.ELEMENT_NODE) {
            // Check if the added node is a custom element
            if (node.tagName && node.tagName.includes('-')) {
              newElements.add(node.tagName.toLowerCase());
            }

            // Check child elements
            const customElements = node.querySelectorAll?.('*[tagName*="-"], *[is]');
            customElements?.forEach(el => {
              if (el.tagName.includes('-')) {
                newElements.add(el.tagName.toLowerCase());
              }
            });
          }
        });
      });

      // Process new components
      newElements.forEach(tagName => {
        if (!this.processingQueue.has(tagName)) {
          this.processingQueue.add(tagName);
          this.processComponent(tagName);
        }
      });
    });

    this.observer.observe(document.body, {
      childList: true,
      subtree: true
    });

    console.debug('[ComponentObserver] Started watching for new components');
  }

  async processComponent(tagName) {
    try {
      // Check if component is in registry but not loaded
      const info = this.discovery.getComponentInfo(tagName);
      if (info && !info.loaded) {
        console.debug(`[ComponentObserver] Auto-loading detected component: ${tagName}`);
        await this.discovery.loadComponent(tagName);
      }
    } catch (error) {
      console.warn(`[ComponentObserver] Could not auto-load ${tagName}:`, error);
    } finally {
      this.processingQueue.delete(tagName);
    }
  }

  stop() {
    if (this.observer) {
      this.observer.disconnect();
      this.observer = null;
      console.debug('[ComponentObserver] Stopped watching');
    }
  }
}

// Auto-start discovery on DOM ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => initializeDiscovery());
} else {
  initializeDiscovery();
}

async function initializeDiscovery() {
  console.debug('[ComponentDiscovery] Starting auto-discovery...');

  // Initialize discovery system
  await componentDiscovery.init();

  // Auto-load components in current DOM
  await componentDiscovery.autoLoad();

  // Start watching for new components
  const observer = new ComponentObserver(componentDiscovery);
  observer.start();

  // Make discovery available globally for debugging
  window.componentDiscovery = componentDiscovery;

  console.debug('[ComponentDiscovery] System ready. Available commands:');
  console.debug('- window.componentDiscovery.listAvailable()');
  console.debug('- window.componentDiscovery.getStats()');
  console.debug('- window.componentDiscovery.loadComponent(tagName)');
}

export default componentDiscovery;