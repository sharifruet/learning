# Lesson 18.1: Functional Programming Concepts

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand functional programming principles
- Write pure functions
- Work with immutability
- Identify and avoid side effects
- Understand first-class functions
- Apply functional programming concepts
- Write more predictable code

---

## Introduction to Functional Programming

Functional Programming (FP) is a programming paradigm that treats computation as the evaluation of mathematical functions and avoids changing state and mutable data.

### Why Functional Programming?

- **Predictability**: Same input always produces same output
- **Testability**: Easier to test pure functions
- **Maintainability**: Code is easier to understand and modify
- **Concurrency**: Easier to reason about parallel code
- **Debugging**: Fewer bugs due to immutability
- **Modern JavaScript**: Many features support FP

### Core Principles

1. **Pure Functions**: No side effects
2. **Immutability**: Don't modify data
3. **First-Class Functions**: Functions as values
4. **Higher-Order Functions**: Functions that operate on functions
5. **Function Composition**: Combine functions

---

## Pure Functions

### What are Pure Functions?

A pure function:
- Always returns the same output for the same input
- Has no side effects
- Doesn't depend on external state

### Pure Function Example

```javascript
// Pure function
function add(a, b) {
    return a + b;
}

// Always returns same output for same input
console.log(add(2, 3));  // 5
console.log(add(2, 3));  // 5 (always)
```

### Impure Function Example

```javascript
// Impure function (depends on external state)
let counter = 0;

function increment() {
    counter++;  // Side effect: modifies external state
    return counter;
}

console.log(increment());  // 1
console.log(increment());  // 2 (different output)
```

### More Pure Function Examples

```javascript
// Pure: No side effects
function multiply(x, y) {
    return x * y;
}

// Pure: Doesn't modify input
function square(x) {
    return x * x;
}

// Pure: Returns new array
function addItem(arr, item) {
    return [...arr, item];  // New array, doesn't modify original
}

// Impure: Modifies input
function addItemImpure(arr, item) {
    arr.push(item);  // Modifies original array
    return arr;
}
```

### Benefits of Pure Functions

```javascript
// Easy to test
function calculateTotal(items) {
    return items.reduce((sum, item) => sum + item.price, 0);
}

// Easy to reason about
let items = [{ price: 10 }, { price: 20 }];
let total = calculateTotal(items);  // Always 30 for this input

// Can be memoized
// Can be parallelized
// Easier to debug
```

---

## Immutability

### What is Immutability?

Immutability means data cannot be changed after creation. Instead, create new data.

### Mutable vs Immutable

```javascript
// Mutable (bad)
let user = { name: 'Alice', age: 30 };
user.age = 31;  // Modifies original

// Immutable (good)
let user = { name: 'Alice', age: 30 };
let updatedUser = { ...user, age: 31 };  // New object
```

### Immutable Arrays

```javascript
// Mutable (bad)
let numbers = [1, 2, 3];
numbers.push(4);  // Modifies original

// Immutable (good)
let numbers = [1, 2, 3];
let newNumbers = [...numbers, 4];  // New array
```

### Immutable Objects

```javascript
// Mutable (bad)
let user = { name: 'Alice', age: 30 };
user.age = 31;

// Immutable (good)
let user = { name: 'Alice', age: 30 };
let updatedUser = { ...user, age: 31 };

// Nested objects
let user = {
    name: 'Alice',
    address: { city: 'NYC', zip: '10001' }
};

// Immutable update
let updatedUser = {
    ...user,
    address: {
        ...user.address,
        zip: '10002'
    }
};
```

### Benefits of Immutability

```javascript
// Predictable
let original = [1, 2, 3];
let doubled = original.map(x => x * 2);
// original is still [1, 2, 3]

// Easier debugging
// Can track changes
// Better for React/Redux
```

---

## Side Effects

### What are Side Effects?

Side effects are changes to state outside the function:
- Modifying variables
- Console logging
- Network requests
- DOM manipulation
- File I/O

### Functions with Side Effects

