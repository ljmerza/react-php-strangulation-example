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

</div>

<?php include 'footer.php'; ?>