// Complete React Strangler System
// This file exports everything needed to use the system

// Core system
export { registerReactComponent } from './registerReactComponent';
export { ComponentRegistry, componentRegistry } from './ComponentRegistry';
export { componentDiscovery } from './discover';

// Vite plugin
export { reactStrangler as default } from './vite-plugin';
export { reactStrangler } from './vite-plugin';
export type { ReactStranglerOptions } from './vite-plugin';

// For manual setup (non-plugin usage)
export { default as discovery } from './discover';