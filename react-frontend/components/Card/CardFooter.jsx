import React from 'react';

export default function CardFooter({
  align = 'left',
  className = '',
  children = ''
}) {
  const footerClass = `card-footer ${align} ${className}`;

  return (
    <div className={footerClass}>
      {children && <div dangerouslySetInnerHTML={{ __html: children }} />}
    </div>
  );
}