# Lesson 11.1: ES6 Modules

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand ES6 module system
- Use `export` keyword to export values
- Use `import` keyword to import values
- Differentiate between default and named exports
- Create and use modules
- Organize code with modules
- Write modern modular JavaScript

---

## Introduction to ES6 Modules

ES6 modules provide a standardized way to organize and share code between files. They're the modern standard for JavaScript module systems.

### Why Modules?

- **Code Organization**: Split code into logical units
- **Reusability**: Share code between files
- **Dependency Management**: Clear dependencies
- **Scope Isolation**: Each module has its own scope
- **Tree Shaking**: Remove unused code
- **Modern Standard**: Supported in modern browsers and Node.js

---

## Basic Module Syntax

### Exporting Values

Use `export` to make values available to other modules:

```javascript
// math.js
export const PI = 3.14159;
export function add(a, b) {
    return a + b;
}
```

### Importing Values

Use `import` to use values from other modules:

```javascript
// main.js
import { PI, add } from './math.js';

console.log(PI);        // 3.14159
console.log(add(5, 3)); // 8
```

---

## Named Exports

Named exports allow you to export multiple values with specific names.

### Exporting Multiple Named Exports

```javascript
// utils.js
export function greet(name) {
    return `Hello, ${name}!`;
}

export function farewell(name) {
    return `Goodbye, ${name}!`;
}

export const MAX_SIZE = 100;
```

### Importing Named Exports

```javascript
// main.js
import { greet, farewell, MAX_SIZE } from './utils.js';

console.log(greet("Alice"));      // "Hello, Alice!"
console.log(farewell("Bob"));     // "Goodbye, Bob!"
console.log(MAX_SIZE);            // 100
```

### Import with Different Names

```javascript
// Import with alias
import { greet as sayHello, farewell as sayGoodbye } from './utils.js';

sayHello("Alice");
sayGoodbye("Bob");
```

### Import All Named Exports

```javascript
// Import everything
import * as utils from './utils.js';

console.log(utils.greet("Alice"));
console.log(utils.MAX_SIZE);
```

### Export After Declaration

```javascript
// math.js
function add(a, b) {
    return a + b;
}

function subtract(a, b) {
    return a - b;
}

export { add, subtract };
```

### Export with Rename

```javascript
// math.js
function add(a, b) {
    return a + b;
}

export { add as sum };
```

---

## Default Exports

Default exports allow you to export a single value as the default export.

### Single Default Export

```javascript
// calculator.js
export default function calculator(a, b, operation) {
    switch (operation) {
        case 'add':
            return a + b;
        case 'subtract':
            return a - b;
        default:
            return 0;
    }
}
```

### Importing Default Export

```javascript
// main.js
import calculator from './calculator.js';

console.log(calculator(5, 3, 'add'));  // 8
```

### Default Export with Named Exports

```javascript
// math.js
export default function add(a, b) {
    return a + b;
}

export function subtract(a, b) {
    return a - b;
}

export const PI = 3.14159;
```

### Importing Default and Named

```javascript
// main.js
import add, { subtract, PI } from './math.js';

console.log(add(5, 3));        // 8
console.log(subtract(5, 3));   // 2
console.log(PI);               // 3.14159
```

### Default Export with Rename

```javascript
// main.js
import { default as add, subtract } from './math.js';
```

---

## Export Syntax Variations

### Export Variable

```javascript
// constants.js
export const API_URL = "https://api.example.com";
export let counter = 0;
```

### Export Class

```javascript
// user.js
export class User {
    constructor(name) {
        this.name = name;
    }
    
    greet() {
        return `Hello, I'm ${this.name}`;
    }
}
```

### Export Object

```javascript
// config.js
const config = {
    apiUrl: "https://api.example.com",
    timeout: 5000
};

export default config;
```

### Re-exporting

```javascript
// index.js
export { add, subtract } from './math.js';
export { greet } from './utils.js';
export { default as Calculator } from './calculator.js';
```

---

## Module Scope

Each module has its own scope. Variables declared in a module are not global.

### Module Scope Example

```javascript
// module1.js
let privateVar = "I'm private";
export let publicVar = "I'm public";

// module2.js
import { publicVar } from './module1.js';
console.log(publicVar);  // "I'm public"
// console.log(privateVar);  // Error: privateVar is not defined
```

### Top-Level Variables

```javascript
// module.js
let count = 0;  // Module-scoped, not global

export function increment() {
    count++;
    return count;
}
```

---

## Practical Examples

### Example 1: Math Module

```javascript
// math.js
export function add(a, b) {
    return a + b;
}

export function subtract(a, b) {
    return a - b;
}

export function multiply(a, b) {
    return a * b;
}

export function divide(a, b) {
    if (b === 0) {
        throw new Error("Division by zero");
    }
    return a / b;
}

