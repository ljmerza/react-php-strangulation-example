<!DOCTYPE html>
<html>
<head>
  <title>Composed Components Demo</title>
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
    .section-description {
      color: #666;
      margin-bottom: 20px;
      font-style: italic;
    }
  </style>
</head>
<body>

<h1>🧩 Composed Components Demo</h1>
<p>This page demonstrates complex, composed React components that are automatically discovered and loaded.</p>

<div class="demo-section">
  <h2>📝 Dynamic Form Composer</h2>
  <div class="section-description">
    A flexible form builder that composes multiple field types with validation and real-time data binding.
  </div>

  <form-composer
    data-props='{
      "title": "User Registration Form",
      "submitLabel": "Register User",
      "resetLabel": "Clear Form",
      "fields": [
        {
          "name": "firstName",
          "label": "First Name",
          "type": "text",
          "required": true,
          "placeholder": "Enter your first name"
        },
        {
          "name": "lastName",
          "label": "Last Name",
          "type": "text",
          "required": true,
          "placeholder": "Enter your last name"
        },
        {
          "name": "email",
          "label": "Email Address",
          "type": "email",
          "required": true,
          "placeholder": "user@example.com"
        },
        {
          "name": "age",
          "label": "Age",
          "type": "number",
          "required": false,
          "placeholder": "Enter your age"
        },
        {
          "name": "country",
          "label": "Country",
          "type": "select",
          "required": true,
          "placeholder": "Select your country",
          "options": [
            {"value": "us", "label": "United States"},
            {"value": "ca", "label": "Canada"},
            {"value": "uk", "label": "United Kingdom"},
            {"value": "de", "label": "Germany"},
            {"value": "fr", "label": "France"}
          ]
        },
        {
          "name": "bio",
          "label": "Bio",
          "type": "textarea",
          "required": false,
          "placeholder": "Tell us about yourself..."
        },
        {
          "name": "newsletter",
          "label": "Subscribe to newsletter",
          "type": "checkbox",
          "required": false
        }
      ],
      "initialData": {
        "firstName": "John",
        "lastName": "Doe",
        "newsletter": true
      }
    }'
  ></form-composer>
</div>

<div class="demo-section">
  <h2>🃏 Flexible Card Layouts</h2>
  <div class="section-description">
    Composable card components with separate header, body, and footer elements that work together.
  </div>

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
    <card-widget data-props='{"variant": "primary"}'>
      <cardheader-widget data-props='{"title": "Basic Card", "subtitle": "Simple card example"}'>
      </cardheader-widget>
      <cardbody-widget>
        <p>This is a composable card with proper header, body structure. The content renders as actual HTML elements.</p>
      </cardbody-widget>
      <cardfooter-widget>
        <button onclick="alert('Card button clicked!')">Action Button</button>
      </cardfooter-widget>
    </card-widget>

    <card-widget data-props='{"variant": "warning"}'>
      <cardheader-widget data-props='{"title": "Warning Alert"}'>
      </cardheader-widget>
      <cardbody-widget>
        <p>⚠️ Your subscription expires in 3 days. Please renew to continue using premium features.</p>
      </cardbody-widget>
      <cardfooter-widget>
        <button style="background: #ffc107; border: none; padding: 8px 16px; border-radius: 4px;">Renew Now</button>
      </cardfooter-widget>
    </card-widget>
  </div>
</div>

<div class="demo-section">
  <h2>📊 Advanced Data Table</h2>
  <div class="section-description">
    Sortable, paginated data table with custom rendering and row interactions.
  </div>

  <data-table id="main-data-table"
    data-props='{
      "sortable": true,
      "paginated": true,
      "pageSize": 5,
      "data": [
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
      ],
      "columns": [
        {"key": "name", "label": "Name"},
        {"key": "email", "label": "Email"},
        {"key": "role", "label": "Role"},
        {"key": "status", "label": "Status"},
        {"key": "joined", "label": "Joined"}
      ]
    }'
  ></data-table>
</div>

<div class="demo-section">
  <h2>🔧 Component Discovery Status</h2>
  <div class="section-description">
    Live view of which composed components are loaded and available.
  </div>

  <div id="discovery-status" style="background: #f8f9fa; padding: 15px; border-radius: 4px; font-family: monospace;">
    Loading discovery status...
  </div>

  <div style="margin-top: 15px;">
    <button onclick="refreshDiscoveryStatus()">Refresh Status</button>
    <button onclick="showComponentDetails()">Show Component Details</button>
  </div>
