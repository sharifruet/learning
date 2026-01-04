# Lesson 1.2: JavaScript Syntax and Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand JavaScript syntax rules and conventions
- Distinguish between statements and expressions
- Know when semicolons are required vs optional
- Write single-line and multi-line comments
- Understand code blocks and basic scope concepts
- Write syntactically correct JavaScript code

---

## JavaScript Syntax Rules

Syntax is the set of rules that defines how JavaScript code must be written. Understanding syntax is crucial for writing valid, executable code.

### Basic Syntax Rules

1. **Case Sensitivity**: JavaScript is case-sensitive
   ```javascript
   let name = "Alice";
   let Name = "Bob";  // Different variable
   let NAME = "Charlie";  // Another different variable
   ```

2. **Whitespace**: Spaces and tabs are generally ignored (except in strings)
   ```javascript
   let x=5;      // Valid
   let x = 5;    // Also valid (more readable)
   let x  =  5;  // Also valid (spaces ignored)
   ```

3. **Line Breaks**: Generally ignored, but can affect code readability
   ```javascript
   let x = 5; let y = 10;  // Multiple statements on one line
   let x = 5;
   let y = 10;  // More readable
   ```

4. **Identifiers**: Names for variables, functions, etc.
   - Must start with letter, underscore (_), or dollar sign ($)
   - Can contain letters, digits, underscores, or dollar signs
   - Cannot be reserved words (if, for, function, etc.)
   ```javascript
   let name = "Alice";      // Valid
   let _private = "secret"; // Valid
   let $element = "div";    // Valid
   let 2name = "invalid";   // Invalid - starts with number
   let my-name = "invalid"; // Invalid - contains hyphen
   ```

5. **Reserved Words**: Cannot be used as identifiers
   ```javascript
   // These are reserved and cannot be used:
   // if, else, for, while, function, var, let, const, return, etc.
   let function = "invalid";  // Error!
   ```

---

## Statements and Expressions

Understanding the difference between statements and expressions is fundamental to JavaScript.

### Expressions

An **expression** is a piece of code that produces a value. Expressions can be evaluated to a single value.

**Examples of Expressions:**
```javascript
// Literal values
42
"Hello"
true

// Variables
name
x

// Operations
2 + 2
x * 5
name.length

// Function calls (that return values)
Math.max(1, 2, 3)
parseInt("42")
```

**Expression Evaluation:**
```javascript
// Each of these evaluates to a value
console.log(5);           // 5
console.log(2 + 3);       // 5
console.log("Hello");     // "Hello"
console.log(name);        // Value of name variable
```

### Statements

A **statement** is an instruction that performs an action. Statements don't necessarily produce values, but they do something.

**Examples of Statements:**
```javascript
// Variable declaration
let x = 5;

// Conditional statement
if (x > 0) {
    console.log("Positive");
}

// Loop statement
for (let i = 0; i < 5; i++) {
    console.log(i);
}

// Function declaration
function greet() {
    console.log("Hello");
}
```

### Expression Statements

Some expressions can be used as statements:

```javascript
// Assignment expression used as statement
x = 5;

// Function call expression used as statement
console.log("Hello");

// Increment expression used as statement
x++;
```

### Key Differences

| Expressions | Statements |
|------------|-----------|
| Produce values | Perform actions |
| Can be used in other expressions | Standalone instructions |
| Examples: `2 + 2`, `name.length` | Examples: `let x = 5;`, `if (condition) {}` |

---

## Semicolons in JavaScript

Semicolons (`;`) in JavaScript are used to mark the end of statements. However, JavaScript has a feature called **Automatic Semicolon Insertion (ASI)** that can automatically add semicolons in many cases.

### When Semicolons Are Required

**1. Multiple Statements on One Line:**
```javascript
let x = 5; let y = 10;  // Semicolons required
```

**2. Before Certain Keywords:**
```javascript
// Without semicolon, this could cause issues
let x = 5
[1, 2, 3].forEach(console.log)  // Could be interpreted as x[1, 2, 3]

// With semicolon, it's clear
let x = 5;
[1, 2, 3].forEach(console.log);
```

**3. Return Statements:**
```javascript
function getValue() {
    return  // ASI adds semicolon here, returns undefined!
        5;
}

// Correct:
function getValue() {
    return 5;  // Explicit semicolon
}
```