export const PI = 3.14159;
export const E = 2.71828;
```

```javascript
// main.js
import { add, subtract, multiply, divide, PI } from './math.js';

console.log(add(5, 3));        // 8
console.log(multiply(4, 2));   // 8
console.log(PI);               // 3.14159
```

### Example 2: User Module

```javascript
// user.js
export class User {
    constructor(name, email) {
        this.name = name;
        this.email = email;
    }
    
    getInfo() {
        return `${this.name} (${this.email})`;
    }
}

export function createUser(name, email) {
    return new User(name, email);
}
```

```javascript
// main.js
import { User, createUser } from './user.js';

let user1 = new User("Alice", "alice@example.com");
let user2 = createUser("Bob", "bob@example.com");

console.log(user1.getInfo());  // "Alice (alice@example.com)"
console.log(user2.getInfo());  // "Bob (bob@example.com)"
```

### Example 3: Configuration Module

```javascript
// config.js
const config = {
    apiUrl: "https://api.example.com",
    timeout: 5000,
    retries: 3
};

export default config;
```

```javascript
// main.js
import config from './config.js';

console.log(config.apiUrl);   // "https://api.example.com"
console.log(config.timeout);  // 5000
```

### Example 4: Utility Module

```javascript
// utils.js
export function formatDate(date) {
    return date.toLocaleDateString();
}

export function formatCurrency(amount) {
    return `$${amount.toFixed(2)}`;
}

export function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func(...args), delay);
    };
}
```

```javascript
// main.js
import { formatDate, formatCurrency, debounce } from './utils.js';

console.log(formatDate(new Date()));
console.log(formatCurrency(19.99));

let debouncedLog = debounce(() => console.log("Debounced"), 1000);
```

---

## Module Best Practices

### 1. One Default Export Per Module

```javascript
// ✅ Good: One default export
export default class Calculator { }

// ⚠️ Avoid: Multiple default exports (not possible)
```

### 2. Consistent Naming

```javascript
// ✅ Good: Clear, descriptive names
export function calculateTotal(items) { }
export const MAX_ITEMS = 100;

// ⚠️ Avoid: Unclear names
export function calc(items) { }
export const MAX = 100;
```

### 3. Barrel Exports (index.js)

```javascript
// index.js - Re-export from multiple modules
export { add, subtract } from './math.js';
export { greet, farewell } from './utils.js';
export { User } from './user.js';
```

### 4. Organize by Feature

```
src/
  users/
    user.js
    userService.js
    index.js
  products/
    product.js
    productService.js
    index.js
```

---

## Practice Exercise

### Exercise: Creating Modules

**Objective**: Practice creating and using ES6 modules.

**Instructions**:

1. Create multiple module files:
   - `math.js` - Math utilities
   - `user.js` - User class and functions
   - `utils.js` - Utility functions
   - `config.js` - Configuration
   - `main.js` - Main file importing from modules

2. Practice:
   - Named exports
   - Default exports
   - Importing with different syntaxes
   - Re-exporting
   - Module organization

**Example Solution**:

```javascript
// math.js
export function add(a, b) {
    return a + b;
}

export function subtract(a, b) {
    return a - b;
}

export function multiply(a, b) {
    return a * b;
}

export function divide(a, b) {
    if (b === 0) {
        throw new Error("Division by zero");
    }
    return a / b;
}

export const PI = 3.14159;
export const E = 2.71828;

// Default export
export default {
    add,
    subtract,
    multiply,
    divide,
    PI,
    E
};
```

```javascript
// user.js
export class User {
    constructor(name, email) {
        this.name = name;
        this.email = email;
    }
    
    getInfo() {
        return `${this.name} (${this.email})`;
    }
}

export function createUser(name, email) {
    return new User(name, email);
}

export function validateEmail(email) {
    return email.includes("@");
}
```

```javascript
// utils.js
export function formatDate(date) {
    return date.toLocaleDateString();
}

export function formatCurrency(amount) {
    return `$${amount.toFixed(2)}`;
}

export function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func(...args), delay);
    };
}

export function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func(...args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}
```

```javascript
// config.js
const config = {
    apiUrl: "https://api.example.com",
    timeout: 5000,
    retries: 3,
    environment: "development"
};

export default config;
```

```javascript
// index.js - Barrel export
export { add, subtract, multiply, divide, PI, E } from './math.js';
export { default as math } from './math.js';
export { User, createUser, validateEmail } from './user.js';
export { formatDate, formatCurrency, debounce, throttle } from './utils.js';
export { default as config } from './config.js';
```

```javascript
// main.js
// Import named exports
import { add, subtract, PI } from './math.js';
import { User, createUser } from './user.js';
import { formatDate, formatCurrency } from './utils.js';

// Import default export
import config from './config.js';

// Import with alias
import { add as sum, subtract as diff } from './math.js';

// Import all
import * as math from './math.js';

