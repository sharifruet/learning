# Lesson 24.1: ESLint

## Learning Objectives

By the end of this lesson, you will be able to:
- Install and configure ESLint
- Understand ESLint rules
- Use ESLint plugins
- Integrate Prettier with ESLint
- Fix linting errors
- Set up ESLint in projects
- Maintain code quality

---

## Introduction to ESLint

ESLint is a tool for identifying and reporting on patterns in JavaScript code.

### Why ESLint?

- **Code Quality**: Enforces consistent code style
- **Bug Prevention**: Catches common errors
- **Best Practices**: Enforces best practices
- **Team Consistency**: Same rules for everyone
- **Automation**: Automatic error detection
- **Professional**: Industry standard tool

---

## Installing ESLint

### Basic Installation

```bash
# Install ESLint
npm install --save-dev eslint

# Initialize ESLint
npx eslint --init

# Or use npm
npm init @eslint/config
```

### Quick Setup

```bash
# Answer questions:
# - How would you like to use ESLint?
# - What type of modules?
# - Which framework?
# - Where does your code run?
# - Use TypeScript?
# - Format with?
```

---

## Configuration

### Configuration Files

```javascript
// .eslintrc.js
module.exports = {
    env: {
        browser: true,
        es2021: true,
        node: true
    },
    extends: [
        'eslint:recommended'
    ],
    parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module'
    },
    rules: {
        // Your rules
    }
};
```

### package.json Configuration

```json
{
  "eslintConfig": {
    "extends": "eslint:recommended",
    "rules": {
      "no-console": "warn"
    }
  }
}
```

### .eslintrc.json

```json
{
  "env": {
    "browser": true,
    "es2021": true
  },
  "extends": "eslint:recommended",
  "parserOptions": {
    "ecmaVersion": "latest",
    "sourceType": "module"
  },
  "rules": {
    "no-console": "warn",
    "no-unused-vars": "error"
  }
}
```

### Environment Configuration

```javascript
module.exports = {
    env: {
        browser: true,   // Browser globals
        node: true,      // Node.js globals
        es6: true,      // ES6 features
        jest: true      // Jest globals
    }
};
```

---

## Rules

### Rule Levels

```javascript
// Rule levels:
// "off" or 0 - Turn rule off
// "warn" or 1 - Warning (doesn't fail)
// "error" or 2 - Error (fails linting)

module.exports = {
    rules: {
        'no-console': 'warn',        // Warning
        'no-debugger': 'error',      // Error
        'no-unused-vars': 'off'      // Off
    }
};
```

### Common Rules

```javascript
module.exports = {
    rules: {
        // Best Practices
        'no-console': 'warn',
        'no-debugger': 'error',
        'no-alert': 'warn',
        'no-eval': 'error',
        
        // Variables
        'no-unused-vars': 'error',
        'no-undef': 'error',
        
        // Style
        'semi': ['error', 'always'],
        'quotes': ['error', 'single'],
        'indent': ['error', 2],
        'comma-dangle': ['error', 'never'],
        
        // ES6
        'prefer-const': 'error',
        'no-var': 'error',
        'arrow-spacing': 'error'
    }
};
```

### Rule Configuration

```javascript
module.exports = {
    rules: {
        // With options
        'quotes': ['error', 'single', { 'avoidEscape': true }],
        'indent': ['error', 2, { 'SwitchCase': 1 }],
        'max-len': ['error', { 'code': 100 }],
        
        // Multiple options
        'array-bracket-spacing': ['error', 'never', {
            'singleValue': false,
            'objectsInArrays': false
        }]
    }
};
```

---

## Plugins

### Installing Plugins

```bash
# Install plugin
npm install --save-dev eslint-plugin-react

# Or for import rules
npm install --save-dev eslint-plugin-import
```

### Using Plugins

```javascript
// .eslintrc.js
module.exports = {
    plugins: ['react', 'import'],
    extends: [
        'eslint:recommended',
        'plugin:react/recommended',
        'plugin:import/recommended'
    ],
    rules: {
        'react/prop-types': 'warn',
        'import/no-unresolved': 'error'
    }
};
```

### Popular Plugins

```javascript
// React
plugins: ['react']
extends: ['plugin:react/recommended']

// Import
plugins: ['import']
extends: ['plugin:import/recommended']

// Jest
plugins: ['jest']
extends: ['plugin:jest/recommended']

// Node
plugins: ['node']
extends: ['plugin:node/recommended']
```