</div>

<script>
  // Default table data
  const defaultTableData = [
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
  ];

  const tableColumns = [
    {"key": "name", "label": "Name"},
    {"key": "email", "label": "Email"},
    {"key": "role", "label": "Role"},
    {"key": "status", "label": "Status"},
    {"key": "joined", "label": "Joined"}
  ];

  let currentTableData = [...defaultTableData];

  // DataTable configuration functions
  function updateDataTable() {
    const table = document.getElementById('main-data-table');
    if (!table) return;

    const sortable = document.getElementById('dt-sortable').checked;
    const paginated = document.getElementById('dt-paginated').checked;
    const pageSize = parseInt(document.getElementById('dt-pageSize').value);
    const emptyMessage = document.getElementById('dt-emptyMessage').value;

    const props = {
      data: currentTableData,
      columns: tableColumns,
      sortable: sortable,
      paginated: paginated,
      pageSize: pageSize,
      emptyMessage: emptyMessage
    };

    table.setAttribute('data-props', JSON.stringify(props));
  }

  function clearTableData() {
    currentTableData = [];
    updateDataTable();
  }

  function resetTableData() {
    currentTableData = [...defaultTableData];
    updateDataTable();
  }

  function addTableRow() {
    const names = ['John Doe', 'Jane Smith', 'Mike Johnson', 'Sarah Wilson', 'Tom Brown', 'Lisa Davis'];
    const roles = ['Admin', 'Editor', 'Viewer'];
    const statuses = ['Active', 'Inactive'];

    const randomName = names[Math.floor(Math.random() * names.length)];
    const randomRole = roles[Math.floor(Math.random() * roles.length)];
    const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
    const randomId = Math.max(...currentTableData.map(r => r.id), 0) + 1;

    const newRow = {
      id: randomId,
      name: randomName,
      email: randomName.toLowerCase().replace(' ', '.') + '@example.com',
      role: randomRole,
      status: randomStatus,
      joined: new Date().toISOString().split('T')[0]
    };

    currentTableData.push(newRow);
    updateDataTable();
  }

  // Form submission handler
  document.addEventListener('web-component-registered', () => {
    // Set up form handling after components are registered
    setTimeout(() => {
      const formComposer = document.querySelector('form-composer');
      if (formComposer) {
        formComposer.addEventListener('form-submitted', (e) => {
          console.log('Form submitted:', e.detail);
          alert('Form submitted! Check console for data.');
        });

        formComposer.addEventListener('field-changed', (e) => {
          console.log('Field changed:', e.detail);
        });
      }

      // Data table row clicks
      const dataTable = document.querySelector('data-table');
      if (dataTable) {
        dataTable.addEventListener('row-clicked', (e) => {
          console.log('Row clicked:', e.detail);
          alert(`Clicked user: ${e.detail.row.name}`);
        });
      }
    }, 500);
  });

  // Discovery status functions
  function refreshDiscoveryStatus() {
    const statusDiv = document.getElementById('discovery-status');

    if (window.componentDiscovery) {
      const stats = window.componentDiscovery.getStats();
      const composedComponents = stats.components.filter(c =>
        c.tagName.includes('form-composer') ||
        c.tagName.includes('card-widget') ||
        c.tagName.includes('data-table')
      );

      statusDiv.innerHTML = `
📊 Discovery Statistics:
• Total components available: ${stats.totalComponents}
• Components loaded: ${stats.loadedComponents}
• Composed components: ${composedComponents.length}

🧩 Composed Components Status:
${composedComponents.map(c =>
  `• ${c.tagName}: ${c.loaded ? '✅ Loaded' : '⏸️ Available'}`
).join('\n')}

💾 Performance:
${stats.performance.bandwidthSavings}
      `.trim();
    } else {
      statusDiv.innerHTML = '❌ Discovery system not available';
    }
  }

  function showComponentDetails() {
    if (window.componentDiscovery) {
      const components = window.componentDiscovery.listAvailable();
      const details = components.map(name => {
        const info = window.componentDiscovery.getComponentInfo(name);
        return `${name}: ${info?.loaded ? 'LOADED' : 'available'}`;
      }).join('\n');

      alert(`Available Components:\n\n${details}`);
    }
  }

  // Auto-refresh status when page loads
  window.addEventListener('load', () => {
    setTimeout(refreshDiscoveryStatus, 1000);

    // Refresh every 5 seconds to show dynamic loading
    setInterval(refreshDiscoveryStatus, 5000);
  });
</script>

</body>
</html>