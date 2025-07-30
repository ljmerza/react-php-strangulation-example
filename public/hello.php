<!DOCTYPE html>
<html>
<head>
  <title>Hello Widget</title>
  <script type="module" src="dist/main.js"></script>
  <script type="module" src="dist/parent.js"></script>
</head>
<body>

<h2>PHP + React Web Component</h2>

<label>Hello from PHP:
  <input type="text" id="phpInput" value="Leo" />
</label>

<br><br>
<hello-widget id="hello" data-props='{"name": "Leo"}'></hello-widget>
<parent-widget></parent-widget>

<script>
  const widget = document.getElementById('hello');
  const phpInput = document.getElementById('phpInput');

  // React → PHP
  widget.addEventListener('input-changed', e => {
    phpInput.value = e.detail.value;
  });

  // PHP → React (2-way binding)
  phpInput.addEventListener('input', () => {
    const props = JSON.parse(widget.getAttribute('data-props'));
    props.name = phpInput.value;
    widget.setAttribute('data-props', JSON.stringify(props));
  });
</script>

</body>
</html>
