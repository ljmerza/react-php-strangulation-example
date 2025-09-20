import React from 'react';
import styles from './CardHeader.module.css';

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