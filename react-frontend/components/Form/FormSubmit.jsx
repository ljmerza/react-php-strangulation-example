import React from 'react';

export default function FormSubmit({
  children = 'Submit',
  type = 'primary',
  disabled = false,
  onClick,
  className = ''
}) {
  const buttonClass = `form-submit ${type} ${disabled ? 'disabled' : ''} ${className}`;

  return (
    <div className="form-submit-container">
      <button
        type="submit"
        className={buttonClass}
        disabled={disabled}
        onClick={onClick}
      >
        {children}
      </button>
    </div>
  );
}