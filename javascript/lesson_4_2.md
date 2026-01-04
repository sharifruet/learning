# Lesson 4.2: Function Scope and Hoisting

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand global scope vs local scope
- Work with block scope (let, const)
- Understand hoisting behavior in JavaScript
- Know how function hoisting works
- Understand variable hoisting
- Avoid common scope-related bugs
- Write code that uses scope effectively

---

## Introduction to Scope

Scope determines where variables and functions are accessible in your code. Understanding scope is crucial for writing correct JavaScript.

### What is Scope?

Scope is the context in which variables and functions are accessible. JavaScript has different types of scope:
- Global scope
- Function scope
- Block scope

---

## Global Scope

Variables declared outside any function are in the global scope and accessible everywhere.

### Global Variables

```javascript
// Global variable
let globalVar = "I'm global";

function test() {
    console.log(globalVar);  // Can access global variable
}

test();  // "I'm global"
console.log(globalVar);  // "I'm global"
```

### Global Functions

```javascript
// Global function
function globalFunction() {
    console.log("I'm global");
}

// Can call from anywhere
globalFunction();
```

### Problems with Global Scope

**⚠️ Avoid polluting global scope:**
```javascript
// ❌ Too many global variables
let userName = "Alice";
let userAge = 25;
let userCity = "NYC";
let userEmail = "alice@example.com";
// ... many more

// ✅ Better: Use objects
let user = {
    name: "Alice",
    age: 25,
    city: "NYC",
    email: "alice@example.com"
};
```

### window Object (Browser)

In browsers, global variables become properties of the `window` object:

```javascript
var globalVar = "Hello";
console.log(window.globalVar);  // "Hello"
console.log(globalVar);         // "Hello" (same thing)
```

**Note**: `let` and `const` don't create properties on `window`.

---

## Local/Function Scope

Variables declared inside a function are in local scope and only accessible within that function.

### Function Scope

```javascript
function myFunction() {
    let localVar = "I'm local";
    console.log(localVar);  // Can access
}

myFunction();
// console.log(localVar);  // ❌ Error: localVar is not defined
```

### Multiple Functions

Each function has its own scope:

```javascript
function function1() {
    let x = 1;
    console.log(x);  // 1
}

function function2() {
    let x = 2;  // Different x
    console.log(x);  // 2
}

function1();  // 1
function2();  // 2
```

### Nested Functions

Inner functions can access outer function variables:

```javascript
function outer() {
    let outerVar = "outer";
    
    function inner() {
        console.log(outerVar);  // Can access outer variable
        let innerVar = "inner";
        console.log(innerVar);  // Can access own variable
    }
    
    inner();
    // console.log(innerVar);  // ❌ Error: innerVar not accessible
}

outer();
```

### Scope Chain

JavaScript looks up the scope chain to find variables:

```javascript
let global = "global";

function level1() {
    let level1Var = "level1";
    
    function level2() {
        let level2Var = "level2";
        
        function level3() {
            // Can access all outer scopes
            console.log(global);      // "global"
            console.log(level1Var);  // "level1"
            console.log(level2Var);  // "level2"
        }
        
        level3();
    }
    
    level2();
}

level1();
```

---

## Block Scope (let, const)

`let` and `const` create block-scoped variables (ES6). They're only accessible within the block `{}` where they're declared.

### Block Scope Basics

```javascript
if (true) {
    let blockVar = "I'm in a block";
    console.log(blockVar);  // Can access
}

// console.log(blockVar);  // ❌ Error: blockVar is not defined
```

### Block Scope in Loops

```javascript
for (let i = 0; i < 3; i++) {
    console.log(i);  // 0, 1, 2
}

// console.log(i);  // ❌ Error: i is not defined
```

### Block Scope vs Function Scope

**var (function scope):**
```javascript
function test() {
    if (true) {
        var x = 5;
    }
    console.log(x);  // 5 (accessible in function)
}

test();
```

