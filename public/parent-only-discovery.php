<!DOCTYPE html>
<html>
<head>
  <title>Parent Component Only (Discovery)</title>
  <script type="module" src="dist/discover.js"></script>
</head>
<body>

<h2>PHP + React - Parent Component Only</h2>
<p><strong>📦 Only Parent + Child components will be loaded</strong> - Hello component stays unloaded!</p>

<!-- ONLY this component will be loaded (and its Child dependency) -->
<parent-widget></parent-widget>

<!-- This hello component is NOT on the page, so it won't be loaded -->
<!-- <hello-widget data-props='{"name": "World"}'></hello-widget> -->

<div style="margin-top: 20px; padding: 10px; background: #f0f0f0;">
  <h3>🔍 Loading Status:</h3>
  <div id="loading-status">Initializing...</div>
</div>

<script>
  // Show what components were actually loaded
  window.addEventListener('load', () => {
    setTimeout(() => {
      const statusDiv = document.getElementById('loading-status');

      if (window.componentDiscovery) {
        const stats = window.componentDiscovery.getStats();
        const loaded = stats.components.filter(c => c.loaded);
        const unloaded = stats.components.filter(c => !c.loaded);

        statusDiv.innerHTML = `
          <strong>✅ Loaded Components (${loaded.length}):</strong><br>
          ${loaded.map(c => `• ${c.tagName}`).join('<br>') || 'None'}

          <br><br><strong>⏸️ Not Loaded (${unloaded.length}):</strong><br>
          ${unloaded.map(c => `• ${c.tagName} (saved bandwidth!)`).join('<br>') || 'None'}

          <br><br><em>Note: Parent component automatically loads Child component as a dependency</em>
        `;
      } else {
        statusDiv.innerHTML = '❌ Discovery system not available';
      }
    }, 1000);
  });
</script>

</body>
</html>