```javascript
// Side effect: Modifies external variable
let count = 0;
function increment() {
    count++;  // Side effect
}

// Side effect: Console log
function logMessage(msg) {
    console.log(msg);  // Side effect
}

// Side effect: DOM manipulation
function updateDOM(element, text) {
    element.textContent = text;  // Side effect
}

// Side effect: Network request
async function fetchData() {
    let data = await fetch('/api/data');  // Side effect
    return data.json();
}
```

### Minimizing Side Effects

```javascript
// Separate pure logic from side effects
function calculateTotal(items) {
    // Pure function
    return items.reduce((sum, item) => sum + item.price, 0);
}

function displayTotal(total) {
    // Side effect isolated
    document.getElementById('total').textContent = total;
}

// Use together
let total = calculateTotal(items);
displayTotal(total);
```

### When Side Effects are Necessary

```javascript
// Side effects are sometimes necessary
// But isolate them and make them explicit

// Good: Isolated side effect
function saveUser(user) {
    // Side effect: Network request
    return fetch('/api/users', {
        method: 'POST',
        body: JSON.stringify(user)
    });
}

// Bad: Hidden side effects
function processUser(user) {
    user.id = generateId();  // Side effect: modifies input
    saveToDatabase(user);     // Side effect: hidden
    updateUI(user);           // Side effect: hidden
    return user;
}
```

---

## First-Class Functions

### What are First-Class Functions?

In JavaScript, functions are first-class citizens:
- Can be assigned to variables
- Can be passed as arguments
- Can be returned from functions
- Can be stored in data structures

### Functions as Values

```javascript
// Assign to variable
let greet = function(name) {
    return `Hello, ${name}!`;
};

// Arrow function
let greet = (name) => `Hello, ${name}!`);

// Use function
console.log(greet('Alice'));
```

### Functions as Arguments

```javascript
// Pass function as argument
function applyOperation(x, y, operation) {
    return operation(x, y);
}

let add = (a, b) => a + b;
let multiply = (a, b) => a * b;

console.log(applyOperation(5, 3, add));      // 8
console.log(applyOperation(5, 3, multiply)); // 15
```

### Functions as Return Values

```javascript
// Return function from function
function createMultiplier(factor) {
    return function(number) {
        return number * factor;
    };
}

let double = createMultiplier(2);
let triple = createMultiplier(3);

console.log(double(5));  // 10
console.log(triple(5));  // 15
```

### Functions in Data Structures

```javascript
// Store functions in array
let operations = [
    (x) => x * 2,
    (x) => x + 1,
    (x) => x * x
];

let result = 5;
operations.forEach(op => {
    result = op(result);
});
console.log(result);  // 121
```

---

## Higher-Order Functions

### What are Higher-Order Functions?

Higher-order functions are functions that:
- Take functions as arguments, or
- Return functions

### Examples

```javascript
// Higher-order function: takes function as argument
function map(array, fn) {
    let result = [];
    for (let item of array) {
        result.push(fn(item));
    }
    return result;
}

let numbers = [1, 2, 3];
let doubled = map(numbers, x => x * 2);
console.log(doubled);  // [2, 4, 6]

// Higher-order function: returns function
function createValidator(rule) {
    return function(value) {
        return rule(value);
    };
}

let isPositive = createValidator(x => x > 0);
console.log(isPositive(5));   // true
console.log(isPositive(-5));  // false
```

---

## Practical Examples

### Example 1: Pure Data Transformation

```javascript
// Pure function: Transform data
function formatUsers(users) {
    return users.map(user => ({
        name: user.name.toUpperCase(),
        age: user.age,
        isAdult: user.age >= 18
    }));
}

let users = [
    { name: 'Alice', age: 30 },
    { name: 'Bob', age: 15 }
];

let formatted = formatUsers(users);
// Original users unchanged
// formatted is new array
```

### Example 2: Immutable Updates

```javascript
// Immutable update function
function updateUser(users, userId, updates) {
    return users.map(user =>
        user.id === userId
            ? { ...user, ...updates }
            : user
    );
}

let users = [
    { id: 1, name: 'Alice', age: 30 },
    { id: 2, name: 'Bob', age: 25 }
];

let updated = updateUser(users, 1, { age: 31 });
// users unchanged
// updated has new user object
```

