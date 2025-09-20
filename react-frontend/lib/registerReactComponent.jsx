import { createRoot } from 'react-dom/client';

// Registry to track registered components
const registeredComponents = new Set();

// Utility function to parse HTML attributes into React props
function parseComponentAttributes(element) {
  const props = {};

  // First, get props from data-props (backward compatibility)
  const dataProps = element.getAttribute('data-props');
  if (dataProps) {
    try {
      Object.assign(props, JSON.parse(dataProps));
    } catch (e) {
      console.warn('Invalid JSON in data-props', e);
    }
  }

  // Then, override with individual attributes
  Array.from(element.attributes).forEach(attr => {
    const name = attr.name;
    const value = attr.value;

    // Skip data-props (already handled) and other special attributes
    if (name === 'data-props' || name.startsWith('data-') || name === 'id' || name === 'class') {
      return;
    }

    // Convert kebab-case to camelCase
    const propName = name.replace(/-([a-z])/g, (match, letter) => letter.toUpperCase());

    // Type conversion based on value
    if (value === 'true') {
      props[propName] = true;
    } else if (value === 'false') {
      props[propName] = false;
    } else if (!isNaN(value) && value !== '') {
      props[propName] = Number(value);
    } else if (propName === 'data' || propName === 'columns') {
      // Handle complex data structures as JSON
      try {
        props[propName] = JSON.parse(value);
      } catch (e) {
        console.warn(`Invalid JSON in ${propName} attribute:`, e);
        props[propName] = value;
      }
    } else {
      props[propName] = value;
    }
  });

  return props;
}

export function registerReactComponent(tagName, Component, componentCSS = '') {
  class ReactCustomElement extends HTMLElement {
    static get observedAttributes() {
      // Observe common component attributes plus data-props for backward compatibility
      return [
        'data-props',
        'sortable', 'paginated', 'page-size', 'empty-message', 'data', 'columns',  // DataTable
        'title', 'subtitle',                                                       // CardHeader
        'padding', 'align',                                                        // CardBody, CardFooter
        'variant', 'className',                                                    // Common props
        'name'                                                                     // Hello widget
      ];
    }

    constructor() {
      super();
      this._props = {};
      this._root = null; // Save the root to rerender later
      this._initialized = false; // Track initialization state
    }

    connectedCallback() {
      // Only create root once, next renders will reuse root
      if (!this.shadowRoot) {
        // Isolate component in a shadow DOM but allow parent js to modify
        this.attachShadow({ mode: 'open' });

        // Inject component-specific CSS if provided
        if (componentCSS) {
          const style = document.createElement('style');
          style.textContent = componentCSS;
          this.shadowRoot.appendChild(style);
        }
      }
      if (!this._root) {
        this._root = createRoot(this.shadowRoot);
      }
      this._initialized = true;
      this._updateProps();
      this._render();
    }

    attributeChangedCallback(name, oldVal, newVal) {
      // Only re-render if component is fully initialized
      if (!this._initialized) return;

      // Re-parse all attributes whenever any observed attribute changes
      this._updateProps();
      this._render();
    }

    _updateProps() {
      // Parse all attributes (both data-props and individual attributes)
      this._props = parseComponentAttributes(this);
    }

    _render() {
      if (!this.isConnected || !this._root || !this.shadowRoot) return;

      const emit = (eventName, detail) => {
        this.dispatchEvent(new CustomEvent(eventName, {
          detail,
          bubbles: true,
          composed: true
        }));
      };

      // For composable components, pass the innerHTML as children
      const innerHTML = this.innerHTML;

      const propsWithHandlers = {
        ...this._props,
        children: innerHTML,
        onInputChange: (val) => emit('input-changed', { value: val }),
        onSubmit: (data) => emit('form-submitted', { data }),
        onFieldChange: (field, value, formData) => emit('field-changed', { field, value, formData }),
        onRowClick: (row, index) => emit('row-clicked', { row, index })
      };

      this._root.render(<Component {...propsWithHandlers} />);
    }
  }

  if (!customElements.get(tagName)) {
    customElements.define(tagName, ReactCustomElement);
    registeredComponents.add(tagName);

    // Dispatch global event for registry tracking
    window.dispatchEvent(new CustomEvent('web-component-registered', {
      detail: { tagName, Component }
    }));
  }
}

// Helper functions for registry integration
export function isComponentRegistered(tagName) {
  return registeredComponents.has(tagName);
}

export function getRegisteredComponents() {
  return Array.from(registeredComponents);
}
