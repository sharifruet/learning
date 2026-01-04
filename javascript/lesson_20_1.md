# Lesson 20.1: Advanced Error Handling

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand different error types
- Create custom error classes
- Implement error handling strategies
- Set up global error handling
- Handle errors in async code
- Build robust error handling systems
- Write more reliable code

---

## Introduction to Error Handling

Error handling is crucial for building robust applications. Proper error handling improves user experience and makes debugging easier.

### Why Error Handling?

- **User Experience**: Graceful error messages
- **Debugging**: Easier to find and fix issues
- **Reliability**: Applications don't crash unexpectedly
- **Maintainability**: Clear error information
- **Best Practices**: Professional code quality
- **Production Ready**: Handle edge cases

---

## Error Types

### Built-in Error Types

```javascript
// Error (base class)
try {
    throw new Error('Something went wrong');
} catch (error) {
    console.log(error.name);      // 'Error'
    console.log(error.message);    // 'Something went wrong'
    console.log(error.stack);      // Stack trace
}

// TypeError
try {
    null.someProperty;
} catch (error) {
    console.log(error.name);      // 'TypeError'
}

// ReferenceError
try {
    console.log(undefinedVariable);
} catch (error) {
    console.log(error.name);      // 'ReferenceError'
}

// SyntaxError
try {
    eval('invalid syntax {');
} catch (error) {
    console.log(error.name);      // 'SyntaxError'
}

// RangeError
try {
    let arr = new Array(-1);
} catch (error) {
    console.log(error.name);      // 'RangeError'
}
```

### Common Error Types

```javascript
// TypeError: Wrong type
let num = 'hello';
num.toUpperCase();  // Works
num.toFixed();      // TypeError: num.toFixed is not a function

// ReferenceError: Variable doesn't exist
console.log(undefinedVar);  // ReferenceError

// SyntaxError: Invalid syntax
// let x = {;  // SyntaxError

// RangeError: Out of range
let arr = new Array(-1);  // RangeError

// URIError: Invalid URI
decodeURIComponent('%');  // URIError
```

---

## Custom Errors

### Basic Custom Error

```javascript
class CustomError extends Error {
    constructor(message) {
        super(message);
        this.name = 'CustomError';
        Error.captureStackTrace(this, this.constructor);
    }
}

try {
    throw new CustomError('Custom error message');
} catch (error) {
    console.log(error.name);      // 'CustomError'
    console.log(error.message);    // 'Custom error message'
}
```

### Custom Error with Additional Properties

```javascript
class ValidationError extends Error {
    constructor(message, field, value) {
        super(message);
        this.name = 'ValidationError';
        this.field = field;
        this.value = value;
        Error.captureStackTrace(this, this.constructor);
    }
}

try {
    throw new ValidationError('Invalid email', 'email', 'invalid');
} catch (error) {
    if (error instanceof ValidationError) {
        console.log(`Field: ${error.field}`);
        console.log(`Value: ${error.value}`);
        console.log(`Message: ${error.message}`);
    }
}
```

### Multiple Custom Error Types

```javascript
class NetworkError extends Error {
    constructor(message, statusCode) {
        super(message);
        this.name = 'NetworkError';
        this.statusCode = statusCode;
    }
}

class AuthenticationError extends Error {
    constructor(message) {
        super(message);
        this.name = 'AuthenticationError';
    }
}

class NotFoundError extends Error {
    constructor(resource) {
        super(`${resource} not found`);
        this.name = 'NotFoundError';
        this.resource = resource;
    }
}

// Usage
try {
    throw new NetworkError('Connection failed', 500);
} catch (error) {
    if (error instanceof NetworkError) {
        console.log(`Network error: ${error.message} (${error.statusCode})`);
    } else if (error instanceof AuthenticationError) {
        console.log('Authentication failed');
    } else if (error instanceof NotFoundError) {
        console.log(`${error.resource} not found`);
    }
}
```

---

## Error Handling Strategies

### Try-Catch-Finally

```javascript
function riskyOperation() {
    try {
        // Code that might throw
        let result = someFunction();
        return result;
    } catch (error) {
        // Handle error
        console.error('Error occurred:', error.message);
        throw error;  // Re-throw if needed
    } finally {
        // Always executes
        console.log('Cleanup code');
    }
}
```

### Error Handling in Functions

```javascript
function divide(a, b) {
    if (b === 0) {
        throw new Error('Division by zero');
    }
    return a / b;
}

function safeDivide(a, b) {
    try {
        return divide(a, b);
    } catch (error) {
        console.error('Division error:', error.message);
        return null;  // Or return default value
    }
}

console.log(safeDivide(10, 2));   // 5
console.log(safeDivide(10, 0));  // null (error handled)
```

### Error Handling in Async Code

