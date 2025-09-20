import React from 'react';

export default function FormField({
  name = '',
  label = '',
  type = 'text',
  required = false,
  placeholder = '',
  value = '',
  options = [],
  onChange,
  className = '',
  children = ''
}) {
  const handleChange = (e) => {
    const newValue = type === 'checkbox' ? e.target.checked : e.target.value;
    onChange?.(name, newValue);
  };

  // Parse options from children if it's a select field
  const selectOptions = React.useMemo(() => {
    if (type === 'select' && children) {
      const parser = new DOMParser();
      const doc = parser.parseFromString(`<div>${children}</div>`, 'text/html');
      const optionElements = doc.querySelectorAll('option');

      return Array.from(optionElements).map(option => ({
        value: option.getAttribute('value') || option.textContent,
        label: option.textContent || option.getAttribute('value')
      }));
    }
    return options;
  }, [children, options, type]);

  const renderField = () => {
    switch (type) {
      case 'textarea':
        return (
          <textarea
            name={name}
            value={value}
            placeholder={placeholder}
            required={required}
            onChange={handleChange}
            className={`form-textarea ${className}`}
            rows={4}
          />
        );

      case 'select':
        return (
          <select
            name={name}
            value={value}
            required={required}
            onChange={handleChange}
            className={`form-select ${className}`}
          >
            {placeholder && (
              <option value="" disabled>
                {placeholder}
              </option>
            )}
            {selectOptions.map((option, index) => (
              <option key={index} value={option.value}>
                {option.label}
              </option>
            ))}
          </select>
        );

      case 'checkbox':
        return (
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
        );

      default:
        return (
          <input
            type={type}
            name={name}
            value={value}
            placeholder={placeholder}
            required={required}
            onChange={handleChange}
            className={`form-input ${className}`}
          />
        );
    }
  };

  if (type === 'checkbox') {
    return <div className="form-field checkbox-field">{renderField()}</div>;
  }

  return (
    <div className="form-field">
      {label && (
        <label htmlFor={name} className="form-label">
          {label}
          {required && <span className="required-asterisk">*</span>}
        </label>
      )}
      {renderField()}
    </div>
  );
}