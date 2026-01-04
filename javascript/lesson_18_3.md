# Lesson 18.3: Advanced Functional Patterns

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand function composition
- Implement currying
- Use memoization for performance
- Build higher-order functions
- Combine functional patterns
- Write more reusable code
- Optimize function performance

---

## Introduction to Advanced Functional Patterns

Advanced functional patterns help you write more elegant, reusable, and performant code.

### Why Advanced Patterns?

- **Reusability**: Write functions that work in many contexts
- **Composability**: Combine small functions into larger ones
- **Performance**: Optimize with memoization
- **Readability**: More declarative code
- **Maintainability**: Easier to modify and extend
- **Modern JavaScript**: Common in modern codebases

---

## Function Composition

### What is Function Composition?

Function composition combines multiple functions into a single function.

### Basic Composition

```javascript
// Compose functions: f(g(x))
function compose(f, g) {
    return function(x) {
        return f(g(x));
    };
}

// Example
let addOne = x => x + 1;
let double = x => x * 2;

let addOneThenDouble = compose(double, addOne);
console.log(addOneThenDouble(5));  // (5 + 1) * 2 = 12
```

### Multiple Functions

```javascript
// Compose multiple functions
function compose(...fns) {
    return function(value) {
        return fns.reduceRight((acc, fn) => fn(acc), value);
    };
}

// Example
let addOne = x => x + 1;
let double = x => x * 2;
let square = x => x * x;

let transform = compose(square, double, addOne);
console.log(transform(5));  // ((5 + 1) * 2) ^ 2 = 144
```

### Pipe (Left to Right)

```javascript
// Pipe: Apply functions left to right
function pipe(...fns) {
    return function(value) {
        return fns.reduce((acc, fn) => fn(acc), value);
    };
}

// Example
let addOne = x => x + 1;
let double = x => x * 2;
let square = x => x * x;

let transform = pipe(addOne, double, square);
console.log(transform(5));  // ((5 + 1) * 2) ^ 2 = 144
```

### Practical Composition Example

```javascript
// Helper functions
let trim = str => str.trim();
let toLowerCase = str => str.toLowerCase();
let capitalize = str => str.charAt(0).toUpperCase() + str.slice(1);

// Compose
let normalizeName = pipe(trim, toLowerCase, capitalize);

console.log(normalizeName('  ALICE  '));  // 'Alice'
```

---

## Currying

### What is Currying?

Currying transforms a function with multiple arguments into a sequence of functions, each taking one argument.

### Basic Currying

```javascript
// Regular function
function add(a, b) {
    return a + b;
}

// Curried function
function addCurried(a) {
    return function(b) {
        return a + b;
    };
}

// Usage
let add5 = addCurried(5);
console.log(add5(3));  // 8
```

### Arrow Function Currying

```javascript
// Curried with arrow functions
let add = a => b => a + b;

// Usage
let add5 = add(5);
console.log(add5(3));  // 8

// Or call directly
console.log(add(5)(3));  // 8
```

### Multiple Arguments

```javascript
// Curry function with multiple arguments
function curry(fn) {
    return function curried(...args) {
        if (args.length >= fn.length) {
            return fn.apply(this, args);
        } else {
            return function(...nextArgs) {
                return curried.apply(this, args.concat(nextArgs));
            };
        }
    };
}

// Example
function multiply(a, b, c) {
    return a * b * c;
}

let curriedMultiply = curry(multiply);

console.log(curriedMultiply(2)(3)(4));     // 24
console.log(curriedMultiply(2, 3)(4));     // 24
console.log(curriedMultiply(2)(3, 4));     // 24
console.log(curriedMultiply(2, 3, 4));     // 24
```

### Practical Currying Example

```javascript
// Curried filter
let filter = predicate => array => array.filter(predicate);

let isEven = x => x % 2 === 0;
let filterEven = filter(isEven);

let numbers = [1, 2, 3, 4, 5, 6];
console.log(filterEven(numbers));  // [2, 4, 6]

// Curried map
let map = fn => array => array.map(fn);

let double = x => x * 2;
let mapDouble = map(double);

console.log(mapDouble(numbers));  // [2, 4, 6, 8, 10, 12]
```

---

## Memoization

### What is Memoization?

Memoization caches function results to avoid recomputation.

### Basic Memoization

