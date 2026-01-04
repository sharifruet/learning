# Lesson 28.1: Node.js Introduction

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what Node.js is
- Know the differences between Node.js and browser JavaScript
- Install Node.js
- Use the REPL
- Run Node.js applications
- Understand Node.js fundamentals
- Write server-side JavaScript

---

## Introduction to Node.js

Node.js is a JavaScript runtime built on Chrome's V8 JavaScript engine. It allows you to run JavaScript on the server.

### What is Node.js?

- **JavaScript Runtime**: Runs JavaScript outside the browser
- **Event-Driven**: Asynchronous, event-driven architecture
- **Non-Blocking I/O**: Efficient handling of I/O operations
- **Single-Threaded**: Uses event loop for concurrency
- **NPM**: Package manager for JavaScript
- **Cross-Platform**: Works on Windows, macOS, Linux

### Why Node.js?

- **One Language**: JavaScript for both frontend and backend
- **Fast**: Built on V8 engine
- **Scalable**: Handles many concurrent connections
- **Large Ecosystem**: Huge number of packages
- **Active Community**: Large and active community
- **Real-Time**: Great for real-time applications

---

## What is Node.js?

### Node.js Architecture

```
┌─────────────────┐
│   JavaScript    │
│     Code        │
└────────┬────────┘
         │
┌────────▼────────┐
│   Node.js API   │
│   (Core Modules)│
└────────┬────────┘
         │
┌────────▼────────┐
│   V8 Engine     │
│  (JavaScript    │
│   Engine)       │
└────────┬────────┘
         │
┌────────▼────────┐
│  libuv (C++)    │
│  (Event Loop)   │
└─────────────────┘
```

### Key Features

- **V8 Engine**: Google's JavaScript engine
- **Event Loop**: Handles asynchronous operations
- **libuv**: C++ library for async I/O
- **Core Modules**: Built-in modules (fs, http, path, etc.)
- **NPM**: Node Package Manager

---

## Node.js vs Browser JavaScript

### Similarities

```javascript
// Both support:
// - JavaScript syntax
// - Variables, functions, objects
// - ES6+ features
// - Async/await, promises
```

### Differences

| Feature | Browser JavaScript | Node.js |
|---------|-------------------|---------|
| **Global Object** | `window` | `global` |
| **DOM** | Yes | No |
| **File System** | No | Yes |
| **Modules** | ES6 modules | CommonJS/ES6 |
| **Process** | No | Yes |
| **OS** | Limited | Full access |
| **Network** | Fetch API | http/https modules |

### Global Objects

```javascript
// Browser
console.log(window);      // Global object
console.log(document);    // DOM
console.log(navigator);   // Browser info

// Node.js
console.log(global);      // Global object
console.log(process);     // Process info
console.log(__dirname);   // Current directory
console.log(__filename);  // Current file
```

### No DOM in Node.js

```javascript
// ❌ Browser only
document.getElementById('app');
window.location;

// ✅ Node.js
const fs = require('fs');
const path = require('path');
const http = require('http');
```

---

## Installing Node.js

### Download and Install