```javascript
// Async function with try-catch
async function fetchData(url) {
    try {
        let response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Fetch error:', error.message);
        throw error;
    }
}

// Promise with catch
fetchData('/api/data')
    .then(data => {
        console.log('Data:', data);
    })
    .catch(error => {
        console.error('Error:', error.message);
    });
```

### Error Handling Patterns

```javascript
// Pattern 1: Return error object
function safeOperation() {
    try {
        let result = riskyOperation();
        return { success: true, data: result };
    } catch (error) {
        return { success: false, error: error.message };
    }
}

// Pattern 2: Throw and handle
function operation() {
    try {
        return riskyOperation();
    } catch (error) {
        // Log error
        console.error(error);
        // Re-throw or handle
        throw error;
    }
}

// Pattern 3: Default values
function getValue(key) {
    try {
        return getValueFromSource(key);
    } catch (error) {
        return defaultValue;  // Return default
    }
}
```

---

## Global Error Handling

### Window Error Handler

```javascript
// Global error handler
window.addEventListener('error', function(event) {
    console.error('Global error:', event.error);
    console.error('Message:', event.message);
    console.error('Source:', event.filename);
    console.error('Line:', event.lineno);
    console.error('Column:', event.colno);
    
    // Send to error tracking service
    // sendToErrorTracking(event.error);
    
    // Prevent default error handling
    // event.preventDefault();
});

// Unhandled promise rejection
window.addEventListener('unhandledrejection', function(event) {
    console.error('Unhandled promise rejection:', event.reason);
    
    // Send to error tracking
    // sendToErrorTracking(event.reason);
    
    // Prevent default handling
    // event.preventDefault();
});
```

### Node.js Error Handling

```javascript
// Node.js global handlers
process.on('uncaughtException', (error) => {
    console.error('Uncaught exception:', error);
    // Cleanup and exit
    process.exit(1);
});

process.on('unhandledRejection', (reason, promise) => {
    console.error('Unhandled rejection:', reason);
    // Handle or exit
});
```

### Error Boundary (React)

```javascript
class ErrorBoundary extends React.Component {
    constructor(props) {
        super(props);
        this.state = { hasError: false, error: null };
    }
    
    static getDerivedStateFromError(error) {
        return { hasError: true, error };
    }
    
    componentDidCatch(error, errorInfo) {
        console.error('Error caught:', error, errorInfo);
        // Log to error tracking service
    }
    
    render() {
        if (this.state.hasError) {
            return <h1>Something went wrong.</h1>;
        }
        return this.props.children;
    }
}
```

---

## Error Handling Best Practices

### 1. Be Specific

```javascript
// ❌ Bad: Generic error
throw new Error('Error');

// ✅ Good: Specific error
throw new ValidationError('Email is required', 'email');
```

### 2. Don't Swallow Errors

```javascript
// ❌ Bad: Swallowing error
try {
    riskyOperation();
} catch (error) {
    // Silent failure
}

// ✅ Good: Handle or log
try {
    riskyOperation();
} catch (error) {
    console.error('Error:', error);
    // Handle appropriately
}
```

### 3. Use Appropriate Error Types

```javascript
// ❌ Bad: Wrong error type
throw new Error('Network error');

// ✅ Good: Specific error type
throw new NetworkError('Connection failed', 500);
```

### 4. Provide Context

```javascript
// ❌ Bad: No context
throw new Error('Failed');

// ✅ Good: With context
throw new Error(`Failed to fetch user ${userId}: ${error.message}`);
```

### 5. Handle Errors at Appropriate Level

```javascript
// Handle at the right level
async function processUser(userId) {
    try {
        let user = await fetchUser(userId);
        return processUserData(user);
    } catch (error) {
        // Handle at this level
        if (error instanceof NotFoundError) {
            return null;  // User not found
        }
        throw error;  // Re-throw other errors
    }
}
```

---

## Practice Exercise

### Exercise: Error Handling

**Objective**: Practice creating custom errors, implementing error handling strategies, and setting up global error handling.

**Instructions**:

1. Create a JavaScript file
2. Practice:
   - Creating custom error classes
   - Implementing error handling
   - Setting up global handlers
   - Handling async errors

**Example Solution**:

```javascript
// error-handling-practice.js
console.log("=== Error Handling Practice ===");

console.log("\n=== Built-in Error Types ===");

// Error
try {
    throw new Error('Something went wrong');
} catch (error) {
    console.log('Error:', error.name, error.message);
}

// TypeError
try {
    let num = 'hello';
    num.toFixed();
} catch (error) {
    console.log('TypeError:', error.name);
}

// ReferenceError
try {
    console.log(undefinedVar);
} catch (error) {
    console.log('ReferenceError:', error.name);
}
console.log();

console.log("=== Custom Errors ===");

// Basic custom error
class CustomError extends Error {
    constructor(message) {
        super(message);
        this.name = 'CustomError';
        Error.captureStackTrace(this, this.constructor);
    }
}

try {
    throw new CustomError('Custom error message');
} catch (error) {
    console.log('Custom error:', error.name, error.message);
}

// Validation error
class ValidationError extends Error {
    constructor(message, field, value) {
        super(message);
        this.name = 'ValidationError';
        this.field = field;
        this.value = value;
    }
}

try {
    throw new ValidationError('Invalid email', 'email', 'invalid');
} catch (error) {
    if (error instanceof ValidationError) {
        console.log(`Validation error: ${error.field} = ${error.value}`);
    }
}

// Network error
class NetworkError extends Error {
    constructor(message, statusCode) {
        super(message);
        this.name = 'NetworkError';
        this.statusCode = statusCode;
    }
}

// Authentication error
class AuthenticationError extends Error {
    constructor(message) {
        super(message);
        this.name = 'AuthenticationError';
    }
}

// Not found error
class NotFoundError extends Error {
    constructor(resource) {
        super(`${resource} not found`);
        this.name = 'NotFoundError';
        this.resource = resource;
    }
}

// Error handler
function handleError(error) {
    if (error instanceof ValidationError) {
        console.log(`Validation error in ${error.field}: ${error.message}`);
    } else if (error instanceof NetworkError) {
        console.log(`Network error (${error.statusCode}): ${error.message}`);
    } else if (error instanceof AuthenticationError) {
        console.log('Authentication failed:', error.message);
    } else if (error instanceof NotFoundError) {
        console.log(`${error.resource} not found`);
    } else {
        console.log('Unknown error:', error.message);
    }
}

try {
    throw new NetworkError('Connection failed', 500);
} catch (error) {
    handleError(error);
}
console.log();

console.log("=== Error Handling Strategies ===");

// Try-catch-finally
function riskyOperation() {
    try {
        console.log('Performing risky operation');
        // Simulate error
        throw new Error('Operation failed');
    } catch (error) {
        console.error('Error caught:', error.message);
        throw error;
    } finally {
        console.log('Cleanup code executed');
    }
}

try {
    riskyOperation();
} catch (error) {
    console.log('Error re-thrown and caught');
}

// Safe operation with default
function safeDivide(a, b) {
    try {
        if (b === 0) {
            throw new Error('Division by zero');
        }
        return a / b;
    } catch (error) {
        console.error('Division error:', error.message);
        return null;
    }
}

console.log('safeDivide(10, 2):', safeDivide(10, 2));
console.log('safeDivide(10, 0):', safeDivide(10, 0));

// Return error object pattern
function safeOperation() {
    try {
        let result = 10 / 2;
        return { success: true, data: result };
    } catch (error) {
        return { success: false, error: error.message };
    }
}

let result = safeOperation();
console.log('Safe operation result:', result);
console.log();

console.log("=== Async Error Handling ===");

// Async function
async function fetchData(url) {
    try {
        // Simulate fetch
        if (url === 'error') {
            throw new NetworkError('Connection failed', 500);
        }
        return { data: 'success' };
    } catch (error) {
        console.error('Fetch error:', error.message);
        throw error;
    }
}

// Handle async errors
async function handleAsync() {
    try {
        let data = await fetchData('error');
        console.log('Data:', data);
    } catch (error) {
        handleError(error);
    }
}

handleAsync();

// Promise error handling
fetchData('error')
    .then(data => {
        console.log('Data:', data);
    })
    .catch(error => {
        handleError(error);
    });
console.log();

console.log("=== Global Error Handling ===");

// Window error handler
window.addEventListener('error', function(event) {
    console.error('Global error:', event.error);
    console.error('Message:', event.message);
    console.error('Source:', event.filename);
    console.error('Line:', event.lineno);
    
    // In production, send to error tracking
    // sendToErrorTracking({
    //     message: event.message,
    //     source: event.filename,
    //     line: event.lineno,
    //     error: event.error
    // });
});

// Unhandled promise rejection
window.addEventListener('unhandledrejection', function(event) {
    console.error('Unhandled promise rejection:', event.reason);
    
    // In production, send to error tracking
    // sendToErrorTracking({
    //     type: 'unhandledRejection',
    //     reason: event.reason
    // });
});
console.log();

console.log("=== Error Handling Utilities ===");

// Error wrapper
function withErrorHandling(fn) {
    return function(...args) {
        try {
            return fn.apply(this, args);
        } catch (error) {
            console.error(`Error in ${fn.name}:`, error.message);
            throw error;
        }
    };
}

function divide(a, b) {
    if (b === 0) {
        throw new Error('Division by zero');
    }
    return a / b;
}

let safeDivide2 = withErrorHandling(divide);
try {
    safeDivide2(10, 0);
} catch (error) {
    console.log('Error handled by wrapper');
}

// Retry with error handling
async function retryWithErrorHandling(fn, maxRetries = 3) {
    for (let i = 0; i < maxRetries; i++) {
        try {
            return await fn();
        } catch (error) {
            if (i === maxRetries - 1) {
                throw error;
            }
            console.log(`Retry ${i + 1}/${maxRetries}`);
        }
    }
}

// Error logger
class ErrorLogger {
    static log(error, context = {}) {
        let errorInfo = {
            name: error.name,
            message: error.message,
            stack: error.stack,
            context: context,
            timestamp: new Date().toISOString()
        };
        
        console.error('Error logged:', errorInfo);
        
        // In production, send to error tracking service
        // sendToErrorTracking(errorInfo);
    }
}

try {
    throw new ValidationError('Invalid input', 'email', 'test');
} catch (error) {
    ErrorLogger.log(error, { userId: 123, action: 'login' });
}
```

