# Lesson 8.2: IIFE (Immediately Invoked Function Expressions)

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what IIFE is and why it's useful
- Write IIFE syntax correctly
- Use IIFEs to create private scope
- Implement the module pattern with IIFEs
- Avoid global namespace pollution
- Use IIFEs in modern JavaScript development

---

## Introduction to IIFE

IIFE stands for **Immediately Invoked Function Expression**. It's a function that is defined and executed immediately after creation.

### What is an IIFE?

An IIFE is a function expression that is invoked immediately:

```javascript
(function() {
    console.log("I run immediately!");
})();
```

### Why Use IIFEs?

- **Private Scope**: Create isolated scope
- **Avoid Global Pollution**: Don't pollute global namespace
- **Module Pattern**: Create modules before ES6
- **Variable Isolation**: Prevent variable conflicts
- **Initialization**: Run code once on load

---

## IIFE Syntax

### Basic Syntax

```javascript
// Syntax 1: Parentheses around function
(function() {
    console.log("IIFE");
})();

// Syntax 2: Parentheses around entire expression
(function() {
    console.log("IIFE");
}());

// Both are equivalent
```

### With Parameters

```javascript
(function(name) {
    console.log(`Hello, ${name}!`);
})("Alice");  // "Hello, Alice!"
```

### Arrow Function IIFE

```javascript
(() => {
    console.log("Arrow function IIFE");
})();
```

### Named IIFE

```javascript
(function myIIFE() {
    console.log("Named IIFE");
})();
```

---

## Creating Private Scope

### Problem: Global Variables

```javascript
// ⚠️ Problem: Pollutes global scope
var count = 0;
var name = "Alice";

function increment() {
    count++;
}

// All variables are global
```

### Solution: IIFE

```javascript
// ✅ Solution: Private scope
(function() {
    var count = 0;
    var name = "Alice";
    
    function increment() {
        count++;
    }
    
    // Variables are private, not global
})();

// count and name are not accessible here
```

### Example: Calculator

```javascript
(function() {
    let result = 0;
    
    function add(x) {
        result += x;
    }
    
    function subtract(x) {
        result -= x;
    }
    
    function getResult() {
        return result;
    }
    
    // Expose only what's needed
    window.calculator = {
        add: add,
        subtract: subtract,
        getResult: getResult
    };
})();

calculator.add(10);
calculator.subtract(3);
console.log(calculator.getResult());  // 7
// result is not accessible globally
```

---

## Module Pattern

The Module Pattern uses IIFE to create modules with private and public APIs.

### Basic Module Pattern

```javascript
let myModule = (function() {
    // Private variables
    let privateVar = "I'm private";
    
    // Private function
    function privateFunction() {
        return privateVar;
    }
    
    // Public API
    return {
        publicMethod: function() {
            return privateFunction();
        },
        publicVar: "I'm public"
    };
})();

console.log(myModule.publicMethod());  // "I'm private"
console.log(myModule.publicVar);      // "I'm public"
// console.log(myModule.privateVar);  // undefined
```

### Module Pattern with Parameters

```javascript
let calculator = (function(initialValue) {
    let result = initialValue || 0;
    
    return {
        add: function(x) {
            result += x;
            return this;
        },
        subtract: function(x) {
            result -= x;
            return this;
        },
        getResult: function() {
            return result;
        },
        reset: function() {
            result = initialValue || 0;
            return this;
        }
    };
})(10);

calculator.add(5).subtract(3);
console.log(calculator.getResult());  // 12
```

### Revealing Module Pattern

```javascript
let myModule = (function() {
    let privateVar = "private";
    
    function privateFunction() {
        return privateVar;
    }
    
    function publicFunction() {
        return privateFunction();
    }
    
    // Reveal only what you want public
    return {
        publicFunction: publicFunction
    };
})();
```

### Module Pattern with Dependencies

```javascript
let myModule = (function(dependency1, dependency2) {
    // Use dependencies
    dependency1.doSomething();
    dependency2.doSomethingElse();
    
    return {
        // Public API
    };
})(dependency1, dependency2);
```

---

## Use Cases

### Use Case 1: Avoiding Global Pollution

