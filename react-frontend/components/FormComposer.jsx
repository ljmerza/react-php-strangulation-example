import React, { useState, useEffect } from 'react';
import FormField from './FormField';

export default function FormComposer({
  title = "Form",
  fields = [],
  initialData = {},
  onSubmit,
  onFieldChange,
  submitLabel = "Submit",
  resetLabel = "Reset"
}) {
  const [formData, setFormData] = useState(initialData);
  const [errors, setErrors] = useState({});

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

    fields.forEach(field => {
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
          {fields.map((field, index) => {
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
          <button type="submit">{submitLabel}</button>
          <button type="button" onClick={handleReset}>{resetLabel}</button>
        </div>
      </form>

      <div className="form-debug" style={{ marginTop: '20px', fontSize: '12px', color: '#666' }}>
        <strong>Form Data:</strong> {JSON.stringify(formData, null, 2)}
      </div>
    </div>
  );
}