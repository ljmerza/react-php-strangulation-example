import React from 'react';
import styles from './CardFooter.module.css';

export default function CardFooter({
  align = 'left',
  className = '',
  children = ''
}) {
  const footerClass = `${styles.footer} ${styles[align]} ${className}`;

  return (
    <div className={footerClass}>
      {children && <div dangerouslySetInnerHTML={{ __html: children }} />}
    </div>
  );
}