```javascript
// Before: Global variables
var userName = "Alice";
var userAge = 25;
var userCity = "NYC";

// After: IIFE
(function() {
    var userName = "Alice";
    var userAge = 25;
    var userCity = "NYC";
    
    // Use variables here
    console.log(`${userName} is ${userAge} years old`);
})();
// Variables don't pollute global scope
```

### Use Case 2: Loop Variable Fix

```javascript
// Problem: All closures share same i
for (var i = 0; i < 3; i++) {
    setTimeout(function() {
        console.log(i);  // 3, 3, 3
    }, 100);
}

// Solution: IIFE creates new scope for each iteration
for (var i = 0; i < 3; i++) {
    (function(index) {
        setTimeout(function() {
            console.log(index);  // 0, 1, 2
        }, 100);
    })(i);
}
```

### Use Case 3: Initialization Code

```javascript
// Run initialization code immediately
(function() {
    // Setup code
    initializeApp();
    setupEventListeners();
    loadInitialData();
})();
```

### Use Case 4: Library Wrapper

```javascript
// Wrap library code in IIFE
(function(window) {
    let myLibrary = {
        version: "1.0.0",
        doSomething: function() {
            console.log("Doing something");
        }
    };
    
    // Expose to global scope
    window.MyLibrary = myLibrary;
})(window);
```

### Use Case 5: Configuration

```javascript
let app = (function(config) {
    let settings = {
        apiUrl: config.apiUrl || "https://api.example.com",
        timeout: config.timeout || 5000,
        retries: config.retries || 3
    };
    
    return {
        getSetting: function(key) {
            return settings[key];
        },
        updateSetting: function(key, value) {
            if (settings.hasOwnProperty(key)) {
                settings[key] = value;
            }
        }
    };
})({
    apiUrl: "https://api.custom.com",
    timeout: 10000
});
```

---

## Modern Alternatives

### ES6 Modules (Modern Alternative)

```javascript
// ES6 Module (preferred in modern code)
// math.js
let result = 0;

export function add(x) {
    result += x;
}

export function getResult() {
    return result;
}

// main.js
import { add, getResult } from './math.js';
```

### Block Scope (let/const)

```javascript
// Modern: Use block scope instead of IIFE
{
    let privateVar = "private";
    // Variables are scoped to block
}
```

### When to Use IIFE

- **Legacy Code**: Supporting older browsers
- **Script Tags**: Inline scripts without module system
- **Quick Isolation**: Temporary scope isolation
- **Library Wrappers**: Wrapping third-party code

---

## Practice Exercise

### Exercise: IIFE Practice

**Objective**: Practice creating and using IIFEs for various scenarios.

**Instructions**:

1. Create a file called `iife-practice.js`

2. Create IIFEs for:
   - Private scope isolation
   - Module pattern
   - Loop variable fixes
   - Library wrappers
   - Configuration modules

3. Demonstrate:
   - Basic IIFE syntax
   - Module pattern
   - Avoiding global pollution
   - Modern alternatives

**Example Solution**:

