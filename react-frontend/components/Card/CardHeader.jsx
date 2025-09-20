import React from 'react';

export default function CardHeader({
  title = '',
  subtitle = '',
  className = ''
}) {
  return (
    <div className={`card-header ${className}`}>
      {title && <h3 className="card-title">{title}</h3>}
      {subtitle && <p className="card-subtitle">{subtitle}</p>}
    </div>
  );
}