<!DOCTYPE html>
<html>
<head>
  <title>React-PHP Component Demo - Home</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      min-height: 100vh;
    }
    .container {
      max-width: 1000px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.1);
      padding: 30px;
      border-radius: 15px;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    }
    h1 {
      text-align: center;
      font-size: 2.5em;
      margin-bottom: 10px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .subtitle {
      text-align: center;
      font-size: 1.2em;
      margin-bottom: 40px;
      opacity: 0.9;
    }
    .section {
      margin-bottom: 40px;
    }
    .section h2 {
      border-bottom: 2px solid rgba(255,255,255,0.3);
      padding-bottom: 10px;
      margin-bottom: 20px;
      font-size: 1.5em;
    }
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }
    .card {
      background: rgba(255, 255, 255, 0.15);
      padding: 20px;
      border-radius: 10px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: transform 0.3s ease, background 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
      background: rgba(255, 255, 255, 0.2);
    }
    .card h3 {
      margin-top: 0;
      color: #fff;
      font-size: 1.2em;
    }
    .card p {
      margin-bottom: 15px;
      opacity: 0.9;
      line-height: 1.4;
    }
    .card a {
      display: inline-block;
      background: rgba(255, 255, 255, 0.2);
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 25px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      transition: all 0.3s ease;
      font-weight: 500;
    }
    .card a:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: scale(1.05);
    }
    .highlight {
      background: linear-gradient(45deg, #ff6b6b, #ee5a24);
      color: white;
    }
    .debug {
      background: linear-gradient(45deg, #feca57, #ff9ff3);
      color: #333;
    }
    .debug a {
      color: #333;
      background: rgba(255, 255, 255, 0.7);
    }
    .footer {
      text-align: center;
      margin-top: 40px;
      opacity: 0.8;
      font-size: 0.9em;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>🧩 React-PHP Component Demo</h1>
    <p class="subtitle">Interactive showcase of React components integrated with PHP</p>

    <div class="section">
      <h2>🎯 Featured Demos</h2>
      <div class="grid">
        <div class="card highlight">
          <h3>🧩 Composed Components</h3>
          <p>Advanced React components with discovery system, forms, data tables, and cards with intelligent loading.</p>
          <a href="composed-components-demo.php">View Demo →</a>
        </div>

      </div>
    </div>

    <div class="section">
      <h2>📊 Discovery System</h2>
      <div class="grid">
        <div class="card">
          <h3>🔍 Full Discovery</h3>
          <p>Complete component discovery with manifest loading and performance metrics.</p>
          <a href="full-discovery.php">View Demo →</a>
        </div>

        <div class="card">
          <h3>👋 Hello Discovery</h3>
          <p>Simple Hello component with discovery system integration.</p>
          <a href="hello-discovery.php">View Demo →</a>
        </div>


        <div class="card">
          <h3>📄 Empty Discovery</h3>
          <p>Minimal page showing discovery system startup and initialization.</p>
          <a href="empty-discovery.php">View Demo →</a>
        </div>
      </div>
    </div>

    <div class="section">
      <h2>🎯 Basic Components</h2>
      <div class="grid">
        <div class="card">
          <h3>👶 Hello Only</h3>
          <p>Minimal Hello component without parent wrapper.</p>
          <a href="hello-only.php">View Demo →</a>
        </div>

        <div class="card">
          <h3>📈 Performance</h3>
          <p>Performance comparison between different loading strategies.</p>
          <a href="performance-comparison.php">View Demo →</a>
        </div>
      </div>
    </div>

    <div class="section">
      <h2>🔍 Debug Tools</h2>
      <div class="grid">
        <div class="card debug">
          <h3>🐛 Discovery Debug</h3>
          <p>Debug the component discovery system with detailed console output.</p>
          <a href="debug-discovery.html">Debug →</a>
        </div>

        <div class="card debug">
          <h3>🔧 Simple Debug</h3>
          <p>Basic JavaScript and discovery system connectivity test.</p>
          <a href="simple-debug.html">Debug →</a>
        </div>
      </div>
    </div>

    <div class="footer">
      <p>💡 <strong>Tip:</strong> Open browser developer tools to see console logs and component loading details</p>
      <p>🌟 Each demo showcases different aspects of React-PHP integration and component discovery</p>
    </div>
  </div>
</body>
</html>