import React from 'react';

export default function CardFooter({
  align = 'left',
  className = '',
  children
}) {
  return (
    <div className={`card-footer align-${align} ${className}`.trim()}>
      {children}
    </div>
  );
}