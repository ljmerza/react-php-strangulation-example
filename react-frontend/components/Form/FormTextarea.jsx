import React from 'react';

export default function FormTextarea({
  name = '',
  label = '',
  required = false,
  placeholder = '',
  value = '',
  rows = 4,
  cols,
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
      <textarea
        name={name}
        value={value}
        placeholder={placeholder}
        required={required}
        rows={rows}
        cols={cols}
        onChange={handleChange}
        className={`form-textarea ${className}`}
      />
    </div>
  );
}