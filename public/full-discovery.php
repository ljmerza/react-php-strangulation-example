<?php
$pageTitle = "Full Discovery System Demo";
include 'header.php';
?>

<style>
  .controls {
    margin: 10px 0;
  }
  button {
    margin: 5px;
    padding: 8px 16px;
  }
  .stats {
    background: #f5f5f5;
    padding: 10px;
    margin: 10px 0;
    font-family: monospace;
    white-space: pre-wrap;
  }
</style>

<div class="container">
  <h1>Component Discovery System Demo</h1>

<div class="demo-section">
  <h3>📝 PHP Input Demo</h3>
  <label>Hello from PHP:
    <input type="text" id="phpInput" value="World" />
  </label>
</div>

<div class="demo-section">
  <h3>⚛️ React Components (Auto-discovered)</h3>
  <hello-widget id="hello" data-props='{"name": "World"}'></hello-widget>

</div>

<div class="demo-section">
  <h3>➕ Dynamic Component Loading</h3>
  <button onclick="addDynamicComponent()">Add Dynamic Hello Component</button>
  <div id="dynamic-container"></div>
</div>

<div class="demo-section">
  <h3>📊 Discovery System Stats</h3>
  <div class="controls">
    <button onclick="showStats()">Refresh Stats</button>
    <button onclick="loadAllComponents()">Load All Components</button>
  </div>
  <div id="stats" class="stats">Initializing...</div>
</div>

<script>
  // PHP ↔ React integration
  document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
      const widget = document.getElementById('hello');
      const phpInput = document.getElementById('phpInput');

      if (widget && phpInput) {
        // React → PHP
        widget.addEventListener('input-changed', e => {
          phpInput.value = e.detail.value;
          updateStats('React updated PHP input');
        });

        // PHP → React
        phpInput.addEventListener('input', () => {
          const props = JSON.parse(widget.getAttribute('data-props') || '{}');
          props.name = phpInput.value;
          widget.setAttribute('data-props', JSON.stringify(props));
          updateStats('PHP updated React component');
        });
      }
    }, 100);
  });

  // Discovery system integration
  async function loadComponent(tagName) {
    if (window.componentDiscovery) {
      try {
        await window.componentDiscovery.loadComponent(tagName);
        updateStats(`✅ Loaded component: ${tagName}`);
      } catch (error) {
        updateStats(`❌ Failed to load ${tagName}: ${error.message}`);
      }
    } else {
      updateStats('❌ Discovery system not ready');
    }
  }

  async function loadAllComponents() {
    if (window.componentDiscovery) {
      const result = await window.componentDiscovery.loadAll();
      updateStats(`✅ Loaded: ${result.loaded.join(', ')}\n❌ Failed: ${result.failed.map(f => f.tagName).join(', ')}`);
    }
  }

  function showStats() {
    if (window.componentDiscovery) {
      const stats = window.componentDiscovery.getStats();
      updateStats(JSON.stringify(stats, null, 2));
    }
  }

  function addDynamicComponent() {
    const container = document.getElementById('dynamic-container');
    const id = 'dynamic-' + Date.now();
    const newWidget = document.createElement('hello-widget');
    newWidget.id = id;
    newWidget.setAttribute('data-props', '{"name": "Dynamic Component!"}');

    const wrapper = document.createElement('div');
    wrapper.style.margin = '10px 0';
    wrapper.appendChild(document.createTextNode('Dynamic: '));
    wrapper.appendChild(newWidget);

    container.appendChild(wrapper);
    updateStats(`➕ Added dynamic component: ${id}`);
  }


  function updateStats(message) {
    const statsDiv = document.getElementById('stats');
    if (statsDiv) {
      const timestamp = new Date().toLocaleTimeString();
      statsDiv.textContent += `[${timestamp}] ${message}\n`;
      statsDiv.scrollTop = statsDiv.scrollHeight;
    } else {
      console.log(`[Stats] ${message}`);
    }
  }

  // Initialize stats on load
  window.addEventListener('load', () => {
    setTimeout(() => {
      if (window.componentDiscovery) {
        showStats();
        updateStats('🚀 Discovery system initialized');
      }
    }, 500);
  });
</script>

</div>

<?php include 'footer.php'; ?>