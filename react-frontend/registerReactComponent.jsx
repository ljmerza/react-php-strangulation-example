import { createRoot } from 'react-dom/client';

export function registerReactComponent(tagName, Component) {
  class ReactCustomElement extends HTMLElement {
    static get observedAttributes() {
      return ['data-props'];
    }

    constructor() {
      super();
      this._props = {};
      this._root = null; // Save the root
    }

    connectedCallback() {
      // Only create root ONCE
      if (!this.shadowRoot) {
        this.attachShadow({ mode: 'open' });
      }
      if (!this._root) {
        this._root = createRoot(this.shadowRoot);
      }
      this._render();
    }

    attributeChangedCallback(name, oldVal, newVal) {
      if (name === 'data-props') {
        try {
          this._props = JSON.parse(newVal);
          this._render(); // Only rerender, not recreate root!
        } catch (e) {
          console.warn('Invalid JSON in data-props', e);
        }
      }
    }

    _render() {
      if (!this.isConnected) return;

      const emit = (eventName, detail) => {
        this.dispatchEvent(new CustomEvent(eventName, {
          detail,
          bubbles: true,
          composed: true
        }));
      };

      const propsWithHandlers = {
        ...this._props,
        onInputChange: (val) => emit('input-changed', { value: val })
      };

      this._root.render(<Component {...propsWithHandlers} />);
    }
  }

  if (!customElements.get(tagName)) {
    customElements.define(tagName, ReactCustomElement);
  }
}
