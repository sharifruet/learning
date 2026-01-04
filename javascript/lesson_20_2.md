# Lesson 20.2: Debugging Techniques

## Learning Objectives

By the end of this lesson, you will be able to:
- Use browser DevTools effectively
- Set and use breakpoints
- Use console methods for debugging
- Understand source maps
- Debug JavaScript code efficiently
- Use debugging tools and techniques
- Find and fix bugs faster

---

## Introduction to Debugging

Debugging is the process of finding and fixing bugs in code. Effective debugging skills are essential for every developer.

### Why Debugging Skills Matter?

- **Faster Development**: Find bugs quickly
- **Better Code**: Understand code behavior
- **Problem Solving**: Systematic approach to issues
- **Learning**: Understand how code works
- **Professional**: Essential skill for developers
- **Productivity**: Save time and effort

---

## Browser DevTools

### Opening DevTools

```javascript
// Keyboard shortcuts
// Chrome/Edge: F12 or Ctrl+Shift+I (Windows) / Cmd+Option+I (Mac)
// Firefox: F12 or Ctrl+Shift+I (Windows) / Cmd+Option+I (Mac)
// Safari: Cmd+Option+I (Mac)

// Or right-click → Inspect
```

### DevTools Panels

1. **Elements/Inspector**: HTML and CSS
2. **Console**: JavaScript console
3. **Sources/Debugger**: JavaScript debugging
4. **Network**: Network requests
5. **Application/Storage**: Storage and data
6. **Performance**: Performance profiling
7. **Memory**: Memory profiling

### Console Panel

```javascript
// Open console: Ctrl+Shift+J (Windows) / Cmd+Option+J (Mac)
// Or: F12 → Console tab

// Basic console usage
console.log('Hello');
console.error('Error message');
console.warn('Warning message');
```

---

## Console Methods

### Basic Console Methods

```javascript
// console.log() - General logging
console.log('Hello', 'World', 123);
console.log({ name: 'Alice', age: 30 });
console.log([1, 2, 3]);

// console.error() - Error messages
console.error('Error occurred');
console.error(new Error('Something went wrong'));

// console.warn() - Warnings
console.warn('This is a warning');

// console.info() - Informational messages
console.info('Information message');

// console.debug() - Debug messages
console.debug('Debug information');
```

### Advanced Console Methods

```javascript
// console.table() - Display data as table
let users = [
    { name: 'Alice', age: 30, city: 'NYC' },
    { name: 'Bob', age: 25, city: 'LA' },
    { name: 'Charlie', age: 35, city: 'Chicago' }
];
console.table(users);

// console.group() - Group related logs
console.group('User Data');
console.log('Name: Alice');
console.log('Age: 30');
console.groupEnd();

// console.groupCollapsed() - Collapsed group
console.groupCollapsed('Details');
console.log('Hidden by default');
console.groupEnd();

// console.time() - Measure execution time
console.time('operation');
// ... code ...
console.timeEnd('operation');

// console.count() - Count occurrences
console.count('counter');
console.count('counter');
console.count('counter');  // counter: 3

// console.trace() - Stack trace
function a() {
    b();
}
function b() {
    c();
}
function c() {
    console.trace('Trace');
}
a();
```

### Console Formatting

```javascript
// String formatting
console.log('%s is %d years old', 'Alice', 30);
console.log('%cStyled text', 'color: red; font-size: 20px');

// Object formatting
console.log('%O', { name: 'Alice' });  // Full object
console.log('%o', { name: 'Alice' });  // Compact object

// Multiple styles
console.log(
    '%cRed %cGreen %cBlue',
    'color: red',
    'color: green',
    'color: blue'
);
```

### Console Assertions

```javascript
// console.assert() - Assert conditions
console.assert(1 === 1, 'This will not log');
console.assert(1 === 2, 'This will log');  // Assertion failed

// Useful for debugging
function divide(a, b) {
    console.assert(b !== 0, 'Division by zero');
    return a / b;
}
```

---

## Breakpoints

