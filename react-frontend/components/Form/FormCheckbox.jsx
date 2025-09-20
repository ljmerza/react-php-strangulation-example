import React from 'react';

export default function FormCheckbox({
  name = '',
  label = '',
  required = false,
  value = false,
  onChange,
  className = ''
}) {
  const handleChange = (e) => {
    onChange?.(name, e.target.checked);
  };

  return (
    <div className="form-field checkbox-field">
      <label className={`form-checkbox-label ${className}`}>
        <input
          type="checkbox"
          name={name}
          checked={!!value}
          required={required}
          onChange={handleChange}
          className="form-checkbox"
        />
        <span className="checkbox-text">{label}</span>
      </label>
    </div>
  );
}