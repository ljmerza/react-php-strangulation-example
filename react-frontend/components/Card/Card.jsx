import React, { useMemo } from 'react';

// Main card component that handles both React children and HTML strings from PHP
export default function Card({
  variant = 'default',
  className = '',
  children
}) {
  const cardClasses = `card ${variant} ${className}`.trim();

  const processedContent = useMemo(() => {
    // If children is a string (from PHP), parse and structure it
    if (typeof children === 'string') {
      const parser = new DOMParser();
      const doc = parser.parseFromString(`<div>${children}</div>`, 'text/html');
      const container = doc.querySelector('div');

      const content = {
        header: null,
        body: [],
        footer: null
      };

      if (!container) return children;

      Array.from(container.children).forEach((child, index) => {
        const tagName = child.tagName.toLowerCase();

        switch (tagName) {
          case 'cardheader-widget':
            const titleMatch = child.getAttribute('data-props');
            let title = null;
            let subtitle = null;

            if (titleMatch) {
              try {
                const props = JSON.parse(titleMatch.replace(/&quot;/g, '"'));
                title = props.title;
                subtitle = props.subtitle;
              } catch (e) {
                console.warn('Failed to parse cardheader-widget props:', e);
              }
            }

            const headerContent = child.innerHTML.trim();

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

          case 'cardbody-widget':
            const bodyContent = child.innerHTML;
            const paddingAttr = child.getAttribute('padding');
            const padding = paddingAttr !== 'false';
            const bodyClass = child.getAttribute('class') || '';

            content.body.push(
              <div
                key={`body-${index}`}
                className={`card-body ${padding ? 'padded' : 'no-padding'} ${bodyClass}`.trim()}
                dangerouslySetInnerHTML={{ __html: bodyContent }}
              />
            );
            break;

          case 'cardfooter-widget':
            const footerContent = child.innerHTML;
            const alignMatch = child.getAttribute('data-props');
            let align = 'left';

            if (alignMatch) {
              try {
                const props = JSON.parse(alignMatch.replace(/&quot;/g, '"'));
                align = props.align || 'left';
              } catch (e) {
                console.warn('Failed to parse cardfooter-widget props:', e);
              }
            }

            const footerClass = child.getAttribute('class') || '';

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

      return (
        <>
          {content.header}
          {content.body.length > 0 ? (
            content.body
          ) : (
            <div className="card-body padded">
              <div dangerouslySetInnerHTML={{ __html: children }} />
            </div>
          )}
          {content.footer}
        </>
      );
    }

    // Otherwise, render as normal React children
    return children;
  }, [children]);

  return (
    <div className={cardClasses}>
      {processedContent}
    </div>
  );
}