```javascript
// Simple memoization
function memoize(fn) {
    let cache = {};
    return function(...args) {
        let key = JSON.stringify(args);
        if (cache[key]) {
            return cache[key];
        }
        let result = fn.apply(this, args);
        cache[key] = result;
        return result;
    };
}

// Example: Fibonacci
function fibonacci(n) {
    if (n <= 1) return n;
    return fibonacci(n - 1) + fibonacci(n - 2);
}

let memoizedFibonacci = memoize(fibonacci);
console.log(memoizedFibonacci(40));  // Fast!
```

### Memoization with Map

```javascript
// Memoization with Map (better for object keys)
function memoize(fn) {
    let cache = new Map();
    return function(...args) {
        let key = JSON.stringify(args);
        if (cache.has(key)) {
            return cache.get(key);
        }
        let result = fn.apply(this, args);
        cache.set(key, result);
        return result;
    };
}
```

### Memoization Example

```javascript
// Expensive calculation
function expensiveOperation(n) {
    console.log('Calculating...', n);
    // Simulate expensive operation
    let result = 0;
    for (let i = 0; i < n * 1000000; i++) {
        result += i;
    }
    return result;
}

let memoized = memoize(expensiveOperation);

console.log(memoized(10));  // Calculates
console.log(memoized(10));  // Uses cache (fast!)
```

---

## Higher-Order Functions

### What are Higher-Order Functions?

Higher-order functions are functions that operate on other functions.

### Function that Takes Function

```javascript
// Higher-order function: takes function as argument
function withLogging(fn) {
    return function(...args) {
        console.log('Calling function with:', args);
        let result = fn.apply(this, args);
        console.log('Result:', result);
        return result;
    };
}

// Usage
let add = (a, b) => a + b;
let loggedAdd = withLogging(add);

loggedAdd(2, 3);
// Calling function with: [2, 3]
// Result: 5
```

### Function that Returns Function

```javascript
// Higher-order function: returns function
function createMultiplier(factor) {
    return function(number) {
        return number * factor;
    };
}

let double = createMultiplier(2);
let triple = createMultiplier(3);

console.log(double(5));   // 10
console.log(triple(5));   // 15
```

### Advanced Higher-Order Functions

```javascript
// Retry function
function retry(fn, times = 3) {
    return async function(...args) {
        for (let i = 0; i < times; i++) {
            try {
                return await fn.apply(this, args);
            } catch (error) {
                if (i === times - 1) throw error;
                console.log(`Retry ${i + 1}/${times}`);
            }
        }
    };
}

// Debounce
function debounce(fn, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            fn.apply(this, args);
        }, delay);
    };
}

// Throttle
function throttle(fn, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            fn.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}
```

---

## Combining Patterns

### Composition + Currying

```javascript
// Curried functions
let add = a => b => a + b;
let multiply = a => b => a * b;

// Compose curried functions
let addThenMultiply = pipe(
    add(5),
    multiply(2)
);

console.log(addThenMultiply(3));  // (3 + 5) * 2 = 16
```

### Memoization + Composition

```javascript
// Compose functions
let addOne = x => x + 1;
let double = x => x * 2;
let square = x => x * x;

let transform = pipe(addOne, double, square);

// Memoize the composition
let memoizedTransform = memoize(transform);

console.log(memoizedTransform(5));  // Calculates
console.log(memoizedTransform(5));  // Uses cache
```

### Higher-Order + Currying

```javascript
// Curried higher-order function
let map = fn => array => array.map(fn);
let filter = predicate => array => array.filter(predicate);

// Compose curried functions
let process = pipe(
    filter(x => x > 5),
    map(x => x * 2)
);

let numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
console.log(process(numbers));  // [12, 14, 16, 18, 20]
```

---

## Practical Examples

### Example 1: Data Processing Pipeline

```javascript
// Helper functions
let trim = str => str.trim();
let toLowerCase = str => str.toLowerCase();
let capitalize = str => str.charAt(0).toUpperCase() + str.slice(1);
let removeSpecial = str => str.replace(/[^a-z0-9\s]/gi, '');

// Compose
let normalize = pipe(trim, toLowerCase, removeSpecial, capitalize);

let names = ['  ALICE!  ', '  bob@example  ', '  Charlie123  '];
let normalized = names.map(normalize);
console.log(normalized);  // ['Alice', 'Bobexample', 'Charlie123']
```

### Example 2: API Request Builder