### Setting Breakpoints

```javascript
// Method 1: In DevTools Sources panel
// 1. Open Sources panel
// 2. Find your file
// 3. Click line number to set breakpoint

// Method 2: Using debugger statement
function myFunction() {
    let x = 10;
    debugger;  // Execution pauses here
    let y = x * 2;
    return y;
}

// Method 3: Conditional breakpoints
// Right-click line number → Add conditional breakpoint
// Enter condition: x > 10
```

### Breakpoint Types

```javascript
// 1. Line breakpoints
// Click line number in Sources panel

// 2. Conditional breakpoints
// Right-click → Add conditional breakpoint
// Condition: variable > value

// 3. Logpoints
// Right-click → Add logpoint
// Log: Variable value without pausing

// 4. DOM breakpoints
// Elements panel → Right-click element → Break on
// - Subtree modifications
// - Attribute modifications
// - Node removal

// 5. Event listener breakpoints
// Sources panel → Event Listener Breakpoints
// Select events to break on
```

### Using Breakpoints

```javascript
// When breakpoint hits:
// 1. Execution pauses
// 2. Inspect variables in Scope panel
// 3. Step through code
// 4. Evaluate expressions in Console

function calculateTotal(items) {
    let total = 0;
    for (let item of items) {
        total += item.price;  // Set breakpoint here
    }
    return total;
}

// Step controls:
// F8: Continue (resume execution)
// F10: Step over (next line)
// F11: Step into (enter function)
// Shift+F11: Step out (exit function)
```

---

## Debugging Techniques

### 1. Step Through Code

```javascript
function processData(data) {
    let processed = [];
    for (let item of data) {
        let result = transform(item);  // Step into here
        processed.push(result);
    }
    return processed;
}

// Use F10 to step over
// Use F11 to step into transform()
```

### 2. Inspect Variables

```javascript
function calculate(a, b, c) {
    let sum = a + b;      // Inspect: sum = 5
    let product = sum * c; // Inspect: product = 15
    return product;
}

// In DevTools:
// - Watch panel: Add variables to watch
// - Scope panel: See all variables in scope
// - Console: Evaluate expressions
```

### 3. Call Stack

```javascript
function a() {
    b();  // Call stack: a → b
}

function b() {
    c();  // Call stack: a → b → c
}

function c() {
    debugger;  // Inspect call stack
}

// Call stack shows:
// - Function call order
// - Where each function was called from
// - Click to navigate to source
```

### 4. Watch Expressions

```javascript
// In DevTools Watch panel:
// Add expressions to watch:
// - variable
// - object.property
// - array[index]
// - function calls

function process(items) {
    let total = 0;
    // Watch: total, items.length, items[0]
    for (let item of items) {
        total += item.value;
    }
    return total;
}
```

---

## Source Maps

### What are Source Maps?

Source maps map minified/transpiled code back to original source code.

### Using Source Maps

```javascript
// In build tools (webpack, babel, etc.)
// Generate source maps:
// webpack.config.js
module.exports = {
    devtool: 'source-map',  // Generate source maps
    // ...
};

// Source maps allow:
// - Debug original source code
// - See original variable names
// - Set breakpoints in original code
// - See original line numbers
```

### Source Map Types

```javascript
// 1. source-map: Full source map file
// 2. inline-source-map: Inline in bundle
// 3. eval-source-map: Fastest, less accurate
// 4. cheap-source-map: Faster, no column info
// 5. cheap-module-source-map: For loader source maps
```

---

## Network Debugging

### Network Panel

```javascript
// Network panel shows:
// - All network requests
// - Request/response headers
// - Response data
// - Timing information
// - Request/response preview

// Filter requests:
// - By type (XHR, JS, CSS, etc.)
// - By domain
// - By status code
// - By search term

// Inspect request:
// - Click request to see details
// - Headers tab: Request/response headers
// - Preview tab: Formatted response
// - Response tab: Raw response
// - Timing tab: Request timing
```

### Network Debugging Tips

