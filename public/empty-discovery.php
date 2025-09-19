<!DOCTYPE html>
<html>
<head>
  <title>No Components (Discovery)</title>
  <script type="module" src="dist/discover.js"></script>
</head>
<body>

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
  <button onclick="addParentComponent()">Add Parent Component</button>
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
          <strong>🎉 Discovery System Active</strong><br>
          • Total available components: ${stats.totalComponents}<br>
          • Components loaded: ${stats.loadedComponents}<br>
          • Bandwidth saved: ${stats.unloadedComponents} components not loaded<br>
          <br><em>All component code stayed unloaded - maximum performance!</em>
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

    // Update status
    setTimeout(() => {
      const statusDiv = document.getElementById('loading-status');
      if (window.componentDiscovery) {
        const stats = window.componentDiscovery.getStats();
        statusDiv.innerHTML += `<br><br><strong>📦 Component loaded on-demand!</strong><br>Now loaded: ${stats.loadedComponents} components`;
      }
    }, 500);
  }

  function addParentComponent() {
    const container = document.getElementById('dynamic-components');
    const parent = document.createElement('parent-widget');

    const wrapper = document.createElement('div');
    wrapper.style.margin = '10px 0';
    wrapper.appendChild(document.createTextNode('Dynamically added: '));
    wrapper.appendChild(parent);

    container.appendChild(wrapper);

    // Update status
    setTimeout(() => {
      const statusDiv = document.getElementById('loading-status');
      if (window.componentDiscovery) {
        const stats = window.componentDiscovery.getStats();
        statusDiv.innerHTML += `<br><br><strong>📦 Component loaded on-demand!</strong><br>Now loaded: ${stats.loadedComponents} components`;
      }
    }, 500);
  }
</script>

</body>
</html>