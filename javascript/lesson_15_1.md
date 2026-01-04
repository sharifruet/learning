# Lesson 15.1: Working with Forms

## Learning Objectives

By the end of this lesson, you will be able to:
- Access form elements
- Get and set form data
- Handle form submission
- Validate form data
- Work with different form elements
- Prevent default form submission
- Build interactive forms

---

## Introduction to Forms

Forms are essential for collecting user input. JavaScript allows you to interact with forms, validate data, and handle submissions programmatically.

### Why Work with Forms?

- **User Input**: Collect data from users
- **Validation**: Ensure data quality
- **User Experience**: Provide feedback
- **Data Processing**: Handle form data before submission
- **Modern Web**: Essential for web applications

---

## Accessing Form Elements

### Accessing Form by ID

```javascript
let form = document.getElementById('myForm');
```

### Accessing Form via forms Collection

```javascript
// Access by index
let firstForm = document.forms[0];

// Access by name
let form = document.forms['myForm'];

// Access by id
let form = document.forms.myForm;
```

### Accessing Form Elements

```javascript
let form = document.getElementById('myForm');

// By name
let username = form.elements.username;
let email = form.elements.email;

// By index
let firstInput = form.elements[0];

// By id (if element has id)
let username = document.getElementById('username');
```

---

## Getting Form Data

### Individual Fields

```javascript
let form = document.getElementById('myForm');
let username = form.elements.username.value;
let email = form.elements.email.value;
```

### FormData Object

```javascript
let form = document.getElementById('myForm');
let formData = new FormData(form);

// Get specific value
let username = formData.get('username');

// Get all values
for (let [key, value] of formData.entries()) {
    console.log(key, value);
}
```

### Serialize Form Data

```javascript
function serializeForm(form) {
    let data = {};
    let formData = new FormData(form);
    
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    return data;
}

let form = document.getElementById('myForm');
let data = serializeForm(form);
console.log(data);
```

### Getting All Form Values

```javascript
function getFormValues(form) {
    let values = {};
    
    for (let element of form.elements) {
        if (element.name) {
            if (element.type === 'checkbox') {
                values[element.name] = element.checked;
            } else if (element.type === 'radio') {
                if (element.checked) {
                    values[element.name] = element.value;
                }
            } else {
                values[element.name] = element.value;
            }
        }
    }
    
    return values;
}
```

---

## Setting Form Data

### Setting Individual Fields

```javascript
let form = document.getElementById('myForm');
form.elements.username.value = 'Alice';
form.elements.email.value = 'alice@example.com';
```

### Setting Multiple Fields

```javascript
function setFormValues(form, data) {
    for (let key in data) {
        let element = form.elements[key];
        if (element) {
            if (element.type === 'checkbox') {
                element.checked = data[key];
            } else {
                element.value = data[key];
            }
        }
    }
}

let form = document.getElementById('myForm');
setFormValues(form, {
    username: 'Alice',
    email: 'alice@example.com',
    remember: true
});
```

### Resetting Form

```javascript
// Reset to default values
form.reset();

// Or reset programmatically
form.elements.username.value = '';
form.elements.email.value = '';
```

---

## Form Submission

### Preventing Default Submission

```javascript
let form = document.getElementById('myForm');

form.addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent default form submission
    
    // Handle form data
    let formData = new FormData(form);
    console.log('Form data:', formData);
    
    // Submit via AJAX or process data
});
```

### Handling Form Submission

```javascript
form.addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Get form data
    let formData = new FormData(form);
    let data = Object.fromEntries(formData);
    
    // Validate
    if (validateForm(data)) {
        // Submit
        submitForm(data);
    } else {
        // Show errors
        showErrors();
    }
});
```

### Programmatic Submission

```javascript
// Submit form programmatically
form.submit();

// Or trigger submit event
let submitEvent = new Event('submit');
form.dispatchEvent(submitEvent);
```

---

## Form Validation

### Basic Validation

```javascript
function validateForm(form) {
    let isValid = true;
    let errors = [];
    
    // Validate username
    let username = form.elements.username.value.trim();
    if (username.length < 3) {
        isValid = false;
        errors.push('Username must be at least 3 characters');
    }
    
    // Validate email
    let email = form.elements.email.value.trim();
    if (!email.includes('@')) {
        isValid = false;
        errors.push('Invalid email address');
    }
    
    // Validate password
    let password = form.elements.password.value;
    if (password.length < 8) {
        isValid = false;
        errors.push('Password must be at least 8 characters');
    }
    
    return { isValid, errors };
}
```

