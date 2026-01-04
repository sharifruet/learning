# Lesson 4.1: Function Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Declare functions using function declarations
- Create functions using function expressions
- Write arrow functions (ES6)
- Understand function parameters and arguments
- Use return statements effectively
- Call functions and pass arguments
- Write reusable, modular code

---

## Introduction to Functions

Functions are reusable blocks of code that perform specific tasks. They are fundamental to JavaScript and enable:
- Code reusability
- Modularity
- Abstraction
- Organization

### Why Use Functions?

- **Avoid Repetition**: Write once, use many times
- **Organization**: Break code into logical pieces
- **Maintainability**: Update in one place
- **Testing**: Test individual functions
- **Readability**: Clear, descriptive names

---

## Function Declarations

Function declarations define a function with a name. They are hoisted (can be called before they're defined).

### Basic Syntax

```javascript
function functionName(parameters) {
    // Function body
    return value;
}
```

### Simple Example

```javascript
function greet() {
    console.log("Hello, World!");
}

greet();  // Call the function
// Output: "Hello, World!"
```

### Function with Parameters

```javascript
function greet(name) {
    console.log(`Hello, ${name}!`);
}

greet("Alice");  // "Hello, Alice!"
greet("Bob");    // "Hello, Bob!"
```

### Function with Return Value

```javascript
function add(a, b) {
    return a + b;
}

let result = add(5, 3);
console.log(result);  // 8
```

### Multiple Parameters

```javascript
function calculateTotal(price, quantity, tax) {
    let subtotal = price * quantity;
    let total = subtotal + (subtotal * tax);
    return total;
}

let total = calculateTotal(10, 3, 0.1);
console.log(total);  // 33
```

### Real-World Examples

```javascript
// Calculate area of rectangle
function calculateArea(width, height) {
    return width * height;
}

let area = calculateArea(10, 5);
console.log(area);  // 50

// Check if number is even
function isEven(number) {
    return number % 2 === 0;
}

console.log(isEven(4));   // true
console.log(isEven(7));   // false

// Get full name
function getFullName(firstName, lastName) {
    return `${firstName} ${lastName}`;
}

let name = getFullName("Alice", "Smith");
console.log(name);  // "Alice Smith"
```

### Function Hoisting

Function declarations are hoisted - you can call them before they're defined:

```javascript
// Call before declaration
sayHello();

function sayHello() {
    console.log("Hello!");
}
// Works! Function is hoisted
```

---

## Function Expressions

Function expressions create functions and assign them to variables. They are not hoisted.

### Basic Syntax

```javascript
let functionName = function(parameters) {
    // Function body
    return value;
};
```

### Simple Example

```javascript
let greet = function() {
    console.log("Hello, World!");
};

greet();  // "Hello, World!"
```

### Function Expression with Parameters

```javascript
let add = function(a, b) {
    return a + b;
};

let result = add(5, 3);
console.log(result);  // 8
```

### Anonymous Functions

Function expressions are often anonymous (no name):

```javascript
let multiply = function(x, y) {
    return x * y;
};
```

### Named Function Expressions

You can give function expressions names (useful for debugging):

```javascript
let divide = function divideNumbers(a, b) {
    return a / b;
};
```

### No Hoisting

Function expressions are NOT hoisted:

```javascript
// ❌ Error: Cannot access before initialization
sayHello();

let sayHello = function() {
    console.log("Hello!");
};
```

### When to Use Function Expressions

- When you need a function as a value
- For callbacks
- When hoisting behavior matters
- For immediately invoked functions (IIFE)

---

## Arrow Functions (ES6)

Arrow functions provide a shorter syntax for writing functions. They have some differences from regular functions.

### Basic Syntax

```javascript
// Regular function
function add(a, b) {
    return a + b;
}

// Arrow function
let add = (a, b) => {
    return a + b;
};
```

### Single Expression (Implicit Return)

If the function body is a single expression, you can omit braces and return:

```javascript
// Regular function
function multiply(a, b) {
    return a * b;
}

// Arrow function (implicit return)
let multiply = (a, b) => a * b;
```

### Single Parameter

If there's only one parameter, you can omit parentheses:

```javascript
// Regular function
function square(x) {
    return x * x;
}

// Arrow function
let square = x => x * x;
```

### No Parameters

If there are no parameters, use empty parentheses:

```javascript
// Regular function
function greet() {
    return "Hello!";
}

// Arrow function
let greet = () => "Hello!";
```

### Multiple Statements

For multiple statements, use braces and explicit return:

```javascript
let calculate = (a, b) => {
    let sum = a + b;
    let product = a * b;
    return sum + product;
};
```

### Examples

```javascript
// Simple calculation
let add = (a, b) => a + b;
console.log(add(5, 3));  // 8

// Check even
let isEven = num => num % 2 === 0;
console.log(isEven(4));  // true

// Get first character
let firstChar = str => str[0];
console.log(firstChar("Hello"));  // "H"

// Multiple statements
let process = (x, y) => {
    let sum = x + y;
    let diff = x - y;
    return { sum, diff };
};
```

### Arrow Functions vs Regular Functions

**Key Differences:**
- Arrow functions don't have their own `this` (covered later)
- Arrow functions can't be used as constructors
- Arrow functions don't have `arguments` object
- Arrow functions are always anonymous

**When to Use Arrow Functions:**
- Short, simple functions
- Callbacks
- Array methods (map, filter, etc.)
- When you don't need `this` binding

---

## Function Parameters and Arguments

### Parameters vs Arguments

- **Parameters**: Variables in the function definition
- **Arguments**: Values passed when calling the function

```javascript
// Parameters: a and b
function add(a, b) {
    return a + b;
}

// Arguments: 5 and 3
let result = add(5, 3);
```

### Multiple Parameters

```javascript
function introduce(name, age, city) {
    console.log(`I'm ${name}, ${age} years old, from ${city}`);
}

