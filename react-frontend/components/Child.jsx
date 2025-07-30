import React, { useState } from 'react';

export default function Child({ message = "Hello from Child!", onChildUpdate }) {
  const [count, setCount] = useState(0);

  const handleClick = () => {
    const newCount = count + 1;
    setCount(newCount);
    onChildUpdate?.(newCount);
  };

  return (
    <div className="child-component">
      <h4>{message}</h4>
      <p>Child component clicked: {count} times</p>
      <button onClick={handleClick}>Click me!</button>
    </div>
  );
}