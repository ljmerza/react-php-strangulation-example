<!DOCTYPE html>
<html>
<head>
  <title>Hello Component Only (Discovery)</title>
  <script type="module" src="dist/discover.js"></script>
</head>
<body>

<h2>PHP + React - Hello Component Only</h2>
<p><strong>📦 Only the Hello component will be loaded</strong> - Parent component code stays unloaded!</p>

<label>Hello from PHP:
  <input type="text" id="phpInput" value="World" />
</label>

<br><br>
<!-- ONLY this component will be loaded -->
<hello-widget id="hello" data-props='{"name": "World"}'></hello-widget>

<!-- This parent component is NOT on the page, so it won't be loaded -->
<!-- <parent-widget></parent-widget> -->

<div style="margin-top: 20px; padding: 10px; background: #f0f0f0;">
  <h3>🔍 Loading Status:</h3>
  <div id="loading-status">Initializing...</div>
</div>

<script>
  // Set up component communication
  document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
      const widget = document.getElementById('hello');
      const phpInput = document.getElementById('phpInput');

      if (widget && phpInput) {
        // React → PHP
        widget.addEventListener('input-changed', e => {
          phpInput.value = e.detail.value;
        });

        // PHP → React
        phpInput.addEventListener('input', () => {
          const props = JSON.parse(widget.getAttribute('data-props') || '{}');
          props.name = phpInput.value;
          widget.setAttribute('data-props', JSON.stringify(props));
        });
      }
    }, 100);
  });

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
        `;
      } else {
        statusDiv.innerHTML = '❌ Discovery system not available';
      }
    }, 1000);
  });
</script>

</body>
</html>