---

## Prettier Integration

### Installing Prettier

```bash
# Install Prettier and ESLint config
npm install --save-dev prettier eslint-config-prettier eslint-plugin-prettier
```

### Configuration

```javascript
// .eslintrc.js
module.exports = {
    extends: [
        'eslint:recommended',
        'plugin:prettier/recommended'  // Must be last
    ],
    plugins: ['prettier'],
    rules: {
        'prettier/prettier': 'error'
    }
};
```

### .prettierrc

```json
{
  "semi": true,
  "singleQuote": true,
  "tabWidth": 2,
  "trailingComma": "none",
  "printWidth": 100
}
```

### Disabling Conflicting Rules

```javascript
// eslint-config-prettier disables ESLint rules
// that conflict with Prettier
module.exports = {
    extends: [
        'eslint:recommended',
        'prettier'  // Disables conflicting rules
    ]
};
```

---

## Using ESLint

### Command Line

```bash
# Lint files
npx eslint file.js

# Lint directory
npx eslint src/

# Fix auto-fixable issues
npx eslint --fix src/

# Use specific config
npx eslint --config .eslintrc.custom.js src/
```

### npm Scripts

```json
{
  "scripts": {
    "lint": "eslint .",
    "lint:fix": "eslint . --fix",
    "lint:watch": "eslint . --watch"
  }
}
```

### Ignoring Files

```javascript
// .eslintignore
node_modules/
dist/
build/
*.min.js
coverage/
```

### Inline Comments

```javascript
// Disable rule for line
console.log('test'); // eslint-disable-line no-console

// Disable rule for next line
// eslint-disable-next-line no-console
console.log('test');

// Disable multiple rules
/* eslint-disable no-console, no-alert */
console.log('test');
alert('test');
/* eslint-enable no-console, no-alert */

// Disable for entire file
/* eslint-disable */
```

---

## Practice Exercise

### Exercise: ESLint Setup

**Objective**: Practice installing ESLint, configuring rules, using plugins, and integrating Prettier.

**Instructions**:

1. Install ESLint
2. Configure ESLint
3. Set up Prettier integration
4. Practice:
   - Configuring ESLint
   - Setting up rules
   - Using plugins
   - Fixing linting errors

**Example Solution**:

```bash
# 1. Initialize project
npm init -y

# 2. Install ESLint
npm install --save-dev eslint

# 3. Initialize ESLint
npx eslint --init
# Or create config manually
```

```javascript
// .eslintrc.js
module.exports = {
    env: {
        browser: true,
        es2021: true,
        node: true
    },
    extends: [
        'eslint:recommended'
    ],
    parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module'
    },
    rules: {
        'no-console': 'warn',
        'no-debugger': 'error',
        'no-unused-vars': 'error',
        'semi': ['error', 'always'],
        'quotes': ['error', 'single'],
        'indent': ['error', 2],
        'prefer-const': 'error',
        'no-var': 'error'
    }
};
```

```javascript
// src/index.js
// This file has intentional linting errors for practice

var x = 10;  // Should use const/let
console.log('Hello');  // console.log warning

function unusedFunction() {  // Unused function
    return 'unused';
}

let y = 20;
y = 30;  // Should use const if not reassigned

// Missing semicolon
let z = 40

// Wrong quotes
let message = "Hello World";

// Wrong indentation
if (true) {
console.log('test');
}
```

```json
// package.json
{
  "name": "eslint-practice",
  "version": "1.0.0",
  "scripts": {
    "lint": "eslint src/",
    "lint:fix": "eslint src/ --fix"
  },
  "devDependencies": {
    "eslint": "^8.50.0"
  }
}
```

```bash
# Run ESLint
npm run lint

# Fix auto-fixable issues
npm run lint:fix
```

```javascript
// .eslintrc.js with React plugin example
module.exports = {
    env: {
        browser: true,
        es2021: true
    },
    extends: [
        'eslint:recommended',
        'plugin:react/recommended'
    ],
    plugins: ['react'],
    parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module',
        ecmaFeatures: {
            jsx: true
        }
    },
    settings: {
        react: {
            version: 'detect'
        }
    },
    rules: {
        'react/prop-types': 'warn',
        'react/react-in-jsx-scope': 'off'  // Not needed in React 17+
    }
};
```

