<?php
$pageTitle = "Hello Widget with Discovery";
include 'header.php';
?>

<div class="container">
  <h2>PHP + React Web Component (Discovery System)</h2>
  <p>This page uses the new component discovery system - components load automatically!</p>

<label>Hello from PHP:
  <input type="text" id="phpInput" value="" />
</label>

<br><br>
<hello-widget id="hello" data-props='{"name": ""}'></hello-widget>

<script>
  // Wait for discovery system to initialize
  document.addEventListener('DOMContentLoaded', () => {
    // Set up component communication after discovery loads the component
    setTimeout(() => {
      const widget = document.getElementById('hello');
      const phpInput = document.getElementById('phpInput');

      if (widget && phpInput) {
        // React → PHP
        widget.addEventListener('input-changed', e => {
          phpInput.value = e.detail.value;
        });

        // PHP → React (2-way binding)
        phpInput.addEventListener('input', () => {
          const props = JSON.parse(widget.getAttribute('data-props') || '{}');
          props.name = phpInput.value;
          widget.setAttribute('data-props', JSON.stringify(props));
        });
      }
    }, 100); // Small delay to ensure discovery system has loaded
  });

  // Debug: Show discovery info in console
  window.addEventListener('load', () => {
    setTimeout(() => {
      if (window.componentDiscovery) {
        console.log('📦 Available Components:', window.componentDiscovery.listAvailable());
        console.log('📊 Registry Stats:', window.componentDiscovery.getStats());
      }
    }, 500);
  });
</script>

<div class="demo-section">
  <h3>💻 How It Works</h3>
  <div class="section-description">
    Simple example showing React component integration with PHP using the discovery system.
  </div>

  <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 14px;">
    <strong>HTML:</strong><br>
    <code style="color: #d63384;">&lt;script type="module" src="dist/discover.js"&gt;&lt;/script&gt;</code><br>
    <code style="color: #0d6efd;">&lt;hello-widget id="hello" data-props='{"name": "World"}'&gt;&lt;/hello-widget&gt;</code>
  </div>

  <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 14px; margin-top: 10px;">
    <strong>JavaScript (Two-way binding):</strong><br>
    <code style="color: #198754;">// React → PHP</code><br>
    <code>widget.addEventListener('input-changed', e => {</code><br>
    <code>&nbsp;&nbsp;phpInput.value = e.detail.value;</code><br>
    <code>});</code><br><br>
    <code style="color: #198754;">// PHP → React</code><br>
    <code>phpInput.addEventListener('input', () => {</code><br>
    <code>&nbsp;&nbsp;const props = JSON.parse(widget.getAttribute('data-props'));</code><br>
    <code>&nbsp;&nbsp;props.name = phpInput.value;</code><br>
    <code>&nbsp;&nbsp;widget.setAttribute('data-props', JSON.stringify(props));</code><br>
    <code>});</code>
  </div>
</div>

</div>

<?php include 'footer.php'; ?>