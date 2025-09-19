import React from 'react';

export default function Card({
  title,
  subtitle,
  headerActions,
  children,
  footer,
  className = '',
  variant = 'default'
}) {
  const cardClasses = `card ${variant} ${className}`.trim();

  return (
    <div className={cardClasses}>
      {(title || subtitle || headerActions) && (
        <div className="card-header">
          <div className="card-title-section">
            {title && <h3 className="card-title">{title}</h3>}
            {subtitle && <p className="card-subtitle">{subtitle}</p>}
          </div>
          {headerActions && (
            <div className="card-actions">
              {headerActions}
            </div>
          )}
        </div>
      )}

      <div className="card-body">
        {children}
      </div>

      {footer && (
        <div className="card-footer">
          {footer}
        </div>
      )}
    </div>
  );
}