### When Semicolons Are Optional

**Single Statement on a Line:**
```javascript
let x = 5;  // Semicolon optional
let x = 5   // Also works (ASI adds it)
```

**After Block Statements:**
```javascript
if (x > 0) {
    console.log("Positive");
}  // No semicolon needed after blocks
```

### Best Practices

**Recommended: Always Use Semicolons**
- Makes code more explicit
- Prevents potential ASI bugs
- Consistent style
- Required in some cases anyway

```javascript
// Good practice
let name = "Alice";
let age = 25;
console.log(name, age);

// Also acceptable (but less explicit)
let name = "Alice"
let age = 25
console.log(name, age)
```

**Common Semicolon Mistakes:**
```javascript
// Missing semicolon can cause issues
let x = 5
let y = 10  // Works, but risky

// Better:
let x = 5;
let y = 10;
```

---

## Comments

Comments are notes in your code that are ignored by JavaScript. They help document your code and explain what it does.

### Single-Line Comments

Use `//` for single-line comments. Everything after `//` on that line is ignored.

```javascript
// This is a single-line comment
let x = 5;  // This comment explains the variable

// You can also comment out code
// let y = 10;
// console.log(y);
```

**Common Uses:**
```javascript
// Explain what the code does
let userName = "Alice";  // Store the user's name

// Temporarily disable code
// console.log("Debug message");

// Add notes
// TODO: Add error handling here
// FIXME: This needs optimization
```

### Multi-Line Comments

Use `/* */` for multi-line comments. Everything between `/*` and `*/` is ignored.

```javascript
/* This is a multi-line comment
   It can span multiple lines
   Useful for longer explanations */

let x = 5;

/*
 * This is a common style for multi-line comments
 * Each line starts with an asterisk
 * Makes it more readable
 */
```

**Block Comments:**
```javascript
/* 
   Function: calculateTotal
   Description: Calculates the total price
   Parameters: price (number), tax (number)
   Returns: total (number)
*/
function calculateTotal(price, tax) {
    return price + (price * tax);
}
```

### When to Use Comments

**Good Uses:**
- Explain **why** code exists, not what it does
- Document complex algorithms
- Add TODO notes
- Explain non-obvious code
- Document function parameters and return values

**Avoid:**
- Stating the obvious
- Commenting out large blocks of code (use version control instead)
- Outdated comments that don't match the code

**Examples:**

```javascript
// Good comment
// Calculate discount based on user's membership level
let discount = membershipLevel * 0.1;

// Bad comment (too obvious)
// Set x to 5
let x = 5;

// Good comment (explains why)
// Use Math.floor to prevent floating-point precision issues
let result = Math.floor(price * 1.1);

// Good multi-line comment for complex logic
/*
 * This algorithm uses the Euclidean method to find
 * the greatest common divisor of two numbers.
 * Time complexity: O(log(min(a, b)))
 */
function gcd(a, b) {
    // Implementation here
}
```

### Commenting Out Code

Comments are useful for temporarily disabling code:

```javascript
// Old implementation
// function oldFunction() {
//     return "old";
// }

// New implementation
function newFunction() {
    return "new";
}
```

**Note**: For large blocks of code, consider using version control (Git) instead of commenting out.

---

## Code Blocks and Scope

### Code Blocks

A **code block** is a group of statements enclosed in curly braces `{}`. Code blocks define scope and are used with control structures.

**Basic Syntax:**
```javascript
{
    // This is a code block
    let x = 5;
    let y = 10;
    console.log(x + y);
}
```

### Blocks with Control Structures

**If Statement:**
```javascript
if (condition) {
    // Code block
    console.log("Condition is true");
}
```

**Function:**
```javascript
function greet() {
    // Code block
    console.log("Hello");
}
```

**Loop:**
```javascript
for (let i = 0; i < 5; i++) {
    // Code block
    console.log(i);
}
```

### Scope Basics

**Scope** determines where variables are accessible. JavaScript has different types of scope:

**Global Scope:**
```javascript
// Variables declared outside any block
let globalVar = "I'm global";

function myFunction() {
    console.log(globalVar);  // Can access globalVar
}
```