### Real-time Validation

```javascript
let usernameInput = form.elements.username;

usernameInput.addEventListener('blur', function() {
    let value = this.value.trim();
    
    if (value.length < 3) {
        showError(this, 'Username must be at least 3 characters');
    } else {
        clearError(this);
    }
});
```

### Validation Functions

```javascript
function validateEmail(email) {
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validatePassword(password) {
    return password.length >= 8 && 
           /[A-Z]/.test(password) && 
           /[a-z]/.test(password) && 
           /\d/.test(password);
}

function validateUsername(username) {
    return username.length >= 3 && 
           /^[a-zA-Z0-9_]+$/.test(username);
}
```

---

## Working with Different Form Elements

### Text Inputs

```javascript
let input = form.elements.username;
console.log(input.value);        // Get value
input.value = 'New value';       // Set value
input.placeholder = 'Enter username';
input.required = true;
```

### Checkboxes

```javascript
let checkbox = form.elements.remember;
console.log(checkbox.checked);   // true or false
checkbox.checked = true;         // Set checked
```

### Radio Buttons

```javascript
let radios = form.elements.gender;
console.log(radios.value);       // Value of checked radio

// Set checked
radios.value = 'male';
// or
radios[0].checked = true;
```

### Select Dropdowns

```javascript
let select = form.elements.country;
console.log(select.value);      // Selected value
console.log(select.selectedIndex); // Selected index

// Set value
select.value = 'usa';

// Get selected option
let selectedOption = select.options[select.selectedIndex];
console.log(selectedOption.text);
```

### Textareas

```javascript
let textarea = form.elements.message;
console.log(textarea.value);     // Get value
textarea.value = 'New message';  // Set value
textarea.rows = 5;              // Set rows
textarea.cols = 50;              // Set columns
```

---

## Practical Examples

### Example 1: Simple Form Handler

```javascript
let form = document.getElementById('myForm');

form.addEventListener('submit', function(event) {
    event.preventDefault();
    
    let formData = new FormData(form);
    let data = {
        username: formData.get('username'),
        email: formData.get('email'),
        password: formData.get('password')
    };
    
    console.log('Form data:', data);
    
    // Process or submit data
    processFormData(data);
});
```

### Example 2: Form with Validation

```javascript
let form = document.getElementById('myForm');

form.addEventListener('submit', function(event) {
    event.preventDefault();
    
    let errors = validateForm(form);
    
    if (errors.length === 0) {
        // Form is valid
        let formData = new FormData(form);
        submitForm(formData);
    } else {
        // Show errors
        displayErrors(errors);
    }
});

function validateForm(form) {
    let errors = [];
    
    // Validate each field
    let username = form.elements.username.value.trim();
    if (!username) {
        errors.push('Username is required');
    } else if (username.length < 3) {
        errors.push('Username must be at least 3 characters');
    }
    
    let email = form.elements.email.value.trim();
    if (!email) {
        errors.push('Email is required');
    } else if (!validateEmail(email)) {
        errors.push('Invalid email address');
    }
    
    return errors;
}
```

### Example 3: Real-time Validation

```javascript
let form = document.getElementById('myForm');

// Validate on blur
form.elements.username.addEventListener('blur', function() {
    validateField(this, validateUsername);
});

form.elements.email.addEventListener('blur', function() {
    validateField(this, validateEmail);
});

function validateField(field, validator) {
    let value = field.value.trim();
    let errorElement = field.parentElement.querySelector('.error');
    
    if (!value) {
        showError(field, 'This field is required');
    } else if (!validator(value)) {
        showError(field, 'Invalid value');
    } else {
        clearError(field);
    }
}

function showError(field, message) {
    clearError(field);
    field.classList.add('error');
    let errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    field.parentElement.appendChild(errorDiv);
}

function clearError(field) {
    field.classList.remove('error');
    let errorDiv = field.parentElement.querySelector('.error-message');
    if (errorDiv) {
        errorDiv.remove();
    }
}
```

---

## Practice Exercise