**let/const (block scope):**
```javascript
function test() {
    if (true) {
        let x = 5;
    }
    // console.log(x);  // ❌ Error: x is not defined
}

test();
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

### Block Scope in Functions

```javascript
function example() {
    let functionVar = "function";
    
    if (true) {
        let blockVar = "block";
        console.log(functionVar);  // ✅ Can access
        console.log(blockVar);     // ✅ Can access
    }
    
    console.log(functionVar);  // ✅ Can access
    // console.log(blockVar);  // ❌ Error: not accessible
}
```

---

## var vs let vs const Scope

### var (Function Scope)

```javascript
function test() {
    if (true) {
        var x = 5;
    }
    console.log(x);  // 5 (accessible in function)
}

// var is function-scoped, not block-scoped
for (var i = 0; i < 3; i++) {
    // i is accessible here
}
console.log(i);  // 3 (accessible outside loop!)
```

### let (Block Scope)

```javascript
function test() {
    if (true) {
        let x = 5;
    }
    // console.log(x);  // ❌ Error: not accessible
}

// let is block-scoped
for (let i = 0; i < 3; i++) {
    // i is only accessible here
}
// console.log(i);  // ❌ Error: not accessible
```

### const (Block Scope)

```javascript
function test() {
    if (true) {
        const x = 5;
    }
    // console.log(x);  // ❌ Error: not accessible
}

// const is block-scoped (same as let)
for (const i = 0; i < 3; i++) {
    // Each iteration has its own i
}
```

### Best Practice

**✅ Use `let` and `const` (block scope):**
```javascript
// Modern JavaScript
let count = 0;
const MAX = 100;

if (true) {
    let temp = 5;
    // temp only accessible here
}
```

**❌ Avoid `var` (legacy):**
```javascript
// Old style (avoid)
var count = 0;
```

---

## Hoisting

Hoisting is JavaScript's behavior of moving declarations to the top of their scope before code execution.

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

### How Function Hoisting Works

JavaScript "moves" function declarations to the top:

```javascript
// What you write:
console.log(typeof myFunction);  // "function"
myFunction();  // Works

function myFunction() {
    console.log("Hello");
}

// What JavaScript "sees":
function myFunction() {
    console.log("Hello");
}

console.log(typeof myFunction);
myFunction();
```

### Function Expressions Are NOT Hoisted

```javascript
// ❌ Error: Cannot access before initialization
sayHello();

let sayHello = function() {
    console.log("Hello!");
};
```

### Arrow Functions Are NOT Hoisted

```javascript
// ❌ Error: Cannot access before initialization
sayHello();

let sayHello = () => {
    console.log("Hello!");
};
```

---

## Variable Hoisting

### var Hoisting

Variables declared with `var` are hoisted but initialized with `undefined`:

```javascript
console.log(x);  // undefined (not an error!)
var x = 5;
console.log(x);  // 5
```

**What JavaScript "sees":**
```javascript
var x;  // Declaration hoisted
console.log(x);  // undefined
x = 5;  // Assignment stays in place
console.log(x);  // 5
```

### let and const Hoisting

`let` and `const` are hoisted but not initialized (Temporal Dead Zone):

```javascript
// ❌ Error: Cannot access before initialization
console.log(x);
let x = 5;
```

**Temporal Dead Zone (TDZ):**
- Variables exist but can't be accessed
- Period between start of scope and declaration
- Prevents using variable before declaration

### Hoisting Examples

**var:**
```javascript
console.log(a);  // undefined
var a = 5;
console.log(a);  // 5
```

**let:**
```javascript
// console.log(b);  // ❌ Error: Cannot access
let b = 5;
console.log(b);  // 5
```

**const:**
```javascript
// console.log(c);  // ❌ Error: Cannot access
const c = 5;
console.log(c);  // 5
```

### Function vs Variable Hoisting

Functions are hoisted first, then variables:

```javascript
console.log(typeof myFunc);  // "function" (function hoisted)
console.log(typeof myVar);   // "undefined" (var hoisted but undefined)

