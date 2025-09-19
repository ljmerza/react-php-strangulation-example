import { registerReactComponent } from './registerReactComponent.jsx';
import './components.css';

import Hello from './components/Hello';
import Parent from './components/Parent';

// register all components in one or create files 
// for each component and register them individually
// to avoid loading all components at once
registerReactComponent('hello-widget', Hello);
registerReactComponent('parent-widget', Parent);