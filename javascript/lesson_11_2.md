# Lesson 11.2: CommonJS and Module Systems

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand CommonJS module system
- Use `require()` and `module.exports`
- Understand AMD modules
- Learn about module bundlers (Webpack, Rollup)
- Compare different module systems
- Choose the right module system for your project
- Understand module loading strategies

---

## Introduction to Module Systems

JavaScript has evolved through different module systems. Understanding them helps you work with different codebases and tools.

### Module System Evolution

1. **No Modules**: Global variables (old way)
2. **CommonJS**: Node.js standard (require/module.exports)
3. **AMD**: Asynchronous Module Definition (browser)
4. **ES6 Modules**: Modern standard (import/export)
5. **Bundlers**: Tools that combine modules (Webpack, Rollup)

---

## CommonJS

CommonJS is the module system used in Node.js. It uses `require()` to import and `module.exports` to export.

### Basic CommonJS Export

```javascript
// math.js
function add(a, b) {
    return a + b;
}

function subtract(a, b) {
    return a - b;
}

module.exports = {
    add,
    subtract
};
```

### Basic CommonJS Import

```javascript
// main.js
const math = require('./math.js');

console.log(math.add(5, 3));      // 8
console.log(math.subtract(5, 3));  // 2
```

### Export Individual Functions

```javascript
// utils.js
exports.greet = function(name) {
    return `Hello, ${name}!`;
};

exports.farewell = function(name) {
    return `Goodbye, ${name}!`;
};
```

```javascript
// main.js
const { greet, farewell } = require('./utils.js');

console.log(greet("Alice"));    // "Hello, Alice!"
console.log(farewell("Bob"));   // "Goodbye, Bob!"
```

### Default Export

```javascript
// calculator.js
function Calculator() {
    this.add = (a, b) => a + b;
    this.subtract = (a, b) => a - b;
}

module.exports = Calculator;
```

```javascript
// main.js
const Calculator = require('./calculator.js');
const calc = new Calculator();

console.log(calc.add(5, 3));  // 8
```

### Export Single Function

```javascript
// add.js
module.exports = function(a, b) {
    return a + b;
};
```

```javascript
// main.js
const add = require('./add.js');
console.log(add(5, 3));  // 8
```

### CommonJS vs ES6 Modules

| Feature | CommonJS | ES6 Modules |
|---------|----------|-------------|
| Syntax | `require()` / `module.exports` | `import` / `export` |
| Loading | Synchronous | Asynchronous |
| Tree Shaking | No | Yes |
| Static Analysis | Limited | Full |
| Browser Support | Via bundler | Native |
| Node.js | Native | Native (ESM) |

---

## AMD (Asynchronous Module Definition)

AMD is designed for browser environments where modules load asynchronously.

### Basic AMD Module

```javascript
// math.js
define(function() {
    return {
        add: function(a, b) {
            return a + b;
        },
        subtract: function(a, b) {
            return a - b;
        }
    };
});
```

### AMD with Dependencies

```javascript
// calculator.js
define(['math'], function(math) {
    return {
        calculate: function(a, b, operation) {
            if (operation === 'add') {
                return math.add(a, b);
            }
            return math.subtract(a, b);
        }
    };
});
```

### AMD with RequireJS

```javascript
// Using RequireJS
require(['math', 'calculator'], function(math, calculator) {
    console.log(math.add(5, 3));
    console.log(calculator.calculate(10, 5, 'add'));
});
```

**Note**: AMD is less common now, replaced by ES6 modules and bundlers.

---

## Module Bundlers

Module bundlers combine multiple modules into one or more files for browser use.

### Why Bundlers?

- **Browser Compatibility**: Browsers don't natively support all module systems
- **Optimization**: Minify, tree-shake, optimize code
- **Asset Management**: Handle CSS, images, etc.
- **Development Tools**: Hot reload, source maps
- **Code Splitting**: Load code on demand

### Popular Bundlers

1. **Webpack**: Most popular, highly configurable
2. **Rollup**: Great for libraries, tree-shaking
3. **Parcel**: Zero-configuration bundler
4. **Vite**: Fast development, modern tooling
5. **esbuild**: Extremely fast bundler

---

## Webpack

Webpack is a powerful module bundler that can handle various assets.

### Basic Webpack Setup

**package.json**:
```json
{
  "name": "my-app",
  "version": "1.0.0",
  "scripts": {
    "build": "webpack",
    "dev": "webpack serve"
  },
  "devDependencies": {
    "webpack": "^5.0.0",
    "webpack-cli": "^4.0.0"
  }
}
```

**webpack.config.js**:
```javascript
const path = require('path');

module.exports = {
  entry: './src/index.js',
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'dist')
  },
  mode: 'development'
};
```

