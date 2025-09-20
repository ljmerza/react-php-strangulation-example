<!DOCTYPE html>
<html>
<head>
  <title><?php echo isset($pageTitle) ? $pageTitle : 'React-PHP Component Demo'; ?></title>
  <script type="module" src="dist/discover.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f5f5f5;
    }

    .header {
      background: #007bff;
      color: white;
      padding: 20px 0 15px 0;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      min-height: 80px;
    }

    .header-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .header h1 {
      margin: 0 0 15px 0 !important;
      font-size: 24px !important;
      line-height: 1.2 !important;
      text-align: left !important;
      text-shadow: none !important;
    }

    .nav {
      margin-top: 0;
    }

    .nav a {
      color: white;
      text-decoration: none;
      margin-right: 20px;
      padding: 8px 12px;
      border-radius: 4px;
      transition: background 0.2s;
    }

    .nav a:hover {
      background: rgba(255,255,255,0.2);
    }

    .nav a.active {
      background: rgba(255,255,255,0.3);
      font-weight: bold;
    }

    .demo-section {
      margin: 30px 0;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .demo-section h2 {
      color: #333;
      border-bottom: 2px solid #007bff;
      padding-bottom: 10px;
    }

    .section-description {
      color: #666;
      margin-bottom: 20px;
      font-style: italic;
    }

    .container {
      max-width: 1200px;
      margin: 20px auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="header">
  <div class="header-content">
    <h1>⚛️ React-PHP Component System</h1>
    <div class="nav">
      <a href="index.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : ''; ?>>🏠 Home</a>
      <a href="hello-discovery.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'hello-discovery.php') ? 'class="active"' : ''; ?>>👋 Hello</a>
      <a href="empty-discovery.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'empty-discovery.php') ? 'class="active"' : ''; ?>>⚡ Empty Discovery</a>
      <a href="composed-components-demo.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'composed-components-demo.php') ? 'class="active"' : ''; ?>>🧩 Components</a>
    </div>
  </div>
</div>

<div class="content">