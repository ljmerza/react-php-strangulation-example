import React from 'react';

export default function FormField({
  type = 'text',
  label,
  name,
  value,
  placeholder,
  required = false,
  options = [],
  onChange
}) {
  const handleChange = (e) => {
    const fieldValue = e.target.type === 'checkbox' ? e.target.checked : e.target.value;
    onChange?.(name, fieldValue);
  };

  const renderField = () => {
    switch (type) {
      case 'select':
        return (
          <select name={name} value={value || ''} onChange={handleChange} required={required}>
            <option value="">{placeholder || 'Select...'}</option>
            {options.map((option, index) => (
              <option key={index} value={option.value || option}>
                {option.label || option}
              </option>
            ))}
          </select>
        );

      case 'textarea':
        return (
          <textarea
            name={name}
            value={value || ''}
            placeholder={placeholder}
            onChange={handleChange}
            required={required}
            rows={3}
          />
        );

      case 'checkbox':
        return (
          <input
            type="checkbox"
            name={name}
            checked={value || false}
            onChange={handleChange}
            required={required}
          />
        );

      default:
        return (
          <input
            type={type}
            name={name}
            value={value || ''}
            placeholder={placeholder}
            onChange={handleChange}
            required={required}
          />
        );
    }
  };

  return (
    <div className="form-field">
      {label && (
        <label htmlFor={name}>
          {label}
          {required && <span className="required">*</span>}
        </label>
      )}
      {renderField()}
    </div>
  );
}