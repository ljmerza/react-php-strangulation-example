<?php
$pageTitle = "No Components (Discovery)";
include 'header.php';
?>

<div class="container">
  <h2>PHP Page with NO React Components</h2>
  <p><strong>📦 ZERO components will be loaded</strong> - Maximum performance!</p>

<div>
  <h3>Regular PHP Content:</h3>
  <p>This is a normal PHP page with no React components.</p>
  <p>The discovery system is loaded but won't load any component code.</p>

  <form>
    <label>PHP Form Field: <input type="text" value="No React here!" /></label>
    <button type="button" onclick="alert('Pure PHP/JS')">Click me</button>
  </form>
</div>

<!-- NO React components on this page -->

<div style="margin-top: 20px; padding: 10px; background: #f0f0f0;">
  <h3>🔍 Loading Status:</h3>
  <div id="loading-status">Initializing...</div>
</div>

<div style="margin-top: 20px; padding: 10px; background: #e8f5e8;">
  <h3>➕ Dynamic Component Test:</h3>
  <p>Click to add components dynamically - they'll load on-demand!</p>
  <button onclick="addHelloComponent()">Add Hello Component</button>
  <button onclick="addFormComponent()">Add Form Component</button>
  <div id="dynamic-components"></div>
</div>

<script>
  // Show loading status
  window.addEventListener('load', () => {
    setTimeout(() => {
      const statusDiv = document.getElementById('loading-status');

      if (window.componentDiscovery) {
        const stats = window.componentDiscovery.getStats();

        statusDiv.innerHTML = `
          • Total available components: ${stats.totalComponents}<br>
          • Components loaded: ${stats.loadedComponents}<br>
          • Bandwidth saved: ${stats.unloadedComponents} components not loaded
        `;
      } else {
        statusDiv.innerHTML = '❌ Discovery system not available';
      }
    }, 1000);
  });

  // Dynamic component addition (loads on-demand)
  function addHelloComponent() {
    const container = document.getElementById('dynamic-components');
    const hello = document.createElement('hello-widget');
    hello.setAttribute('data-props', '{"name": "Dynamic Hello!"}');

    const wrapper = document.createElement('div');
    wrapper.style.margin = '10px 0';
    wrapper.appendChild(document.createTextNode('Dynamically added: '));
    wrapper.appendChild(hello);

    container.appendChild(wrapper);

    // Manually trigger component loading
    setTimeout(async () => {
      if (window.componentDiscovery) {
        try {
          await window.componentDiscovery.loadComponent('hello-widget');
          const statusDiv = document.getElementById('loading-status');
          const stats = window.componentDiscovery.getStats();
          statusDiv.innerHTML = `
            • Total available components: ${stats.totalComponents}<br>
            • Components loaded: ${stats.loadedComponents}<br>
            • Bandwidth saved: ${stats.unloadedComponents} components not loaded
          `;
        } catch (error) {
          console.error('Failed to load hello-widget:', error);
        }
      }
    }, 100);
  }

  function addFormComponent() {
    const container = document.getElementById('dynamic-components');
    const form = document.createElement('form-composer');
    form.setAttribute('title', 'Dynamic Form');
    form.innerHTML = `
      <form-field name="dynamicName" label="Name" type="text" required></form-field>
      <form-field name="dynamicEmail" label="Email" type="email" required></form-field>
      <form-submit>Submit Dynamic Form</form-submit>
    `;

    const wrapper = document.createElement('div');
    wrapper.style.margin = '10px 0';
    wrapper.appendChild(document.createTextNode('Dynamically added: '));
    wrapper.appendChild(form);

    container.appendChild(wrapper);

    // Manually trigger form components loading
    setTimeout(async () => {
      if (window.componentDiscovery) {
        try {
          await window.componentDiscovery.loadComponent('form-composer');
          await window.componentDiscovery.loadComponent('form-field');
          await window.componentDiscovery.loadComponent('form-submit');

          const statusDiv = document.getElementById('loading-status');
          const stats = window.componentDiscovery.getStats();
          statusDiv.innerHTML = `
            • Total available components: ${stats.totalComponents}<br>
            • Components loaded: ${stats.loadedComponents}<br>
            • Bandwidth saved: ${stats.unloadedComponents} components not loaded
          `;
        } catch (error) {
          console.error('Failed to load form components:', error);
        }
      }
    }, 100);
  }

</script>

<div class="demo-section">
  <h3>💻 How It Works</h3>
  <div class="section-description">
    Maximum performance: Discovery system loads but no components are initialized until needed.
  </div>

  <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 14px;">
    <strong>HTML (Zero Components):</strong><br>
    <code style="color: #d63384;">&lt;script type="module" src="dist/discover.js"&gt;&lt;/script&gt;</code><br>
    <code style="color: #6c757d;">// No React components in HTML = Zero bundle loading</code>
  </div>

  <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 14px; margin-top: 10px;">
    <strong>Dynamic Loading:</strong><br>
    <code style="color: #198754;">// Add component dynamically</code><br>
    <code>const hello = document.createElement('hello-widget');</code><br>
    <code>hello.setAttribute('data-props', '{"name": "Dynamic!"}');</code><br>
    <code>container.appendChild(hello);</code><br><br>
    <code style="color: #198754;">// Discovery system auto-loads on demand</code><br>
    <code>await window.componentDiscovery.loadComponent('hello-widget');</code>
  </div>
</div>

</div>

<?php include 'footer.php'; ?>