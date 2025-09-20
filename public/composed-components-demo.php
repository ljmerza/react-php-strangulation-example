<?php
$pageTitle = "Composed Components Demo";
include 'header.php';
?>

<div class="container">
  <h1>🧩 Composed Components Demo</h1>
  <p>This page demonstrates complex, composed React components that are automatically discovered and loaded.</p>

<div class="demo-section">
  <h2>📝 Dynamic Form Composer</h2>
  <div class="section-description">
    A flexible form builder that composes multiple field types with validation and real-time data binding.
  </div>

  <form-composer title="User Registration Form">
    <form-field
      name="firstName"
      label="First Name"
      type="text"
      required
      placeholder="Enter your first name">
    </form-field>

    <form-field
      name="lastName"
      label="Last Name"
      type="text"
      required
      placeholder="Enter your last name">
    </form-field>

    <form-field
      name="email"
      label="Email Address"
      type="email"
      required
      placeholder="user@example.com">
    </form-field>

    <form-field
      name="age"
      label="Age"
      type="number"
      placeholder="Enter your age">
    </form-field>

    <form-field
      name="country"
      label="Country"
      type="select"
      required
      placeholder="Select your country">
      <option value="us">United States</option>
      <option value="ca">Canada</option>
      <option value="uk">United Kingdom</option>
      <option value="de">Germany</option>
      <option value="fr">France</option>
    </form-field>

    <form-field
      name="bio"
      label="Bio"
      type="textarea"
      placeholder="Tell us about yourself...">
    </form-field>

    <form-field
      name="newsletter"
      label="Subscribe to newsletter"
      type="checkbox">
    </form-field>

    <form-submit>Register User</form-submit>
  </form-composer>
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
      <h4>Composable Forms</h4>
      <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 12px;">
        <code style="color: #0d6efd;">&lt;form-composer title="Contact Us"&gt;</code><br>
        <code>&nbsp;&nbsp;&lt;form-field</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;name="email"</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;label="Email"</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;type="email"</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;required&gt;</code><br>
        <code>&nbsp;&nbsp;&lt;/form-field&gt;</code><br><br>
        <code>&nbsp;&nbsp;&lt;form-field</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;name="country"</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;type="select"&gt;</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;&lt;option value="us"&gt;USA&lt;/option&gt;</code><br>
        <code>&nbsp;&nbsp;&nbsp;&nbsp;&lt;option value="ca"&gt;Canada&lt;/option&gt;</code><br>
        <code>&nbsp;&nbsp;&lt;/form-field&gt;</code><br><br>
        <code>&nbsp;&nbsp;&lt;form-submit&gt;Send&lt;/form-submit&gt;</code><br>
        <code style="color: #0d6efd;">&lt;/form-composer&gt;</code>
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
        <code>table.setAttribute('page-size', '10');</code>
      </div>
    </div>
  </div>

  <div style="background: #e6f3ff; padding: 15px; border-radius: 5px; margin-top: 15px;">
    <strong>💡 Key Benefits:</strong>
    <ul style="margin: 10px 0;">
      <li>✅ <strong>Semantic HTML</strong> - Individual attributes instead of JSON blobs</li>
      <li>✅ <strong>Composable Structure</strong> - Build forms like React components</li>
      <li>✅ <strong>Auto-discovery</strong> - Components load automatically when found in DOM</li>
      <li>✅ <strong>On-demand Loading</strong> - Zero unused JavaScript</li>
    </ul>
  </div>
</div>

</div>

<?php include 'footer.php'; ?>