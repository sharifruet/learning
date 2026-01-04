# Lesson 3.3: Error Handling

## Learning Objectives

By the end of this lesson, you will be able to:
- Use try-catch blocks to handle errors
- Throw custom errors with throw statements
- Use finally blocks for cleanup code
- Identify and handle common error types
- Write robust error handling code
- Understand error propagation
- Create custom error messages

---

## Introduction to Error Handling

Error handling allows your program to gracefully handle unexpected situations instead of crashing. It's essential for building robust, production-ready applications.

### Why Error Handling?

- Prevents program crashes
- Provides user-friendly error messages
- Allows graceful recovery
- Helps with debugging
- Improves user experience

### Types of Errors

1. **Syntax Errors**: Code that violates JavaScript syntax
2. **Runtime Errors**: Errors that occur during execution
3. **Logical Errors**: Code runs but produces wrong results

---

## try-catch Blocks

The `try-catch` statement allows you to test a block of code for errors and handle them gracefully.

### Basic Syntax

```javascript
try {
    // Code that might throw an error
} catch (error) {
    // Code to handle the error
}
```

### Simple Example

```javascript
try {
    let result = 10 / 0;
    console.log(result);  // Infinity (not an error, but unexpected)
} catch (error) {
    console.log("An error occurred:", error.message);
}
```

### Catching Actual Errors

```javascript
try {
    let x = y + 5;  // y is not defined
} catch (error) {
    console.log("Error:", error.message);  // "y is not defined"
    console.log("Error name:", error.name);  // "ReferenceError"
}
```

### Real-World Example

```javascript
try {
    let userInput = getUserInput();
    let number = parseInt(userInput);
    
    if (isNaN(number)) {
        throw new Error("Invalid number");
    }
    
    console.log("Number:", number);
} catch (error) {
    console.log("Error:", error.message);
    // Handle error gracefully
}
```

### Accessing Error Information

```javascript
try {
    // Code that might error
    let result = someFunction();
} catch (error) {
    console.log("Error name:", error.name);
    console.log("Error message:", error.message);
    console.log("Error stack:", error.stack);
    console.log("Full error:", error);
}
```

---

## Common Error Types

JavaScript has several built-in error types.

### ReferenceError

Occurs when trying to access a variable that doesn't exist.

```javascript
try {
    console.log(nonExistentVariable);
} catch (error) {
    console.log(error.name);  // "ReferenceError"
    console.log(error.message);  // "nonExistentVariable is not defined"
}
```

### TypeError

Occurs when a value is not of the expected type.

```javascript
try {
    let x = null;
    x.someMethod();  // Can't call method on null
} catch (error) {
    console.log(error.name);  // "TypeError"
    console.log(error.message);  // "Cannot read property 'someMethod' of null"
}
```

### SyntaxError

Occurs when code violates JavaScript syntax (usually caught at parse time).

```javascript
try {
    eval("let x = ;");  // Invalid syntax
} catch (error) {
    console.log(error.name);  // "SyntaxError"
}
```

### RangeError

Occurs when a value is outside the allowed range.

```javascript
try {
    let arr = new Array(-1);  // Invalid array length
} catch (error) {
    console.log(error.name);  // "RangeError"
}
```

### URIError

Occurs with incorrect use of URI handling functions.

```javascript
try {
    decodeURIComponent("%");  // Invalid URI
} catch (error) {
    console.log(error.name);  // "URIError"
}
```

### Handling Specific Error Types

```javascript
try {
    // Code that might error
    riskyOperation();
} catch (error) {
    if (error instanceof TypeError) {
        console.log("Type error:", error.message);
    } else if (error instanceof ReferenceError) {
        console.log("Reference error:", error.message);
    } else {
        console.log("Other error:", error.message);
    }
}
```

---

## throw Statement

The `throw` statement allows you to create and throw custom errors.

### Basic Syntax

```javascript
throw expression;
```

### Throwing Strings

```javascript
try {
    throw "Something went wrong";
} catch (error) {
    console.log(error);  // "Something went wrong"
}
```

### Throwing Error Objects

