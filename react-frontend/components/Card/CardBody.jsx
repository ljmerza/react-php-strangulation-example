import React from 'react';
import styles from './CardBody.module.css';

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