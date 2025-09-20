import React from 'react';
import styles from './CardHeader.module.css';
import cssText from './CardHeader.module.css?inline';

// Export CSS for web component registration
export const cardheaderwidgetCSS = cssText;

export default function CardHeader({
  title = '',
  subtitle = '',
  className = ''
}) {
  return (
    <div className={`${styles.header} ${className}`}>
      {title && <h3 className={styles.title}>{title}</h3>}
      {subtitle && <p className={styles.subtitle}>{subtitle}</p>}
    </div>
  );
}