1. **Visit**: [nodejs.org](https://nodejs.org)
2. **Download**: LTS (Long Term Support) version
3. **Install**: Follow installation wizard
4. **Verify**: Check installation

### Verify Installation

```bash
# Check Node.js version
node --version
# or
node -v

# Check npm version
npm --version
# or
npm -v
```

### Using nvm (Node Version Manager)

```bash
# Install nvm (macOS/Linux)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash

# Install Node.js
nvm install node        # Latest version
nvm install 18          # Specific version
nvm install --lts       # LTS version

# Use version
nvm use 18

# List installed versions
nvm list

# Set default
nvm alias default 18
```

### Using nvm-windows

```powershell
# Download from: https://github.com/coreybutler/nvm-windows/releases
# Install and use:
nvm install 18
nvm use 18
```

---

## REPL (Read-Eval-Print Loop)

### What is REPL?

REPL is an interactive programming environment where you can run JavaScript code.

### Starting REPL

```bash
# Start REPL
node

# Or with specific file
node filename.js
```

### REPL Commands

```javascript
// In REPL:
> const name = 'Alice';
undefined

> name
'Alice'

> 2 + 2
4

> function greet(name) {
...   return `Hello, ${name}!`;
... }
undefined

> greet('Alice')
'Hello, Alice!'

// Special commands:
.help          // Show help
.break         // Exit multi-line input
.clear         // Clear context
.exit          // Exit REPL
.save file.js  // Save session
.load file.js  // Load file
```

### REPL Features

```javascript
// Multi-line input
> function add(a, b) {
...   return a + b;
... }
undefined

> add(2, 3)
5

// Variables persist
> let x = 10;
undefined
> x
10

// Use require
> const fs = require('fs');
undefined
> fs.readFileSync('package.json', 'utf8')
'...'

// Use _ for last result
> 2 + 2
4
> _ * 2
8
```

---

## Your First Node.js Application

### Simple Script

```javascript
// hello.js
console.log('Hello, Node.js!');

// Run it
// node hello.js
```

### Using Modules

```javascript
// app.js
const fs = require('fs');
const path = require('path');

console.log('Current directory:', __dirname);
console.log('Current file:', __filename);

// Read a file
const data = fs.readFileSync('package.json', 'utf8');
console.log('Package.json:', data);
```

### Using Process

```javascript
// process-example.js
console.log('Process ID:', process.pid);
console.log('Node version:', process.version);
console.log('Platform:', process.platform);
console.log('Arguments:', process.argv);

// Access command line arguments
const args = process.argv.slice(2);
console.log('Arguments:', args);
```

### Environment Variables

```javascript
// env-example.js
console.log('NODE_ENV:', process.env.NODE_ENV);
console.log('HOME:', process.env.HOME);

// Set environment variable
process.env.MY_VAR = 'my value';
console.log('MY_VAR:', process.env.MY_VAR);
```

---

## Practice Exercise

### Exercise: Node.js Basics

**Objective**: Practice installing Node.js, using REPL, and creating your first Node.js applications.

**Instructions**:

1. Install Node.js
2. Use REPL
3. Create Node.js scripts
4. Practice:
   - Running Node.js scripts
   - Using global objects
   - Working with process
   - Using environment variables

**Example Solution**:

```javascript
// exercise-1.js
// Basic Node.js script
console.log('Hello, Node.js!');
console.log('Current directory:', __dirname);
console.log('Current file:', __filename);
```

```javascript
// exercise-2.js
// Process information
console.log('=== Process Information ===');
console.log('Process ID:', process.pid);
console.log('Node version:', process.version);
console.log('Platform:', process.platform);
console.log('Architecture:', process.arch);
console.log('Current working directory:', process.cwd());
```

```javascript
// exercise-3.js
// Command line arguments
const args = process.argv.slice(2);

console.log('=== Command Line Arguments ===');
console.log('Number of arguments:', args.length);
args.forEach((arg, index) => {
    console.log(`Argument ${index + 1}: ${arg}`);
});

// Example usage:
// node exercise-3.js arg1 arg2 arg3
```

```javascript
// exercise-4.js
// Environment variables
console.log('=== Environment Variables ===');
console.log('NODE_ENV:', process.env.NODE_ENV || 'not set');
console.log('HOME:', process.env.HOME || process.env.USERPROFILE || 'not set');
console.log('PATH:', process.env.PATH ? 'set' : 'not set');

// Set custom environment variable
process.env.MY_APP_NAME = 'My Node.js App';
console.log('MY_APP_NAME:', process.env.MY_APP_NAME);
```

```javascript
// exercise-5.js
// Simple calculator
const args = process.argv.slice(2);

if (args.length !== 3) {
    console.log('Usage: node exercise-5.js <num1> <operator> <num2>');
    console.log('Operators: +, -, *, /');
    process.exit(1);
}

const num1 = parseFloat(args[0]);
const operator = args[1];
const num2 = parseFloat(args[2]);

let result;

switch (operator) {
    case '+':
        result = num1 + num2;
        break;
    case '-':
        result = num1 - num2;
        break;
    case '*':
        result = num1 * num2;
        break;
    case '/':
        if (num2 === 0) {
            console.error('Error: Division by zero');
            process.exit(1);
        }
        result = num1 / num2;
        break;
    default:
        console.error('Error: Invalid operator');
        process.exit(1);
}

console.log(`${num1} ${operator} ${num2} = ${result}`);

// Example usage:
// node exercise-5.js 10 + 5
// node exercise-5.js 10 - 5
// node exercise-5.js 10 * 5
// node exercise-5.js 10 / 5
```

```javascript
// exercise-6.js
// Interactive script with readline
const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question('What is your name? ', (name) => {
    console.log(`Hello, ${name}!`);
    
    rl.question('What is your age? ', (age) => {
        console.log(`You are ${age} years old.`);
        
        rl.question('What is your favorite color? ', (color) => {
            console.log(`Your favorite color is ${color}.`);
            rl.close();
        });
    });
});
```

```json
// package.json
{
  "name": "nodejs-basics",
  "version": "1.0.0",
  "description": "Node.js basics practice",
  "main": "exercise-1.js",
  "scripts": {
    "start": "node exercise-1.js",
    "process": "node exercise-2.js",
    "args": "node exercise-3.js",
    "env": "node exercise-4.js",
    "calc": "node exercise-5.js",
    "interactive": "node exercise-6.js"
  },
  "keywords": ["nodejs", "basics"],
  "author": "",
  "license": "ISC"
}
```

**Expected Output**:

```bash
# Run exercises
node exercise-1.js
# Output: Hello, Node.js! Current directory: ... Current file: ...

node exercise-2.js
# Output: Process information

node exercise-3.js arg1 arg2
# Output: Command line arguments

node exercise-4.js
# Output: Environment variables

node exercise-5.js 10 + 5
# Output: 10 + 5 = 15

node exercise-6.js
# Interactive prompts
```

**Challenge (Optional)**:
- Create more complex scripts
- Build a CLI tool
- Practice with REPL
- Explore Node.js documentation

---

## Common Mistakes

### 1. Using Browser APIs

```javascript
// ❌ Bad: Browser APIs don't exist in Node.js
document.getElementById('app');
window.location;

// ✅ Good: Use Node.js APIs
const fs = require('fs');
const http = require('http');
```

### 2. Forgetting to Install Dependencies

```javascript
// ❌ Bad: Using module without installing
const express = require('express');

// ✅ Good: Install first
// npm install express
const express = require('express');
```

### 3. Not Handling Errors

```javascript
// ❌ Bad: No error handling
const data = fs.readFileSync('file.txt', 'utf8');

// ✅ Good: Handle errors
try {
    const data = fs.readFileSync('file.txt', 'utf8');
} catch (error) {
    console.error('Error reading file:', error);
}
```

---

## Key Takeaways

1. **Node.js**: JavaScript runtime for server-side
2. **V8 Engine**: Powers Node.js
3. **Event-Driven**: Asynchronous, non-blocking
4. **No DOM**: No browser APIs
5. **Global Objects**: global, process, __dirname, __filename
6. **REPL**: Interactive JavaScript environment
7. **Best Practice**: Use Node.js APIs, handle errors, install dependencies

---

## Quiz: Node.js Introduction

Test your understanding with these questions:

1. **Node.js is:**
   - A) JavaScript runtime
   - B) JavaScript framework
   - C) Both
   - D) Neither