```javascript
try {
    throw new Error("Custom error message");
} catch (error) {
    console.log(error.message);  // "Custom error message"
    console.log(error.name);     // "Error"
}
```

### Throwing Specific Error Types

```javascript
// TypeError
throw new TypeError("Expected a number");

// ReferenceError
throw new ReferenceError("Variable not defined");

// Custom message
throw new Error("Invalid input: must be positive number");
```

### Practical Examples

**Input Validation:**
```javascript
function divide(a, b) {
    if (b === 0) {
        throw new Error("Division by zero is not allowed");
    }
    return a / b;
}

try {
    let result = divide(10, 0);
} catch (error) {
    console.log("Error:", error.message);
}
```

**Type Checking:**
```javascript
function processNumber(num) {
    if (typeof num !== "number") {
        throw new TypeError("Expected a number");
    }
    if (num < 0) {
        throw new RangeError("Number must be positive");
    }
    return num * 2;
}

try {
    processNumber("hello");
} catch (error) {
    console.log(error.name + ":", error.message);
}
```

**Custom Validation:**
```javascript
function validateAge(age) {
    if (age < 0) {
        throw new Error("Age cannot be negative");
    }
    if (age > 150) {
        throw new Error("Age seems unrealistic");
    }
    if (!Number.isInteger(age)) {
        throw new Error("Age must be an integer");
    }
    return true;
}

try {
    validateAge(-5);
} catch (error) {
    console.log("Validation failed:", error.message);
}
```

---

## finally Block

The `finally` block executes code regardless of whether an error occurred or not. It's useful for cleanup operations.

### Basic Syntax

```javascript
try {
    // Code that might error
} catch (error) {
    // Handle error
} finally {
    // Always executes
}
```

### Simple Example

```javascript
try {
    console.log("Try block");
    throw new Error("Test error");
} catch (error) {
    console.log("Catch block:", error.message);
} finally {
    console.log("Finally block - always runs");
}
// Output:
// Try block
// Catch block: Test error
// Finally block - always runs
```

### Without Error

```javascript
try {
    console.log("Try block - no error");
} catch (error) {
    console.log("Catch block");
} finally {
    console.log("Finally block - always runs");
}
// Output:
// Try block - no error
// Finally block - always runs
```

### Practical Use Cases

**Resource Cleanup:**
```javascript
let fileHandle = null;

try {
    fileHandle = openFile("data.txt");
    processFile(fileHandle);
} catch (error) {
    console.log("Error processing file:", error.message);
} finally {
    if (fileHandle) {
        closeFile(fileHandle);  // Always close, even on error
    }
}
```

**Database Connections:**
```javascript
let connection = null;

try {
    connection = connectToDatabase();
    executeQuery(connection);
} catch (error) {
    console.log("Database error:", error.message);
} finally {
    if (connection) {
        connection.close();  // Always close connection
    }
}
```

**Timer Cleanup:**
```javascript
let timer = null;

try {
    timer = setInterval(() => {
        // Do something
    }, 1000);
    // Some code that might error
} catch (error) {
    console.log("Error:", error.message);
} finally {
    if (timer) {
        clearInterval(timer);  // Always clear timer
    }
}
```

### finally with return

**Important**: `finally` executes even if there's a return statement:

```javascript
function test() {
    try {
        return "from try";
    } catch (error) {
        return "from catch";
    } finally {
        console.log("Finally always runs");
    }
}

console.log(test());
// Output:
// Finally always runs
// from try
```

---

## Error Propagation

Errors propagate up the call stack until they're caught or reach the top level.

### Uncaught Errors

```javascript
function level1() {
    level2();
}

function level2() {
    level3();
}

function level3() {
    throw new Error("Error in level3");
}

try {
    level1();
} catch (error) {
    console.log("Caught:", error.message);  // "Error in level3"
}
```

### Catching at Different Levels

```javascript
function level1() {
    try {
        level2();
    } catch (error) {
        console.log("Caught in level1:", error.message);
    }
}

function level2() {
    level3();
}

function level3() {
    throw new Error("Error in level3");
}

level1();  // Error caught in level1
```

### Re-throwing Errors

You can catch an error, handle it, and then re-throw it:

```javascript
function processData(data) {
    try {
        validateData(data);
    } catch (error) {
        console.log("Validation failed, logging error");
        throw error;  // Re-throw to caller
    }
}

try {
    processData(null);
} catch (error) {
    console.log("Caught by caller:", error.message);
}
```

---

## Best Practices

### 1. Be Specific with Error Messages

```javascript
// ❌ Vague
throw new Error("Error");

// ✅ Specific
throw new Error("Invalid email format: must contain @ symbol");
```

### 2. Handle Errors Appropriately

```javascript
// ✅ Good: Handle and recover
try {
    let data = fetchData();
} catch (error) {
    console.log("Using default data");
    data = getDefaultData();
}

// ❌ Bad: Swallow errors silently
try {
    riskyOperation();
} catch (error) {
    // Silent failure - bad!
}
```

### 3. Use finally for Cleanup

```javascript
// ✅ Good: Always cleanup
let resource = acquireResource();
try {
    useResource(resource);
} finally {
    releaseResource(resource);
}
```

### 4. Don't Catch Everything Blindly

```javascript
// ⚠️ Too broad
try {
    // Lots of code
} catch (error) {
    // Catches everything - might hide bugs
}

// ✅ Better: Catch specific errors
try {
    // Code
} catch (error) {
    if (error instanceof TypeError) {
        // Handle type errors
    } else {
        throw error;  // Re-throw unexpected errors
    }
}
```

### 5. Provide Context

```javascript
// ✅ Good: Add context
try {
    processUser(userId);
} catch (error) {
    throw new Error(`Failed to process user ${userId}: ${error.message}`);
}
```

---

## Practice Exercise

### Exercise: Error Handling

**Objective**: Write a program that demonstrates error handling with try-catch, throw, and finally.

**Instructions**:

1. Create a file called `error-handling.js`

2. Create functions that might throw errors:
   - Divide function (throw on division by zero)
   - Validate age function (throw on invalid age)
   - Parse number function (throw on invalid input)
   - Access array element (might throw)

3. Use try-catch to handle errors:
   - Catch specific error types
   - Provide user-friendly messages
   - Handle different scenarios

4. Use finally blocks:
   - Clean up resources
   - Log completion status

5. Demonstrate:
   - Error propagation
   - Re-throwing errors
   - Multiple catch scenarios

**Example Solution**:

```javascript
// Error Handling Practice
console.log("=== Basic Try-Catch ===");
try {
    let result = 10 / 0;
    console.log("Result:", result);  // Infinity (not an error)
} catch (error) {
    console.log("Error:", error.message);
}

try {
    let x = undefinedVariable;
} catch (error) {
    console.log("Caught:", error.name, "-", error.message);
}
console.log();

console.log("=== Custom Error with Throw ===");
function divide(a, b) {
    if (b === 0) {
        throw new Error("Division by zero is not allowed");
    }
    if (typeof a !== "number" || typeof b !== "number") {
        throw new TypeError("Both arguments must be numbers");
    }
    return a / b;
}

try {
    console.log(divide(10, 2));  // 5
} catch (error) {
    console.log("Error:", error.message);
}

try {
    console.log(divide(10, 0));  // Error
} catch (error) {
    console.log("Error:", error.message);
}

try {
    console.log(divide("10", 2));  // Error
} catch (error) {
    console.log("Error:", error.message);
}
console.log();

console.log("=== Validation Function ===");
function validateAge(age) {
    if (typeof age !== "number") {
        throw new TypeError("Age must be a number");
    }
    if (!Number.isInteger(age)) {
        throw new Error("Age must be an integer");
    }
    if (age < 0) {
        throw new RangeError("Age cannot be negative");
    }
    if (age > 150) {
        throw new RangeError("Age seems unrealistic");
    }
    return true;
}

let testAges = [25, -5, "thirty", 25.5, 200];

testAges.forEach(age => {
    try {
        validateAge(age);
        console.log(`Age ${age} is valid`);
    } catch (error) {
        console.log(`Age ${age}: ${error.name} - ${error.message}`);
    }
});
console.log();

console.log("=== Finally Block ===");
function processFile(filename) {
    let fileHandle = `handle_${filename}`;
    console.log(`Opening file: ${filename}`);
    
    try {
        if (filename === "error.txt") {
            throw new Error("File not found");
        }
        console.log(`Processing ${filename}...`);
        return "File processed successfully";
    } catch (error) {
        console.log(`Error processing ${filename}:`, error.message);
        throw error;  // Re-throw
    } finally {
        console.log(`Closing file handle: ${fileHandle}`);
    }
}

try {
    console.log(processFile("data.txt"));
} catch (error) {
    console.log("Caught by caller:", error.message);
}

try {
    console.log(processFile("error.txt"));
} catch (error) {
    console.log("Caught by caller:", error.message);
}
console.log();

console.log("=== Error Propagation ===");
function level1() {
    console.log("Level 1: calling level2");
    level2();
}

function level2() {
    console.log("Level 2: calling level3");
    level3();
}

function level3() {
    console.log("Level 3: throwing error");
    throw new Error("Error originated in level3");
}

try {
    level1();
} catch (error) {
    console.log("Caught at top level:", error.message);
    console.log("Stack trace:", error.stack.split("\n")[0]);
}
console.log();

console.log("=== Handling Specific Error Types ===");
function riskyOperation(type) {
    if (type === "reference") {
        console.log(nonExistent);  // ReferenceError
    } else if (type === "type") {
        let x = null;
        x.method();  // TypeError
    } else if (type === "range") {
        let arr = new Array(-1);  // RangeError
    } else {
        throw new Error("Unknown operation type");
    }
}

let operations = ["reference", "type", "range", "unknown"];

operations.forEach(op => {
    try {
        riskyOperation(op);
    } catch (error) {
        if (error instanceof ReferenceError) {
            console.log(`ReferenceError: ${error.message}`);
        } else if (error instanceof TypeError) {
            console.log(`TypeError: ${error.message}`);
        } else if (error instanceof RangeError) {
            console.log(`RangeError: ${error.message}`);
        } else {
            console.log(`Other error: ${error.message}`);
        }
    }
});
console.log();

console.log("=== Safe Array Access ===");
function safeArrayAccess(arr, index) {
    try {
        if (!Array.isArray(arr)) {
            throw new TypeError("First argument must be an array");
        }
        if (typeof index !== "number") {
            throw new TypeError("Index must be a number");
        }
        if (index < 0 || index >= arr.length) {
            throw new RangeError(`Index ${index} is out of bounds`);
        }
        return arr[index];
    } catch (error) {
        console.log(`Error accessing array: ${error.message}`);
        return null;
    }
}

let numbers = [10, 20, 30, 40, 50];
console.log(safeArrayAccess(numbers, 2));    // 30
console.log(safeArrayAccess(numbers, 10));   // Error
console.log(safeArrayAccess(numbers, -1));   // Error
console.log(safeArrayAccess("not array", 0)); // Error
```

**Expected Output**:
```
=== Basic Try-Catch ===
Result: Infinity
Caught: ReferenceError - undefinedVariable is not defined

=== Custom Error with Throw ===
5
Error: Division by zero is not allowed
Error: Both arguments must be numbers

=== Validation Function ===
Age 25 is valid
Age -5: RangeError - Age cannot be negative
Age thirty: TypeError - Age must be a number
Age 25.5: Error - Age must be an integer
Age 200: RangeError - Age seems unrealistic

=== Finally Block ===
Opening file: data.txt
Processing data.txt...
Closing file handle: handle_data.txt
File processed successfully
Opening file: error.txt
Error processing error.txt: File not found
Closing file handle: handle_error.txt
Caught by caller: File not found

=== Error Propagation ===
Level 1: calling level2
Level 2: calling level3
Level 3: throwing error
Caught at top level: Error originated in level3
Stack trace: Error: Error originated in level3

=== Handling Specific Error Types ===
ReferenceError: nonExistent is not defined
TypeError: Cannot read property 'method' of null
RangeError: Invalid array length
Other error: Unknown operation type

=== Safe Array Access ===
30
Error accessing array: Index 10 is out of bounds
Error accessing array: Index -1 is out of bounds
Error accessing array: First argument must be an array
```

