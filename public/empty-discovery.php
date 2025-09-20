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
  <button onclick="addCardComponent()">Add Card Component</button>
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

  function addCardComponent() {
    const container = document.getElementById('dynamic-components');
    const card = document.createElement('card-widget');
    card.setAttribute('data-props', '{"variant": "primary"}');
    card.innerHTML = `
      <cardheader-widget data-props='{"title": "Dynamic Card", "subtitle": "Added on-demand"}'></cardheader-widget>
      <cardbody-widget data-props='{"padding": true}'>
        <p>This card was added dynamically and loaded on-demand!</p>
      </cardbody-widget>
      <cardfooter-widget data-props='{"align": "right"}'>
        <button onclick="alert('Card button clicked!')">Action</button>
      </cardfooter-widget>
    `;

    const wrapper = document.createElement('div');
    wrapper.style.margin = '10px 0';
    wrapper.appendChild(document.createTextNode('Dynamically added: '));
    wrapper.appendChild(card);

    container.appendChild(wrapper);

    // Manually trigger card components loading
    setTimeout(async () => {
      if (window.componentDiscovery) {
        try {
          await window.componentDiscovery.loadComponent('card-widget');
          await window.componentDiscovery.loadComponent('cardheader-widget');
          await window.componentDiscovery.loadComponent('cardbody-widget');
          await window.componentDiscovery.loadComponent('cardfooter-widget');

          const statusDiv = document.getElementById('loading-status');
          const stats = window.componentDiscovery.getStats();
          statusDiv.innerHTML = `
            • Total available components: ${stats.totalComponents}<br>
            • Components loaded: ${stats.loadedComponents}<br>
            • Bandwidth saved: ${stats.unloadedComponents} components not loaded
          `;
        } catch (error) {
          console.error('Failed to load card components:', error);
        }
      }
    }, 100);
  }

</script>

</div>

<?php include 'footer.php'; ?>