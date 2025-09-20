<?php
$pageTitle = "Composed Components Demo";
include 'header.php';
?>

<div class="container">
  <h1>🧩 Composed Components Demo</h1>
  <p>This page demonstrates complex, composed React components that are automatically discovered and loaded.</p>

<div class="demo-section">
  <h2>🃏 Composable Card Components</h2>
  <div class="section-description">
    Simple, clean card composition using individual HTML components that work together.
  </div>

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
    <card-widget variant="primary">
      <cardheader-widget title="Welcome Card" subtitle="Getting started"></cardheader-widget>
      <cardbody-widget padding="true">
        <p>This is a composable card built with individual components. Each part is a separate web component that renders cleanly.</p>
        <p>✅ Clean HTML structure<br>✅ Individual attributes<br>✅ Composable pattern</p>
      </cardbody-widget>
      <cardfooter-widget align="right">
        <button onclick="alert('Primary card action!')">Get Started</button>
      </cardfooter-widget>
    </card-widget>

    <card-widget variant="warning">
      <cardheader-widget title="Alert Notice"></cardheader-widget>
      <cardbody-widget>
        <p>⚠️ This demonstrates the composable pattern without complex logic. Simple and clean!</p>
      </cardbody-widget>
      <cardfooter-widget align="center">
        <button onclick="alert('Warning acknowledged!')">Acknowledge</button>
      </cardfooter-widget>
    </card-widget>

    <card-widget>
      <cardheader-widget title="Individual Attributes" subtitle="DataTable approach"></cardheader-widget>
      <cardbody-widget padding="true">
        <p>Cards use individual HTML attributes just like the DataTable below:</p>
        <code>variant="primary"</code><br>
        <code>title="My Title"</code><br>
        <code>padding="true"</code><br>
        <code>align="center"</code>
      </cardbody-widget>
      <cardfooter-widget>
        <em>Much cleaner than JSON!</em>
      </cardfooter-widget>
    </card-widget>
  </div>
</div>

<div class="demo-section">
  <h2>📊 Advanced Data Table</h2>
  <div class="section-description">
    Sortable, paginated data table with custom rendering and row interactions.
  </div>

  <data-table
    id="main-data-table"
    sortable="true"
    paginated="true"
    page-size="5"
    empty-message="No data available"
    data='[
      {"id": 1, "name": "Alice Johnson", "email": "alice@example.com", "role": "Admin", "status": "Active", "joined": "2023-01-15"},
      {"id": 2, "name": "Bob Smith", "email": "bob@example.com", "role": "Editor", "status": "Active", "joined": "2023-02-20"},
      {"id": 3, "name": "Carol Davis", "email": "carol@example.com", "role": "Viewer", "status": "Inactive", "joined": "2023-03-10"},
      {"id": 4, "name": "David Wilson", "email": "david@example.com", "role": "Admin", "status": "Active", "joined": "2023-04-05"},
      {"id": 5, "name": "Eva Brown", "email": "eva@example.com", "role": "Editor", "status": "Active", "joined": "2023-05-12"},
      {"id": 6, "name": "Frank Miller", "email": "frank@example.com", "role": "Viewer", "status": "Active", "joined": "2023-06-18"},
      {"id": 7, "name": "Grace Lee", "email": "grace@example.com", "role": "Admin", "status": "Inactive", "joined": "2023-07-22"},
      {"id": 8, "name": "Henry Taylor", "email": "henry@example.com", "role": "Editor", "status": "Active", "joined": "2023-08-30"},
      {"id": 9, "name": "Ivy Chen", "email": "ivy@example.com", "role": "Viewer", "status": "Active", "joined": "2023-09-14"},
      {"id": 10, "name": "Jack Robinson", "email": "jack@example.com", "role": "Admin", "status": "Active", "joined": "2023-10-01"}
    ]'
    columns='[
      {"key": "name", "label": "Name"},
      {"key": "email", "label": "Email"},
      {"key": "role", "label": "Role"},
      {"key": "status", "label": "Status"},
      {"key": "joined", "label": "Joined"}
    ]'>
  </data-table>
</div>

<script>
  // Simple card interaction demo
  document.addEventListener('web-component-registered', () => {
    console.log('Card components are ready!');

    // Optional: Add click handlers for card interactions
    setTimeout(() => {
      const cards = document.querySelectorAll('card-widget');
      cards.forEach((card, index) => {
        console.log(`Card ${index + 1} loaded with variant: ${card.getAttribute('variant') || 'default'}`);
      });
    }, 500);
  });
</script>

<div class="demo-section">
  <h3>💻 How It Works</h3>
  <div class="section-description">
    Code examples showing composable forms and individual attribute usage.
  </div>

  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <div>
      <h4>Composable Cards</h4>
      <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 12px;">
        <code style="color: #0d6efd;">&lt;card-widget variant="primary"&gt;</code><br>
        <code>&nbsp;&nbsp;&lt;cardheader-widget</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;title="My Card"</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;subtitle="Description"&gt;</code><br>
        <code>&nbsp;&nbsp;&lt;/cardheader-widget&gt;</code><br><br>
        <code>&nbsp;&nbsp;&lt;cardbody-widget padding="true"&gt;</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;&lt;p&gt;Card content here&lt;/p&gt;</code><br>
        <code>&nbsp;&nbsp;&lt;/cardbody-widget&gt;</code><br><br>
        <code>&nbsp;&nbsp;&lt;cardfooter-widget align="right"&gt;</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;&lt;button&gt;Action&lt;/button&gt;</code><br>
        <code>&nbsp;&nbsp;&lt;/cardfooter-widget&gt;</code><br>
        <code style="color: #0d6efd;">&lt;/card-widget&gt;</code>
      </div>
    </div>

    <div>
      <h4>Individual Attributes</h4>
      <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 12px;">
        <code style="color: #0d6efd;">&lt;data-table</code><br>
        <code>&nbsp;&nbsp;sortable="true"</code><br>
        <code>&nbsp;&nbsp;paginated="true"</code><br>
        <code>&nbsp;&nbsp;page-size="5"</code><br>
        <code>&nbsp;&nbsp;empty-message="No data"</code><br>
        <code>&nbsp;&nbsp;data='[{"name": "Alice"}, ...]'</code><br>
        <code>&nbsp;&nbsp;columns='[{"key": "name", "label": "Name"}]'&gt;</code><br>
        <code style="color: #0d6efd;">&lt;/data-table&gt;</code><br><br>
        <code style="color: #198754;">// Update individual attribute</code><br>
        <code>card.setAttribute('variant', 'success');</code>
      </div>
    </div>
  </div>

  <div style="background: #e6f3ff; padding: 15px; border-radius: 5px; margin-top: 15px;">
    <strong>💡 Key Benefits:</strong>
    <ul style="margin: 10px 0;">
      <li>✅ <strong>Semantic HTML</strong> - Individual attributes instead of JSON blobs</li>
      <li>✅ <strong>Composable Structure</strong> - Build cards like React components</li>
      <li>✅ <strong>Auto-discovery</strong> - Components load automatically when found in DOM</li>
      <li>✅ <strong>Simple & Clean</strong> - Easy to understand and maintain</li>
    </ul>
  </div>
</div>

</div>

<?php include 'footer.php'; ?>