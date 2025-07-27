import { registerReactComponent } from './registerReactComponent';

import Hello from './components/Hello';
import Another from './components/Another';

registerReactComponent('hello-widget', Hello);
registerReactComponent('another-widget', Another);