```javascript
// IIFE Practice
console.log("=== Basic IIFE ===");

(function() {
    console.log("I run immediately!");
})();

(function(name) {
    console.log(`Hello, ${name}!`);
})("Alice");

(() => {
    console.log("Arrow function IIFE");
})();
console.log();

console.log("=== Private Scope ===");

// Without IIFE: Global pollution
var globalCount = 0;
var globalName = "Global";

// With IIFE: Private scope
(function() {
    var privateCount = 0;
    var privateName = "Private";
    
    function increment() {
        privateCount++;
        console.log(`Count: ${privateCount}`);
    }
    
    increment();  // Count: 1
    increment();  // Count: 2
})();

// privateCount and privateName are not accessible here
console.log();

console.log("=== Module Pattern ===");

let calculator = (function(initialValue) {
    let result = initialValue || 0;
    
    return {
        add: function(x) {
            result += x;
            return this;
        },
        subtract: function(x) {
            result -= x;
            return this;
        },
        multiply: function(x) {
            result *= x;
            return this;
        },
        getResult: function() {
            return result;
        },
        reset: function() {
            result = initialValue || 0;
            return this;
        }
    };
})(10);

calculator.add(5).multiply(2).subtract(3);
console.log("Calculator result:", calculator.getResult());  // 27
calculator.reset();
console.log("After reset:", calculator.getResult());  // 10
console.log();

console.log("=== Revealing Module Pattern ===");

let myModule = (function() {
    let privateVar = "I'm private";
    let publicVar = "I'm public";
    
    function privateFunction() {
        return privateVar;
    }
    
    function publicFunction() {
        return privateFunction() + " but accessible";
    }
    
    return {
        publicFunction: publicFunction,
        publicVar: publicVar
    };
})();

console.log("Public function:", myModule.publicFunction());
console.log("Public var:", myModule.publicVar);
// console.log(myModule.privateVar);  // undefined
console.log();

console.log("=== Loop Variable Fix ===");

// Problem: var in loop
console.log("Problem with var:");
for (var i = 0; i < 3; i++) {
    setTimeout(function() {
        console.log("  var i:", i);  // 3, 3, 3
    }, 10);
}

// Solution: IIFE
setTimeout(() => {
    console.log("Solution with IIFE:");
    for (var j = 0; j < 3; j++) {
        (function(index) {
            setTimeout(function() {
                console.log("  IIFE j:", index);  // 0, 1, 2
            }, 20);
        })(j);
    }
}, 50);
console.log();

console.log("=== Library Wrapper ===");

(function(window) {
    let MyLibrary = {
        version: "1.0.0",
        
        config: {
            apiUrl: "https://api.example.com",
            timeout: 5000
        },
        
        init: function(config) {
            Object.assign(this.config, config);
        },
        
        doSomething: function() {
            console.log("Doing something with", this.config.apiUrl);
        }
    };
    
    window.MyLibrary = MyLibrary;
})(window);

MyLibrary.doSomething();
MyLibrary.init({ apiUrl: "https://api.custom.com" });
MyLibrary.doSomething();
console.log();

console.log("=== Configuration Module ===");

let app = (function(config) {
    let settings = {
        apiUrl: config.apiUrl || "https://api.example.com",
        timeout: config.timeout || 5000,
        retries: config.retries || 3,
        debug: config.debug || false
    };
    
    return {
        getSetting: function(key) {
            return settings[key];
        },
        updateSetting: function(key, value) {
            if (settings.hasOwnProperty(key)) {
                settings[key] = value;
                console.log(`Updated ${key} to ${value}`);
            }
        },
        getAllSettings: function() {
            return { ...settings };  // Return copy
        }
    };
})({
    apiUrl: "https://api.custom.com",
    timeout: 10000,
    debug: true
});

console.log("API URL:", app.getSetting("apiUrl"));
console.log("Timeout:", app.getSetting("timeout"));
console.log("All settings:", app.getAllSettings());
app.updateSetting("timeout", 15000);
console.log("Updated timeout:", app.getSetting("timeout"));
console.log();

console.log("=== Multiple Modules ===");

let module1 = (function() {
    let private = "Module 1 private";
    return {
        public: "Module 1 public",
        getPrivate: function() {
            return private;
        }
    };
})();

let module2 = (function() {
    let private = "Module 2 private";
    return {
        public: "Module 2 public",
        getPrivate: function() {
            return private;
        }
    };
})();

console.log("Module 1:", module1.public, module1.getPrivate());
console.log("Module 2:", module2.public, module2.getPrivate());
// Each module has its own private scope
console.log();

console.log("=== Module with Dependencies ===");

let dependency = {
    doSomething: function() {
        return "Dependency did something";
    }
};

let dependentModule = (function(dep) {
    let result = dep.doSomething();
    
    return {
        getResult: function() {
            return result;
        },
        doMore: function() {
            return result + " and more";
        }
    };
})(dependency);

console.log("Dependent module:", dependentModule.getResult());
console.log("Do more:", dependentModule.doMore());
```

**Expected Output**:
```
=== Basic IIFE ===
I run immediately!
Hello, Alice!
Arrow function IIFE

=== Private Scope ===
Count: 1
Count: 2

=== Module Pattern ===
Calculator result: 27
After reset: 10

=== Revealing Module Pattern ===
Public function: I'm private but accessible
Public var: I'm public

=== Loop Variable Fix ===
Problem with var:
  var i: 3
  var i: 3
  var i: 3
Solution with IIFE:
  IIFE j: 0
  IIFE j: 1
  IIFE j: 2

=== Library Wrapper ===
Doing something with https://api.example.com
Doing something with https://api.custom.com

=== Configuration Module ===
API URL: https://api.custom.com
Timeout: 10000
All settings: { apiUrl: "https://api.custom.com", timeout: 10000, retries: 3, debug: true }
Updated timeout to 15000
Updated timeout: 15000

=== Multiple Modules ===
Module 1: Module 1 public Module 1 private
Module 2: Module 2 public Module 2 private

=== Module with Dependencies ===
Dependent module: Dependency did something
Do more: Dependency did something and more
```

