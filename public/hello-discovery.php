<?php
$pageTitle = "Hello Widget with Discovery";
include 'header.php';
?>

<div class="container">
  <h2>PHP + React Web Component (Discovery System)</h2>
  <p>This page uses the new component discovery system - components load automatically!</p>

<label>Hello from PHP:
  <input type="text" id="phpInput" value="Leo" />
</label>

<br><br>
<hello-widget id="hello" data-props='{"name": "Leo"}'></hello-widget>

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

</div>

<?php include 'footer.php'; ?>