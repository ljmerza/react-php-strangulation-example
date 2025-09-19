import React, { useMemo } from 'react';

export default function PHPComposableCard({
  variant = 'default',
  className = '',
  children
}) {
  const cardContent = useMemo(() => {
    if (!children || typeof children !== 'string') {
      return { header: null, body: [], footer: null };
    }

    // Parse the HTML string to extract card sections
    const parser = new DOMParser();
    const doc = parser.parseFromString(`<div>${children}</div>`, 'text/html');
    const container = doc.querySelector('div');

    const content = {
      header: null,
      body: [],
      footer: null
    };

    if (!container) return content;

    Array.from(container.children).forEach((child, index) => {
      const tagName = child.tagName.toLowerCase();

      switch (tagName) {
        case 'card-header':
          const title = child.getAttribute('title');
          const subtitle = child.getAttribute('subtitle');
          const headerContent = child.innerHTML;

          content.header = (
            <div key="header" className="card-header">
              <div className="card-title-section">
                {title && <h3 className="card-title">{title}</h3>}
                {subtitle && <p className="card-subtitle">{subtitle}</p>}
                {headerContent && (
                  <div
                    className="card-header-content"
                    dangerouslySetInnerHTML={{ __html: headerContent }}
                  />
                )}
              </div>
            </div>
          );
          break;

        case 'card-body':
          const padding = child.getAttribute('padding') !== 'false';
          const bodyClass = child.getAttribute('class') || '';
          const bodyContent = child.innerHTML;

          content.body.push(
            <div
              key={`body-${index}`}
              className={`card-body ${padding ? 'padded' : 'no-padding'} ${bodyClass}`.trim()}
              dangerouslySetInnerHTML={{ __html: bodyContent }}
            />
          );
          break;

        case 'card-footer':
          const align = child.getAttribute('align') || 'left';
          const footerClass = child.getAttribute('class') || '';
          const footerContent = child.innerHTML;

          content.footer = (
            <div
              key="footer"
              className={`card-footer align-${align} ${footerClass}`.trim()}
              dangerouslySetInnerHTML={{ __html: footerContent }}
            />
          );
          break;

        default:
          // Unknown elements go into body
          content.body.push(
            <div
              key={`unknown-${index}`}
              className="card-body padded"
              dangerouslySetInnerHTML={{ __html: child.outerHTML }}
            />
          );
      }
    });

    return content;
  }, [children]);

  const cardClasses = `card ${variant} ${className}`.trim();

  return (
    <div className={cardClasses}>
      {cardContent.header}
      {cardContent.body.length > 0 ? (
        cardContent.body
      ) : (
        <div className="card-body padded">
          <div dangerouslySetInnerHTML={{ __html: children || '' }} />
        </div>
      )}
      {cardContent.footer}
    </div>
  );
}