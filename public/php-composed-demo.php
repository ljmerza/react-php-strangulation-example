<!DOCTYPE html>
<html>
<head>
  <title>PHP Composed Components Demo</title>
  <script type="module" src="dist/discover.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background: #f5f5f5;
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
    .code-example {
      background: #f8f9fa;
      padding: 15px;
      border-left: 4px solid #007bff;
      margin: 15px 0;
      font-family: monospace;
      white-space: pre-wrap;
      overflow-x: auto;
    }
  </style>
</head>
<body>

<h1>🧩 PHP Composed Components Demo</h1>
<p>This page shows how PHP can compose React components using nested web components.</p>

<div class="demo-section">
  <h2>🃏 Basic Card Composition</h2>
  <p>PHP composes a card with header, body, and footer using nested web components:</p>

  <div class="code-example">&lt;php-composable-card variant="primary"&gt;
  &lt;card-header title="User Profile" subtitle="Manage your account settings"&gt;&lt;/card-header&gt;
  &lt;card-body&gt;
    &lt;p&gt;Welcome back! Here's your account information.&lt;/p&gt;
    &lt;button&gt;Edit Profile&lt;/button&gt;
  &lt;/card-body&gt;
  &lt;card-footer align="right"&gt;
    &lt;small&gt;Last updated: Today&lt;/small&gt;
  &lt;/card-footer&gt;
&lt;/php-composable-card&gt;</div>

  <php-composable-card variant="primary">
    <card-header title="User Profile" subtitle="Manage your account settings"></card-header>
    <card-body>
      <p>Welcome back! Here's your account information.</p>
      <div style="margin-top: 15px;">
        <button style="background: #007bff; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Edit Profile</button>
        <button style="background: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; margin-left: 8px;">View Activity</button>
      </div>
    </card-body>
    <card-footer align="right">
      <small>Last updated: Today</small>
    </card-footer>
  </php-composable-card>
</div>

<div class="demo-section">
  <h2>📊 Statistics Cards</h2>
  <p>Different card variants with various content compositions:</p>

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 20px 0;">

    <php-composable-card variant="success">
      <card-header title="Revenue" subtitle="This month"></card-header>
      <card-body padding="true">
        <div style="text-align: center;">
          <div style="font-size: 2.5em; font-weight: bold; color: #28a745;">$12,450</div>
          <div style="color: #28a745; margin-top: 5px;">↑ 15% increase</div>
        </div>
      </card-body>
    </php-composable-card>

    <php-composable-card variant="warning">
      <card-header title="Pending Orders"></card-header>
      <card-body>
        <div style="text-align: center;">
          <div style="font-size: 2em; font-weight: bold; color: #ffc107;">23</div>
          <div style="color: #666; margin-top: 5px;">Needs attention</div>
        </div>
      </card-body>
      <card-footer align="center">
        <button style="background: #ffc107; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">View Orders</button>
      </card-footer>
    </php-composable-card>

    <php-composable-card variant="danger">
      <card-header title="System Status" subtitle="Server monitoring"></card-header>
      <card-body>
        <div style="text-align: center;">
          <div style="font-size: 1.5em; color: #dc3545;">⚠️ 2 Issues</div>
          <ul style="text-align: left; margin: 10px 0; font-size: 14px;">
            <li>Database connection slow</li>
            <li>High memory usage</li>
          </ul>
        </div>
      </card-body>
      <card-footer align="right">
        <button style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">Fix Issues</button>
      </card-footer>
    </php-composable-card>

  </div>
</div>

<div class="demo-section">
  <h2>📝 Content Cards</h2>
  <p>Cards with rich content and different layouts:</p>

  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">

    <php-composable-card variant="default">
      <card-header title="Blog Post" subtitle="Latest article"></card-header>
      <card-body>
        <h4>How to Build Better Web Components</h4>
        <p>Learn the best practices for creating reusable, composable web components that work across different frameworks...</p>
        <div style="margin-top: 15px;">
          <span style="background: #e9ecef; padding: 4px 8px; border-radius: 12px; font-size: 12px; margin-right: 8px;">React</span>
          <span style="background: #e9ecef; padding: 4px 8px; border-radius: 12px; font-size: 12px; margin-right: 8px;">PHP</span>
          <span style="background: #e9ecef; padding: 4px 8px; border-radius: 12px; font-size: 12px;">Web Components</span>
        </div>
      </card-body>
      <card-footer>
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <small>Published: Sept 19, 2025</small>
          <button style="background: #007bff; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">Read More</button>
        </div>
      </card-footer>
    </php-composable-card>

    <php-composable-card variant="primary">
      <card-header title="Quick Actions"></card-header>
      <card-body>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
          <button style="background: #007bff; color: white; border: none; padding: 12px; border-radius: 4px; cursor: pointer;">📊 Analytics</button>
          <button style="background: #28a745; color: white; border: none; padding: 12px; border-radius: 4px; cursor: pointer;">👥 Users</button>
          <button style="background: #ffc107; color: black; border: none; padding: 12px; border-radius: 4px; cursor: pointer;">⚙️ Settings</button>
          <button style="background: #dc3545; color: white; border: none; padding: 12px; border-radius: 4px; cursor: pointer;">📝 Reports</button>
        </div>
      </card-body>
      <card-footer align="center">
        <small>Choose an action above</small>
      </card-footer>
    </php-composable-card>

  </div>
