import React, { useState } from 'react';
import Child from './Child';

export default function Parent() {
  const [childCount, setChildCount] = useState(0);

  const handleChildUpdate = (count) => {
    setChildCount(count);
  };

  return (
    <div className="parent-component">
      <br/>
      <h3>This is the Parent component!</h3>
      <p>It contains a nested Child component below.</p>
      <p>Child has been clicked: {childCount} times</p>
      
      <Child 
        message="I'm a nested child component!" 
        onChildUpdate={handleChildUpdate}
      />
    </div>
  );
}
