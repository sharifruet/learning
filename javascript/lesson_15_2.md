# Lesson 15.2: Input Types and Validation

## Learning Objectives

By the end of this lesson, you will be able to:
- Work with different HTML5 input types
- Use HTML5 built-in validation
- Implement JavaScript validation
- Create real-time validation
- Build custom validation rules
- Display validation errors
- Create user-friendly validation feedback

---

## Introduction to Input Types

HTML5 introduced many new input types that provide better user experience and built-in validation.

### Why Different Input Types?

- **Better UX**: Appropriate keyboards on mobile
- **Built-in Validation**: Browser validates automatically
- **Data Type**: Ensures correct data format
- **Accessibility**: Better for screen readers
- **Modern Standard**: HTML5 standard

---

## HTML5 Input Types

### Text Inputs

```html
<!-- Basic text -->
<input type="text" name="username">

<!-- Email -->
<input type="email" name="email">

<!-- Password -->
<input type="password" name="password">

<!-- Number -->
<input type="number" name="age" min="0" max="120">

<!-- Tel -->
<input type="tel" name="phone">

<!-- URL -->
<input type="url" name="website">

<!-- Search -->
<input type="search" name="query">
```

### Date and Time Inputs

```html
<!-- Date -->
<input type="date" name="birthday">

<!-- Time -->
<input type="time" name="appointment">

<!-- DateTime Local -->
<input type="datetime-local" name="event">

<!-- Month -->
<input type="month" name="month">

<!-- Week -->
<input type="week" name="week">
```

### Other Input Types

```html
<!-- Color -->
<input type="color" name="color">

<!-- Range -->
<input type="range" name="volume" min="0" max="100">

<!-- File -->
<input type="file" name="upload" accept="image/*">

<!-- Hidden -->
<input type="hidden" name="token" value="abc123">
```

---

## HTML5 Validation Attributes

### required

Makes field required:

```html
<input type="text" name="username" required>
```

### min and max

Set minimum and maximum values:

```html
<input type="number" name="age" min="18" max="100">
<input type="date" name="date" min="2024-01-01" max="2024-12-31">
```

### minlength and maxlength

Set minimum and maximum length:

```html
<input type="text" name="username" minlength="3" maxlength="20">
```

### pattern

Validate against regex pattern:

```html
<input type="text" name="username" pattern="[a-zA-Z0-9_]+">
```

### step

Set step for number inputs:

```html
<input type="number" name="quantity" min="0" step="5">
```

### Validation Messages

```javascript
let input = document.getElementById('username');

input.addEventListener('invalid', function(event) {
    if (input.validity.valueMissing) {
        input.setCustomValidity('Username is required');
    } else if (input.validity.tooShort) {
        input.setCustomValidity('Username is too short');
    } else {
        input.setCustomValidity('');
    }
});
```

---

## JavaScript Validation

### Validity API

```javascript
let input = document.getElementById('email');

// Check validity
console.log(input.validity.valid);           // true or false
console.log(input.validity.valueMissing);     // true if required and empty
console.log(input.validity.typeMismatch);     // true if type doesn't match
console.log(input.validity.patternMismatch);  // true if pattern doesn't match
console.log(input.validity.tooLong);          // true if too long
console.log(input.validity.tooShort);         // true if too short
console.log(input.validity.rangeUnderflow);   // true if below min
console.log(input.validity.rangeOverflow);     // true if above max
console.log(input.validity.stepMismatch);     // true if step doesn't match
console.log(input.validity.badInput);         // true if bad input
console.log(input.validity.customError);      // true if custom error set

// Validation message
console.log(input.validationMessage);
```

### checkValidity()

Check if form or element is valid:

```javascript
let form = document.getElementById('myForm');

if (form.checkValidity()) {
    // Form is valid
    submitForm();
} else {
    // Form has errors
    showErrors();
}

// Check individual field
let input = form.elements.username;
if (input.checkValidity()) {
    console.log('Field is valid');
} else {
    console.log('Field error:', input.validationMessage);
}
```

