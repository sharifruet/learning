# Lesson 4.3: Advanced Function Concepts

## Learning Objectives

By the end of this lesson, you will be able to:
- Use default parameters in functions
- Work with rest parameters (...)
- Use the spread operator effectively
- Understand and create higher-order functions
- Use callback functions
- Combine these concepts in practical scenarios

---

## Introduction

Advanced function concepts make JavaScript functions more powerful and flexible. These features (mostly from ES6+) enable:
- More flexible function signatures
- Better handling of variable arguments
- Functional programming patterns
- Cleaner, more expressive code

---

## Default Parameters

Default parameters allow you to set default values for function parameters if no argument is provided.

### Basic Syntax

```javascript
function functionName(param1 = defaultValue1, param2 = defaultValue2) {
    // Function body
}
```

### Simple Example

```javascript
function greet(name = "Guest") {
    console.log(`Hello, ${name}!`);
}

greet("Alice");  // "Hello, Alice!"
greet();         // "Hello, Guest!"
```

### Multiple Default Parameters

```javascript
function createUser(name = "Anonymous", age = 0, city = "Unknown") {
    return {
        name: name,
        age: age,
        city: city
    };
}

console.log(createUser());                    // All defaults
console.log(createUser("Alice"));             // name only
console.log(createUser("Alice", 25));         // name and age
console.log(createUser("Alice", 25, "NYC"));  // All provided
```

### Default with Expressions

Default values can be expressions:

```javascript
function calculateTotal(price, quantity = 1, tax = price * 0.1) {
    return price * quantity + tax;
}

console.log(calculateTotal(100));      // 100 + 10 = 110
console.log(calculateTotal(100, 2));   // 200 + 10 = 210
```

### Default with Function Calls

```javascript
function getDefaultName() {
    return "Guest";
}

function greet(name = getDefaultName()) {
    console.log(`Hello, ${name}!`);
}

greet();           // "Hello, Guest!"
greet("Alice");    // "Hello, Alice!"
```

### Skipping Parameters

You can skip parameters by passing `undefined`:

```javascript
function greet(greeting = "Hello", name = "Guest") {
    console.log(`${greeting}, ${name}!`);
}

greet("Hi", "Alice");        // "Hi, Alice!"
greet(undefined, "Alice");   // "Hello, Alice!" (uses default for greeting)
greet("Hi");                 // "Hi, Guest!" (uses default for name)
```

### Practical Examples

```javascript
// Configuration with defaults
function createConfig(host = "localhost", port = 3000, ssl = false) {
    return {
        host: host,
        port: port,
        ssl: ssl
    };
}

// Math function with default
function power(base, exponent = 2) {
    return base ** exponent;
}

console.log(power(5));    // 25 (5^2)
console.log(power(5, 3)); // 125 (5^3)
```

---

## Rest Parameters (...)

Rest parameters allow you to represent an indefinite number of arguments as an array.

### Basic Syntax

```javascript
function functionName(...restParams) {
    // restParams is an array
}
```

### Simple Example

```javascript
function sum(...numbers) {
    let total = 0;
    for (let num of numbers) {
        total += num;
    }
    return total;
}

console.log(sum(1, 2, 3));        // 6
console.log(sum(1, 2, 3, 4, 5));  // 15
console.log(sum());                // 0
```

### Rest Must Be Last

Rest parameter must be the last parameter:

```javascript
// ✅ Correct
function example(a, b, ...rest) {
    console.log(a, b, rest);
}

// ❌ Error
// function example(...rest, a) { }
```

### Combining Regular and Rest Parameters

```javascript
function introduce(firstName, lastName, ...hobbies) {
    console.log(`Name: ${firstName} ${lastName}`);
    console.log(`Hobbies: ${hobbies.join(", ")}`);
}

introduce("Alice", "Smith", "reading", "coding", "traveling");
// Name: Alice Smith
// Hobbies: reading, coding, traveling
```

### Rest vs Arguments Object

**Rest parameters (modern):**
```javascript
function sum(...numbers) {
    return numbers.reduce((a, b) => a + b, 0);
}
```

**Arguments object (legacy):**
```javascript
function sum() {
    let total = 0;
    for (let i = 0; i < arguments.length; i++) {
        total += arguments[i];
    }
    return total;
}
```

**Benefits of rest parameters:**
- Real array (can use array methods)
- Clearer intent
- Works with arrow functions

### Practical Examples

```javascript
// Find maximum
function max(...numbers) {
    return Math.max(...numbers);
}

console.log(max(1, 5, 3, 9, 2));  // 9

// Collect all arguments
function logAll(...args) {
    args.forEach((arg, index) => {
        console.log(`Argument ${index}:`, arg);
    });
}

logAll("a", "b", "c");
```