introduce("Alice", 25, "New York");
// Output: "I'm Alice, 25 years old, from New York"
```

### Parameter Order Matters

```javascript
function greet(greeting, name) {
    console.log(`${greeting}, ${name}!`);
}

greet("Hello", "Alice");  // "Hello, Alice!"
greet("Alice", "Hello");  // "Alice, Hello!" (wrong order!)
```

### Missing Arguments

If you call a function with fewer arguments than parameters, missing parameters are `undefined`:

```javascript
function greet(name, greeting) {
    console.log(`${greeting}, ${name}!`);
}

greet("Alice");  // "undefined, Alice!"
```

### Extra Arguments

Extra arguments are ignored:

```javascript
function add(a, b) {
    return a + b;
}

console.log(add(1, 2, 3, 4, 5));  // 3 (only uses first two)
```

### Arguments Object

Regular functions have access to an `arguments` object:

```javascript
function sum() {
    let total = 0;
    for (let i = 0; i < arguments.length; i++) {
        total += arguments[i];
    }
    return total;
}

console.log(sum(1, 2, 3, 4, 5));  // 15
```

**Note**: Arrow functions don't have `arguments` object.

---

## Return Statements

The `return` statement specifies the value a function returns. Functions without `return` return `undefined`.

### Basic Return

```javascript
function add(a, b) {
    return a + b;
}

let result = add(5, 3);
console.log(result);  // 8
```

### Early Return

You can return early to exit a function:

```javascript
function checkAge(age) {
    if (age < 0) {
        return "Invalid age";
    }
    if (age < 18) {
        return "Minor";
    }
    return "Adult";
}

console.log(checkAge(25));  // "Adult"
console.log(checkAge(-5));   // "Invalid age"
```

### Multiple Return Points

```javascript
function getGrade(score) {
    if (score >= 90) return "A";
    if (score >= 80) return "B";
    if (score >= 70) return "C";
    if (score >= 60) return "D";
    return "F";
}

console.log(getGrade(85));  // "B"
```

### Returning Objects

```javascript
function createUser(name, age) {
    return {
        name: name,
        age: age,
        isAdult: age >= 18
    };
}

let user = createUser("Alice", 25);
console.log(user);  // { name: "Alice", age: 25, isAdult: true }
```

### Returning Arrays

```javascript
function getEvenNumbers(max) {
    let evens = [];
    for (let i = 2; i <= max; i += 2) {
        evens.push(i);
    }
    return evens;
}

let numbers = getEvenNumbers(10);
console.log(numbers);  // [2, 4, 6, 8, 10]
```

### No Return Statement

Functions without `return` return `undefined`:

```javascript
function doSomething() {
    console.log("Doing something");
    // No return statement
}

let result = doSomething();
console.log(result);  // undefined
```

### Return Stops Execution

After `return`, no code executes:

```javascript
function test() {
    console.log("Before return");
    return "Done";
    console.log("After return");  // Never executes
}

console.log(test());
// Output: "Before return", "Done"
```

---

## Calling Functions

### Basic Function Call

```javascript
function greet() {
    console.log("Hello!");
}

greet();  // Call the function
```

### Calling with Arguments

```javascript
function add(a, b) {
    return a + b;
}

let result = add(5, 3);  // Call with arguments
console.log(result);
```

### Storing Function in Variable

```javascript
function multiply(a, b) {
    return a * b;
}