</div>

<div class="demo-section">
  <h2>🔧 Dynamic PHP Example</h2>
  <p>PHP generating card content dynamically:</p>

  <?php
    // Simulate PHP data
    $users = [
      ['name' => 'Alice Johnson', 'role' => 'Admin', 'status' => 'Active'],
      ['name' => 'Bob Smith', 'role' => 'Editor', 'status' => 'Active'],
      ['name' => 'Carol Davis', 'role' => 'Viewer', 'status' => 'Inactive']
    ];
  ?>

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
    <?php foreach ($users as $user): ?>
      <php-composable-card variant="<?= $user['status'] === 'Active' ? 'success' : 'default' ?>">
        <card-header title="<?= htmlspecialchars($user['name']) ?>" subtitle="<?= htmlspecialchars($user['role']) ?>"></card-header>
        <card-body>
          <div style="text-align: center;">
            <div style="width: 60px; height: 60px; border-radius: 50%; background: #007bff; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-size: 24px;">
              <?= substr($user['name'], 0, 1) ?>
            </div>
            <div style="margin-top: 10px; font-size: 14px; color: #666;">
              Status: <span style="color: <?= $user['status'] === 'Active' ? '#28a745' : '#6c757d' ?>;"><?= $user['status'] ?></span>
            </div>
          </div>
        </card-body>
        <card-footer align="center">
          <button style="background: #007bff; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px;">
            View Profile
          </button>
        </card-footer>
      </php-composable-card>
    <?php endforeach; ?>
  </div>
</div>

<div class="demo-section">
  <h2>💡 How It Works</h2>
  <p>This composition system allows PHP to:</p>
  <ul>
    <li>✅ <strong>Nest web components</strong> naturally in HTML</li>
    <li>✅ <strong>Pass attributes</strong> to individual sections (title, subtitle, align, etc.)</li>
    <li>✅ <strong>Mix HTML content</strong> with React components seamlessly</li>
    <li>✅ <strong>Generate dynamic content</strong> using PHP loops and data</li>
    <li>✅ <strong>Maintain separation</strong> between PHP logic and React components</li>
  </ul>

  <div class="code-example">Example PHP composition:

&lt;php-composable-card variant="primary"&gt;
  &lt;card-header title="&lt;?= $title ?&gt;" subtitle="&lt;?= $subtitle ?&gt;"&gt;&lt;/card-header&gt;
  &lt;card-body&gt;
    &lt;?php foreach ($items as $item): ?&gt;
      &lt;p&gt;&lt;?= htmlspecialchars($item) ?&gt;&lt;/p&gt;
    &lt;?php endforeach; ?&gt;
  &lt;/card-body&gt;
  &lt;card-footer align="right"&gt;
    &lt;button onclick="alert('PHP + React!')"&gt;Action&lt;/button&gt;
  &lt;/card-footer&gt;
&lt;/php-composable-card&gt;</div>

  <p><strong>Result:</strong> PHP generates the structure, React renders the interactive components, and the discovery system loads only what's needed!</p>
</div>

<script>
  // Example of handling events from composed components
  document.addEventListener('DOMContentLoaded', () => {
    // Add click handlers to dynamically generated buttons
    document.querySelectorAll('button').forEach(button => {
      if (!button.onclick && button.textContent.includes('View Profile')) {
        button.onclick = () => alert(`Viewing profile: ${button.closest('php-composable-card').querySelector('.card-title').textContent}`);
      }
    });
  });

  // Debug: Show which components are loaded
  window.addEventListener('load', () => {
    setTimeout(() => {
      if (window.componentDiscovery) {
        const stats = window.componentDiscovery.getStats();
        console.log('📦 Composed Components Loaded:', stats);
      }
    }, 1000);
  });
</script>

</body>
</html>