### Example 3: Function Composition

```javascript
// Compose functions
function compose(...fns) {
    return function(value) {
        return fns.reduceRight((acc, fn) => fn(acc), value);
    };
}

let addOne = x => x + 1;
let double = x => x * 2;
let square = x => x * x;

let transform = compose(square, double, addOne);
console.log(transform(5));  // ((5 + 1) * 2) ^ 2 = 144
```

---

## Practice Exercise

### Exercise: Functional Programming

**Objective**: Practice writing pure functions, working with immutability, and avoiding side effects.

**Instructions**:

1. Create a JavaScript file
2. Practice:
   - Writing pure functions
   - Working with immutability
   - Identifying side effects
   - Using first-class functions

**Example Solution**:

```javascript
// functional-programming-practice.js
console.log("=== Functional Programming Practice ===");

console.log("\n=== Pure Functions ===");

// Pure function: Always same output for same input
function add(a, b) {
    return a + b;
}

console.log('add(2, 3):', add(2, 3));  // 5
console.log('add(2, 3):', add(2, 3));  // 5 (always same)

// Pure function: No side effects
function multiply(x, y) {
    return x * y;
}

console.log('multiply(4, 5):', multiply(4, 5));  // 20

// Pure function: Returns new array
function addItem(arr, item) {
    return [...arr, item];
}

let numbers = [1, 2, 3];
let newNumbers = addItem(numbers, 4);
console.log('Original:', numbers);      // [1, 2, 3]
console.log('New:', newNumbers);        // [1, 2, 3, 4]
console.log();

console.log("=== Impure Functions (for comparison) ===");

// Impure: Depends on external state
let counter = 0;
function increment() {
    counter++;
    return counter;
}

console.log('increment():', increment());  // 1
console.log('increment():', increment());  // 2 (different)

// Impure: Modifies input
function addItemImpure(arr, item) {
    arr.push(item);
    return arr;
}

let arr1 = [1, 2, 3];
let arr2 = addItemImpure(arr1, 4);
console.log('arr1:', arr1);  // [1, 2, 3, 4] (modified!)
console.log('arr2:', arr2);  // [1, 2, 3, 4]
console.log();

console.log("=== Immutability ===");

// Immutable: Create new objects
let user = { name: 'Alice', age: 30 };
let updatedUser = { ...user, age: 31 };

console.log('Original user:', user);         // { name: 'Alice', age: 30 }
console.log('Updated user:', updatedUser);  // { name: 'Alice', age: 31 }

// Immutable: Create new arrays
let items = [1, 2, 3];
let newItems = [...items, 4];

console.log('Original items:', items);    // [1, 2, 3]
console.log('New items:', newItems);      // [1, 2, 3, 4]

// Immutable: Nested objects
let person = {
    name: 'Alice',
    address: { city: 'NYC', zip: '10001' }
};

let updatedPerson = {
    ...person,
    address: {
        ...person.address,
        zip: '10002'
    }
};

console.log('Original person:', person);
console.log('Updated person:', updatedPerson);
console.log();

console.log("=== Side Effects ===");

// Function with side effect
function logMessage(msg) {
    console.log('Logging:', msg);  // Side effect: console.log
}

logMessage('Hello');

// Function with side effect: DOM manipulation
function updateDOM(elementId, text) {
    // Side effect: DOM manipulation
    // (commented out for this example)
    // document.getElementById(elementId).textContent = text;
    console.log('Would update DOM:', elementId, text);
}

updateDOM('output', 'Hello World');

// Isolate side effects
function calculateTotal(items) {
    // Pure function
    return items.reduce((sum, item) => sum + item.price, 0);
}

function displayTotal(total) {
    // Side effect isolated
    console.log('Total:', total);
}

let cart = [
    { name: 'Apple', price: 1.00 },
    { name: 'Banana', price: 0.50 }
];

let total = calculateTotal(cart);
displayTotal(total);
console.log();

console.log("=== First-Class Functions ===");

// Functions as values
let greet = function(name) {
    return `Hello, ${name}!`;
};

console.log('greet("Alice"):', greet('Alice'));

// Arrow function
let add = (a, b) => a + b;
console.log('add(2, 3):', add(2, 3));

// Functions as arguments
function applyOperation(x, y, operation) {
    return operation(x, y);
}

let multiply = (a, b) => a * b;
console.log('applyOperation(5, 3, multiply):', applyOperation(5, 3, multiply));

// Functions as return values
function createMultiplier(factor) {
    return function(number) {
        return number * factor;
    };
}

let double = createMultiplier(2);
let triple = createMultiplier(3);

console.log('double(5):', double(5));   // 10
console.log('triple(5):', triple(5));  // 15

// Functions in data structures
let operations = [
    x => x * 2,
    x => x + 1,
    x => x * x
];

let result = 5;
operations.forEach(op => {
    result = op(result);
});
console.log('Result after operations:', result);
console.log();

console.log("=== Higher-Order Functions ===");

// Higher-order function: takes function as argument
function map(array, fn) {
    let result = [];
    for (let item of array) {
        result.push(fn(item));
    }
    return result;
}

let numbers = [1, 2, 3, 4, 5];
let doubled = map(numbers, x => x * 2);
console.log('Doubled:', doubled);  // [2, 4, 6, 8, 10]

// Higher-order function: returns function
function createValidator(rule) {
    return function(value) {
        return rule(value);
    };
}

let isPositive = createValidator(x => x > 0);
let isEven = createValidator(x => x % 2 === 0);

console.log('isPositive(5):', isPositive(5));   // true
console.log('isPositive(-5):', isPositive(-5)); // false
console.log('isEven(4):', isEven(4));            // true
console.log('isEven(5):', isEven(5));            // false
console.log();

console.log("=== Practical Examples ===");

// Pure data transformation
function formatUsers(users) {
    return users.map(user => ({
        name: user.name.toUpperCase(),
        age: user.age,
        isAdult: user.age >= 18
    }));
}

let users = [
    { name: 'Alice', age: 30 },
    { name: 'Bob', age: 15 },
    { name: 'Charlie', age: 25 }
];

let formatted = formatUsers(users);
console.log('Formatted users:', formatted);

// Immutable update
function updateUser(users, userId, updates) {
    return users.map(user =>
        user.id === userId
            ? { ...user, ...updates }
            : user
    );
}

let usersWithId = [
    { id: 1, name: 'Alice', age: 30 },
    { id: 2, name: 'Bob', age: 25 }
];

let updated = updateUser(usersWithId, 1, { age: 31 });
console.log('Original users:', usersWithId);
console.log('Updated users:', updated);

// Function composition
function compose(...fns) {
    return function(value) {
        return fns.reduceRight((acc, fn) => fn(acc), value);
    };
}

let addOne = x => x + 1;
let double = x => x * 2;
let square = x => x * x;

let transform = compose(square, double, addOne);
console.log('transform(5):', transform(5));  // ((5 + 1) * 2) ^ 2 = 144
console.log();

console.log("=== Benefits of Functional Programming ===");

// Easy to test
function calculateTotal(items) {
    return items.reduce((sum, item) => sum + item.price, 0);
}

let testItems = [
    { price: 10 },
    { price: 20 },
    { price: 30 }
];

let total = calculateTotal(testItems);
console.log('Total:', total);  // Always 60 for this input

// Predictable
let numbers2 = [1, 2, 3];
let doubled2 = numbers2.map(x => x * 2);
console.log('Original:', numbers2);  // [1, 2, 3] (unchanged)
console.log('Doubled:', doubled2);   // [2, 4, 6]
```