function myFunc() { }
var myVar = 5;
```

---

## Common Hoisting Scenarios

### Scenario 1: Function Declaration

```javascript
// ✅ Works
test();

function test() {
    console.log("Hello");
}
```

### Scenario 2: Function Expression

```javascript
// ❌ Error
test();

let test = function() {
    console.log("Hello");
};
```

### Scenario 3: var Variable

```javascript
// ⚠️ Works but x is undefined
console.log(x);  // undefined
var x = 5;
```

### Scenario 4: let Variable

```javascript
// ❌ Error
console.log(x);
let x = 5;
```

### Scenario 5: Function and Variable

```javascript
function example() {
    console.log(typeof myVar);  // "undefined" (not "function")
    var myVar = function() { };
}

example();
```

---

## Scope Best Practices

### 1. Use let and const

```javascript
// ✅ Good
let count = 0;
const MAX = 100;

// ❌ Avoid
var count = 0;
```

### 2. Declare Variables at Top

```javascript
// ✅ Good: Clear scope
function example() {
    let x = 5;
    let y = 10;
    // Use x and y
}

// ⚠️ Works but less clear
function example() {
    // Some code
    let x = 5;
    // More code
    let y = 10;
}
```

### 3. Avoid Global Variables

```javascript
// ❌ Bad: Global pollution
let userName = "Alice";
let userAge = 25;

// ✅ Good: Encapsulate
let user = {
    name: "Alice",
    age: 25
};
```

### 4. Use Block Scope

```javascript
// ✅ Good: Block scope
if (condition) {
    let temp = calculate();
    // Use temp
}
// temp is not accessible (good!)

// ⚠️ Less ideal: Function scope
if (condition) {
    var temp = calculate();
}
// temp still accessible (might be unwanted)
```

### 5. Understand Hoisting

```javascript
// ✅ Good: Declare before use
function example() {
    let x = 5;
    console.log(x);
}

// ⚠️ Works but confusing
function example() {
    console.log(x);  // undefined (hoisted)
    var x = 5;
}
```

---

## Practice Exercise

### Exercise: Scope Practice

**Objective**: Write code that demonstrates different scoping behaviors and hoisting.

**Instructions**:

1. Create a file called `scope-practice.js`

2. Demonstrate:
   - Global scope variables
   - Function scope variables
   - Block scope variables (let, const)
   - Function hoisting
   - Variable hoisting (var, let, const)
   - Nested scopes
   - Scope chain

3. Show common mistakes and correct patterns

**Example Solution**:

```javascript
// Scope Practice
console.log("=== Global Scope ===");
let globalVar = "I'm global";

function accessGlobal() {
    console.log("Inside function:", globalVar);
}

accessGlobal();
console.log("Outside function:", globalVar);
console.log();

console.log("=== Function Scope ===");
function function1() {
    let localVar = "Function 1 variable";
    console.log("Function 1:", localVar);
}

function function2() {
    let localVar = "Function 2 variable";  // Different variable
    console.log("Function 2:", localVar);
}

function1();
function2();
// console.log(localVar);  // ❌ Error: not accessible
console.log();

console.log("=== Block Scope (let/const) ===");
if (true) {
    let blockVar = "Block variable";
    const blockConst = "Block constant";
    console.log("Inside block:", blockVar, blockConst);
}
// console.log(blockVar);  // ❌ Error: not accessible
console.log();

console.log("=== var vs let Scope ===");
function varExample() {
    if (true) {
        var functionScoped = "Function scope";
    }
    console.log("var accessible:", functionScoped);  // Accessible
}

function letExample() {
    if (true) {
        let blockScoped = "Block scope";
        console.log("let inside block:", blockScoped);
    }
    // console.log(blockScoped);  // ❌ Error: not accessible
}

varExample();
letExample();
console.log();

console.log("=== Nested Scopes ===");
let outer = "outer";

function outerFunction() {
    let middle = "middle";
    console.log("Outer function:", outer, middle);
    
    function innerFunction() {
        let inner = "inner";
        console.log("Inner function:", outer, middle, inner);
    }
    
    innerFunction();
    // console.log(inner);  // ❌ Error: not accessible
}