2. **Node.js uses:**
   - A) V8 engine
   - B) SpiderMonkey
   - C) Both
   - D) Neither

3. **Node.js has:**
   - A) DOM
   - B) No DOM
   - C) Both
   - D) Neither

4. **Global object in Node.js:**
   - A) window
   - B) global
   - C) Both
   - D) Neither

5. **REPL stands for:**
   - A) Read-Eval-Print Loop
   - B) Run-Execute-Print Loop
   - C) Both
   - D) Neither

6. **Node.js is:**
   - A) Single-threaded
   - B) Multi-threaded
   - C) Both
   - D) Neither

7. **Package manager for Node.js:**
   - A) npm
   - B) yarn
   - C) Both
   - D) Neither

**Answers**:
1. A) JavaScript runtime
2. A) V8 engine
3. B) No DOM
4. B) global
5. A) Read-Eval-Print Loop
6. A) Single-threaded (with event loop)
7. C) Both (npm is default, yarn is alternative)

---

## Next Steps

Congratulations! You've learned Node.js introduction. You now know:
- What Node.js is
- Differences from browser JavaScript
- How to install Node.js
- How to use REPL

**What's Next?**
- Lesson 28.2: Node.js Modules
- Learn CommonJS modules
- Understand core modules
- Work with npm modules

---

## Additional Resources

- **Node.js Documentation**: [nodejs.org/docs](https://nodejs.org/docs)
- **Node.js API**: [nodejs.org/api](https://nodejs.org/api)
- **npm Documentation**: [docs.npmjs.com](https://docs.npmjs.com)
- **nvm**: [github.com/nvm-sh/nvm](https://github.com/nvm-sh/nvm)

---

*Lesson completed! You're ready to move on to the next lesson.*

