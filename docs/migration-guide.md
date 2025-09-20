# Legacy Frontend Migration Guide

> Step-by-step guide for using the Strangler Fig pattern to modernize legacy server-side frontends with React.

## Supported Frameworks

React Strangler works with **any server-side framework** that generates HTML:

- ✅ **PHP** - Laravel, Symfony, CodeIgniter, vanilla PHP
- ✅ **Ruby** - Rails, Sinatra, Hanami
- ✅ **Python** - Django, Flask, FastAPI
- ✅ **JavaScript** - Express, Next.js (SSR), Nuxt.js (SSR)
- ✅ **Java** - Spring Boot, JSP, Struts
- ✅ **C#** - ASP.NET MVC, Razor Pages
- ✅ **Go** - Gin, Echo, standard templates
- ✅ **Any framework** that can include a `<script>` tag

## The Strangler Fig Pattern

The Strangler Fig pattern allows you to **gradually replace legacy code** by:
1. **Growing new functionality alongside the old**
2. **Redirecting traffic incrementally to new components**
3. **Eventually strangling out the legacy code**

This approach minimizes risk and allows continuous deployment during modernization.

## Migration Strategy

### Phase 1: Foundation Setup

#### 1.1 Install React Strangler

```bash
# In your legacy project
mkdir react-frontend
cd react-frontend

npm init -y
npm install --save-dev vite @vitejs/plugin-react vite-plugin-react-strangler
npm install react react-dom
```

#### 1.2 Configure Build System

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { reactStrangler } from 'vite-plugin-react-strangler';

export default defineConfig({
  plugins: [
    react(),
    reactStrangler({
      outputDir: '../public/dist',
      publicDir: '../public'
    })
  ]
});
```

#### 1.3 Add Discovery Script to Legacy Pages

```php
<!-- Add to your legacy page templates -->
<script type="module" src="dist/discover.js"></script>
```

### Phase 2: Identify Migration Candidates

#### 2.1 Start with Low-Risk Components

**Good first candidates:**
- ✅ **Display components** (user cards, product tiles)
- ✅ **Simple forms** (contact forms, search boxes)
- ✅ **Static widgets** (alerts, badges, buttons)

**Avoid initially:**
- ❌ **Complex interactions** (drag & drop, complex forms)
- ❌ **Legacy dependencies** (jQuery plugins, old libraries)
- ❌ **Critical business logic** (checkout, payments)

#### 2.2 Migration Priority Matrix

| Component Type | Complexity | Dependencies | Risk | Priority |
|----------------|------------|--------------|------|----------|
| User Card      | Low        | None         | Low  | ⭐⭐⭐ |
| Data Table     | Medium     | Sorting lib  | Med  | ⭐⭐ |
| Dashboard      | High       | Charts, WS   | High | ⭐ |

### Phase 3: Component Creation

#### 3.1 Create Your First Component

**Start with a simple display component:**

```tsx
// components/UserCard.tsx
import React from 'react';
import styles from './UserCard.module.css';

interface UserCardProps {
  name: string;
  email: string;
  role?: string;
  avatar?: string;
}

export default function UserCard({ name, email, role = 'User', avatar }: UserCardProps) {
  return (
    <div className={styles.card}>
      {avatar && <img src={avatar} alt={name} className={styles.avatar} />}
      <div className={styles.info}>
        <h3 className={styles.name}>{name}</h3>
        <p className={styles.email}>{email}</p>
        <span className={styles.role}>{role}</span>
      </div>
    </div>
  );
}
```

```css
/* components/UserCard.module.css */
.card {
  display: flex;
  align-items: center;
  padding: 16px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background: white;
  margin: 8px 0;
}

.avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  margin-right: 12px;
}

.info {
  flex: 1;
}

.name {
  margin: 0 0 4px 0;
  color: #333;
  font-size: 16px;
}

.email {
  margin: 0 0 8px 0;
  color: #666;
  font-size: 14px;
}