### Webpack Features

- **Loaders**: Transform files (Babel, TypeScript, CSS)
- **Plugins**: Extend functionality
- **Code Splitting**: Split code into chunks
- **Hot Module Replacement**: Update without refresh
- **Source Maps**: Debug original code

---

## Rollup

Rollup is optimized for creating libraries and uses ES6 modules.

### Basic Rollup Setup

**rollup.config.js**:
```javascript
export default {
  input: 'src/index.js',
  output: {
    file: 'dist/bundle.js',
    format: 'es'  // ES module format
  }
};
```

### Rollup Features

- **Tree Shaking**: Remove unused code
- **ES6 Modules**: Native ES6 module support
- **Smaller Bundles**: Optimized for libraries
- **Multiple Formats**: ES, CommonJS, UMD

---

## Vite

Vite is a modern build tool that provides fast development experience.

### Basic Vite Setup

**package.json**:
```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build"
  },
  "devDependencies": {
    "vite": "^4.0.0"
  }
}
```

### Vite Features

- **Fast HMR**: Instant hot module replacement
- **ES Modules**: Native ES module support
- **Optimized Build**: Uses Rollup for production
- **Zero Config**: Works out of the box

---

## Module System Comparison

### When to Use Each

**CommonJS:**
- Node.js applications
- Legacy codebases
- Server-side JavaScript

**ES6 Modules:**
- Modern JavaScript projects
- Browser applications
- When you need tree-shaking
- Modern Node.js (with ESM)

**AMD:**
- Legacy browser applications
- RequireJS projects
- (Generally avoid for new projects)

**Bundlers:**
- Browser applications
- When you need optimization
- Complex build requirements
- Asset management

---

## Practical Examples

### Example 1: CommonJS Module

```javascript
// user.js
class User {
    constructor(name, email) {
        this.name = name;
        this.email = email;
    }
    
    getInfo() {
        return `${this.name} (${this.email})`;
    }
}

module.exports = User;
```

```javascript
// main.js
const User = require('./user.js');

let user = new User("Alice", "alice@example.com");
console.log(user.getInfo());
```

### Example 2: CommonJS with Multiple Exports

```javascript
// math.js
exports.add = (a, b) => a + b;
exports.subtract = (a, b) => a - b;
exports.multiply = (a, b) => a * b;
exports.divide = (a, b) => a / b;
```

```javascript
// main.js
const { add, subtract, multiply, divide } = require('./math.js');

console.log(add(5, 3));        // 8
console.log(multiply(4, 2));   // 8
```

### Example 3: Mixed Exports

```javascript
// utils.js
function formatDate(date) {
    return date.toLocaleDateString();
}

function formatCurrency(amount) {
    return `$${amount.toFixed(2)}`;
}

// Named exports
exports.formatDate = formatDate;
exports.formatCurrency = formatCurrency;

// Default export
module.exports.default = {
    formatDate,
    formatCurrency
};
```

---

## Practice Exercise

### Exercise: Module Systems

**Objective**: Practice using different module systems and understand bundlers.

**Instructions**:

1. Create CommonJS modules
2. Convert to ES6 modules
3. Understand bundler concepts
4. Compare module systems

**Example Solution**:

```javascript
// CommonJS Example
// math.js
function add(a, b) {
    return a + b;
}

function subtract(a, b) {
    return a - b;
}

function multiply(a, b) {
    return a * b;
}

function divide(a, b) {
    if (b === 0) {
        throw new Error("Division by zero");
    }
    return a / b;
}

module.exports = {
    add,
    subtract,
    multiply,
    divide
};

// Alternative syntax
// exports.add = add;
// exports.subtract = subtract;
```

```javascript
// main.js (CommonJS)
const math = require('./math.js');

console.log("=== CommonJS Module ===");
console.log("Add:", math.add(5, 3));        // 8
console.log("Subtract:", math.subtract(5, 3));  // 2
console.log("Multiply:", math.multiply(4, 2));  // 8
console.log("Divide:", math.divide(10, 2));     // 5

// Destructuring
const { add, subtract } = require('./math.js');
console.log("Destructured:", add(10, 5));  // 15
```

```javascript
// ES6 Module Equivalent
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
```

```javascript
// main.js (ES6)
import { add, subtract, multiply, divide } from './math.js';

console.log("=== ES6 Module ===");
console.log("Add:", add(5, 3));
console.log("Subtract:", subtract(5, 3));
console.log("Multiply:", multiply(4, 2));
console.log("Divide:", divide(10, 2));
```