---

## Spread Operator (...)

The spread operator expands an iterable (array, string) into individual elements.

### Basic Syntax

```javascript
...iterable
```

### Spreading Arrays

```javascript
let arr1 = [1, 2, 3];
let arr2 = [4, 5, 6];
let combined = [...arr1, ...arr2];
console.log(combined);  // [1, 2, 3, 4, 5, 6]
```

### Function Arguments

Spread array elements as function arguments:

```javascript
function add(a, b, c) {
    return a + b + c;
}

let numbers = [1, 2, 3];
console.log(add(...numbers));  // 6
// Equivalent to: add(1, 2, 3)
```

### Copying Arrays

```javascript
let original = [1, 2, 3];
let copy = [...original];
copy.push(4);
console.log(original);  // [1, 2, 3] (unchanged)
console.log(copy);       // [1, 2, 3, 4]
```

### Combining Arrays

```javascript
let arr1 = [1, 2];
let arr2 = [3, 4];
let arr3 = [5, 6];

let combined = [...arr1, ...arr2, ...arr3];
console.log(combined);  // [1, 2, 3, 4, 5, 6]
```

### Spreading Objects (ES2018)

```javascript
let obj1 = { a: 1, b: 2 };
let obj2 = { c: 3, d: 4 };
let combined = { ...obj1, ...obj2 };
console.log(combined);  // { a: 1, b: 2, c: 3, d: 4 }
```

### Spreading Strings

```javascript
let str = "Hello";
let chars = [...str];
console.log(chars);  // ["H", "e", "l", "l", "o"]
```

### Practical Examples

```javascript
// Math operations
let numbers = [1, 5, 3, 9, 2];
console.log(Math.max(...numbers));  // 9
console.log(Math.min(...numbers));  // 1

// Array methods
let arr1 = [1, 2, 3];
let arr2 = [4, 5, 6];
let all = [...arr1, ...arr2, 7, 8, 9];
console.log(all);  // [1, 2, 3, 4, 5, 6, 7, 8, 9]

// Function calls
function greet(greeting, name) {
    console.log(`${greeting}, ${name}!`);
}

let args = ["Hello", "Alice"];
greet(...args);  // "Hello, Alice!"
```

### Rest vs Spread

**Rest** (collects into array):
```javascript
function collect(...items) {
    console.log(items);  // Array
}
collect(1, 2, 3);  // [1, 2, 3]
```

**Spread** (expands array):
```javascript
let arr = [1, 2, 3];
console.log(...arr);  // 1 2 3 (individual elements)
```

---

## Higher-Order Functions

Higher-order functions are functions that:
- Take other functions as arguments, or
- Return functions as results

### Functions as Arguments

```javascript
function operate(a, b, operation) {
    return operation(a, b);
}

function add(x, y) {
    return x + y;
}

function multiply(x, y) {
    return x * y;
}

console.log(operate(5, 3, add));        // 8
console.log(operate(5, 3, multiply));   // 15
```

### Functions as Return Values

```javascript
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

### Arrow Function Version

```javascript
function createMultiplier(factor) {
    return (number) => number * factor;
}

let double = createMultiplier(2);
console.log(double(5));  // 10
```

### Built-in Higher-Order Functions

JavaScript has many built-in higher-order functions:

**Array.map():**
```javascript
let numbers = [1, 2, 3, 4, 5];
let doubled = numbers.map(num => num * 2);
console.log(doubled);  // [2, 4, 6, 8, 10]
```

**Array.filter():**
```javascript
let numbers = [1, 2, 3, 4, 5, 6];
let evens = numbers.filter(num => num % 2 === 0);
console.log(evens);  // [2, 4, 6]
```

**Array.reduce():**
```javascript
let numbers = [1, 2, 3, 4, 5];
let sum = numbers.reduce((acc, num) => acc + num, 0);
console.log(sum);  // 15
```

### Custom Higher-Order Functions

```javascript
// Function that takes a function and calls it multiple times
function repeat(times, fn) {
    for (let i = 0; i < times; i++) {
        fn(i);
    }
}

repeat(3, (index) => {
    console.log(`Iteration ${index}`);
});
// Iteration 0
// Iteration 1
// Iteration 2
```

### Practical Example: Calculator

```javascript
function calculator(operation) {
    return function(a, b) {
        return operation(a, b);
    };
}

let add = calculator((a, b) => a + b);
let subtract = calculator((a, b) => a - b);
let multiply = calculator((a, b) => a * b);

