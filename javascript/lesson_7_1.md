# Lesson 7.1: Let, Const, and Block Scope

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the differences between `let`, `const`, and `var`
- Use `let` for block-scoped variables
- Use `const` for constants
- Understand the Temporal Dead Zone (TDZ)
- Work with block scope effectively
- Avoid common scoping pitfalls
- Write modern JavaScript code

---

## Introduction to Modern Variable Declarations

ES6 (ES2015) introduced `let` and `const` as alternatives to `var`. These new declarations provide better scoping rules and help prevent common bugs.

### Why New Declarations?

- **Block Scope**: Better than function scope
- **Temporal Dead Zone**: Prevents using variables before declaration
- **No Hoisting Issues**: Clearer behavior
- **Constants**: `const` prevents accidental reassignment
- **Modern Standard**: Recommended for all new code

---

## var vs let vs const

### Quick Comparison

| Feature | var | let | const |
|---------|-----|-----|-------|
| Scope | Function | Block | Block |
| Hoisting | Yes (undefined) | Yes (TDZ) | Yes (TDZ) |
| Reassignment | Yes | Yes | No |
| Redeclaration | Yes | No | No |
| Initialization | Optional | Optional | Required |

### When to Use Each

- **const**: Default choice for values that won't change
- **let**: Use when you need to reassign
- **var**: Avoid (legacy code only)

---

## let vs var

### Scope Difference

**var (function scope):**
```javascript
function example() {
    if (true) {
        var x = 5;
    }
    console.log(x);  // 5 (accessible in function)
}

example();
```

**let (block scope):**
```javascript
function example() {
    if (true) {
        let x = 5;
    }
    // console.log(x);  // ❌ Error: x is not defined
}

example();
```

### Loop Example

**var in loops (problematic):**
```javascript
for (var i = 0; i < 3; i++) {
    setTimeout(() => {
        console.log(i);  // 3, 3, 3 (all same!)
    }, 100);
}
```

**let in loops (correct):**
```javascript
for (let i = 0; i < 3; i++) {
    setTimeout(() => {
        console.log(i);  // 0, 1, 2 (correct!)
    }, 100);
}
```

### Redeclaration

**var allows redeclaration:**
```javascript
var x = 5;
var x = 10;  // ✅ Works (but confusing)
console.log(x);  // 10
```

**let prevents redeclaration:**
```javascript
let x = 5;
// let x = 10;  // ❌ Error: Identifier 'x' has already been declared
```

### Hoisting Behavior

**var hoisting:**
```javascript
console.log(x);  // undefined (not an error)
var x = 5;
```

**let hoisting (Temporal Dead Zone):**
```javascript
// console.log(x);  // ❌ Error: Cannot access before initialization
let x = 5;
```

---

## const for Constants

`const` creates constants that cannot be reassigned.

### Basic Usage

```javascript
const PI = 3.14159;
const MAX_SIZE = 100;
const API_URL = "https://api.example.com";

// PI = 3.14;  // ❌ Error: Assignment to constant variable
```

### const Must Be Initialized

```javascript
// ❌ Error: Missing initializer
// const x;

// ✅ Correct
const x = 5;
```

### const and Objects

`const` prevents reassignment, not mutation:

```javascript
const person = {
    name: "Alice",
    age: 25
};

// ✅ Can modify properties
person.age = 26;
person.city = "New York";

// ❌ Cannot reassign object
// person = { name: "Bob" };  // Error
```

### const and Arrays

```javascript
const numbers = [1, 2, 3];

// ✅ Can modify array
numbers.push(4);
numbers[0] = 10;

// ❌ Cannot reassign array
// numbers = [5, 6, 7];  // Error
```

### When to Use const

**Use const for:**
- Values that shouldn't change
- Object and array references
- Function declarations
- Imported modules
- Configuration values

**Use let for:**
- Loop counters
- Variables that will be reassigned
- Conditional assignments

---

## Temporal Dead Zone (TDZ)

The Temporal Dead Zone is the period between the start of a scope and the variable declaration where the variable exists but cannot be accessed.

### Understanding TDZ

```javascript
// TDZ starts here
console.log(x);  // ❌ Error: Cannot access 'x' before initialization
// TDZ continues...
let x = 5;       // TDZ ends here
```

### TDZ Examples

```javascript
// ❌ Error: TDZ
console.log(myVar);
let myVar = 10;

// ✅ Works: Variable is declared first
let myVar = 10;
console.log(myVar);
```

### TDZ with Functions

```javascript
// ❌ Error: TDZ
function test() {
    console.log(x);  // Error
    let x = 5;
}

// ✅ Works
function test() {
    let x = 5;
    console.log(x);  // 5
}
```