let calc = multiply;  // Store function reference
console.log(calc(5, 3));  // 15
```

### Functions as Values

Functions are first-class citizens - they can be:
- Assigned to variables
- Passed as arguments
- Returned from functions
- Stored in data structures

```javascript
// Assign to variable
let myFunction = function() {
    return "Hello";
};

// Pass as argument
function callFunction(fn) {
    return fn();
}

console.log(callFunction(myFunction));  // "Hello"
```

---

## Practice Exercise

### Exercise: Writing Functions

**Objective**: Write various functions demonstrating different function types and concepts.

**Instructions**:

1. Create a file called `functions-practice.js`

2. Write functions using different styles:
   - Function declarations
   - Function expressions
   - Arrow functions

3. Create functions for:
   - Mathematical operations (add, subtract, multiply, divide)
   - String operations (reverse, capitalize, count words)
   - Validation (isEven, isPositive, isValidEmail)
   - Data transformation (convert temperature, format currency)

4. Test all functions with different inputs

**Example Solution**:

```javascript
// Functions Practice
console.log("=== Function Declarations ===");

// Math functions
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
        return "Cannot divide by zero";
    }
    return a / b;
}

console.log("Add:", add(10, 5));           // 15
console.log("Subtract:", subtract(10, 5)); // 5
console.log("Multiply:", multiply(10, 5)); // 50
console.log("Divide:", divide(10, 5));     // 2
console.log("Divide by zero:", divide(10, 0));
console.log();

console.log("=== Function Expressions ===");

// String functions
let reverseString = function(str) {
    return str.split("").reverse().join("");
};

let capitalize = function(str) {
    return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
};

let countWords = function(str) {
    return str.trim().split(/\s+/).length;
};

console.log("Reverse:", reverseString("Hello"));      // "olleH"
console.log("Capitalize:", capitalize("hello"));      // "Hello"
console.log("Count words:", countWords("Hello world")); // 2
console.log();

console.log("=== Arrow Functions ===");

// Validation functions
let isEven = num => num % 2 === 0;
let isPositive = num => num > 0;
let isValidEmail = email => email.includes("@") && email.includes(".");

// Temperature conversion
let celsiusToFahrenheit = celsius => (celsius * 9/5) + 32;
let fahrenheitToCelsius = fahrenheit => (fahrenheit - 32) * 5/9;

// Currency formatting
let formatCurrency = (amount, currency = "$") => {
    return `${currency}${amount.toFixed(2)}`;
};

console.log("Is even:", isEven(4));                    // true
console.log("Is positive:", isPositive(-5));           // false
console.log("Valid email:", isValidEmail("test@email.com")); // true
console.log("C to F:", celsiusToFahrenheit(25));       // 77
console.log("F to C:", fahrenheitToCelsius(77));       // 25
console.log("Currency:", formatCurrency(1234.56));     // "$1234.56"
console.log();

console.log("=== Complex Functions ===");

// Function with multiple statements
function calculateTotal(items, taxRate) {
    let subtotal = 0;
    for (let item of items) {
        subtotal += item.price * item.quantity;
    }
    let tax = subtotal * taxRate;
    return {
        subtotal: subtotal,
        tax: tax,
        total: subtotal + tax
    };
}

let cart = [
    { price: 10, quantity: 2 },
    { price: 5, quantity: 3 }
];

let total = calculateTotal(cart, 0.1);
console.log("Cart total:", total);
// { subtotal: 35, tax: 3.5, total: 38.5 }
console.log();

console.log("=== Functions with Early Return ===");

function getGrade(score) {
    if (score < 0 || score > 100) {
        return "Invalid score";
    }
    if (score >= 90) return "A";
    if (score >= 80) return "B";
    if (score >= 70) return "C";
    if (score >= 60) return "D";
    return "F";
}

console.log("Grade (95):", getGrade(95));   // "A"
console.log("Grade (85):", getGrade(85));   // "B"
console.log("Grade (75):", getGrade(75));   // "C"
console.log("Grade (105):", getGrade(105)); // "Invalid score"
console.log();

console.log("=== Functions Returning Arrays ===");

function getMultiples(number, count) {
    let multiples = [];
    for (let i = 1; i <= count; i++) {
        multiples.push(number * i);
    }
    return multiples;
}

let multiples = getMultiples(5, 5);
console.log("Multiples of 5:", multiples);  // [5, 10, 15, 20, 25]
console.log();

console.log("=== Functions as Values ===");

let operations = {
    add: (a, b) => a + b,
    subtract: (a, b) => a - b,
    multiply: (a, b) => a * b,
    divide: (a, b) => a / b
};

function calculate(operation, a, b) {
    if (operations[operation]) {
        return operations[operation](a, b);
    }
    return "Unknown operation";
}