// Use imported values
console.log("=== Math Operations ===");
console.log("Add:", add(5, 3));           // 8
console.log("Subtract:", subtract(5, 3));  // 2
console.log("PI:", PI);                   // 3.14159
console.log("Sum (alias):", sum(10, 5));  // 15
console.log("Math module:", math.multiply(4, 2));  // 8

console.log("\n=== User Operations ===");
let user1 = new User("Alice", "alice@example.com");
let user2 = createUser("Bob", "bob@example.com");
console.log("User 1:", user1.getInfo());
console.log("User 2:", user2.getInfo());

console.log("\n=== Utility Functions ===");
console.log("Date:", formatDate(new Date()));
console.log("Currency:", formatCurrency(19.99));

console.log("\n=== Configuration ===");
console.log("API URL:", config.apiUrl);
console.log("Timeout:", config.timeout);
console.log("Environment:", config.environment);

// Import from barrel export
import { formatDate as format, config as appConfig } from './index.js';
console.log("\n=== From Barrel Export ===");
console.log("Formatted date:", format(new Date()));
console.log("Config:", appConfig);
```

**Expected Output**:
```
=== Math Operations ===
Add: 8
Subtract: 2
PI: 3.14159
Sum (alias): 15
Math module: 8

=== User Operations ===
User 1: Alice (alice@example.com)
User 2: Bob (bob@example.com)

=== Utility Functions ===
Date: [Current date]
Currency: $19.99

=== Configuration ===
API URL: https://api.example.com
Timeout: 5000
Environment: development

=== From Barrel Export ===
Formatted date: [Current date]
Config: { apiUrl: "https://api.example.com", timeout: 5000, retries: 3, environment: "development" }
```

**Challenge (Optional)**:
- Build a complete module-based application
- Create a module library
- Organize a large codebase with modules
- Create reusable module patterns

---

## Common Mistakes

### 1. Missing File Extension

```javascript
// ⚠️ Problem: Missing .js extension
import { add } from './math';  // May not work in all environments

// ✅ Solution: Include extension
import { add } from './math.js';
```

### 2. Mixing Default and Named Exports Incorrectly

```javascript
// ⚠️ Problem: Wrong import syntax
import add, { subtract } from './math.js';  // add is default

// ✅ Correct: Default first, then named
import add, { subtract } from './math.js';
```

### 3. Circular Dependencies

```javascript
// ⚠️ Problem: Circular dependency
// module1.js
import { func2 } from './module2.js';

// module2.js
import { func1 } from './module1.js';  // Circular!

// ✅ Solution: Restructure to avoid circular dependencies
```

### 4. Exporting Non-existent Values

```javascript
// ⚠️ Problem: Exporting undefined
export { nonExistentVar };  // Error

// ✅ Solution: Export existing values
let myVar = "value";
export { myVar };
```

---

## Key Takeaways

1. **export**: Makes values available to other modules
2. **import**: Brings values from other modules
3. **Named Exports**: Multiple exports with specific names
4. **Default Export**: Single default export per module
5. **Module Scope**: Each module has its own scope
6. **File Extension**: Use `.js` extension in imports
7. **Best Practice**: One default export, multiple named exports
8. **Organization**: Organize modules by feature

---

## Quiz: ES6 Modules

Test your understanding with these questions:

1. **What keyword exports values?**
   - A) export
   - B) import
   - C) module
   - D) require

2. **What keyword imports values?**
   - A) export
   - B) import
   - C) module
   - D) require

3. **How many default exports per module?**
   - A) 0
   - B) 1
   - C) Multiple
   - D) Unlimited

4. **Named exports use:**
   - A) export default
   - B) export { name }
   - C) Both
   - D) Neither

5. **Import syntax for default export:**
   - A) import { name } from './module.js'
   - B) import name from './module.js'
   - C) import * as name from './module.js'
   - D) All of the above

6. **Modules have:**
   - A) Global scope
   - B) Module scope
   - C) Function scope
   - D) Block scope

7. **Re-exporting uses:**
   - A) export from
   - B) import from
   - C) require from
   - D) module from

**Answers**:
1. A) export
2. B) import
3. B) 1
4. B) export { name }
5. B) import name from './module.js'
6. B) Module scope
7. A) export from

---

## Next Steps

Congratulations! You've learned ES6 modules. You now know:
- How to export and import values
- Named vs default exports
- Module syntax and organization
- Best practices for modules

**What's Next?**
- Lesson 11.2: CommonJS and Module Systems
- Learn about other module systems
- Understand module bundlers
- Build larger applications

---

## Additional Resources

- **MDN: ES6 Modules**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules)
- **JavaScript.info: Modules**: [javascript.info/modules-intro](https://javascript.info/modules-intro)
- **ES6 Modules Guide**: Comprehensive module patterns

---

*Lesson completed! You're ready to move on to the next lesson.*