.role {
  background: #007bff;
  color: white;
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 12px;
}
```

#### 3.2 Build and Test

```bash
npm run build
```

#### 3.3 Replace Legacy Code in Any Framework

**PHP:**
```php
<!-- Before -->
<div class="user-info">
  <h3><?= $user['name'] ?></h3>
  <p><?= $user['email'] ?></p>
</div>

<!-- After -->
<usercard-widget
  name="<?= $user['name'] ?>"
  email="<?= $user['email'] ?>">
</usercard-widget>
```

**Rails:**
```erb
<!-- Before -->
<div class="user-info">
  <h3><%= @user.name %></h3>
  <p><%= @user.email %></p>
</div>

<!-- After -->
<usercard-widget
  name="<%= @user.name %>"
  email="<%= @user.email %>">
</usercard-widget>
```

**Django:**
```html
<!-- Before -->
<div class="user-info">
  <h3>{{ user.name }}</h3>
  <p>{{ user.email }}</p>
</div>

<!-- After -->
<usercard-widget
  name="{{ user.name }}"
  email="{{ user.email }}">
</usercard-widget>
```

### Phase 4: Advanced Integration

#### 4.1 Legacy JavaScript Integration

Connect with existing jQuery/vanilla JS:

```tsx
// components/InteractiveWidget.tsx
import React, { useEffect, useRef } from 'react';

export default function InteractiveWidget({ onLegacyEvent }: { onLegacyEvent?: (data: any) => void }) {
  const widgetRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    // Listen for legacy events
    const handleLegacyUpdate = (event: CustomEvent) => {
      onLegacyEvent?.(event.detail);
    };

    document.addEventListener('legacy-data-update', handleLegacyUpdate);
    return () => document.removeEventListener('legacy-data-update', handleLegacyUpdate);
  }, [onLegacyEvent]);

  const triggerLegacyAction = () => {
    // Trigger legacy JavaScript functions
    if (typeof (window as any).legacyFunction === 'function') {
      (window as any).legacyFunction('some-data');
    }
  };

  return (
    <div ref={widgetRef}>
      <button onClick={triggerLegacyAction}>Interact with Legacy</button>
    </div>
  );
}
```

#### 4.2 Form Integration

Integrate with legacy form handling:

```tsx
// components/ModernForm.tsx
export default function ModernForm({ onSubmit }: { onSubmit?: (data: FormData) => void }) {
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const formData = new FormData(e.target as HTMLFormElement);

    // Call legacy form handler if it exists
    if (typeof (window as any).handleLegacyForm === 'function') {
      (window as any).handleLegacyForm(formData);
    }

    onSubmit?.(formData);
  };

  return (
    <form onSubmit={handleSubmit}>
      <input name="email" type="email" required />
      <button type="submit">Submit</button>
    </form>
  );
}
```

### Phase 5: Production Deployment

#### 5.1 Feature Flags

Implement gradual rollout in any framework:

**PHP:**
```php
<?php $useReact = $_SESSION['feature_flags']['react_components'] ?? false; ?>

<?php if ($useReact): ?>
  <usercard-widget name="<?= $user['name'] ?>"></usercard-widget>
<?php else: ?>
  <div class="legacy-user-card">...</div>
<?php endif; ?>
```

**Rails:**
```erb
<% if feature_enabled?(:react_components) %>
  <usercard-widget name="<%= @user.name %>"></usercard-widget>
<% else %>
  <div class="legacy-user-card">...</div>
<% end %>
```

**Django:**
```html
{% if 'react_components' in request.user.feature_flags %}
  <usercard-widget name="{{ user.name }}"></usercard-widget>
{% else %}
  <div class="legacy-user-card">...</div>
{% endif %}
```

**Express + EJS:**
```html
<% if (user.featureFlags.reactComponents) { %>
  <usercard-widget name="<%= user.name %>"></usercard-widget>
<% } else { %>
  <div class="legacy-user-card">...</div>
<% } %>
```

#### 5.2 Error Handling

Add error boundaries and fallbacks:

```html
<div data-component-fallback>
  <!-- React component will render here -->
  <usercard-widget name="John Doe"></usercard-widget>

  <!-- Fallback for errors/unsupported browsers -->
  <noscript>
    <div class="legacy-user-card">
      <h3>John Doe</h3>
    </div>
  </noscript>