```javascript
// CommonJS: User Module
// user.js
class User {
    constructor(name, email) {
        this.name = name;
        this.email = email;
    }
    
    getInfo() {
        return `${this.name} (${this.email})`;
    }
}

module.exports = User;
```

```javascript
// main.js
const User = require('./user.js');

let user = new User("Alice", "alice@example.com");
console.log("User:", user.getInfo());
```

```javascript
// CommonJS: Configuration
// config.js
const config = {
    apiUrl: "https://api.example.com",
    timeout: 5000,
    retries: 3
};

module.exports = config;
```

```javascript
// main.js
const config = require('./config.js');
console.log("Config:", config);
```

**Expected Output**:
```
=== CommonJS Module ===
Add: 8
Subtract: 2
Multiply: 8
Divide: 5
Destructured: 15

=== ES6 Module ===
Add: 8
Subtract: 2
Multiply: 8
Divide: 5

User: Alice (alice@example.com)
Config: { apiUrl: "https://api.example.com", timeout: 5000, retries: 3 }
```

**Challenge (Optional)**:
- Set up a Webpack project
- Set up a Rollup project
- Convert CommonJS to ES6 modules
- Create a module library

---

## Common Mistakes

### 1. Mixing Module Systems

```javascript
// ⚠️ Problem: Mixing CommonJS and ES6
// module1.js (CommonJS)
module.exports = { add };

// module2.js (ES6)
import { add } from './module1.js';  // May not work

// ✅ Solution: Use one system consistently
```

### 2. Circular Dependencies

```javascript
// ⚠️ Problem: Circular dependency
// module1.js
const { func2 } = require('./module2.js');

// module2.js
const { func1 } = require('./module1.js');  // Circular!

// ✅ Solution: Restructure to avoid
```

### 3. Wrong Export Syntax

```javascript
// ⚠️ Problem: Wrong syntax
exports = { add };  // Doesn't work

// ✅ Solution: Use module.exports or exports.property
module.exports = { add };
// or
exports.add = add;
```

### 4. Forgetting File Extension

```javascript
// ⚠️ Problem: May not work in all environments
const math = require('./math');

// ✅ Solution: Include extension (optional in CommonJS, required in ES6)
const math = require('./math.js');
```

---

## Key Takeaways

1. **CommonJS**: Node.js standard, uses `require()` and `module.exports`
2. **AMD**: Browser-focused, asynchronous loading (legacy)
3. **ES6 Modules**: Modern standard, `import`/`export`
4. **Bundlers**: Combine modules for browsers (Webpack, Rollup, Vite)
5. **Choose Wisely**: Use ES6 for new projects, CommonJS for Node.js
6. **Bundlers Essential**: Needed for browser applications
7. **Best Practice**: Use consistent module system
8. **Modern Approach**: ES6 modules with bundler

---

## Quiz: Module Systems

Test your understanding with these questions:

1. **CommonJS uses:**
   - A) import/export
   - B) require/module.exports
   - C) define/require
   - D) module/import

2. **ES6 modules use:**
   - A) require/module.exports
   - B) import/export
   - C) define/require
   - D) module/require

3. **CommonJS is:**
   - A) Asynchronous
   - B) Synchronous
   - C) Both
   - D) Neither

4. **AMD stands for:**
   - A) Asynchronous Module Definition
   - B) Advanced Module Definition
   - C) Application Module Definition
   - D) Automatic Module Definition

5. **Webpack is a:**
   - A) Module system
   - B) Module bundler
   - C) Framework
   - D) Library

6. **Rollup is optimized for:**
   - A) Applications
   - B) Libraries
   - C) Both
   - D) Neither

7. **Modern projects should use:**
   - A) CommonJS only
   - B) ES6 modules
   - C) AMD
   - D) No modules

**Answers**:
1. B) require/module.exports
2. B) import/export
3. B) Synchronous
4. A) Asynchronous Module Definition
5. B) Module bundler
6. B) Libraries
7. B) ES6 modules

---

## Next Steps

Congratulations! You've completed Module 11: Modules. You now know:
- How ES6 modules work
- How CommonJS works
- About module bundlers
- When to use each system

**What's Next?**
- Module 12: Working with APIs
- Lesson 12.1: Fetch API
- Practice building modular applications
- Continue learning advanced JavaScript

---

## Additional Resources

- **Node.js Modules**: [nodejs.org/api/modules.html](https://nodejs.org/api/modules.html)
- **Webpack Documentation**: [webpack.js.org](https://webpack.js.org/)
- **Rollup Documentation**: [rollupjs.org](https://rollupjs.org/)
- **Vite Documentation**: [vitejs.dev](https://vitejs.dev/)

---

*Lesson completed! You've finished Module 11: Modules. Ready for Module 12: Working with APIs!*

