import React from 'react';

export default function CardHeader({
  title,
  subtitle,
  className = '',
  children
}) {
  return (
    <div className={`card-header ${className}`.trim()}>
      <div className="card-title-section">
        {title && <h3 className="card-title">{title}</h3>}
        {subtitle && <p className="card-subtitle">{subtitle}</p>}
        {children && (
          <div className="card-header-content">
            {children}
          </div>
        )}
      </div>
    </div>
  );
}