import React from 'react';

export default function Card({
  variant = 'default',
  className = '',
  children = ''
}) {
  const cardClass = `card ${variant} ${className}`;

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
          <div className="card-header">
            <h3 className="card-title">
              {headerElement.getAttribute('title') || ''}
            </h3>
            {headerElement.getAttribute('subtitle') && (
              <p className="card-subtitle">
                {headerElement.getAttribute('subtitle')}
              </p>
            )}
          </div>
        )}

        {bodyElement && (
          <div className={`card-body ${bodyElement.getAttribute('padding') === 'true' ? 'with-padding' : ''}`}>
            <div dangerouslySetInnerHTML={{ __html: bodyElement.innerHTML }} />
          </div>
        )}

        {footerElement && (
          <div className={`card-footer ${footerElement.getAttribute('align') || 'left'}`}>
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