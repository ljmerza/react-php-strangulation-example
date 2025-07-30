import React, { useState, useEffect } from 'react';

export default function Hello({ name = "World", onInputChange }) {
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
    <div className="hello-component">
      <h3>Hello from React, {value}!</h3>
      <input value={value} onChange={handleChange} />
    </div>
  );
}