**Challenge (Optional)**:
- Build a complete module system with IIFEs
- Create a plugin architecture
- Build a configuration management system
- Create reusable module patterns

---

## Common Mistakes

### 1. Missing Parentheses

```javascript
// ❌ Error: Function declaration, not expression
function() {
    console.log("Error");
}();

// ✅ Correct: Wrap in parentheses
(function() {
    console.log("Works");
})();
```

### 2. Semicolon Before IIFE

```javascript
// ⚠️ Problem: Missing semicolon can cause issues
var x = 5
(function() {
    console.log("IIFE");
})();

// ✅ Correct: Add semicolon
var x = 5;
(function() {
    console.log("IIFE");
})();
```

### 3. Forgetting Return Statement

```javascript
// ⚠️ Problem: Nothing returned
let module = (function() {
    let private = "private";
    // No return
})();
console.log(module);  // undefined

// ✅ Correct: Return public API
let module = (function() {
    let private = "private";
    return {
        public: "public"
    };
})();
```

### 4. Global Variable Leakage

```javascript
// ⚠️ Problem: Forgot var/let/const
(function() {
    count = 0;  // Creates global variable!
})();

// ✅ Correct: Use var/let/const
(function() {
    let count = 0;  // Private variable
})();
```

---

## Key Takeaways

1. **IIFE**: Immediately Invoked Function Expression
2. **Syntax**: `(function() { })()` or `(function() { }())`
3. **Private Scope**: Creates isolated scope
4. **Module Pattern**: Common use case for IIFEs
5. **Global Pollution**: Prevents polluting global namespace
6. **Loop Variables**: Fixes closure issues in loops
7. **Modern Alternative**: ES6 modules preferred in modern code
8. **Best Practice**: Use when you need immediate execution and private scope

---

## Quiz: IIFE

Test your understanding with these questions:

1. **What does IIFE stand for?**
   - A) Immediately Invoked Function Expression
   - B) Internal Invoked Function Expression
   - C) Instant Invoked Function Expression
   - D) Inline Invoked Function Expression

2. **IIFE creates:**
   - A) Global scope
   - B) Private scope
   - C) Block scope
   - D) No scope

3. **What's the correct IIFE syntax?**
   - A) `function() { }()`
   - B) `(function() { })()`
   - C) `function() { }()`
   - D) `(function() { }`

4. **Module pattern uses IIFE to:**
   - A) Create global variables
   - B) Create private and public APIs
   - C) Create functions
   - D) Nothing

5. **IIFE helps with:**
   - A) Global namespace pollution
   - B) Loop variable issues
   - C) Module creation
   - D) All of the above

6. **Modern alternative to IIFE:**
   - A) var
   - B) let/const
   - C) ES6 modules
   - D) Functions

7. **IIFE executes:**
   - A) When called
   - B) Immediately
   - C) Never
   - D) On load

**Answers**:
1. A) Immediately Invoked Function Expression
2. B) Private scope
3. B) `(function() { })()`
4. B) Create private and public APIs
5. D) All of the above
6. C) ES6 modules
7. B) Immediately

---

## Next Steps

Congratulations! You've learned IIFEs. You now know:
- What IIFEs are and how to use them
- Module pattern implementation
- How to avoid global pollution
- When to use IIFEs vs modern alternatives

**What's Next?**
- Lesson 8.3: Bind, Call, and Apply
- Practice creating modules
- Understand method binding
- Learn advanced function techniques

---

## Additional Resources

- **MDN: Functions**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Functions](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Functions)
- **JavaScript.info: Functions**: [javascript.info/function-basics](https://javascript.info/function-basics)
- **IIFE Pattern Guide**: Comprehensive examples

---

*Lesson completed! You're ready to move on to the next lesson.*