console.log(add(5, 3));        // 8
console.log(subtract(5, 3));   // 2
console.log(multiply(5, 3));   // 15
```

---

## Callback Functions

A callback function is a function passed as an argument to another function and executed later.

### Basic Callback

```javascript
function greet(name, callback) {
    console.log(`Hello, ${name}!`);
    callback();
}

function sayGoodbye() {
    console.log("Goodbye!");
}

greet("Alice", sayGoodbye);
// Hello, Alice!
// Goodbye!
```

### Inline Callbacks

```javascript
function process(data, callback) {
    console.log("Processing:", data);
    callback(data);
}

process("test", function(result) {
    console.log("Callback received:", result);
});
```

### Arrow Function Callbacks

```javascript
function process(data, callback) {
    console.log("Processing:", data);
    callback(data);
}

process("test", (result) => {
    console.log("Callback received:", result);
});
```

### Common Use Cases

**Array Methods:**
```javascript
let numbers = [1, 2, 3, 4, 5];

// forEach callback
numbers.forEach(num => {
    console.log(num * 2);
});

// map callback
let doubled = numbers.map(num => num * 2);

// filter callback
let evens = numbers.filter(num => num % 2 === 0);
```

**Event Handlers:**
```javascript
// Simulated event handler
function onClick(callback) {
    // Simulate click
    callback("button clicked");
}

onClick((event) => {
    console.log("Event:", event);
});
```

**Async Operations:**
```javascript
function fetchData(callback) {
    // Simulate async operation
    setTimeout(() => {
        callback({ data: "result" });
    }, 1000);
}

fetchData((result) => {
    console.log("Received:", result);
});
```

### Error-First Callbacks

Common pattern in Node.js:

```javascript
function asyncOperation(callback) {
    // Simulate operation
    let success = Math.random() > 0.5;
    
    if (success) {
        callback(null, "Success!");
    } else {
        callback(new Error("Operation failed"), null);
    }
}

asyncOperation((error, result) => {
    if (error) {
        console.log("Error:", error.message);
    } else {
        console.log("Result:", result);
    }
});
```

### Callback Hell

Multiple nested callbacks can become hard to read:

```javascript
// ⚠️ Callback hell
operation1((result1) => {
    operation2(result1, (result2) => {
        operation3(result2, (result3) => {
            operation4(result3, (result4) => {
                console.log(result4);
            });
        });
    });
});
```

**Solution**: Use Promises or async/await (covered later).

---

## Combining Concepts

### Default Parameters + Rest

```javascript
function createUser(name = "Guest", ...hobbies) {
    return {
        name: name,
        hobbies: hobbies
    };
}

console.log(createUser("Alice", "reading", "coding"));
// { name: "Alice", hobbies: ["reading", "coding"] }
```

### Spread + Rest

```javascript
function combine(...arrays) {
    return [...arrays].flat();
}

let arr1 = [1, 2];
let arr2 = [3, 4];
let arr3 = [5, 6];

console.log(combine(arr1, arr2, arr3));  // [1, 2, 3, 4, 5, 6]
```

### Higher-Order + Callbacks

```javascript
function processArray(arr, callback) {
    return arr.map(callback);
}

let numbers = [1, 2, 3, 4, 5];
let doubled = processArray(numbers, num => num * 2);
console.log(doubled);  // [2, 4, 6, 8, 10]
```

### Complete Example

```javascript
function createCalculator(defaultOperation = "add") {
    const operations = {
        add: (a, b) => a + b,
        subtract: (a, b) => a - b,
        multiply: (a, b) => a * b
    };
    
    return function(...numbers) {
        const operation = operations[defaultOperation];
        return numbers.reduce(operation);
    };
}

let adder = createCalculator("add");
console.log(adder(1, 2, 3, 4));  // 10

let multiplier = createCalculator("multiply");
console.log(multiplier(2, 3, 4));  // 24
```

---

## Practice Exercise

### Exercise: Advanced Functions

**Objective**: Write functions using default parameters, rest parameters, spread operator, higher-order functions, and callbacks.

**Instructions**:

1. Create a file called `advanced-functions.js`

2. Create functions demonstrating:
   - Default parameters
   - Rest parameters
   - Spread operator
   - Higher-order functions
   - Callback functions

3. Combine multiple concepts in practical examples

**Example Solution**:

```javascript
// Advanced Functions Practice
console.log("=== Default Parameters ===");

function greet(name = "Guest", greeting = "Hello") {
    console.log(`${greeting}, ${name}!`);
}

greet("Alice");              // "Hello, Alice!"
greet("Bob", "Hi");          // "Hi, Bob!"
greet();                     // "Hello, Guest!"