</div>
```

#### 5.3 Performance Monitoring

Track migration success:

```javascript
// Add to your analytics
window.addEventListener('load', () => {
  if (window.componentDiscovery) {
    const stats = window.componentDiscovery.getStats();

    // Track component usage
    analytics.track('react_strangler_stats', {
      components_loaded: stats.loadedComponents,
      total_components: stats.totalComponents,
      page_url: window.location.pathname
    });
  }
});
```

## Migration Checklist

### ✅ Pre-Migration
- [ ] Legacy application is stable
- [ ] Build system is set up
- [ ] Team is trained on React basics
- [ ] Component candidates identified

### ✅ During Migration
- [ ] Start with simple, low-risk components
- [ ] Maintain legacy fallbacks
- [ ] Test thoroughly in staging
- [ ] Monitor performance impact
- [ ] Gather user feedback

### ✅ Post-Migration
- [ ] Remove legacy code safely
- [ ] Update documentation
- [ ] Train team on new components
- [ ] Plan next migration phase

## Best Practices

### DO ✅
- **Start small** - Begin with simple display components
- **Maintain fallbacks** - Always have legacy versions available
- **Test extensively** - Use both automated and manual testing
- **Monitor performance** - Track bundle sizes and load times
- **Document changes** - Keep migration log for team reference

### DON'T ❌
- **Don't migrate everything at once** - Incremental approach reduces risk
- **Don't ignore legacy dependencies** - Consider jQuery, bootstrap integration
- **Don't skip testing** - Component isolation doesn't mean skip testing
- **Don't forget about SEO** - Ensure server-side rendering when needed
- **Don't neglect accessibility** - React components should be accessible

## Common Patterns

### 1. Progressive Enhancement
```html
<!-- Works without JavaScript -->
<div class="user-list">
  <?php foreach($users as $user): ?>
    <div class="user-item"><?= $user['name'] ?></div>
  <?php endforeach; ?>
</div>

<!-- Enhanced with React when available -->
<script>
  if (window.componentDiscovery) {
    document.querySelector('.user-list').innerHTML = `
      <userlist-widget data='<?= json_encode($users) ?>'></userlist-widget>
    `;
  }
</script>
```

### 2. Legacy CSS Preservation
```tsx
// Preserve existing CSS classes
export default function ModernCard({ legacyClass, ...props }) {
  return (
    <div className={`${styles.card} ${legacyClass}`}>
      {/* Modern React content */}
    </div>
  );
}
```

### 3. Event Bridge Pattern
```typescript
// Bridge React events to legacy code
const handleReactEvent = (data: any) => {
  // Trigger legacy event handlers
  $(document).trigger('user-updated', data);

  // Also handle in React way
  updateUserState(data);
};
```

## Rollback Strategy

### Emergency Rollback
```php
<?php
// Kill switch for React components
if ($emergencyMode) {
  // Disable all React components
  echo '<script>window.DISABLE_REACT_COMPONENTS = true;</script>';
}
?>
```

### Component-Level Rollback
```javascript
// In discover.js - selective disabling
const DISABLED_COMPONENTS = ['problematic-widget'];

if (DISABLED_COMPONENTS.includes(tagName)) {
  console.log(`Component ${tagName} is disabled, using legacy fallback`);
  return false;
}
```

## Success Metrics

Track these metrics to measure migration success:

- **Page load time** (should improve with lazy loading)
- **Bundle size** (should be smaller than legacy JS)
- **User engagement** (modern UI should increase interaction)
- **Developer velocity** (faster feature development)
- **Bug rate** (should decrease with React's predictability)
- **Maintenance cost** (should reduce over time)

---

*This guide provides a structured approach to legacy frontend modernization using the React Strangler pattern.*