import React from 'react';

export default function CardBody({
  padding = false,
  className = '',
  children = ''
}) {
  const bodyClass = `card-body ${padding ? 'with-padding' : ''} ${className}`;

  return (
    <div className={bodyClass}>
      {children && <div dangerouslySetInnerHTML={{ __html: children }} />}
    </div>
  );
}