**Expected Output**:
```
=== Functional Programming Practice ===

=== Pure Functions ===
add(2, 3): 5
add(2, 3): 5
multiply(4, 5): 20
Original: [1, 2, 3]
New: [1, 2, 3, 4]

=== Impure Functions (for comparison) ===
increment(): 1
increment(): 2
arr1: [1, 2, 3, 4]
arr2: [1, 2, 3, 4]

=== Immutability ===
Original user: { name: 'Alice', age: 30 }
Updated user: { name: 'Alice', age: 31 }
Original items: [1, 2, 3]
New items: [1, 2, 3, 4]

=== Side Effects ===
Logging: Hello
Would update DOM: output Hello World
Total: 1.5

=== First-Class Functions ===
greet("Alice"): Hello, Alice!
add(2, 3): 5
applyOperation(5, 3, multiply): 15
double(5): 10
triple(5): 15
Result after operations: 121

=== Higher-Order Functions ===
Doubled: [2, 4, 6, 8, 10]
isPositive(5): true
isPositive(-5): false
isEven(4): true
isEven(5): false

=== Practical Examples ===
Formatted users: [array]
Original users: [array]
Updated users: [array]
transform(5): 144

=== Benefits of Functional Programming ===
Total: 60
Original: [1, 2, 3]
Doubled: [2, 4, 6]
```