**Expected Output**:
```
=== Error Handling Practice ===

=== Built-in Error Types ===
Error: Something went wrong
TypeError: TypeError
ReferenceError: ReferenceError

=== Custom Errors ===
Custom error: CustomError Custom error message
Validation error: email = invalid
Network error (500): Connection failed

=== Error Handling Strategies ===
Performing risky operation
Error caught: Operation failed
Cleanup code executed
Error re-thrown and caught
Division error: Division by zero
safeDivide(10, 2): 5
safeDivide(10, 0): null
Safe operation result: { success: true, data: 5 }

=== Async Error Handling ===
Fetch error: Connection failed
Network error (500): Connection failed
Network error (500): Connection failed

=== Global Error Handling ===
[Global handlers registered]

=== Error Handling Utilities ===
Error in divide: Division by zero
Error handled by wrapper
Error logged: { object }
```

**Challenge (Optional)**:
- Build a complete error handling system
- Create an error tracking service
- Build error recovery mechanisms
- Practice error handling in real applications

---

## Common Mistakes

### 1. Swallowing Errors

```javascript
// ❌ Bad: Error swallowed
try {
    riskyOperation();
} catch (error) {
    // Silent failure
}

// ✅ Good: Handle or log
try {
    riskyOperation();
} catch (error) {
    console.error('Error:', error);
    // Handle appropriately
}
```

### 2. Generic Error Messages

```javascript
// ❌ Bad: Generic
throw new Error('Error');

// ✅ Good: Specific
throw new ValidationError('Email is required', 'email');
```

### 3. Not Handling Async Errors

```javascript
// ❌ Bad: Unhandled promise rejection
async function fetchData() {
    let response = await fetch(url);
    return response.json();
}
fetchData();  // Error not handled

// ✅ Good: Handle errors
async function fetchData() {
    try {
        let response = await fetch(url);
        return response.json();
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}
```

---

## Key Takeaways

1. **Error Types**: Use appropriate built-in or custom error types
2. **Custom Errors**: Create specific error classes for better handling
3. **Try-Catch**: Use try-catch-finally for error handling
4. **Async Errors**: Handle errors in async/await and promises
5. **Global Handlers**: Set up global error handlers
6. **Best Practices**: Be specific, provide context, handle appropriately
7. **Error Tracking**: Log errors for debugging and monitoring

---

## Quiz: Error Handling

Test your understanding with these questions:

1. **Error base class:**
   - A) TypeError
   - B) Error
   - C) ReferenceError
   - D) None

2. **Custom errors should:**
   - A) Extend Error
   - B) Not extend anything
   - C) Extend Object
   - D) Nothing

3. **Finally block:**
   - A) Always executes
   - B) Sometimes executes
   - C) Never executes
   - D) Random

4. **Async errors handled with:**
   - A) try-catch
   - B) .catch()
   - C) Both
   - D) Neither

5. **Global error handler:**
   - A) window.addEventListener('error')
   - B) window.onerror
   - C) Both
   - D) Neither

6. **Error handling should:**
   - A) Be specific
   - B) Provide context
   - C) Both
   - D) Neither

7. **Swallowing errors:**
   - A) Good practice
   - B) Bad practice
   - C) Sometimes OK
   - D) Always OK

**Answers**:
1. B) Error
2. A) Extend Error
3. A) Always executes
4. C) Both
5. C) Both
6. C) Both
7. B) Bad practice

---

## Next Steps

Congratulations! You've learned advanced error handling. You now know:
- Different error types
- How to create custom errors
- Error handling strategies
- Global error handling

**What's Next?**
- Lesson 20.2: Debugging Techniques
- Learn browser DevTools
- Understand debugging tools
- Master breakpoints and console methods

---

## Additional Resources

- **MDN: Error Handling**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Control_flow_and_error_handling](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Control_flow_and_error_handling)
- **MDN: Error**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Error](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Error)

---

*Lesson completed! You're ready to move on to the next lesson.*