### Why TDZ Exists

TDZ prevents:
- Using variables before declaration
- Confusing behavior from hoisting
- Accidental bugs

---

## Block Scope

Block scope means variables are only accessible within the block `{}` where they're declared.

### Basic Block Scope

```javascript
{
    let x = 5;
    console.log(x);  // 5
}
// console.log(x);  // ❌ Error: x is not defined
```

### Block Scope in Conditionals

```javascript
if (true) {
    let message = "Hello";
    console.log(message);  // "Hello"
}
// console.log(message);  // ❌ Error: message is not defined
```

### Block Scope in Loops

```javascript
for (let i = 0; i < 3; i++) {
    console.log(i);  // 0, 1, 2
}
// console.log(i);  // ❌ Error: i is not defined
```

### Multiple Blocks

Each block creates its own scope:

```javascript
{
    let x = 1;
    console.log(x);  // 1
}

{
    let x = 2;  // Different x
    console.log(x);  // 2
}
```

### Nested Blocks

```javascript
let outer = "outer";

{
    let middle = "middle";
    
    {
        let inner = "inner";
        console.log(outer);   // ✅ Can access
        console.log(middle);   // ✅ Can access
        console.log(inner);    // ✅ Can access
    }
    
    console.log(outer);   // ✅ Can access
    console.log(middle);   // ✅ Can access
    // console.log(inner);  // ❌ Error: inner not accessible
}

// console.log(middle);  // ❌ Error: middle not accessible
// console.log(inner);   // ❌ Error: inner not accessible
```

---

## Practical Examples

### Example 1: Loop Variables

```javascript
// ✅ Good: let in loops
for (let i = 0; i < 5; i++) {
    setTimeout(() => {
        console.log(i);  // 0, 1, 2, 3, 4
    }, 100);
}

// ⚠️ Problem: var in loops
for (var j = 0; j < 5; j++) {
    setTimeout(() => {
        console.log(j);  // 5, 5, 5, 5, 5 (all same!)
    }, 100);
}
```

### Example 2: Conditional Scope

```javascript
let user = getUser();

if (user) {
    let userId = user.id;
    let userName = user.name;
    processUser(userId, userName);
}
// userId and userName not accessible here (good!)
```

### Example 3: Constants

```javascript
// Configuration
const API_BASE_URL = "https://api.example.com";
const MAX_RETRIES = 3;
const TIMEOUT = 5000;

// Object reference
const config = {
    apiUrl: API_BASE_URL,
    retries: MAX_RETRIES
};

// Can modify properties
config.timeout = TIMEOUT;

// Cannot reassign
// config = {};  // Error
```

### Example 4: Block Scope Benefits

```javascript
function processData(data) {
    if (data) {
        let processed = transform(data);
        let validated = validate(processed);
        return validated;
    }
    // processed and validated not accessible here (clean scope)
    return null;
}
```

---

## Best Practices

### 1. Use const by Default

```javascript
// ✅ Good: const by default
const name = "Alice";
const age = 25;
const user = { name, age };

// Use let only when needed
let counter = 0;
counter++;  // Need to reassign
```

### 2. Declare at Top of Block

```javascript
// ✅ Good: Clear scope
function example() {
    let x = 5;
    let y = 10;
    // Use x and y
}

// ⚠️ Less clear: Scattered declarations
function example() {
    // Some code
    let x = 5;
    // More code
    let y = 10;
}
```

### 3. Avoid var

```javascript
// ❌ Old style
var x = 5;

// ✅ Modern style
let x = 5;      // If reassigning
const x = 5;    // If constant
```

### 4. Use Meaningful Names

```javascript
// ✅ Good
const MAX_USERS = 100;
const API_TIMEOUT = 5000;

// ❌ Avoid
const m = 100;
const t = 5000;
```

### 5. Block Scope for Temporary Variables

```javascript
// ✅ Good: Block scope for temporary variables
if (condition) {
    let temp = calculate();
    process(temp);
}
// temp not accessible (good!)

// ⚠️ Less ideal: Function scope
if (condition) {
    var temp = calculate();
    process(temp);
}
// temp still accessible (might be unwanted)
```

---

## Practice Exercise

### Exercise: Block Scope Practice

**Objective**: Practice using `let` and `const` with block scope in various scenarios.

**Instructions**:

1. Create a file called `block-scope-practice.js`

2. Demonstrate:
   - `let` vs `var` in different scopes
   - `const` for constants
   - Block scope in conditionals and loops
   - Temporal Dead Zone
   - Nested scopes
   - Best practices

**Example Solution**:

```javascript
// Block Scope Practice
console.log("=== let vs var Scope ===");

// var: Function scope
function varExample() {
    if (true) {
        var x = 5;
    }
    console.log("var x:", x);  // 5 (accessible)
}

// let: Block scope
function letExample() {
    if (true) {
        let y = 5;
    }
    // console.log("let y:", y);  // ❌ Error: not accessible
}

varExample();
letExample();
console.log();

console.log("=== Loop Scope ===");

// var in loop (problem)
console.log("Using var:");
for (var i = 0; i < 3; i++) {
    setTimeout(() => {
        console.log("var i:", i);  // 3, 3, 3
    }, 10);
}

// let in loop (correct)
setTimeout(() => {
    console.log("Using let:");
    for (let j = 0; j < 3; j++) {
        setTimeout(() => {
            console.log("let j:", j);  // 0, 1, 2
        }, 20);
    }
}, 50);
console.log();

console.log("=== const Usage ===");

// Constants
const PI = 3.14159;
const MAX_SIZE = 100;
const API_URL = "https://api.example.com";

console.log("PI:", PI);
console.log("MAX_SIZE:", MAX_SIZE);
console.log("API_URL:", API_URL);

// const with objects
const person = {
    name: "Alice",
    age: 25
};

person.age = 26;  // ✅ Can modify
person.city = "NYC";  // ✅ Can add
console.log("Modified person:", person);

// const with arrays
const numbers = [1, 2, 3];
numbers.push(4);  // ✅ Can modify
numbers[0] = 10;  // ✅ Can modify
console.log("Modified array:", numbers);
console.log();

console.log("=== Block Scope Examples ===");

// Basic block
{
    let blockVar = "I'm in a block";
    console.log("Inside block:", blockVar);
}
// console.log(blockVar);  // ❌ Error

// Conditional blocks
let condition = true;
if (condition) {
    let ifVar = "Inside if";
    console.log("If block:", ifVar);
}
// console.log(ifVar);  // ❌ Error

// Loop blocks
for (let i = 0; i < 3; i++) {
    let loopVar = `Iteration ${i}`;
    console.log("Loop:", loopVar);
}
// console.log(loopVar);  // ❌ Error
// console.log(i);  // ❌ Error
console.log();

console.log("=== Nested Scopes ===");

let global = "global";

{
    let level1 = "level1";
    console.log("Level 1:", global, level1);
    
    {
        let level2 = "level2";
        console.log("Level 2:", global, level1, level2);
        
        {
            let level3 = "level3";
            console.log("Level 3:", global, level1, level2, level3);
        }
        
        // console.log(level3);  // ❌ Error
    }
    
    // console.log(level2);  // ❌ Error
    // console.log(level3);  // ❌ Error
}
console.log();

console.log("=== Temporal Dead Zone ===");

// TDZ demonstration
function tdzExample() {
    // console.log(tdzVar);  // ❌ Error: Cannot access before initialization
    let tdzVar = "I'm in TDZ";
    console.log("After declaration:", tdzVar);  // ✅ Works
}

tdzExample();

// var vs let hoisting
console.log("var hoisting:");
console.log("varX:", typeof varX);  // "undefined" (hoisted)
var varX = 5;

// console.log("letX:", typeof letX);  // ❌ Error: TDZ
let letX = 5;
console.log();

console.log("=== Best Practices ===");

// ✅ Good: const by default
const userName = "Alice";
const userAge = 25;
const userConfig = {
    theme: "dark",
    language: "en"
};

// ✅ Good: let when reassigning
let counter = 0;
counter++;
counter += 5;

// ✅ Good: Block scope for temporary variables
function processData(data) {
    if (data && data.length > 0) {
        let processed = data.map(item => item * 2);
        let filtered = processed.filter(item => item > 10);
        return filtered;
    }
    // processed and filtered not accessible (good!)
    return [];
}

let result = processData([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
console.log("Processed data:", result);  // [12, 14, 16, 18, 20]
console.log();

console.log("=== Real-World Example ===");

// Configuration with const
const CONFIG = {
    apiUrl: "https://api.example.com",
    timeout: 5000,
    retries: 3
};

// Function with block scope
function makeRequest(endpoint) {
    const url = `${CONFIG.apiUrl}${endpoint}`;
    
    for (let attempt = 1; attempt <= CONFIG.retries; attempt++) {
        let response = simulateRequest(url);
        
        if (response.success) {
            return response;
        }
        
        if (attempt < CONFIG.retries) {
            console.log(`Attempt ${attempt} failed, retrying...`);
        }
    }
    
    throw new Error("All retry attempts failed");
}

function simulateRequest(url) {
    return { success: Math.random() > 0.5 };
}

try {
    let response = makeRequest("/users");
    console.log("Request successful!");
} catch (error) {
    console.log("Request failed:", error.message);
}
```