```javascript
// Curried API builder
let apiRequest = method => url => data => {
    return fetch(url, {
        method: method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
};

// Create specific request functions
let get = apiRequest('GET');
let post = apiRequest('POST');
let put = apiRequest('PUT');

// Use
let getUser = get('/api/users');
let createUser = post('/api/users');
```

### Example 3: Validation Pipeline

```javascript
// Validators
let isRequired = value => value !== null && value !== undefined && value !== '';
let minLength = length => value => value.length >= length;
let isEmail = value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

// Combine validators
function validate(...validators) {
    return function(value) {
        return validators.every(validator => validator(value));
    };
}

// Create validators
let validateEmail = validate(isRequired, isEmail);
let validatePassword = validate(isRequired, minLength(8));

console.log(validateEmail('alice@example.com'));  // true
console.log(validatePassword('password123'));     // true
```

---

## Practice Exercise

### Exercise: Advanced Functional Patterns

**Objective**: Practice function composition, currying, memoization, and higher-order functions.

**Instructions**:

1. Create a JavaScript file
2. Practice:
   - Composing functions
   - Creating curried functions
   - Implementing memoization
   - Building higher-order functions
   - Combining patterns

**Example Solution**:

```javascript
// advanced-functional-patterns-practice.js
console.log("=== Advanced Functional Patterns Practice ===");

console.log("\n=== Function Composition ===");

// Basic composition
function compose(f, g) {
    return function(x) {
        return f(g(x));
    };
}

let addOne = x => x + 1;
let double = x => x * 2;

let addOneThenDouble = compose(double, addOne);
console.log('addOneThenDouble(5):', addOneThenDouble(5));  // 12

// Multiple functions
function compose(...fns) {
    return function(value) {
        return fns.reduceRight((acc, fn) => fn(acc), value);
    };
}

let addOne = x => x + 1;
let double = x => x * 2;
let square = x => x * x;

let transform = compose(square, double, addOne);
console.log('transform(5):', transform(5));  // 144

// Pipe (left to right)
function pipe(...fns) {
    return function(value) {
        return fns.reduce((acc, fn) => fn(acc), value);
    };
}

let transform2 = pipe(addOne, double, square);
console.log('transform2(5):', transform2(5));  // 144

// Practical: String normalization
let trim = str => str.trim();
let toLowerCase = str => str.toLowerCase();
let capitalize = str => str.charAt(0).toUpperCase() + str.slice(1);

let normalizeName = pipe(trim, toLowerCase, capitalize);
console.log('normalizeName("  ALICE  "):', normalizeName('  ALICE  '));  // 'Alice'
console.log();

console.log("=== Currying ===");

// Basic currying
function addCurried(a) {
    return function(b) {
        return a + b;
    };
}

let add5 = addCurried(5);
console.log('add5(3):', add5(3));  // 8

// Arrow function currying
let add = a => b => a + b;
let add10 = add(10);
console.log('add10(5):', add10(5));  // 15

// Generic curry function
function curry(fn) {
    return function curried(...args) {
        if (args.length >= fn.length) {
            return fn.apply(this, args);
        } else {
            return function(...nextArgs) {
                return curried.apply(this, args.concat(nextArgs));
            };
        }
    };
}

function multiply(a, b, c) {
    return a * b * c;
}

let curriedMultiply = curry(multiply);
console.log('curriedMultiply(2)(3)(4):', curriedMultiply(2)(3)(4));     // 24
console.log('curriedMultiply(2, 3)(4):', curriedMultiply(2, 3)(4));     // 24
console.log('curriedMultiply(2)(3, 4):', curriedMultiply(2)(3, 4));     // 24

// Practical: Curried array methods
let filter = predicate => array => array.filter(predicate);
let map = fn => array => array.map(fn);

let isEven = x => x % 2 === 0;
let filterEven = filter(isEven);
let double = x => x * 2;
let mapDouble = map(double);

let numbers = [1, 2, 3, 4, 5, 6];
console.log('filterEven(numbers):', filterEven(numbers));  // [2, 4, 6]
console.log('mapDouble(numbers):', mapDouble(numbers));    // [2, 4, 6, 8, 10, 12]
console.log();

console.log("=== Memoization ===");

// Basic memoization
function memoize(fn) {
    let cache = {};
    return function(...args) {
        let key = JSON.stringify(args);
        if (cache[key]) {
            console.log('Cache hit for:', key);
            return cache[key];
        }
        console.log('Cache miss, calculating...');
        let result = fn.apply(this, args);
        cache[key] = result;
        return result;
    };
}

// Expensive function
function expensiveOperation(n) {
    let result = 0;
    for (let i = 0; i < n * 1000000; i++) {
        result += i;
    }
    return result;
}

let memoized = memoize(expensiveOperation);
console.log('memoized(10):', memoized(10));  // Calculates
console.log('memoized(10):', memoized(10));  // Uses cache

// Fibonacci with memoization
function fibonacci(n) {
    if (n <= 1) return n;
    return fibonacci(n - 1) + fibonacci(n - 2);
}

let memoizedFib = memoize(fibonacci);
console.log('memoizedFib(40):', memoizedFib(40));  // Fast with memoization
console.log();

console.log("=== Higher-Order Functions ===");

// Function that takes function
function withLogging(fn) {
    return function(...args) {
        console.log('Calling function with:', args);
        let result = fn.apply(this, args);
        console.log('Result:', result);
        return result;
    };
}

let add = (a, b) => a + b;
let loggedAdd = withLogging(add);
loggedAdd(2, 3);

// Function that returns function
function createMultiplier(factor) {
    return function(number) {
        return number * factor;
    };
}

let double = createMultiplier(2);
let triple = createMultiplier(3);
console.log('double(5):', double(5));   // 10
console.log('triple(5):', triple(5));   // 15

// Retry function
function retry(fn, times = 3) {
    return async function(...args) {
        for (let i = 0; i < times; i++) {
            try {
                return await fn.apply(this, args);
            } catch (error) {
                if (i === times - 1) throw error;
                console.log(`Retry ${i + 1}/${times}`);
            }
        }
    };
}

// Debounce
function debounce(fn, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            fn.apply(this, args);
        }, delay);
    };
}

// Throttle
function throttle(fn, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            fn.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}
console.log();

console.log("=== Combining Patterns ===");

// Composition + Currying
let add = a => b => a + b;
let multiply = a => b => a * b;

let addThenMultiply = pipe(
    add(5),
    multiply(2)
);
console.log('addThenMultiply(3):', addThenMultiply(3));  // 16

// Memoization + Composition
let addOne = x => x + 1;
let double = x => x * 2;
let square = x => x * x;

let transform = pipe(addOne, double, square);
let memoizedTransform = memoize(transform);

console.log('memoizedTransform(5):', memoizedTransform(5));  // Calculates
console.log('memoizedTransform(5):', memoizedTransform(5));  // Uses cache

// Higher-Order + Currying
let map = fn => array => array.map(fn);
let filter = predicate => array => array.filter(predicate);

let process = pipe(
    filter(x => x > 5),
    map(x => x * 2)
);

let numbers2 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
console.log('process(numbers2):', process(numbers2));  // [12, 14, 16, 18, 20]
console.log();

console.log("=== Practical Examples ===");

// Example 1: Data Processing Pipeline
let trim = str => str.trim();
let toLowerCase = str => str.toLowerCase();
let capitalize = str => str.charAt(0).toUpperCase() + str.slice(1);
let removeSpecial = str => str.replace(/[^a-z0-9\s]/gi, '');

let normalize = pipe(trim, toLowerCase, removeSpecial, capitalize);

let names = ['  ALICE!  ', '  bob@example  ', '  Charlie123  '];
let normalized = names.map(normalize);
console.log('Normalized names:', normalized);

// Example 2: Validation Pipeline
let isRequired = value => value !== null && value !== undefined && value !== '';
let minLength = length => value => value.length >= length;
let isEmail = value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

function validate(...validators) {
    return function(value) {
        return validators.every(validator => validator(value));
    };
}

let validateEmail = validate(isRequired, isEmail);
let validatePassword = validate(isRequired, minLength(8));

console.log('validateEmail("alice@example.com"):', validateEmail('alice@example.com'));  // true
console.log('validatePassword("password123"):', validatePassword('password123'));          // true
```