```javascript
// 1. Filter by XHR to see API calls
// 2. Check status codes (200, 404, 500, etc.)
// 3. Inspect request payload
// 4. Check response data
// 5. Look at timing (slow requests)
// 6. Check for CORS errors
// 7. Verify headers (Content-Type, Authorization, etc.)
```

---

## Performance Debugging

### Performance Panel

```javascript
// Performance panel:
// 1. Click Record
// 2. Perform actions
// 3. Stop recording
// 4. Analyze timeline

// Shows:
// - FPS (frames per second)
// - CPU usage
// - Memory usage
// - Function call stack
// - Long tasks
// - Layout shifts
```

### Memory Debugging

```javascript
// Memory panel:
// - Take heap snapshot
// - Compare snapshots
// - Find memory leaks
// - See object sizes
// - Find retained objects

// Common issues:
// - Memory leaks (objects not garbage collected)
// - Large objects
// - Circular references
// - Event listeners not removed
```

---

## Practice Exercise

### Exercise: Debugging Practice

**Objective**: Practice using DevTools, breakpoints, console methods, and debugging techniques.

**Instructions**:

1. Create an HTML file with JavaScript
2. Open DevTools
3. Practice:
   - Using console methods
   - Setting breakpoints
   - Stepping through code
   - Inspecting variables
   - Using network panel
   - Debugging issues

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debugging Practice</title>
</head>
<body>
    <h1>Debugging Practice</h1>
    <button onclick="processData()">Process Data</button>
    <button onclick="fetchData()">Fetch Data</button>
    <div id="output"></div>
    
    <script src="debugging-practice.js"></script>
</body>
</html>
```

```javascript
// debugging-practice.js
console.log("=== Debugging Practice ===");

console.log("\n=== Console Methods ===");

// Basic logging
console.log('Hello World');
console.log('Number:', 123);
console.log('Object:', { name: 'Alice', age: 30 });
console.log('Array:', [1, 2, 3]);

// Error and warnings
console.error('This is an error');
console.warn('This is a warning');
console.info('This is info');
console.debug('This is debug');

// Table
let users = [
    { name: 'Alice', age: 30, city: 'NYC' },
    { name: 'Bob', age: 25, city: 'LA' },
    { name: 'Charlie', age: 35, city: 'Chicago' }
];
console.table(users);

// Grouping
console.group('User Details');
console.log('Name: Alice');
console.log('Age: 30');
console.log('City: NYC');
console.groupEnd();

console.groupCollapsed('Hidden Details');
console.log('This is hidden by default');
console.groupEnd();

// Timing
console.time('loop');
for (let i = 0; i < 1000000; i++) {
    // Some operation
}
console.timeEnd('loop');

// Counting
console.count('counter');
console.count('counter');
console.count('counter');
console.countReset('counter');
console.count('counter');

// Trace
function functionA() {
    functionB();
}

function functionB() {
    functionC();
}

function functionC() {
    console.trace('Call stack trace');
}

functionA();

// Assertions
console.assert(1 === 1, 'This will not log');
console.assert(1 === 2, 'Assertion failed: 1 !== 2');

// Styling
console.log('%cRed text', 'color: red; font-size: 20px');
console.log('%cRed %cGreen %cBlue', 'color: red', 'color: green', 'color: blue');
console.log();

console.log("=== Breakpoints ===");

function processData() {
    let data = [1, 2, 3, 4, 5];
    let result = [];
    
    // Set breakpoint here (line number in DevTools)
    for (let i = 0; i < data.length; i++) {
        let value = data[i];
        let doubled = value * 2;  // Set breakpoint here
        result.push(doubled);
    }
    
    // Or use debugger statement
    debugger;
    
    console.log('Result:', result);
    document.getElementById('output').textContent = result.join(', ');
}

// Conditional breakpoint example
function findMax(numbers) {
    let max = numbers[0];
    
    for (let i = 1; i < numbers.length; i++) {
        // Set conditional breakpoint: numbers[i] > 10
        if (numbers[i] > max) {
            max = numbers[i];
        }
    }
    
    return max;
}

