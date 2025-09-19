import { registerReactComponent } from './registerReactComponent.jsx';
import './components.css';

import Hello from './components/Hello';
import Parent from './components/Parent';

registerReactComponent('hello-widget', Hello);
registerReactComponent('parent-widget', Parent);