### reportValidity()

Show validation messages to user:

```javascript
let form = document.getElementById('myForm');

if (!form.reportValidity()) {
    // Validation failed, browser shows messages
    return;
}

// Form is valid
submitForm();
```

---

## Custom Validation

### setCustomValidity()

Set custom validation message:

```javascript
let password = document.getElementById('password');
let confirmPassword = document.getElementById('confirmPassword');

confirmPassword.addEventListener('input', function() {
    if (this.value !== password.value) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});
```

### Custom Validation Example

```javascript
function validatePassword(password) {
    let errors = [];
    
    if (password.length < 8) {
        errors.push('Password must be at least 8 characters');
    }
    if (!/[A-Z]/.test(password)) {
        errors.push('Password must contain uppercase letter');
    }
    if (!/[a-z]/.test(password)) {
        errors.push('Password must contain lowercase letter');
    }
    if (!/\d/.test(password)) {
        errors.push('Password must contain a number');
    }
    if (!/[!@#$%^&*]/.test(password)) {
        errors.push('Password must contain special character');
    }
    
    return errors;
}

let passwordInput = document.getElementById('password');
passwordInput.addEventListener('blur', function() {
    let errors = validatePassword(this.value);
    
    if (errors.length > 0) {
        this.setCustomValidity(errors.join('. '));
    } else {
        this.setCustomValidity('');
    }
});
```

---

## Real-time Validation

### Input Event Validation

```javascript
let usernameInput = document.getElementById('username');

usernameInput.addEventListener('input', function() {
    validateUsername(this);
});

function validateUsername(input) {
    let value = input.value.trim();
    let errorDiv = input.parentElement.querySelector('.error');
    
    if (value.length < 3) {
        showError(input, 'Username must be at least 3 characters');
    } else if (!/^[a-zA-Z0-9_]+$/.test(value)) {
        showError(input, 'Username can only contain letters, numbers, and underscores');
    } else {
        clearError(input);
    }
}
```

### Blur Event Validation

```javascript
let emailInput = document.getElementById('email');

emailInput.addEventListener('blur', function() {
    validateEmail(this);
});

function validateEmail(input) {
    let value = input.value.trim();
    
    if (!value) {
        showError(input, 'Email is required');
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
        showError(input, 'Invalid email address');
    } else {
        clearError(input);
    }
}
```

### Combined Validation

```javascript
function setupValidation(input, validator) {
    // Validate on blur
    input.addEventListener('blur', function() {
        validator(this);
    });
    
    // Clear error on input (optional)
    input.addEventListener('input', function() {
        if (this.classList.contains('error')) {
            validator(this);
        }
    });
}

setupValidation(usernameInput, validateUsername);
setupValidation(emailInput, validateEmail);
```

---

## Validation Patterns

### Email Validation

```javascript
function validateEmail(email) {
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

// More strict
function validateEmailStrict(email) {
    let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return regex.test(email);
}
```

### Password Validation

```javascript
function validatePassword(password) {
    let rules = {
        minLength: password.length >= 8,
        hasUpperCase: /[A-Z]/.test(password),
        hasLowerCase: /[a-z]/.test(password),
        hasNumber: /\d/.test(password),
        hasSpecial: /[!@#$%^&*(),.?":{}|<>]/.test(password)
    };
    
    return rules;
}
```

### Phone Validation

```javascript
function validatePhone(phone) {
    // Remove non-digits
    let digits = phone.replace(/\D/g, '');
    
    // US phone: 10 digits
    if (digits.length === 10) {
        return true;
    }
    
    // International: +country code
    if (phone.startsWith('+') && digits.length >= 10) {
        return true;
    }
    
    return false;
}
```

### URL Validation