**Expected Output**:
```
=== Advanced Functional Patterns Practice ===

=== Function Composition ===
addOneThenDouble(5): 12
transform(5): 144
transform2(5): 144
normalizeName("  ALICE  "): Alice

=== Currying ===
add5(3): 8
add10(5): 15
curriedMultiply(2)(3)(4): 24
curriedMultiply(2, 3)(4): 24
curriedMultiply(2)(3, 4): 24
filterEven(numbers): [2, 4, 6]
mapDouble(numbers): [2, 4, 6, 8, 10, 12]

=== Memoization ===
Cache miss, calculating...
memoized(10): [result]
Cache hit for: [10]
memoized(10): [result]
memoizedFib(40): [result]

=== Higher-Order Functions ===
Calling function with: [2, 3]
Result: 5
double(5): 10
triple(5): 15

=== Combining Patterns ===
addThenMultiply(3): 16
memoizedTransform(5): [result]
memoizedTransform(5): [result]
process(numbers2): [12, 14, 16, 18, 20]

=== Practical Examples ===
Normalized names: ['Alice', 'Bobexample', 'Charlie123']
validateEmail("alice@example.com"): true
validatePassword("password123"): true
```

**Challenge (Optional)**:
- Build a complete functional programming library
- Create reusable composition utilities
- Build a validation framework
- Practice combining all patterns