function createProduct(name, price = 0, discount = 0) {
    return {
        name: name,
        price: price,
        discount: discount,
        finalPrice: price * (1 - discount)
    };
}

console.log(createProduct("Laptop", 1000, 0.1));
// { name: "Laptop", price: 1000, discount: 0.1, finalPrice: 900 }
console.log();

console.log("=== Rest Parameters ===");

function sum(...numbers) {
    return numbers.reduce((acc, num) => acc + num, 0);
}

console.log("Sum:", sum(1, 2, 3, 4, 5));  // 15

function collectInfo(name, age, ...hobbies) {
    return {
        name: name,
        age: age,
        hobbies: hobbies
    };
}

let info = collectInfo("Alice", 25, "reading", "coding", "traveling");
console.log(info);
console.log();

console.log("=== Spread Operator ===");

// Spreading arrays
let arr1 = [1, 2, 3];
let arr2 = [4, 5, 6];
let combined = [...arr1, ...arr2];
console.log("Combined:", combined);  // [1, 2, 3, 4, 5, 6]

// Function arguments
function add(a, b, c) {
    return a + b + c;
}

let numbers = [1, 2, 3];
console.log("Add:", add(...numbers));  // 6

// Math operations
let values = [5, 10, 15, 20, 25];
console.log("Max:", Math.max(...values));  // 25
console.log("Min:", Math.min(...values));  // 5
console.log();

console.log("=== Higher-Order Functions ===");

// Function that takes function as argument
function applyOperation(a, b, operation) {
    return operation(a, b);
}

let add = (x, y) => x + y;
let multiply = (x, y) => x * y;

console.log("Add:", applyOperation(5, 3, add));        // 8
console.log("Multiply:", applyOperation(5, 3, multiply)); // 15

// Function that returns function
function createMultiplier(factor) {
    return (number) => number * factor;
}

let double = createMultiplier(2);
let triple = createMultiplier(3);

console.log("Double 5:", double(5));   // 10
console.log("Triple 5:", triple(5));   // 15

// Custom higher-order function
function repeat(times, callback) {
    for (let i = 0; i < times; i++) {
        callback(i);
    }
}

repeat(3, (index) => {
    console.log(`Iteration ${index}`);
});
console.log();

console.log("=== Callback Functions ===");

// Simple callback
function processData(data, callback) {
    console.log("Processing:", data);
    let result = data.toUpperCase();
    callback(result);
}

processData("hello", (result) => {
    console.log("Result:", result);
});

// Array callbacks
let numbers = [1, 2, 3, 4, 5];

let doubled = numbers.map(num => num * 2);
console.log("Doubled:", doubled);  // [2, 4, 6, 8, 10]

let evens = numbers.filter(num => num % 2 === 0);
console.log("Evens:", evens);  // [2, 4]

let sum = numbers.reduce((acc, num) => acc + num, 0);
console.log("Sum:", sum);  // 15
console.log();

console.log("=== Combining Concepts ===");

// Default + Rest + Spread
function createUser(name = "Guest", age = 0, ...tags) {
    return {
        name: name,
        age: age,
        tags: tags
    };
}

let user1 = createUser("Alice", 25, "developer", "blogger");
console.log("User 1:", user1);

let user2 = createUser("Bob");
console.log("User 2:", user2);

// Higher-order + Callback + Spread
function processNumbers(operation, ...numbers) {
    return numbers.reduce(operation);
}

let total = processNumbers((a, b) => a + b, 1, 2, 3, 4, 5);
console.log("Total:", total);  // 15

let product = processNumbers((a, b) => a * b, 2, 3, 4);
console.log("Product:", product);  // 24

// Complex example
function createValidator(rules) {
    return function(data) {
        return rules.every(rule => rule(data));
    };
}

let isPositive = x => x > 0;
let isInteger = x => Number.isInteger(x);
let isLessThan100 = x => x < 100;

let validate = createValidator([isPositive, isInteger, isLessThan100]);

console.log("Validate 50:", validate(50));    // true
console.log("Validate -5:", validate(-5));    // false
console.log("Validate 150:", validate(150));  // false
```

**Expected Output**:
```
=== Default Parameters ===
Hello, Alice!
Hi, Bob!
Hello, Guest!
{ name: "Laptop", price: 1000, discount: 0.1, finalPrice: 900 }

=== Rest Parameters ===
Sum: 15
{ name: "Alice", age: 25, hobbies: ["reading", "coding", "traveling"] }

=== Spread Operator ===
Combined: [1, 2, 3, 4, 5, 6]
Add: 6
Max: 25
Min: 5

