import React from 'react';
import styles from './CardFooter.module.css';
import cssText from './CardFooter.module.css?inline';

// Export CSS for web component registration
export const cardfooterwidgetCSS = cssText;

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