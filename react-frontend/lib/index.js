// React-PHP Component System - Vite Plugin
// Main entry point for the component discovery and registration system

export { registerReactComponent } from './registerReactComponent.jsx';
export { ComponentRegistry, componentRegistry } from './ComponentRegistry.js';
export { componentDiscovery } from './discover.js';

// Re-export discovery system for backwards compatibility
export { default as discovery } from './discover.js';