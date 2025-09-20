import React from 'react';

export default function CardBody({
  padding = true,
  className = '',
  children
}) {
  const bodyClasses = `card-body ${padding ? 'padded' : 'no-padding'} ${className}`.trim();

  return (
    <div className={bodyClasses}>
      {children}
    </div>
  );
}