```javascript
function validateURL(url) {
    try {
        new URL(url);
        return true;
    } catch {
        return false;
    }
}

// Or regex
function validateURLRegex(url) {
    let regex = /^https?:\/\/.+\..+/;
    return regex.test(url);
}
```

---

## Displaying Validation Errors

### Inline Error Messages

```javascript
function showError(input, message) {
    input.classList.add('error');
    
    let errorDiv = input.parentElement.querySelector('.error-message');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        input.parentElement.appendChild(errorDiv);
    }
    errorDiv.textContent = message;
}

function clearError(input) {
    input.classList.remove('error');
    let errorDiv = input.parentElement.querySelector('.error-message');
    if (errorDiv) {
        errorDiv.remove();
    }
}
```

### Summary Error List

```javascript
function displayFormErrors(errors) {
    let errorContainer = document.getElementById('errors');
    errorContainer.innerHTML = '';
    
    if (errors.length > 0) {
        let errorList = document.createElement('ul');
        errorList.className = 'error-list';
        
        errors.forEach(error => {
            let li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });
        
        errorContainer.appendChild(errorList);
    }
}
```

### Visual Feedback

```javascript
function updateFieldStatus(input, isValid, message) {
    if (isValid) {
        input.classList.remove('error');
        input.classList.add('success');
        clearError(input);
    } else {
        input.classList.remove('success');
        input.classList.add('error');
        showError(input, message);
    }
}
```

---

## Practical Examples

### Example 1: Complete Form Validation

```javascript
let form = document.getElementById('myForm');

form.addEventListener('submit', function(event) {
    event.preventDefault();
    
    let errors = validateForm(form);
    
    if (errors.length === 0) {
        submitForm(form);
    } else {
        displayErrors(errors);
    }
});

function validateForm(form) {
    let errors = [];
    
    // Validate each field
    let username = form.elements.username.value.trim();
    if (!username) {
        errors.push({ field: 'username', message: 'Username is required' });
    } else if (username.length < 3) {
        errors.push({ field: 'username', message: 'Username must be at least 3 characters' });
    }
    
    let email = form.elements.email.value.trim();
    if (!email) {
        errors.push({ field: 'email', message: 'Email is required' });
    } else if (!validateEmail(email)) {
        errors.push({ field: 'email', message: 'Invalid email address' });
    }
    
    // ... more validations
    
    return errors;
}
```

### Example 2: Real-time Password Strength

```javascript
let passwordInput = document.getElementById('password');
let strengthIndicator = document.getElementById('strength');

passwordInput.addEventListener('input', function() {
    let strength = calculatePasswordStrength(this.value);
    updateStrengthIndicator(strength);
});

function calculatePasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[!@#$%^&*]/.test(password)) strength++;
    
    return strength;
}

function updateStrengthIndicator(strength) {
    strengthIndicator.className = 'strength-' + strength;
    
    if (strength <= 2) {
        strengthIndicator.textContent = 'Weak';
    } else if (strength <= 4) {
        strengthIndicator.textContent = 'Medium';
    } else {
        strengthIndicator.textContent = 'Strong';
    }
}
```

### Example 3: Conditional Validation

```javascript
let form = document.getElementById('myForm');
let ageInput = form.elements.age;
let parentConsent = form.elements.parentConsent;

ageInput.addEventListener('change', function() {
    let age = parseInt(this.value);
    
    if (age < 18) {
        parentConsent.required = true;
        parentConsent.parentElement.style.display = 'block';
    } else {
        parentConsent.required = false;
        parentConsent.parentElement.style.display = 'none';
    }
});
```

---

## Practice Exercise

### Exercise: Form Validation

**Objective**: Practice working with different input types and implementing validation.

**Instructions**:

1. Create an HTML file with various input types
2. Create a JavaScript file for validation
3. Practice:
   - HTML5 validation attributes
   - JavaScript validation
   - Real-time validation
   - Custom validation rules
   - Error display

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Types and Validation</title>
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .error {
            border: 2px solid red;
        }
        .success {
            border: 2px solid green;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
        .strength-weak { color: red; }
        .strength-medium { color: orange; }
        .strength-strong { color: green; }
    </style>
</head>
<body>
    <h1>Input Types and Validation Practice</h1>
    
    <form id="validationForm">
        <div class="form-group">
            <label for="email">Email (HTML5):</label>
            <input type="email" id="email" name="email" required>
            <div class="error-message"></div>
        </div>
        
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" 
                   pattern="[a-zA-Z0-9_]+" minlength="3" maxlength="20" required>
            <div class="error-message"></div>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" 
                   minlength="8" required>
            <div id="strength"></div>
            <div class="error-message"></div>
        </div>
        
        <div class="form-group">
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <div class="error-message"></div>
        </div>
        
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="18" max="100" required>
            <div class="error-message"></div>
        </div>
        
        <div class="form-group">
            <label for="birthday">Birthday:</label>
            <input type="date" id="birthday" name="birthday" required>
            <div class="error-message"></div>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{10}">
            <div class="error-message"></div>
        </div>
        
        <div class="form-group">
            <label for="website">Website:</label>
            <input type="url" id="website" name="website">
            <div class="error-message"></div>
        </div>
        
        <div class="form-group">
            <label for="volume">Volume (0-100):</label>
            <input type="range" id="volume" name="volume" min="0" max="100" value="50">
            <span id="volumeValue">50</span>
        </div>
        
        <div class="form-group">
            <label for="color">Favorite Color:</label>
            <input type="color" id="color" name="color" value="#000000">
        </div>
        
        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
    </form>
    
    <div id="output"></div>
    
    <script src="input-validation.js"></script>
</body>
</html>
```

```javascript
// input-validation.js
console.log("=== Input Types and Validation Practice ===");

let form = document.getElementById('validationForm');
let output = document.getElementById('output');

console.log("\n=== HTML5 Input Types ===");

// Email input
let emailInput = form.elements.email;
console.log("Email input type:", emailInput.type);

// Number input
let ageInput = form.elements.age;
console.log("Age input type:", ageInput.type);
console.log("Age min:", ageInput.min);
console.log("Age max:", ageInput.max);

// Date input
let birthdayInput = form.elements.birthday;
console.log("Birthday input type:", birthdayInput.type);

// Range input
let volumeInput = form.elements.volume;
let volumeValue = document.getElementById('volumeValue');
volumeInput.addEventListener('input', function() {
    volumeValue.textContent = this.value;
});
console.log();

console.log("=== HTML5 Validation ===");

// Check validity
function checkFieldValidity(input) {
    console.log(`${input.name} validity:`, input.validity.valid);
    if (!input.validity.valid) {
        console.log(`  Error: ${input.validationMessage}`);
        console.log(`  Value missing: ${input.validity.valueMissing}`);
        console.log(`  Type mismatch: ${input.validity.typeMismatch}`);
        console.log(`  Too short: ${input.validity.tooShort}`);
        console.log(`  Pattern mismatch: ${input.validity.patternMismatch}`);
    }
}

// Check form validity
function checkFormValidity() {
    console.log("Form valid:", form.checkValidity());
    
    Array.from(form.elements).forEach(element => {
        if (element.tagName === 'INPUT' || element.tagName === 'SELECT' || element.tagName === 'TEXTAREA') {
            if (!element.validity.valid) {
                checkFieldValidity(element);
            }
        }
    });
}
console.log();

console.log("=== Custom Validation Messages ===");

emailInput.addEventListener('invalid', function(event) {
    if (this.validity.valueMissing) {
        this.setCustomValidity('Email address is required');
    } else if (this.validity.typeMismatch) {
        this.setCustomValidity('Please enter a valid email address');
    } else {
        this.setCustomValidity('');
    }
});
console.log();

console.log("=== Real-time Validation ===");

// Username validation
let usernameInput = form.elements.username;
usernameInput.addEventListener('blur', function() {
    validateUsername(this);
});

function validateUsername(input) {
    let value = input.value.trim();
    let error = null;
    
    if (!value) {
        error = 'Username is required';
    } else if (value.length < 3) {
        error = 'Username must be at least 3 characters';
    } else if (value.length > 20) {
        error = 'Username must be no more than 20 characters';
    } else if (!/^[a-zA-Z0-9_]+$/.test(value)) {
        error = 'Username can only contain letters, numbers, and underscores';
    }
    
    updateFieldStatus(input, !error, error);
}

// Password strength
let passwordInput = form.elements.password;
passwordInput.addEventListener('input', function() {
    let strength = calculatePasswordStrength(this.value);
    updatePasswordStrength(strength);
    validatePassword(this);
});

function calculatePasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
    
    return strength;
}

