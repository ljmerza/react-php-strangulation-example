import React from 'react';
import styles from './CardBody.module.css';
import cssText from './CardBody.module.css?inline';

// Export CSS for web component registration
export const cardbodywidgetCSS = cssText;

export default function CardBody({
  padding = false,
  className = '',
  children = ''
}) {
  const bodyClass = `${styles.body} ${padding ? styles.withPadding : ''} ${className}`;

  return (
    <div className={bodyClass}>
      {children && <div dangerouslySetInnerHTML={{ __html: children }} />}
    </div>
  );
}