**Local/Function Scope:**
```javascript
function myFunction() {
    let localVar = "I'm local";
    console.log(localVar);  // Can access localVar
}

// console.log(localVar);  // Error! localVar is not accessible here
```

**Block Scope (with let/const):**
```javascript
if (true) {
    let blockVar = "I'm in a block";
    console.log(blockVar);  // Can access blockVar
}

// console.log(blockVar);  // Error! blockVar is not accessible here
```

### Scope Rules

1. **Variables declared with `var`** have function scope (or global if outside function)
2. **Variables declared with `let`/`const`** have block scope
3. **Inner scopes can access outer scopes**, but not vice versa

**Example:**
```javascript
let outer = "I'm outside";

function myFunction() {
    let middle = "I'm in the function";
    
    if (true) {
        let inner = "I'm in the block";
        
        console.log(outer);   // ✅ Can access outer
        console.log(middle);  // ✅ Can access middle
        console.log(inner);    // ✅ Can access inner
    }
    
    console.log(outer);   // ✅ Can access outer
    console.log(middle);  // ✅ Can access middle
    // console.log(inner);  // ❌ Error! inner is not accessible
}

// console.log(outer);   // ✅ Can access outer
// console.log(middle);  // ❌ Error! middle is not accessible
// console.log(inner);   // ❌ Error! inner is not accessible
```

### Nested Blocks

Blocks can be nested inside other blocks:

```javascript
{
    let level1 = "Level 1";
    
    {
        let level2 = "Level 2";
        
        {
            let level3 = "Level 3";
            console.log(level1);  // ✅ Can access all levels
            console.log(level2);  // ✅ Can access level2 and level3
            console.log(level3);  // ✅ Can access level3
        }
        
        console.log(level1);  // ✅ Can access level1 and level2
        console.log(level2);  // ✅ Can access level2
        // console.log(level3);  // ❌ Error! level3 not accessible
    }
    
    console.log(level1);  // ✅ Can access level1
    // console.log(level2);  // ❌ Error! level2 not accessible
    // console.log(level3);  // ❌ Error! level3 not accessible
}
```

---

## Syntax Best Practices

### 1. Consistent Formatting

```javascript
// Good: Consistent spacing
let name = "Alice";
let age = 25;
let city = "New York";

// Bad: Inconsistent spacing
let name="Alice";
let age= 25;
let city ="New York";
```

### 2. Meaningful Names

```javascript
// Good: Descriptive names
let userName = "Alice";
let userAge = 25;

// Bad: Unclear names
let n = "Alice";
let a = 25;
```

### 3. Proper Indentation

```javascript
// Good: Proper indentation
if (condition) {
    console.log("True");
    if (nested) {
        console.log("Nested");
    }
}

// Bad: No indentation
if (condition) {
console.log("True");
if (nested) {
console.log("Nested");
}
}
```

### 4. Use Semicolons

```javascript
// Good: Explicit semicolons
let x = 5;
let y = 10;

// Acceptable but less explicit
let x = 5
let y = 10
```

### 5. Comment Wisely

```javascript
// Good: Comments explain why
// Calculate tax using state-specific rate
let tax = price * stateTaxRate;

// Bad: Comment states the obvious
// Set tax to price times stateTaxRate
let tax = price * stateTaxRate;
```

---

## Practice Exercise

### Exercise: Practice Syntax

**Objective**: Write JavaScript code that demonstrates proper syntax, comments, and code blocks.

**Instructions**:

1. Create a file called `syntax-practice.js`

2. Write code that includes:
   - At least 5 variable declarations with proper syntax
   - Single-line comments explaining each variable
   - A multi-line comment describing what the program does
   - At least 2 code blocks (if statements or functions)
   - Proper use of semicolons
   - Proper indentation

3. Your code should demonstrate:
   - Different data types (strings, numbers, booleans)
   - Scope (global and local variables)
   - Code blocks with proper formatting

**Example Solution**:

```javascript
/*
 * Syntax Practice Program
 * This program demonstrates JavaScript syntax rules,
 * comments, code blocks, and scope.
 */

// Global variables
let userName = "Alice";
let userAge = 25;
let isActive = true;
let userScore = 95.5;
let userCity = "New York";

// Function with local scope
function displayUserInfo() {
    // Local variable
    let greeting = "Hello";
    
    // Code block with if statement
    if (isActive) {
        console.log(greeting + ", " + userName);
        console.log("Age: " + userAge);
        console.log("City: " + userCity);
        console.log("Score: " + userScore);
    }
}

// Another code block
if (userScore >= 90) {
    let grade = "A";
    console.log("Grade: " + grade);
}

// Call the function
displayUserInfo();
```

**Expected Output**:
```
Hello, Alice
Age: 25
City: New York
Score: 95.5
Grade: A
```

**Challenge (Optional)**:
- Add nested code blocks
- Use different comment styles
- Create variables in different scopes
- Add more complex expressions

---

## Common Syntax Errors

### 1. Missing Quotes

```javascript
// Error
let name = Alice;  // Alice is not defined

// Correct
let name = "Alice";
```

### 2. Mismatched Brackets

```javascript
// Error
if (condition) {
    console.log("Hello";
}

// Correct
if (condition) {
    console.log("Hello");
}
```

### 3. Reserved Words

```javascript
// Error
let function = "invalid";

// Correct
let myFunction = "valid";
```

### 4. Invalid Identifiers

```javascript
// Error
let 2name = "invalid";
let my-name = "invalid";

// Correct
let name2 = "valid";
let myName = "valid";
```

### 5. Missing Semicolons (in some cases)

```javascript
// Can cause issues
let x = 5
[1, 2, 3].forEach(console.log)  // Could be interpreted as x[1, 2, 3]

// Better
let x = 5;
[1, 2, 3].forEach(console.log);
```

---

## Key Takeaways

1. **Syntax Rules**: JavaScript is case-sensitive, uses specific naming rules
2. **Statements vs Expressions**: Statements perform actions, expressions produce values
3. **Semicolons**: Optional but recommended for clarity and to avoid ASI bugs
4. **Comments**: Use `//` for single-line, `/* */` for multi-line
5. **Code Blocks**: Defined with `{}`, create scope boundaries
6. **Scope**: Variables are accessible based on where they're declared
7. **Best Practices**: Consistent formatting, meaningful names, proper indentation

---

## Quiz: Syntax Fundamentals

Test your understanding with these questions:

1. **JavaScript is case-sensitive. True or False?**
   - A) True
   - B) False

2. **Which of these is a valid identifier?**
   - A) `2name`
   - B) `my-name`
   - C) `_name`
   - D) `function`

3. **What does `console.log(2 + 2)` represent?**
   - A) A statement
   - B) An expression
   - C) Both statement and expression
   - D) Neither

4. **Semicolons in JavaScript are:**
   - A) Always required
   - B) Always optional
   - C) Optional but recommended
   - D) Never used

5. **Which comment style is for multi-line comments?**
   - A) `//`
   - B) `/* */`
   - C) `#`
   - D) `<!-- -->`

6. **Variables declared inside a code block with `let` are accessible:**
   - A) Globally
   - B) Only within that block
   - C) In parent blocks only
   - D) Everywhere

7. **What symbol is used to define code blocks?**
   - A) `[]`
   - B) `()`
   - C) `{}`
   - D) `<>`

**Answers**:
1. A) True
2. C) `_name`
3. C) Both statement and expression (it's an expression used as a statement)
4. C) Optional but recommended
5. B) `/* */`
6. B) Only within that block
7. C) `{}`

---

## Next Steps

Congratulations! You've learned JavaScript syntax fundamentals. You now know:
- JavaScript syntax rules and conventions
- The difference between statements and expressions
- How to use semicolons properly
- How to write comments
- How code blocks and scope work

**What's Next?**
- Lesson 1.3: Variables and Data Types
- Practice writing syntactically correct code
- Experiment with different code block structures
- Explore scope with nested blocks

---

## Additional Resources

- **MDN: JavaScript Syntax**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Grammar_and_types](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Grammar_and_types)
- **JavaScript.info: Code Quality**: [javascript.info/code-quality](https://javascript.info/code-quality)
- **Airbnb JavaScript Style Guide**: [github.com/airbnb/javascript](https://github.com/airbnb/javascript)

---

*Lesson completed! You're ready to move on to the next lesson.*