function updatePasswordStrength(strength) {
    let strengthDiv = document.getElementById('strength');
    
    if (strength <= 2) {
        strengthDiv.textContent = 'Password strength: Weak';
        strengthDiv.className = 'strength-weak';
    } else if (strength <= 4) {
        strengthDiv.textContent = 'Password strength: Medium';
        strengthDiv.className = 'strength-medium';
    } else {
        strengthDiv.textContent = 'Password strength: Strong';
        strengthDiv.className = 'strength-strong';
    }
}

function validatePassword(input) {
    let value = input.value;
    let error = null;
    
    if (!value) {
        error = 'Password is required';
    } else if (value.length < 8) {
        error = 'Password must be at least 8 characters';
    } else {
        let rules = {
            hasUpperCase: /[A-Z]/.test(value),
            hasLowerCase: /[a-z]/.test(value),
            hasNumber: /\d/.test(value),
            hasSpecial: /[!@#$%^&*(),.?":{}|<>]/.test(value)
        };
        
        let missing = [];
        if (!rules.hasUpperCase) missing.push('uppercase letter');
        if (!rules.hasLowerCase) missing.push('lowercase letter');
        if (!rules.hasNumber) missing.push('number');
        if (!rules.hasSpecial) missing.push('special character');
        
        if (missing.length > 0) {
            error = `Password must contain: ${missing.join(', ')}`;
        }
    }
    
    updateFieldStatus(input, !error, error);
}

// Confirm password
let confirmPasswordInput = form.elements.confirmPassword;
confirmPasswordInput.addEventListener('blur', function() {
    validateConfirmPassword(this);
});

function validateConfirmPassword(input) {
    let value = input.value;
    let password = passwordInput.value;
    let error = null;
    
    if (!value) {
        error = 'Please confirm your password';
    } else if (value !== password) {
        error = 'Passwords do not match';
    }
    
    updateFieldStatus(input, !error, error);
}

// Phone validation
let phoneInput = form.elements.phone;
phoneInput.addEventListener('blur', function() {
    validatePhone(this);
});

function validatePhone(input) {
    let value = input.value.trim();
    let error = null;
    
    if (value && !/^\d{10}$/.test(value.replace(/\D/g, ''))) {
        error = 'Please enter a valid 10-digit phone number';
    }
    
    updateFieldStatus(input, !error, error);
}

// Website validation
let websiteInput = form.elements.website;
websiteInput.addEventListener('blur', function() {
    validateWebsite(this);
});

function validateWebsite(input) {
    let value = input.value.trim();
    let error = null;
    
    if (value) {
        try {
            new URL(value);
        } catch {
            error = 'Please enter a valid URL (e.g., https://example.com)';
        }
    }
    
    updateFieldStatus(input, !error, error);
}
console.log();

console.log("=== Field Status Update ===");

function updateFieldStatus(input, isValid, errorMessage) {
    let errorDiv = input.parentElement.querySelector('.error-message');
    
    if (isValid) {
        input.classList.remove('error');
        input.classList.add('success');
        if (errorDiv) {
            errorDiv.textContent = '';
        }
    } else {
        input.classList.remove('success');
        input.classList.add('error');
        if (errorDiv) {
            errorDiv.textContent = errorMessage || '';
        }
    }
}
console.log();

console.log("=== Form Submission with Validation ===");

form.addEventListener('submit', function(event) {
    event.preventDefault();
    
    console.log('Form submission attempted');
    
    // Check HTML5 validity
    if (!form.checkValidity()) {
        console.log('HTML5 validation failed');
        form.reportValidity();
        return;
    }
    
    // Additional JavaScript validation
    let errors = [];
    
    // Validate password match
    if (passwordInput.value !== confirmPasswordInput.value) {
        errors.push('Passwords do not match');
    }
    
    // Validate age
    let age = parseInt(ageInput.value);
    if (age < 18) {
        errors.push('You must be at least 18 years old');
    }
    
    if (errors.length > 0) {
        console.log('JavaScript validation errors:', errors);
        output.innerHTML = '<div style="color: red;"><strong>Errors:</strong><ul>' +
            errors.map(e => '<li>' + e + '</li>').join('') + '</ul></div>';
        return;
    }
    
    // Form is valid
    console.log('Form is valid');
    let formData = new FormData(form);
    let data = {};
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    output.innerHTML = '<div style="color: green;"><strong>Form submitted successfully!</strong></div>';
    output.innerHTML += '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
});
console.log();

console.log("=== Validity API Demonstration ===");

function demonstrateValidityAPI() {
    console.log("=== Email Field Validity ===");
    console.log("Valid:", emailInput.validity.valid);
    console.log("Value missing:", emailInput.validity.valueMissing);
    console.log("Type mismatch:", emailInput.validity.typeMismatch);
    console.log("Validation message:", emailInput.validationMessage);
    
    console.log("\n=== Username Field Validity ===");
    console.log("Valid:", usernameInput.validity.valid);
    console.log("Pattern mismatch:", usernameInput.validity.patternMismatch);
    console.log("Too short:", usernameInput.validity.tooShort);
    console.log("Too long:", usernameInput.validity.tooLong);
    
    console.log("\n=== Age Field Validity ===");
    console.log("Valid:", ageInput.validity.valid);
    console.log("Range underflow:", ageInput.validity.rangeUnderflow);
    console.log("Range overflow:", ageInput.validity.rangeOverflow);
    console.log("Step mismatch:", ageInput.validity.stepMismatch);
}

// Demonstrate after form interaction
setTimeout(() => {
    demonstrateValidityAPI();
}, 2000);
console.log();

console.log("=== Input Type Features ===");

// Date input
birthdayInput.addEventListener('change', function() {
    console.log('Birthday selected:', this.value);
    let date = new Date(this.value);
    console.log('Date object:', date);
});

// Range input
volumeInput.addEventListener('input', function() {
    console.log('Volume changed:', this.value);
});

// Color input
let colorInput = form.elements.color;
colorInput.addEventListener('change', function() {
    console.log('Color selected:', this.value);
    document.body.style.backgroundColor = this.value;
});
```

**Expected Output** (in browser console):
```
=== Input Types and Validation Practice ===

=== HTML5 Input Types ===
Email input type: email
Age input type: number
Age min: 18
Age max: 100
Birthday input type: date

=== HTML5 Validation ===
[On form check]
Form valid: true/false
[Field validity details]

=== Custom Validation Messages ===
[Custom messages set]

=== Real-time Validation ===
[On blur/input events]
[Validation messages shown]

=== Field Status Update ===
[Fields updated with success/error classes]

=== Form Submission with Validation ===
[On submit]
Form submission attempted
[Validation results]
Form is valid / Errors shown

=== Validity API Demonstration ===
=== Email Field Validity ===
Valid: true/false
Value missing: true/false
Type mismatch: true/false
Validation message: [message]

=== Input Type Features ===
[On interactions]
[Input values logged]
```

**Challenge (Optional)**:
- Build a complete validation library
- Create a multi-step form with validation
- Build a password strength meter
- Create a form validation framework

---

## Common Mistakes

### 1. Not Using HTML5 Validation

```javascript
// ⚠️ Problem: Only JavaScript validation
function validateEmail(email) {
    return email.includes('@');
}

// ✅ Solution: Combine HTML5 and JavaScript
<input type="email" required>
// Plus JavaScript for custom rules
```

### 2. Not Clearing Custom Validity

```javascript
// ⚠️ Problem: Custom validity persists
input.setCustomValidity('Error');
// Error always shows

// ✅ Solution: Clear when valid
if (isValid) {
    input.setCustomValidity('');
}
```

### 3. Not Handling All Input Types

```javascript
// ⚠️ Problem: Only handles text
let value = input.value;  // Works for text, but...

// ✅ Solution: Handle different types
if (input.type === 'checkbox') {
    value = input.checked;
} else if (input.type === 'radio') {
    value = input.checked ? input.value : null;
} else {
    value = input.value;
}
```

### 4. Not Validating on Both Input and Blur

```javascript
// ⚠️ Problem: Only validates on blur
input.addEventListener('blur', validate);

// ✅ Solution: Validate on both
input.addEventListener('blur', validate);
input.addEventListener('input', function() {
    if (this.classList.contains('error')) {
        validate(this);
    }
});
```

---

## Key Takeaways

1. **HTML5 Input Types**: email, number, date, url, tel, etc.
2. **HTML5 Validation**: required, min, max, pattern, etc.
3. **Validity API**: Check field validity programmatically
4. **Custom Validation**: setCustomValidity() for custom rules
5. **Real-time Validation**: Validate on input or blur
6. **Error Display**: Show errors inline or in summary
7. **Best Practice**: Combine HTML5 and JavaScript validation
8. **User Experience**: Provide immediate feedback

---

## Quiz: Validation

Test your understanding with these questions:

1. **HTML5 email input:**
   - A) Only accepts emails
   - B) Validates email format
   - C) Both A and B
   - D) Neither

2. **required attribute:**
   - A) Makes field optional
   - B) Makes field required
   - C) Hides field
   - D) Nothing

3. **checkValidity() returns:**
   - A) Error message
   - B) true/false
   - C) Validation object
   - D) Nothing

4. **setCustomValidity() sets:**
   - A) HTML5 message
   - B) Custom message
   - C) Both
   - D) Neither

5. **pattern attribute uses:**
   - A) CSS selector
   - B) Regular expression
   - C) String
   - D) Number

6. **Real-time validation uses:**
   - A) submit event
   - B) input/blur events
   - C) load event
   - D) click event

7. **validity.valid is:**
   - A) Always true
   - B) true if field valid
   - C) Always false
   - D) Error message

**Answers**:
1. B) Validates email format (doesn't restrict, just validates)
2. B) Makes field required
3. B) true/false
4. B) Custom message
5. B) Regular expression
6. B) input/blur events
7. B) true if field valid

---

## Next Steps

Congratulations! You've completed Module 15: Forms and Validation. You now know:
- How to work with forms
- Different input types
- HTML5 validation
- JavaScript validation
- Real-time validation

**What's Next?**
- Course 4: Browser APIs and Storage
- Module 16: Browser Storage
- Learn localStorage and sessionStorage
- Work with browser storage APIs

---

## Additional Resources

- **MDN: HTML Input Types**: [developer.mozilla.org/en-US/docs/Web/HTML/Element/input](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input)
- **MDN: Constraint Validation**: [developer.mozilla.org/en-US/docs/Web/API/Constraint_validation](https://developer.mozilla.org/en-US/docs/Web/API/Constraint_validation)
- **JavaScript.info: Forms**: [javascript.info/forms-controls](https://javascript.info/forms-controls)

---

*Lesson completed! You've finished Module 15: Forms and Validation. Ready for Course 4: Browser APIs and Storage!*