### Exercise: Form Handling

**Objective**: Practice working with forms, accessing data, and validation.

**Instructions**:

1. Create an HTML file with a form
2. Create a JavaScript file for form handling
3. Practice:
   - Accessing form elements
   - Getting form data
   - Setting form data
   - Handling form submission
   - Form validation

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Handling Practice</title>
    <style>
        .error {
            border: 2px solid red;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
        .success {
            border: 2px solid green;
        }
        form {
            max-width: 400px;
            margin: 20px;
        }
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
    </style>
</head>
<body>
    <h1>Form Handling Practice</h1>
    
    <form id="userForm">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <div class="error-message"></div>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <div class="error-message"></div>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <div class="error-message"></div>
        </div>
        
        <div class="form-group">
            <label for="country">Country:</label>
            <select id="country" name="country">
                <option value="">Select country</option>
                <option value="us">United States</option>
                <option value="uk">United Kingdom</option>
                <option value="ca">Canada</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="newsletter" value="yes">
                Subscribe to newsletter
            </label>
        </div>
        
        <div class="form-group">
            <label>Gender:</label>
            <label><input type="radio" name="gender" value="male"> Male</label>
            <label><input type="radio" name="gender" value="female"> Female</label>
            <label><input type="radio" name="gender" value="other"> Other</label>
        </div>
        
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4"></textarea>
        </div>
        
        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
    </form>
    
    <div id="output"></div>
    
    <script src="form-handling.js"></script>
</body>
</html>
```

```javascript
// form-handling.js
console.log("=== Form Handling Practice ===");

let form = document.getElementById('userForm');
let output = document.getElementById('output');

console.log("\n=== Accessing Form Elements ===");

// Access form
console.log("Form:", form);
console.log("Form ID:", form.id);
console.log("Form method:", form.method);
console.log("Form action:", form.action);

// Access elements
console.log("Username element:", form.elements.username);
console.log("Email element:", form.elements.email);
console.log("Number of elements:", form.elements.length);
console.log();

console.log("=== Getting Form Data ===");

// Individual fields
function getFormData() {
    return {
        username: form.elements.username.value,
        email: form.elements.email.value,
        password: form.elements.password.value,
        country: form.elements.country.value,
        newsletter: form.elements.newsletter.checked,
        gender: form.elements.gender.value,
        message: form.elements.message.value
    };
}

// Using FormData
function getFormDataFormData() {
    let formData = new FormData(form);
    let data = {};
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    return data;
}

// Display current form data
function displayFormData() {
    let data = getFormData();
    console.log("Current form data:", data);
}
console.log();

console.log("=== Setting Form Data ===");

function setFormData(data) {
    if (data.username) form.elements.username.value = data.username;
    if (data.email) form.elements.email.value = data.email;
    if (data.password) form.elements.password.value = data.password;
    if (data.country) form.elements.country.value = data.country;
    if (data.newsletter !== undefined) form.elements.newsletter.checked = data.newsletter;
    if (data.gender) form.elements.gender.value = data.gender;
    if (data.message) form.elements.message.value = data.message;
}

// Set sample data
setFormData({
    username: 'alice',
    email: 'alice@example.com',
    country: 'us',
    newsletter: true,
    gender: 'female',
    message: 'Hello world'
});

console.log("Set sample form data");
displayFormData();
console.log();

console.log("=== Form Submission ===");

form.addEventListener('submit', function(event) {
    event.preventDefault();
    console.log('Form submitted');
    
    let data = getFormData();
    console.log('Submitted data:', data);
    
    // Validate
    let errors = validateForm(form);
    
    if (errors.length === 0) {
        console.log('Form is valid');
        output.innerHTML = '<p style="color: green;">Form submitted successfully!</p>';
        output.innerHTML += '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        
        // Could submit to server here
        // submitToServer(data);
    } else {
        console.log('Form has errors:', errors);
        output.innerHTML = '<p style="color: red;">Form has errors:</p><ul>';
        errors.forEach(error => {
            output.innerHTML += '<li>' + error + '</li>';
        });
        output.innerHTML += '</ul>';
    }
});
console.log();

console.log("=== Form Validation ===");

function validateForm(form) {
    let errors = [];
    
    // Username validation
    let username = form.elements.username.value.trim();
    if (!username) {
        errors.push('Username is required');
    } else if (username.length < 3) {
        errors.push('Username must be at least 3 characters');
    } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
        errors.push('Username can only contain letters, numbers, and underscores');
    }
    
    // Email validation
    let email = form.elements.email.value.trim();
    if (!email) {
        errors.push('Email is required');
    } else if (!validateEmail(email)) {
        errors.push('Invalid email address');
    }
    
    // Password validation
    let password = form.elements.password.value;
    if (!password) {
        errors.push('Password is required');
    } else if (password.length < 8) {
        errors.push('Password must be at least 8 characters');
    }
    
    // Country validation
    let country = form.elements.country.value;
    if (!country) {
        errors.push('Country is required');
    }
    
    return errors;
}