let numbers = [5, 12, 3, 8, 15, 7];
console.log('Max:', findMax(numbers));
console.log();

console.log("=== Variable Inspection ===");

function calculateTotal(items) {
    let total = 0;
    let tax = 0.1;
    
    // Watch these variables in DevTools:
    // - total
    // - tax
    // - items.length
    // - items[0].price
    
    for (let item of items) {
        total += item.price;
    }
    
    let totalWithTax = total * (1 + tax);
    
    return {
        subtotal: total,
        tax: total * tax,
        total: totalWithTax
    };
}

let items = [
    { name: 'Apple', price: 1.00 },
    { name: 'Banana', price: 0.50 },
    { name: 'Orange', price: 1.50 }
];

let result = calculateTotal(items);
console.log('Total:', result);
console.log();

console.log("=== Call Stack ===");

function level1() {
    console.log('Level 1');
    level2();
}

function level2() {
    console.log('Level 2');
    level3();
}

function level3() {
    console.log('Level 3');
    debugger;  // Inspect call stack here
    console.trace('Call stack');
}

level1();
console.log();

console.log("=== Network Debugging ===");

async function fetchData() {
    try {
        // Open Network panel to see this request
        let response = await fetch('https://jsonplaceholder.typicode.com/posts/1');
        let data = await response.json();
        console.log('Fetched data:', data);
        document.getElementById('output').textContent = JSON.stringify(data, null, 2);
    } catch (error) {
        console.error('Fetch error:', error);
    }
}

// Uncomment to test network debugging
// fetchData();
console.log();

console.log("=== Error Debugging ===");

function buggyFunction() {
    let x = 10;
    let y = 0;
    
    // This will cause an error
    try {
        let result = x / y;  // Division by zero
        return result;
    } catch (error) {
        console.error('Error in buggyFunction:', error);
        console.error('Stack trace:', error.stack);
        throw error;
    }
}

// Set breakpoint in catch block to inspect error
try {
    buggyFunction();
} catch (error) {
    console.error('Caught error:', error);
}
console.log();

console.log("=== Performance Debugging ===");

function slowOperation() {
    console.time('slowOperation');
    
    let result = 0;
    for (let i = 0; i < 10000000; i++) {
        result += i;
    }
    
    console.timeEnd('slowOperation');
    return result;
}

// Use Performance panel to profile this
slowOperation();
console.log();

console.log("=== Memory Debugging ===");

// Memory leak example (don't do this in production)
let memoryLeak = [];

function addToMemoryLeak() {
    for (let i = 0; i < 1000; i++) {
        memoryLeak.push({
            data: new Array(1000).fill(0),
            timestamp: Date.now()
        });
    }
}

// Use Memory panel to take snapshots
// Call addToMemoryLeak() multiple times
// Compare snapshots to find memory leak
console.log('Memory debugging: Use Memory panel to take snapshots');
console.log();

console.log("=== Debugging Tips ===");
console.log('1. Use console.log() strategically');
console.log('2. Set breakpoints at key points');
console.log('3. Step through code line by line');
console.log('4. Inspect variables in Scope panel');
console.log('5. Use Watch panel for expressions');
console.log('6. Check Call Stack for function flow');
console.log('7. Use Network panel for API debugging');
console.log('8. Use Performance panel for bottlenecks');
console.log('9. Use Memory panel for leaks');
console.log('10. Read error messages carefully');
```

**Expected Output** (in browser console):
```
=== Debugging Practice ===

=== Console Methods ===
Hello World
Number: 123
Object: { name: 'Alice', age: 30 }
Array: [1, 2, 3]
[Error, warning, info, debug messages]
[Table output]
[Grouped output]
loop: [time]ms
counter: 1
counter: 2
counter: 3
counter: 1
[Call stack trace]
[Assertion messages]
[Styled text]

=== Breakpoints ===
[When breakpoint hits, execution pauses]

=== Variable Inspection ===
Total: { subtotal: 3, tax: 0.3, total: 3.3 }