outerFunction();
console.log();

console.log("=== Function Hoisting ===");
// Call before declaration
hoistedFunction();

function hoistedFunction() {
    console.log("I'm hoisted!");
}

// Function expression - NOT hoisted
// notHoisted();  // ❌ Error

let notHoisted = function() {
    console.log("I'm not hoisted");
};
console.log();

console.log("=== Variable Hoisting ===");
// var hoisting
console.log("var before declaration:", hoistedVar);  // undefined
var hoistedVar = "I'm hoisted";
console.log("var after declaration:", hoistedVar);

// let hoisting (Temporal Dead Zone)
// console.log(hoistedLet);  // ❌ Error: Cannot access
let hoistedLet = "I'm in TDZ";
console.log("let after declaration:", hoistedLet);
console.log();

console.log("=== Scope Chain ===");
let level0 = "Level 0";

function level1() {
    let level1Var = "Level 1";
    console.log("Level 1 can access:", level0, level1Var);
    
    function level2() {
        let level2Var = "Level 2";
        console.log("Level 2 can access:", level0, level1Var, level2Var);
        
        function level3() {
            let level3Var = "Level 3";
            console.log("Level 3 can access:", level0, level1Var, level2Var, level3Var);
        }
        
        level3();
    }
    
    level2();
}

level1();
console.log();

console.log("=== Block Scope in Loops ===");
console.log("Using let (block scope):");
for (let i = 0; i < 3; i++) {
    setTimeout(() => {
        console.log("let i:", i);  // 0, 1, 2 (each iteration has own i)
    }, 100);
}

console.log("Using var (function scope):");
for (var j = 0; j < 3; j++) {
    setTimeout(() => {
        console.log("var j:", j);  // 3, 3, 3 (shared variable)
    }, 200);
}
console.log();

console.log("=== Best Practices ===");
// ✅ Good: Use let/const, declare at top
function goodExample() {
    let x = 5;
    let y = 10;
    
    if (x > 0) {
        let temp = x + y;
        console.log("Temp:", temp);
    }
    // temp not accessible (good!)
}

// ⚠️ Less ideal: var, scattered declarations
function lessIdealExample() {
    console.log(x);  // undefined (hoisted)
    var x = 5;
    
    if (x > 0) {
        var temp = x + 5;
    }
    console.log(temp);  // Still accessible (might be unwanted)
}

goodExample();
lessIdealExample();
```

**Expected Output**:
```
=== Global Scope ===
Inside function: I'm global
Outside function: I'm global

=== Function Scope ===
Function 1: Function 1 variable
Function 2: Function 2 variable

=== Block Scope (let/const) ===
Inside block: Block variable Block constant

=== var vs let Scope ===
var accessible: Function scope
let inside block: Block scope

=== Nested Scopes ===
Outer function: outer middle
Inner function: outer middle inner

=== Function Hoisting ===
I'm hoisted!

=== Variable Hoisting ===
var before declaration: undefined
var after declaration: I'm hoisted
let after declaration: I'm in TDZ

=== Scope Chain ===
Level 1 can access: Level 0 Level 1
Level 2 can access: Level 0 Level 1 Level 2
Level 3 can access: Level 0 Level 1 Level 2 Level 3

=== Block Scope in Loops ===
Using let (block scope):
Using var (function scope):
let i: 0
let i: 1
let i: 2
var j: 3
var j: 3
var j: 3

=== Best Practices ===
Temp: 15
undefined
15
```

**Challenge (Optional)**:
- Create examples showing closure behavior
- Demonstrate module pattern using scope
- Show IIFE (Immediately Invoked Function Expression)
- Create scope-related bugs and fixes

---

## Common Mistakes

### 1. Assuming Block Scope for var

```javascript
// ⚠️ var is function-scoped, not block-scoped
if (true) {
    var x = 5;
}
console.log(x);  // 5 (accessible!)