function validateEmail(email) {
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
console.log();

console.log("=== Real-time Validation ===");

// Username validation
form.elements.username.addEventListener('blur', function() {
    validateField(this, function(value) {
        if (!value) {
            return 'Username is required';
        } else if (value.length < 3) {
            return 'Username must be at least 3 characters';
        } else if (!/^[a-zA-Z0-9_]+$/.test(value)) {
            return 'Username can only contain letters, numbers, and underscores';
        }
        return null;
    });
});

// Email validation
form.elements.email.addEventListener('blur', function() {
    validateField(this, function(value) {
        if (!value) {
            return 'Email is required';
        } else if (!validateEmail(value)) {
            return 'Invalid email address';
        }
        return null;
    });
});

// Password validation
form.elements.password.addEventListener('blur', function() {
    validateField(this, function(value) {
        if (!value) {
            return 'Password is required';
        } else if (value.length < 8) {
            return 'Password must be at least 8 characters';
        }
        return null;
    });
});

function validateField(field, validator) {
    let value = field.value.trim();
    let errorMessage = field.parentElement.querySelector('.error-message');
    let error = validator(value);
    
    if (error) {
        field.classList.add('error');
        field.classList.remove('success');
        if (errorMessage) {
            errorMessage.textContent = error;
        }
    } else {
        field.classList.remove('error');
        field.classList.add('success');
        if (errorMessage) {
            errorMessage.textContent = '';
        }
    }
}
console.log();

console.log("=== Working with Different Elements ===");

// Text input
console.log("Text input value:", form.elements.username.value);

// Checkbox
console.log("Checkbox checked:", form.elements.newsletter.checked);

// Radio buttons
console.log("Radio value:", form.elements.gender.value);

// Select
console.log("Select value:", form.elements.country.value);
console.log("Select selected index:", form.elements.country.selectedIndex);
console.log("Selected option:", form.elements.country.options[form.elements.country.selectedIndex]?.text);

// Textarea
console.log("Textarea value:", form.elements.message.value);
console.log();

console.log("=== Form Reset ===");

form.addEventListener('reset', function() {
    console.log('Form reset');
    output.innerHTML = '';
    
    // Clear all error messages
    let errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(msg => msg.textContent = '');
    
    let errorFields = document.querySelectorAll('.error');
    errorFields.forEach(field => {
        field.classList.remove('error');
        field.classList.remove('success');
    });
});
console.log();

console.log("=== FormData API ===");

function demonstrateFormData() {
    let formData = new FormData(form);
    
    console.log("FormData entries:");
    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }
    
    // Get specific value
    console.log("Username from FormData:", formData.get('username'));
    console.log("Newsletter from FormData:", formData.get('newsletter'));
    
    // Check if has key
    console.log("Has username:", formData.has('username'));
    
    // Get all values for a key (if multiple)
    console.log("All values:", Array.from(formData.values()));
}

// Demonstrate when form is submitted
form.addEventListener('submit', function(event) {
    event.preventDefault();
    demonstrateFormData();
});
```

**Expected Output** (in browser console):
```
=== Form Handling Practice ===

=== Accessing Form Elements ===
Form: [form element]
Form ID: userForm
Form method: get
Form action: 
Username element: [input element]
Email element: [input element]
Number of elements: [number]

=== Getting Form Data ===
Current form data: { username: "alice", email: "alice@example.com", ... }

=== Setting Form Data ===
Set sample form data
Current form data: { username: "alice", email: "alice@example.com", ... }