console.log("Calculate add:", calculate("add", 10, 5));        // 15
console.log("Calculate multiply:", calculate("multiply", 10, 5)); // 50
console.log("Calculate unknown:", calculate("power", 10, 5));   // "Unknown operation"
```

**Expected Output**:
```
=== Function Declarations ===
Add: 15
Subtract: 5
Multiply: 50
Divide: 2
Divide by zero: Cannot divide by zero

=== Function Expressions ===
Reverse: olleH
Capitalize: Hello
Count words: 2

=== Arrow Functions ===
Is even: true
Is positive: false
Valid email: true
C to F: 77
F to C: 25
Currency: $1234.56

=== Complex Functions ===
Cart total: { subtotal: 35, tax: 3.5, total: 38.5 }

=== Functions with Early Return ===
Grade (95): A
Grade (85): B
Grade (75): C
Grade (105): Invalid score

=== Functions Returning Arrays ===
Multiples of 5: [5, 10, 15, 20, 25]

=== Functions as Values ===
Calculate add: 15
Calculate multiply: 50
Calculate unknown: Unknown operation
```

**Challenge (Optional)**:
- Create a calculator with multiple operations
- Build a string manipulation library
- Create validation functions for forms
- Build utility functions for common tasks

---

## Common Mistakes

### 1. Forgetting Return Statement

```javascript
// ❌ Returns undefined
function add(a, b) {
    a + b;  // Missing return
}

// ✅ Correct
function add(a, b) {
    return a + b;
}
```

### 2. Calling Function Without Parentheses

```javascript
// ❌ Doesn't call function
let result = add;  // Stores function, doesn't call it

// ✅ Correct
let result = add(5, 3);  // Calls function
```

### 3. Parameter vs Argument Confusion

```javascript
// Parameters: a, b
function multiply(a, b) {
    return a * b;
}

// Arguments: 5, 3
multiply(5, 3);
```

### 4. Arrow Function Syntax

```javascript
// ❌ Wrong syntax
let add = a, b => a + b;

// ✅ Correct
let add = (a, b) => a + b;
```

### 5. Hoisting Confusion

```javascript
// ✅ Works (function declaration)
sayHello();
function sayHello() {
    console.log("Hello");
}

// ❌ Doesn't work (function expression)
sayHello();
let sayHello = function() {
    console.log("Hello");
};
```

---

## Key Takeaways

1. **Function Declarations**: `function name() {}` - hoisted
2. **Function Expressions**: `let name = function() {}` - not hoisted
3. **Arrow Functions**: `() => {}` - shorter syntax, no `this` binding
4. **Parameters**: Variables in function definition
5. **Arguments**: Values passed when calling function
6. **Return**: Specifies function's return value
7. **Functions are Values**: Can be assigned, passed, returned
8. **Choose Style**: Use appropriate function type for context

---

## Quiz: Functions Basics

Test your understanding with these questions:

1. **What is the output of: `function test() { } console.log(test())`?**
   - A) undefined
   - B) null
   - C) Error
   - D) "test"

2. **Which function type is hoisted?**
   - A) Function expression
   - B) Arrow function
   - C) Function declaration
   - D) None

3. **What does `return` do?**
   - A) Stops function execution
   - B) Returns a value
   - C) Both A and B
   - D) Nothing

4. **Arrow functions can omit braces when:**
   - A) Always
   - B) Single expression
   - C) No parameters
   - D) Never

5. **What are the variables in function definition called?**
   - A) Arguments
   - B) Parameters
   - C) Variables
   - D) Values

6. **Which is correct arrow function syntax?**
   - A) `let fn = a => a * 2`
   - B) `let fn = (a) => a * 2`
   - C) `let fn = a => { return a * 2 }`
   - D) All of the above

7. **Functions without return statement return:**
   - A) null
   - B) undefined
   - C) 0
   - D) Error

**Answers**:
1. A) undefined (no return statement)
2. C) Function declaration
3. C) Both A and B
4. B) Single expression
5. B) Parameters
6. D) All of the above (all are valid)
7. B) undefined

---

## Next Steps

Congratulations! You've learned function basics. You now know:
- How to declare functions
- Function expressions and arrow functions
- Parameters and arguments
- Return statements

**What's Next?**
- Lesson 4.2: Function Scope and Hoisting
- Practice writing different function types
- Experiment with return values
- Build reusable functions

---

## Additional Resources

- **MDN: Functions**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Functions](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Functions)
- **MDN: Arrow Functions**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions)
- **JavaScript.info: Functions**: [javascript.info/function-basics](https://javascript.info/function-basics)
- **JavaScript.info: Arrow Functions**: [javascript.info/arrow-functions-basics](https://javascript.info/arrow-functions-basics)

---

*Lesson completed! You're ready to move on to the next lesson.*