```javascript
// .eslintrc.js with Prettier integration
module.exports = {
    env: {
        browser: true,
        es2021: true
    },
    extends: [
        'eslint:recommended',
        'plugin:prettier/recommended'
    ],
    plugins: ['prettier'],
    parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module'
    },
    rules: {
        'prettier/prettier': 'error',
        'no-console': 'warn'
    }
};
```

```json
// .prettierrc
{
  "semi": true,
  "singleQuote": true,
  "tabWidth": 2,
  "trailingComma": "none",
  "printWidth": 100,
  "arrowParens": "avoid"
}
```

```javascript
// .eslintignore
node_modules/
dist/
build/
*.min.js
coverage/
```

**Expected Output** (when running `npm run lint`):
```
/Users/.../src/index.js
  1:1   error  Unexpected var, use let or const  no-var
  2:1   warning  Unexpected console statement    no-console
  4:1   error  'unusedFunction' is defined but never used  no-unused-vars
  7:1   error  'y' is never reassigned. Use 'const' instead  prefer-const
  9:1   error  Missing semicolon                            semi
  12:1  error  Strings must use singlequote                 quotes
  15:1  error  Expected indentation of 2 spaces but found 0  indent

✖ 7 problems (6 errors, 1 warning)
```

**Challenge (Optional)**:
- Set up ESLint for a real project
- Configure custom rules
- Integrate with your editor
- Set up pre-commit hooks

---

## Common Mistakes

### 1. Not Extending Recommended

```javascript
// ❌ Bad: No extends
module.exports = {
    rules: {
        // Only custom rules
    }
};

// ✅ Good: Extend recommended
module.exports = {
    extends: ['eslint:recommended'],
    rules: {
        // Custom rules on top
    }
};
```

### 2. Conflicting Prettier and ESLint

```javascript
// ❌ Bad: Both format
module.exports = {
    extends: ['eslint:recommended'],
    rules: {
        'semi': 'error',  // Conflicts with Prettier
        'quotes': 'error'  // Conflicts with Prettier
    }
};

// ✅ Good: Use prettier config
module.exports = {
    extends: ['eslint:recommended', 'prettier'],
    // Prettier handles formatting
};
```

### 3. Not Using --fix

```bash
# ❌ Bad: Manual fixes
# Fix all errors manually

# ✅ Good: Auto-fix
npm run lint:fix
```

---

## Key Takeaways

1. **ESLint**: Tool for code quality and consistency
2. **Configuration**: Use .eslintrc.js or package.json
3. **Rules**: Configure rules for your needs
4. **Plugins**: Extend functionality with plugins
5. **Prettier**: Integrate for code formatting
6. **Best Practice**: Extend recommended, use plugins, auto-fix
7. **Automation**: Use in CI/CD and pre-commit hooks

---

## Quiz: ESLint

Test your understanding with these questions:

1. **ESLint is:**
   - A) Code formatter
   - B) Code linter
   - C) Both
   - D) Neither

2. **Rule level "error":**
   - A) Fails linting
   - B) Warning only
   - C) Disabled
   - D) Nothing

3. **extends:**
   - A) Extends configs
   - B) Creates new config
   - C) Deletes config
   - D) Nothing

4. **plugins:**
   - A) Add rules
   - B) Remove rules
   - C) Both
   - D) Neither

5. **--fix flag:**
   - A) Auto-fixes issues
   - B) Shows issues
   - C) Both
   - D) Neither

6. **Prettier handles:**
   - A) Formatting
   - B) Linting
   - C) Both
   - D) Neither

7. **.eslintignore:**
   - A) Ignores files
   - B) Includes files
   - C) Both
   - D) Neither

**Answers**:
1. B) Code linter
2. A) Fails linting
3. A) Extends configs
4. A) Add rules
5. A) Auto-fixes issues
6. A) Formatting
7. A) Ignores files

---

## Next Steps

Congratulations! You've learned ESLint. You now know:
- How to install and configure ESLint
- How to use rules and plugins
- How to integrate Prettier
- How to maintain code quality

**What's Next?**
- Lesson 24.2: TypeScript Introduction
- Learn TypeScript basics
- Understand types and interfaces
- Work with type annotations

---

## Additional Resources

- **ESLint Documentation**: [eslint.org](https://eslint.org)
- **ESLint Rules**: [eslint.org/docs/rules](https://eslint.org/docs/rules)
- **Prettier**: [prettier.io](https://prettier.io)

---

*Lesson completed! You're ready to move on to the next lesson.*

