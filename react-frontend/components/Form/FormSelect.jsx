import React from 'react';

export default function FormSelect({
  name = '',
  label = '',
  required = false,
  placeholder = '',
  value = '',
  multiple = false,
  size,
  onChange,
  className = '',
  children = ''
}) {
  const handleChange = (e) => {
    const newValue = multiple
      ? Array.from(e.target.selectedOptions, option => option.value)
      : e.target.value;
    onChange?.(name, newValue);
  };

  // Parse options from children HTML
  const options = React.useMemo(() => {
    if (!children) return [];

    const parser = new DOMParser();
    const doc = parser.parseFromString(`<div>${children}</div>`, 'text/html');
    const optionElements = doc.querySelectorAll('option');

    return Array.from(optionElements).map(option => ({
      value: option.getAttribute('value') || option.textContent,
      label: option.textContent || option.getAttribute('value')
    }));
  }, [children]);

  return (
    <div className="form-field">
      {label && (
        <label htmlFor={name} className="form-label">
          {label}
          {required && <span className="required-asterisk">*</span>}
        </label>
      )}
      <select
        name={name}
        value={value}
        required={required}
        multiple={multiple}
        size={size}
        onChange={handleChange}
        className={`form-select ${className}`}
      >
        {placeholder && (
          <option value="" disabled>
            {placeholder}
          </option>
        )}
        {options.map((option, index) => (
          <option key={index} value={option.value}>
            {option.label}
          </option>
        ))}
      </select>
    </div>
  );
}