**Expected Output**:
```
=== let vs var Scope ===
var x: 5

=== Loop Scope ===
Using var:
Using let:
var i: 3
var i: 3
var i: 3
let j: 0
let j: 1
let j: 2

=== const Usage ===
PI: 3.14159
MAX_SIZE: 100
API_URL: https://api.example.com
Modified person: { name: "Alice", age: 26, city: "NYC" }
Modified array: [10, 2, 3, 4]

=== Block Scope Examples ===
Inside block: I'm in a block
If block: Inside if
Loop: Iteration 0
Loop: Iteration 1
Loop: Iteration 2

=== Nested Scopes ===
Level 1: global level1
Level 2: global level1 level2
Level 3: global level1 level2 level3

=== Temporal Dead Zone ===
After declaration: I'm in TDZ
var hoisting:
varX: undefined

=== Best Practices ===
Processed data: [12, 14, 16, 18, 20]

=== Real-World Example ===
Attempt 1 failed, retrying...
Request successful!
```

**Challenge (Optional)**:
- Refactor code from var to let/const
- Create scope-based utilities
- Build configuration systems with const
- Practice TDZ scenarios

---

## Common Mistakes

### 1. Using var Instead of let/const

```javascript
// ❌ Old style
var x = 5;

// ✅ Modern style
let x = 5;      // If reassigning
const x = 5;    // If constant
```

### 2. Trying to Reassign const

```javascript
// ❌ Error
const x = 5;
x = 10;  // Error

// ✅ Use let if reassigning
let x = 5;
x = 10;  // Works
```

### 3. Accessing Before Declaration

```javascript
// ❌ Error: TDZ
console.log(x);
let x = 5;

// ✅ Declare first
let x = 5;
console.log(x);
```

### 4. Forgetting const Initialization

```javascript
// ❌ Error: Missing initializer
// const x;

// ✅ Must initialize
const x = 5;
```

### 5. Confusing const Immutability

```javascript
// ⚠️ const prevents reassignment, not mutation
const obj = { x: 1 };
obj.x = 2;      // ✅ Works (mutation)
// obj = {};    // ❌ Error (reassignment)
```

---

## Key Takeaways

1. **let**: Block-scoped, can reassign, no redeclaration
2. **const**: Block-scoped, cannot reassign, must initialize
3. **var**: Function-scoped, avoid in modern code
4. **Block Scope**: Variables only accessible in their block
5. **Temporal Dead Zone**: Period before declaration where variable can't be accessed
6. **Best Practice**: Use `const` by default, `let` when reassigning
7. **Loop Variables**: Always use `let` in loops
8. **Constants**: Use `const` for values that shouldn't change

---

## Quiz: Modern Variable Declarations

Test your understanding with these questions:

1. **What scope does `let` have?**
   - A) Function scope
   - B) Block scope
   - C) Global scope
   - D) No scope

2. **Can you reassign a `const` variable?**
   - A) Yes
   - B) No
   - C) Sometimes
   - D) Only in functions

3. **What is the Temporal Dead Zone?**
   - A) Error zone
   - B) Period before declaration
   - C) Block scope
   - D) Function scope

4. **Which is hoisted to undefined?**
   - A) let
   - B) const
   - C) var
   - D) All of them

5. **What happens: `console.log(x); let x = 5;`?**
   - A) undefined
   - B) 5
   - C) Error
   - D) null

6. **Can you modify a const object's properties?**
   - A) Yes
   - B) No
   - C) Only in functions
   - D) Only arrays

7. **Which should you use by default?**
   - A) var
   - B) let
   - C) const
   - D) Doesn't matter

**Answers**:
1. B) Block scope
2. B) No
3. B) Period before declaration
4. C) var
5. C) Error (TDZ)
6. A) Yes (const prevents reassignment, not mutation)
7. C) const

---

## Next Steps

Congratulations! You've learned modern variable declarations. You now know:
- Differences between let, const, and var
- Block scope and its benefits
- Temporal Dead Zone
- When to use each declaration

**What's Next?**
- Lesson 7.2: Destructuring
- Practice refactoring var to let/const
- Understand scope better
- Build more modern JavaScript code

---

## Additional Resources

- **MDN: let**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/let](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/let)
- **MDN: const**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/const](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/const)
- **JavaScript.info: Variables**: [javascript.info/variables](https://javascript.info/variables)
- **JavaScript.info: Closure**: [javascript.info/closure](https://javascript.info/closure)

---

*Lesson completed! You're ready to move on to the next lesson.*