=== Higher-Order Functions ===
Add: 8
Multiply: 15
Double 5: 10
Triple 5: 15
Iteration 0
Iteration 1
Iteration 2

=== Callback Functions ===
Processing: hello
Result: HELLO
Doubled: [2, 4, 6, 8, 10]
Evens: [2, 4]
Sum: 15

=== Combining Concepts ===
User 1: { name: "Alice", age: 25, tags: ["developer", "blogger"] }
User 2: { name: "Guest", age: 0, tags: [] }
Total: 15
Product: 24
Validate 50: true
Validate -5: false
Validate 150: false
```

**Challenge (Optional)**:
- Create a function builder using higher-order functions
- Build a validation system with callbacks
- Create utility functions using all concepts
- Build a functional programming library

---

## Common Mistakes

### 1. Rest Parameter Position

```javascript
// ❌ Error: Rest must be last
// function example(...rest, a) { }

// ✅ Correct
function example(a, ...rest) { }
```

### 2. Confusing Rest and Spread

```javascript
// Rest: collects into array
function collect(...items) {
    console.log(items);  // Array
}

// Spread: expands array
let arr = [1, 2, 3];
console.log(...arr);  // Individual elements
```

### 3. Default Parameter Order

```javascript
// ⚠️ Can be confusing
function example(a = 1, b) {
    // If you want b default, must pass undefined for a
}

// ✅ Better: Put defaults last
function example(a, b = 1) {
}
```

### 4. Callback Not Function

```javascript
// ❌ Error if callback is not function
function process(callback) {
    callback();  // Error if callback is not function
}

// ✅ Check first
function process(callback) {
    if (typeof callback === "function") {
        callback();
    }
}
```

### 5. Forgetting Return in Callback

```javascript
// ⚠️ No return value
let doubled = numbers.map(num => {
    num * 2;  // Missing return
});

// ✅ With return
let doubled = numbers.map(num => {
    return num * 2;
});

// ✅ Or implicit return
let doubled = numbers.map(num => num * 2);
```

---

## Key Takeaways

1. **Default Parameters**: Set default values for parameters
2. **Rest Parameters**: Collect remaining arguments into array
3. **Spread Operator**: Expand arrays/objects into individual elements
4. **Higher-Order Functions**: Functions that take/return functions
5. **Callbacks**: Functions passed as arguments
6. **Combine Concepts**: Use together for powerful patterns
7. **Best Practice**: Use modern features (default, rest, spread) over legacy patterns

---

## Quiz: Advanced Functions

Test your understanding with these questions:

1. **What is the output: `function test(a = 1, b) { return a + b; } test(undefined, 2)`?**
   - A) 3
   - B) undefined2
   - C) Error
   - D) NaN

2. **Rest parameter must be:**
   - A) First parameter
   - B) Last parameter
   - C) Middle parameter
   - D) Anywhere

3. **What does spread operator do?**
   - A) Collects into array
   - B) Expands array/object
   - C) Creates function
   - D) Nothing

4. **Higher-order function:**
   - A) Takes function as argument
   - B) Returns function
   - C) Both A and B
   - D) Neither

5. **What is a callback?**
   - A) Function passed as argument
   - B) Function that returns value
   - C) Default parameter
   - D) Rest parameter

6. **What is `...args` in function definition?**
   - A) Spread operator
   - B) Rest parameter
   - C) Default parameter
   - D) Error

7. **Arrow functions can use:**
   - A) Rest parameters
   - B) Default parameters
   - C) Spread operator
   - D) All of the above

**Answers**:
1. A) 3 (a uses default 1, b is 2)
2. B) Last parameter
3. B) Expands array/object
4. C) Both A and B
5. A) Function passed as argument
6. B) Rest parameter (collects)
7. D) All of the above

---

## Next Steps

Congratulations! You've completed Module 4: Functions. You now know:
- Function basics (declarations, expressions, arrows)
- Scope and hoisting
- Advanced concepts (defaults, rest, spread, callbacks)

**What's Next?**
- Module 5: Objects and Arrays
- Lesson 5.1: Objects
- Practice combining function concepts
- Build reusable function libraries

---

## Additional Resources

- **MDN: Default Parameters**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Default_parameters](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Default_parameters)
- **MDN: Rest Parameters**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/rest_parameters](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/rest_parameters)
- **MDN: Spread Syntax**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Spread_syntax](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Spread_syntax)
- **JavaScript.info: Advanced Functions**: [javascript.info/advanced-functions](https://javascript.info/advanced-functions)

---

*Lesson completed! You've finished Module 4: Functions. Ready for Module 5: Objects and Arrays!*