**Challenge (Optional)**:
- Refactor existing code to be more functional
- Build a functional programming library
- Create immutable data structures
- Practice function composition

---

## Common Mistakes

### 1. Modifying Input Parameters

```javascript
// ⚠️ Problem: Modifies input
function addItem(arr, item) {
    arr.push(item);
    return arr;
}

// ✅ Solution: Return new array
function addItem(arr, item) {
    return [...arr, item];
}
```

### 2. Using External State

```javascript
// ⚠️ Problem: Depends on external state
let multiplier = 2;
function multiply(x) {
    return x * multiplier;  // Depends on external state
}

// ✅ Solution: Pass as parameter
function multiply(x, multiplier) {
    return x * multiplier;
}
```

### 3. Mixing Side Effects with Logic

```javascript
// ⚠️ Problem: Side effects mixed with logic
function processUser(user) {
    user.id = generateId();  // Side effect
    saveToDB(user);           // Side effect
    return user;
}

// ✅ Solution: Separate concerns
function processUser(user) {
    return { ...user, id: generateId() };
}

let processed = processUser(user);
saveToDB(processed);
```

---

## Key Takeaways

1. **Pure Functions**: Same input → same output, no side effects
2. **Immutability**: Don't modify data, create new data
3. **Side Effects**: Isolate and minimize
4. **First-Class Functions**: Functions are values
5. **Higher-Order Functions**: Functions that work with functions
6. **Benefits**: Predictable, testable, maintainable code
7. **Best Practice**: Prefer pure functions, use immutability, isolate side effects

---

## Quiz: Functional Programming Basics

Test your understanding with these questions:

1. **Pure function:**
   - A) Always same output
   - B) Can have side effects
   - C) Modifies input
   - D) Uses global variables

2. **Immutability means:**
   - A) Can modify data
   - B) Create new data
   - C) Delete data
   - D) Nothing

3. **Side effects include:**
   - A) Return values
   - B) Console.log, DOM, network
   - C) Calculations
   - D) Nothing

4. **First-class functions:**
   - A) Can be values
   - B) Can be arguments
   - C) Can be returned
   - D) All of the above

5. **Higher-order function:**
   - A) Takes function as argument
   - B) Returns function
   - C) Both
   - D) Neither

6. **Pure function benefits:**
   - A) Testable
   - B) Predictable
   - C) Both
   - D) Neither

7. **Immutability helps:**
   - A) Debugging
   - B) Predictability
   - C) Both
   - D) Neither

**Answers**:
1. A) Always same output
2. B) Create new data
3. B) Console.log, DOM, network
4. D) All of the above
5. C) Both
6. C) Both
7. C) Both

---

## Next Steps

Congratulations! You've learned functional programming concepts. You now know:
- What pure functions are
- How to work with immutability
- How to identify side effects
- How to use first-class functions

**What's Next?**
- Lesson 18.2: Array Methods for Functional Programming
- Learn map, filter, reduce
- Work with functional array methods
- Build functional data pipelines

---

## Additional Resources

- **MDN: Functional Programming**: [developer.mozilla.org/en-US/docs/Glossary/Functional_programming](https://developer.mozilla.org/en-US/docs/Glossary/Functional_programming)
- **JavaScript.info: Functional Programming**: [javascript.info/functional-programming](https://javascript.info/functional-programming)

---

*Lesson completed! You're ready to move on to the next lesson.*

