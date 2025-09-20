import React, { useState, useEffect } from 'react';
import styles from './Hello.module.css';

interface HelloProps {
  name?: string;
  onInputChange?: (value: string) => void;
}

export default function Hello({ name = "World", onInputChange }: HelloProps) {
  const [value, setValue] = useState(name);

  useEffect(() => {
    setValue(name); // react to external changes
  }, [name]);

  const handleChange = (e) => {
    const newVal = e.target.value;
    setValue(newVal);

    // Emit event to WebComponent
    onInputChange?.(newVal);
  };

  return (
    <div className={styles.hello}>
      <h3 className={styles.title}>Hello from React, {value}!</h3>
      <input value={value} onChange={handleChange} className={styles.input} />
    </div>
  );
}