**Challenge (Optional)**:
- Create a robust input validation system
- Build error logging functionality
- Create custom error classes
- Implement retry logic with error handling
- Build a safe API caller with error handling

---

## Common Mistakes

### 1. Swallowing Errors

```javascript
// ❌ Bad: Silent failure
try {
    riskyOperation();
} catch (error) {
    // Do nothing - hides bugs!
}

// ✅ Good: Log or handle
try {
    riskyOperation();
} catch (error) {
    console.error("Operation failed:", error);
    // Or handle appropriately
}
```

### 2. Catching Too Broadly

```javascript
// ⚠️ Catches everything
try {
    // Lots of code
} catch (error) {
    // Might hide unexpected errors
}

// ✅ Better: Be specific
try {
    // Code
} catch (error) {
    if (error instanceof ExpectedError) {
        // Handle expected error
    } else {
        throw error;  // Re-throw unexpected
    }
}
```

### 3. Not Using finally for Cleanup

```javascript
// ❌ Resource might not be cleaned up
let resource = acquire();
try {
    use(resource);
} catch (error) {
    handle(error);
}
// What if error occurs? Resource not cleaned up!

// ✅ Always cleanup
let resource = acquire();
try {
    use(resource);
} catch (error) {
    handle(error);
} finally {
    cleanup(resource);
}
```

### 4. Throwing Non-Error Values

```javascript
// ⚠️ Works but not ideal
throw "Error message";

// ✅ Better: Use Error object
throw new Error("Error message");
```

### 5. Not Providing Context

```javascript
// ❌ Vague
throw new Error("Error");

// ✅ Specific
throw new Error(`Failed to process user ${userId}: ${originalError.message}`);
```

---

## Key Takeaways

1. **try-catch**: Handle errors gracefully
2. **throw**: Create and throw custom errors
3. **finally**: Always executes, useful for cleanup
4. **Error Types**: ReferenceError, TypeError, RangeError, etc.
5. **Error Propagation**: Errors bubble up until caught
6. **Best Practices**: Be specific, handle appropriately, use finally
7. **Don't Swallow**: Always log or handle errors

---

## Quiz: Error Handling

Test your understanding with these questions:

1. **What does a try-catch block do?**
   - A) Prevents all errors
   - B) Handles errors gracefully
   - C) Stops program execution
   - D) Nothing

2. **When does a finally block execute?**
   - A) Only if error occurs
   - B) Only if no error
   - C) Always
   - D) Never

3. **What is thrown when accessing undefined variable?**
   - A) TypeError
   - B) ReferenceError
   - C) SyntaxError
   - D) RangeError

4. **What does `throw` do?**
   - A) Catches errors
   - B) Creates and throws errors
   - C) Prevents errors
   - D) Logs errors

5. **What happens to uncaught errors?**
   - A) They're ignored
   - B) They crash the program
   - C) They're logged automatically
   - D) They're converted to warnings

6. **Which is best practice?**
   - A) Catch all errors silently
   - B) Use specific error handling
   - C) Never use try-catch
   - D) Always throw errors

7. **What does `error.message` contain?**
   - A) Error name
   - B) Error description
   - C) Stack trace
   - D) Error type

**Answers**:
1. B) Handles errors gracefully
2. C) Always
3. B) ReferenceError
4. B) Creates and throws errors
5. B) They crash the program (in browser/Node.js)
6. B) Use specific error handling
7. B) Error description

---

## Next Steps

Congratulations! You've completed Module 3: Control Flow. You now know:
- Conditional statements (if, else, switch)
- All types of loops
- Error handling with try-catch

**What's Next?**
- Module 4: Functions
- Lesson 4.1: Function Basics
- Practice combining control flow concepts
- Build more complex programs

---

## Additional Resources

- **MDN: try...catch**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/try...catch](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/try...catch)
- **MDN: throw**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/throw](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/throw)
- **MDN: Error**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Error](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Error)
- **JavaScript.info: Error Handling**: [javascript.info/error-handling](https://javascript.info/error-handling)

---

*Lesson completed! You've finished Module 3: Control Flow. Ready for Module 4: Functions!*

