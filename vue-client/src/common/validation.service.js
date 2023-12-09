export const validate = (value, rules) => {
  let isValid = true;
  let error = '';

  if (rules.required && isValid) {
    isValid = value.trim() !== '';
    if (!isValid) error = 'This field is required';
  }

  if (rules.minLength && isValid) {
    isValid = value.length >= rules.minLength;
    if (!isValid) error = `Minimum length is ${rules.minLength}`;
  }

  if (rules.isEmail && isValid) {
    const emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
    isValid = !emailRegex.test(value);
    if (!isValid) error = `This field must be a valid email`;
  }

  return { isValid, error };
};

// Check and validate individual field
export const validateField = (validationRules, validationErrors, field, value) => {
  if (validationRules[field]) {
    const { isValid, error } = validate(value, validationRules[field]);
    validationErrors[field] = !isValid ? error : null;

    return isValid;
  }

  return true;
};

// Validate all fields before submitting
export const validateForm = (validationRules, validationErrors, formValues) => {
  let isFormValid = true;
  
  for (const field in formValues) {
    const isFieldValid = validateField(validationRules, validationErrors, field, formValues[field]);
    if (!isFieldValid) isFormValid = false;
  }

  return isFormValid;
};