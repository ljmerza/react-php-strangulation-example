import React from 'react';
import styles from './Card.module.css';
import cssText from './Card.module.css?inline';

// Export CSS for web component registration
export const cardwidgetCSS = cssText;

export default function Card({
  variant = 'default',
  className = '',
  children = ''
}) {
  const cardClass = `${styles.card} ${variant !== 'default' ? styles[variant] : ''} ${className}`;

  // Parse children to extract card components
  const renderContent = () => {
    if (!children) return null;

    const parser = new DOMParser();
    const doc = parser.parseFromString(`<div>${children}</div>`, 'text/html');
    const container = doc.querySelector('div');

    // Find card components
    const headerElement = container.querySelector('cardheader-widget');
    const bodyElement = container.querySelector('cardbody-widget');
    const footerElement = container.querySelector('cardfooter-widget');

    return (
      <>
        {headerElement && (
          <div className={styles.header}>
            <h3 className={styles.title}>
              {headerElement.getAttribute('title') || ''}
            </h3>
            {headerElement.getAttribute('subtitle') && (
              <p className={styles.subtitle}>
                {headerElement.getAttribute('subtitle')}
              </p>
            )}
          </div>
        )}

        {bodyElement && (
          <div className={`${styles.body} ${bodyElement.getAttribute('padding') === 'true' ? styles.withPadding : ''}`}>
            <div dangerouslySetInnerHTML={{ __html: bodyElement.innerHTML }} />
          </div>
        )}

        {footerElement && (
          <div className={`${styles.footer} ${styles[footerElement.getAttribute('align') || 'left']}`}>
            <div dangerouslySetInnerHTML={{ __html: footerElement.innerHTML }} />
          </div>
        )}
      </>
    );
  };

  return (
    <div className={cardClass}>
      {renderContent()}
    </div>
  );
}