---

## Common Mistakes

### 1. Wrong Composition Order

```javascript
// ⚠️ Problem: Wrong order
let result = compose(addOne, double)(5);  // (5 * 2) + 1 = 11

// ✅ Solution: Understand order
let result = compose(double, addOne)(5);  // (5 + 1) * 2 = 12
```

### 2. Not Handling Arguments in Curry

```javascript
// ⚠️ Problem: Doesn't handle partial application
function curry(fn) {
    return function(a) {
        return function(b) {
            return fn(a, b);
        };
    };
}

// ✅ Solution: Handle any number of arguments
function curry(fn) {
    return function curried(...args) {
        if (args.length >= fn.length) {
            return fn.apply(this, args);
        } else {
            return function(...nextArgs) {
                return curried.apply(this, args.concat(nextArgs));
            };
        }
    };
}
```

### 3. Memoization with Non-Serializable Keys

```javascript
// ⚠️ Problem: Objects can't be stringified properly
function memoize(fn) {
    let cache = {};
    return function(...args) {
        let key = JSON.stringify(args);  // Might fail with functions
        // ...
    };
}

// ✅ Solution: Use Map or better key generation
function memoize(fn) {
    let cache = new Map();
    return function(...args) {
        let key = JSON.stringify(args);
        // Or use a better key generation strategy
    };
}
```

---

## Key Takeaways

1. **Function Composition**: Combine functions into pipelines
2. **Currying**: Transform multi-argument functions
3. **Memoization**: Cache results for performance
4. **Higher-Order Functions**: Functions that work with functions
5. **Combining Patterns**: Use patterns together for power
6. **Best Practice**: Start simple, compose for complexity
7. **Performance**: Memoization can significantly improve performance

---

## Quiz: Advanced Functional Programming

Test your understanding with these questions:

1. **Function composition:**
   - A) Combines functions
   - B) Separates functions
   - C) Deletes functions
   - D) Nothing

2. **Currying transforms:**
   - A) One argument to many
   - B) Many arguments to one
   - C) Functions to values
   - D) Nothing

3. **Memoization:**
   - A) Caches results
   - B) Deletes results
   - C) Modifies results
   - D) Nothing

4. **Higher-order function:**
   - A) Takes function as argument
   - B) Returns function
   - C) Both
   - D) Neither

5. **compose applies functions:**
   - A) Left to right
   - B) Right to left
   - C) Random
   - D) Never

6. **pipe applies functions:**
   - A) Left to right
   - B) Right to left
   - C) Random
   - D) Never

7. **Memoization helps:**
   - A) Performance
   - B) Readability
   - C) Both
   - D) Neither

**Answers**:
1. A) Combines functions
2. B) Many arguments to one
3. A) Caches results
4. C) Both
5. B) Right to left
6. A) Left to right
7. A) Performance

---

## Next Steps

Congratulations! You've completed Module 18: Functional Programming. You now know:
- Functional programming concepts
- Array methods for FP
- Advanced functional patterns
- Function composition, currying, memoization

**What's Next?**
- Module 19: Design Patterns
- Lesson 19.1: Creational Patterns
- Learn design patterns
- Build reusable solutions

---

## Additional Resources

- **MDN: Functions**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Functions](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Functions)
- **JavaScript.info: Advanced Functions**: [javascript.info/advanced-functions](https://javascript.info/advanced-functions)

---

*Lesson completed! You've finished Module 18: Functional Programming. Ready for Module 19: Design Patterns!*

