import React from 'react';

export default function FormText({
  name = '',
  label = '',
  required = false,
  placeholder = '',
  value = '',
  onChange,
  className = ''
}) {
  const handleChange = (e) => {
    onChange?.(name, e.target.value);
  };

  return (
    <div className="form-field">
      {label && (
        <label htmlFor={name} className="form-label">
          {label}
          {required && <span className="required-asterisk">*</span>}
        </label>
      )}
      <input
        type="text"
        name={name}
        value={value}
        placeholder={placeholder}
        required={required}
        onChange={handleChange}
        className={`form-input ${className}`}
      />
    </div>
  );
}