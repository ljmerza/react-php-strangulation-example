import React, { useState, useEffect, useMemo } from 'react';
import FormField from './FormField';

export default function FormComposer({
  title = "Form",
  fields = [],
  initialData = {},
  onSubmit,
  onFieldChange,
  submitLabel = "Submit",
  resetLabel = "Reset",
  children = ''
}) {
  const [formData, setFormData] = useState(initialData);
  const [errors, setErrors] = useState({});

  // Parse form fields from HTML children (like Card component does)
  const parsedFields = useMemo(() => {
    if (!children || fields.length > 0) return fields; // Use fields prop if provided

    const parser = new DOMParser();
    const doc = parser.parseFromString(`<div>${children}</div>`, 'text/html');
    const fieldElements = doc.querySelectorAll('form-field');

    return Array.from(fieldElements).map(element => {
      const field = {
        name: element.getAttribute('name') || '',
        label: element.getAttribute('label') || '',
        type: element.getAttribute('type') || 'text',
        required: element.hasAttribute('required'),
        placeholder: element.getAttribute('placeholder') || '',
      };

      // Handle select options from innerHTML
      if (field.type === 'select') {
        field.children = element.innerHTML;
      }

      return field;
    });
  }, [children, fields]);

  // Extract submit button configuration from children
  const submitConfig = useMemo(() => {
    if (!children) return { label: submitLabel };

    const parser = new DOMParser();
    const doc = parser.parseFromString(`<div>${children}</div>`, 'text/html');
    const submitElement = doc.querySelector('form-submit');

    if (submitElement) {
      return {
        label: submitElement.textContent || submitLabel,
        type: submitElement.getAttribute('type') || 'primary'
      };
    }

    return { label: submitLabel };
  }, [children, submitLabel]);

  useEffect(() => {
    setFormData(initialData);
  }, [initialData]);

  const handleFieldChange = (fieldName, value) => {
    const newData = { ...formData, [fieldName]: value };
    setFormData(newData);

    // Clear error when field is changed
    if (errors[fieldName]) {
      setErrors(prev => ({ ...prev, [fieldName]: null }));
    }

    // Emit field change event
    onFieldChange?.(fieldName, value, newData);
  };

  const validateForm = () => {
    const newErrors = {};

    parsedFields.forEach(field => {
      if (!field || !field.name) return; // Skip invalid field definitions

      if (field.required && !formData[field.name]) {
        newErrors[field.name] = `${field.label || field.name} is required`;
      }

      if (field.validate && formData[field.name]) {
        const validationResult = field.validate(formData[field.name], formData);
        if (validationResult !== true) {
          newErrors[field.name] = validationResult;
        }
      }
    });

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    if (validateForm()) {
      onSubmit?.(formData);
    }
  };

  const handleReset = () => {
    setFormData(initialData);
    setErrors({});
  };

  return (
    <div className="form-composer">
      <form onSubmit={handleSubmit}>
        {title && <h3>{title}</h3>}

        <div className="form-fields">
          {parsedFields.map((field, index) => {
            if (!field || !field.name) return null; // Skip invalid fields

            return (
              <div key={field.name || index} className="field-wrapper">
                <FormField
                  {...field}
                  value={formData[field.name]}
                  onChange={handleFieldChange}
                />
                {errors[field.name] && (
                  <div className="field-error">{errors[field.name]}</div>
                )}
              </div>
            );
          })}
        </div>

        <div className="form-actions">
          <button type="submit" className={`form-submit ${submitConfig.type || 'primary'}`}>
            {submitConfig.label}
          </button>
          <button type="button" onClick={handleReset} className="form-reset">
            {resetLabel}
          </button>
        </div>
      </form>

      <div className="form-debug" style={{ marginTop: '20px', fontSize: '12px', color: '#666' }}>
        <strong>Form Data:</strong> {JSON.stringify(formData, null, 2)}
      </div>
    </div>
  );
}