// React Strangler - Main entry point for the component discovery and registration system

export { registerReactComponent } from './registerReactComponent';
export { ComponentRegistry, componentRegistry } from './ComponentRegistry';
export { componentDiscovery } from './discover';

// Re-export discovery system for backwards compatibility
export { default as discovery } from './discover';