// ✅ Use let for block scope
if (true) {
    let y = 5;
}
// console.log(y);  // ❌ Error: not accessible
```

### 2. Hoisting Confusion

```javascript
// ⚠️ Confusing: x is undefined
console.log(x);  // undefined
var x = 5;

// ✅ Clear: declare first
let y = 5;
console.log(y);  // 5
```

### 3. Global Variable Pollution

```javascript
// ❌ Bad: Too many globals
let userName = "Alice";
let userAge = 25;
let userCity = "NYC";

// ✅ Good: Encapsulate
let user = {
    name: "Alice",
    age: 25,
    city: "NYC"
};
```

### 4. Loop Variable Scope

```javascript
// ⚠️ Problem with var
for (var i = 0; i < 3; i++) {
    setTimeout(() => {
        console.log(i);  // 3, 3, 3 (all same!)
    }, 100);
}

// ✅ Solution: Use let
for (let i = 0; i < 3; i++) {
    setTimeout(() => {
        console.log(i);  // 0, 1, 2 (correct!)
    }, 100);
}
```

### 5. Accessing Before Declaration

```javascript
// ❌ Error with let/const
console.log(x);
let x = 5;

// ✅ Declare first
let y = 5;
console.log(y);
```

---

## Key Takeaways

1. **Global Scope**: Variables outside functions, accessible everywhere
2. **Function Scope**: Variables inside functions, accessible only in function
3. **Block Scope**: Variables in `{}` blocks (let/const), accessible only in block
4. **Function Hoisting**: Function declarations can be called before definition
5. **Variable Hoisting**: var hoisted to undefined, let/const in TDZ
6. **Scope Chain**: Inner scopes can access outer scopes
7. **Best Practice**: Use let/const, avoid var, minimize globals

---

## Quiz: Scope and Hoisting

Test your understanding with these questions:

1. **What scope does `var` have?**
   - A) Block scope
   - B) Function scope
   - C) Global scope
   - D) No scope

2. **What is the output: `console.log(x); var x = 5;`?**
   - A) 5
   - B) undefined
   - C) Error
   - D) null

3. **Which is hoisted?**
   - A) Function expression
   - B) Arrow function
   - C) Function declaration
   - D) let variable

4. **What is Temporal Dead Zone?**
   - A) Error zone
   - B) Period before let/const initialization
   - C) Block scope
   - D) Function scope

5. **Inner functions can access:**
   - A) Only their own variables
   - B) Outer function variables
   - C) Global variables
   - D) All of the above

6. **What scope do `let` and `const` have?**
   - A) Function scope
   - B) Block scope
   - C) Global scope
   - D) No scope

7. **Function declarations are:**
   - A) Not hoisted
   - B) Hoisted
   - C) Block scoped
   - D) Always undefined

**Answers**:
1. B) Function scope
2. B) undefined (var is hoisted but undefined)
3. C) Function declaration
4. B) Period before let/const initialization
5. D) All of the above (scope chain)
6. B) Block scope
7. B) Hoisted

---

## Next Steps

Congratulations! You've learned about scope and hoisting. You now know:
- Global, function, and block scope
- How hoisting works
- Differences between var, let, and const
- Scope chain and nested scopes

**What's Next?**
- Lesson 4.3: Advanced Function Concepts
- Practice with different scoping scenarios
- Understand closure (uses scope)
- Build functions with proper scope

---

## Additional Resources

- **MDN: Scope**: [developer.mozilla.org/en-US/docs/Glossary/Scope](https://developer.mozilla.org/en-US/docs/Glossary/Scope)
- **MDN: Hoisting**: [developer.mozilla.org/en-US/docs/Glossary/Hoisting](https://developer.mozilla.org/en-US/docs/Glossary/Hoisting)
- **JavaScript.info: Variable Scope**: [javascript.info/var](https://javascript.info/var)
- **JavaScript.info: Closure**: [javascript.info/closure](https://javascript.info/closure)

---

*Lesson completed! You're ready to move on to the next lesson.*