=== Call Stack ===
Level 1
Level 2
Level 3
[Call stack trace]

=== Network Debugging ===
[Network request visible in Network panel]

=== Error Debugging ===
Error in buggyFunction: [error]
Stack trace: [stack]

=== Performance Debugging ===
slowOperation: [time]ms

=== Memory Debugging ===
[Use Memory panel]

=== Debugging Tips ===
[Tips listed]
```

**Challenge (Optional)**:
- Debug a real application
- Find and fix bugs
- Profile performance
- Identify memory leaks
- Practice all debugging techniques

---

## Common Mistakes

### 1. Too Many console.log()

```javascript
// ❌ Bad: Too many logs
console.log('Step 1');
console.log('Step 2');
console.log('Step 3');
// ... many more

// ✅ Good: Strategic logging
console.log('Processing started');
// Use breakpoints instead
console.log('Processing completed');
```

### 2. Not Using Breakpoints

```javascript
// ❌ Bad: Only console.log
console.log('Value:', value);

// ✅ Good: Use breakpoints
// Set breakpoint and inspect in DevTools
```

### 3. Ignoring Error Messages

```javascript
// ❌ Bad: Ignore errors
try {
    riskyOperation();
} catch (error) {
    // Silent
}

// ✅ Good: Read and understand errors
try {
    riskyOperation();
} catch (error) {
    console.error('Error:', error.message);
    console.error('Stack:', error.stack);
}
```

---

## Key Takeaways

1. **DevTools**: Essential debugging tool
2. **Console Methods**: Use appropriate methods for logging
3. **Breakpoints**: Set breakpoints to pause execution
4. **Step Through**: Use step controls to debug
5. **Inspect Variables**: Use Scope and Watch panels
6. **Network Panel**: Debug API calls
7. **Performance Panel**: Find bottlenecks
8. **Memory Panel**: Find memory leaks
9. **Source Maps**: Debug original source code
10. **Best Practice**: Systematic debugging approach

---

## Quiz: Debugging

Test your understanding with these questions:

1. **DevTools opens with:**
   - A) F12
   - B) Ctrl+Shift+I
   - C) Both
   - D) Neither

2. **console.table() displays:**
   - A) Text
   - B) Table
   - C) Error
   - D) Nothing

3. **Breakpoint pauses:**
   - A) Execution
   - B) Nothing
   - C) Compilation
   - D) Loading

4. **F10 key:**
   - A) Step over
   - B) Step into
   - C) Step out
   - D) Continue

5. **Source maps:**
   - A) Map to original source
   - B) Map to minified code
   - C) Both
   - D) Neither

6. **Network panel shows:**
   - A) Requests
   - B) Responses
   - C) Both
   - D) Neither

7. **Memory panel helps find:**
   - A) Memory leaks
   - B) Performance issues
   - C) Network issues
   - D) Nothing

**Answers**:
1. C) Both
2. B) Table
3. A) Execution
4. A) Step over
5. A) Map to original source
6. C) Both
7. A) Memory leaks

---

## Next Steps

Congratulations! You've completed Module 20: Error Handling and Debugging. You now know:
- Advanced error handling
- Custom error classes
- Error handling strategies
- Global error handling
- Debugging techniques
- DevTools usage
- Breakpoints and console methods

**What's Next?**
- Module 21: Performance Optimization
- Lesson 21.1: Performance Basics
- Learn performance metrics
- Understand profiling tools

---

## Additional Resources

- **Chrome DevTools**: [developer.chrome.com/docs/devtools](https://developer.chrome.com/docs/devtools)
- **Firefox DevTools**: [developer.mozilla.org/en-US/docs/Tools](https://developer.mozilla.org/en-US/docs/Tools)
- **MDN: Console API**: [developer.mozilla.org/en-US/docs/Web/API/Console](https://developer.mozilla.org/en-US/docs/Web/API/Console)

---

*Lesson completed! You've finished Module 20: Error Handling and Debugging. Ready for Module 21: Performance Optimization!*