=== Form Submission ===
[On submit]
Form submitted
Submitted data: { username: "...", email: "...", ... }
Form is valid / Form has errors: [...]

=== Form Validation ===
[Validation functions defined]

=== Real-time Validation ===
[On blur events]
[Shows validation messages]

=== Working with Different Elements ===
Text input value: alice
Checkbox checked: true
Radio value: female
Select value: us
Selected option: United States
Textarea value: Hello world

=== Form Reset ===
[On reset]
Form reset

=== FormData API ===
[On submit]
FormData entries:
username: alice
email: alice@example.com
...
Username from FormData: alice
Newsletter from FormData: yes
Has username: true
All values: [array of values]
```

**Challenge (Optional)**:
- Build a complete form validation system
- Create a multi-step form
- Build a form builder
- Create a form data persistence system

---

## Common Mistakes

### 1. Not Preventing Default

```javascript
// ⚠️ Problem: Form submits and page reloads
form.addEventListener('submit', function(event) {
    // Process form
    // Page reloads!
});

// ✅ Solution: Prevent default
form.addEventListener('submit', function(event) {
    event.preventDefault();
    // Process form
});
```

### 2. Accessing Value Before Input

```javascript
// ⚠️ Problem: Value might be empty
let username = form.elements.username.value;
console.log(username);  // Might be empty

// ✅ Solution: Check or wait for input
form.elements.username.addEventListener('input', function() {
    console.log(this.value);
});
```

### 3. Not Handling Checkboxes/Radios

```javascript
// ⚠️ Problem: Wrong way to get checkbox value
let newsletter = form.elements.newsletter.value;  // Always "yes"

// ✅ Solution: Check checked property
let newsletter = form.elements.newsletter.checked;
```

### 4. Not Trimming Values

```javascript
// ⚠️ Problem: Includes whitespace
let username = form.elements.username.value;
if (username.length < 3) { }  // Might fail due to spaces

// ✅ Solution: Trim first
let username = form.elements.username.value.trim();
```

---

## Key Takeaways

1. **Form Access**: Use getElementById, forms collection, or querySelector
2. **Form Data**: Use FormData or access elements directly
3. **Form Submission**: Prevent default, handle programmatically
4. **Validation**: Check values before submission
5. **Form Elements**: Different elements need different handling
6. **Real-time**: Validate on blur or input
7. **Best Practice**: Always prevent default, validate data, trim values
8. **FormData**: Modern API for form data handling

---

## Quiz: Forms

Test your understanding with these questions:

1. **Form elements accessed via:**
   - A) form.elements
   - B) form.inputs
   - C) form.fields
   - D) form.data

2. **FormData is:**
   - A) Old API
   - B) Modern API
   - C) Deprecated
   - D) Not available

3. **Checkbox value accessed via:**
   - A) value property
   - B) checked property
   - C) Both
   - D) Neither

4. **preventDefault() prevents:**
   - A) Form submission
   - B) Event propagation
   - C) Both
   - D) Neither

5. **form.reset() does:**
   - A) Clears all fields
   - B) Resets to default values
   - C) Both
   - D) Nothing

6. **Radio button value:**
   - A) Value of checked button
   - B) All values
   - C) First value
   - D) Nothing

7. **FormData.get() returns:**
   - A) All values
   - B) First value for key
   - C) Last value
   - D) Nothing

**Answers**:
1. A) form.elements
2. B) Modern API
3. B) checked property (for boolean, value for string)
4. A) Form submission (default behavior)
5. B) Resets to default values
6. A) Value of checked button
7. B) First value for key

---

## Next Steps

Congratulations! You've learned form handling. You now know:
- How to access form elements
- How to get and set form data
- How to handle form submission
- How to validate forms

**What's Next?**
- Lesson 15.2: Input Types and Validation
- Learn different input types
- Understand HTML5 validation
- Build comprehensive validation systems

---

## Additional Resources

- **MDN: Forms**: [developer.mozilla.org/en-US/docs/Web/HTML/Element/form](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form)
- **MDN: FormData**: [developer.mozilla.org/en-US/docs/Web/API/FormData](https://developer.mozilla.org/en-US/docs/Web/API/FormData)
- **JavaScript.info: Forms**: [javascript.info/forms-controls](https://javascript.info/forms-controls)

---

*Lesson completed! You're ready to move on to the next lesson.*

