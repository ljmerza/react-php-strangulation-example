// Complete React-PHP Component System
// This file exports everything needed to use the system

// Core system
export { registerReactComponent } from './registerReactComponent.jsx';
export { ComponentRegistry, componentRegistry } from './ComponentRegistry.js';
export { componentDiscovery } from './discover.js';

// Vite plugin
export { reactStrangler as default } from './vite-plugin.js';
export { reactStrangler } from './vite-plugin.js';

// For manual setup (non-plugin usage)
export { default as discovery } from './discover.js';