# Lesson 28.2: Node.js Modules

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand CommonJS modules
- Use core Node.js modules
- Work with npm modules
- Understand module patterns
- Create and use custom modules
- Organize code with modules
- Build modular applications

---

## Introduction to Modules

Modules are reusable pieces of code that can be imported and used in other files. Node.js uses a module system to organize code.

### Why Modules?

- **Code Organization**: Split code into logical units
- **Reusability**: Use code in multiple places
- **Namespace**: Avoid global variable pollution
- **Maintainability**: Easier to maintain and test
- **Dependency Management**: Clear dependencies

---

## CommonJS Modules

### What is CommonJS?

CommonJS is the module system used by Node.js. It uses `require()` and `module.exports`.

### Exporting Modules

```javascript
// math.js
// Export single value
module.exports = function add(a, b) {
    return a + b;
};

// Export object
module.exports = {
    add: (a, b) => a + b,
    subtract: (a, b) => a - b,
    multiply: (a, b) => a * b,
    divide: (a, b) => a / b
};

// Export using exports
exports.add = (a, b) => a + b;
exports.subtract = (a, b) => a - b;
```

### Importing Modules

```javascript
// app.js
// Import single value
const add = require('./math');
console.log(add(2, 3));

// Import object
const math = require('./math');
console.log(math.add(2, 3));
console.log(math.subtract(5, 2));

// Destructure import
const { add, subtract } = require('./math');
console.log(add(2, 3));
```

### Module Caching

```javascript
// Modules are cached after first require
// Subsequent requires return cached version
const module1 = require('./math');
const module2 = require('./math');
// module1 === module2 (same instance)
```

---

## Core Modules

### What are Core Modules?

Core modules are built-in Node.js modules that don't require installation.

### Common Core Modules

```javascript
// File System
const fs = require('fs');

// Path
const path = require('path');

// HTTP
const http = require('http');
const https = require('https');

// URL
const url = require('url');

// Events
const events = require('events');

// Stream
const stream = require('stream');

// Crypto
const crypto = require('crypto');

// OS
const os = require('os');

// Process
const process = require('process');

// Buffer
const buffer = require('buffer');
```

### fs Module (File System)

```javascript
const fs = require('fs');

// Read file synchronously
const data = fs.readFileSync('file.txt', 'utf8');

// Read file asynchronously
fs.readFile('file.txt', 'utf8', (err, data) => {
    if (err) {
        console.error(err);
        return;
    }
    console.log(data);
});

// Write file
fs.writeFileSync('output.txt', 'Hello, World!');

// Check if file exists
if (fs.existsSync('file.txt')) {
    console.log('File exists');
}
```

### path Module

```javascript
const path = require('path');

// Join paths
const fullPath = path.join(__dirname, 'data', 'file.txt');

// Get directory name
const dir = path.dirname('/users/john/file.txt');
// '/users/john'

// Get file name
const filename = path.basename('/users/john/file.txt');
// 'file.txt'

// Get extension
const ext = path.extname('file.txt');
// '.txt'

// Parse path
const parsed = path.parse('/users/john/file.txt');
// { root: '/', dir: '/users/john', base: 'file.txt', ext: '.txt', name: 'file' }

// Resolve path
const resolved = path.resolve('data', 'file.txt');
```

### http Module

```javascript
const http = require('http');

// Create server
const server = http.createServer((req, res) => {
    res.writeHead(200, { 'Content-Type': 'text/plain' });
    res.end('Hello, World!');
});

server.listen(3000, () => {
    console.log('Server running on port 3000');
});
```

### url Module

```javascript
const url = require('url');

// Parse URL
const parsedUrl = url.parse('https://example.com/path?query=value');
console.log(parsedUrl.hostname);  // 'example.com'
console.log(parsedUrl.pathname);  // '/path'
console.log(parsedUrl.query);     // 'query=value'

// Create URL
const myUrl = new URL('https://example.com/path?query=value');
console.log(myUrl.searchParams.get('query'));  // 'value'
```

### os Module

```javascript
const os = require('os');

console.log(os.platform());      // 'darwin', 'win32', 'linux'
console.log(os.arch());          // 'x64', 'arm64'
console.log(os.cpus());          // CPU information
console.log(os.totalmem());      // Total memory
console.log(os.freemem());       // Free memory
console.log(os.homedir());       // Home directory
console.log(os.hostname());      // Hostname
```

### crypto Module

```javascript
const crypto = require('crypto');

// Create hash
const hash = crypto.createHash('sha256');
hash.update('Hello, World!');
console.log(hash.digest('hex'));

// Generate random bytes
const randomBytes = crypto.randomBytes(16);
console.log(randomBytes.toString('hex'));
```

---

## npm Modules

### What is npm?

npm (Node Package Manager) is the package manager for Node.js. It allows you to install and manage third-party modules.

### Installing Packages

```bash
# Install package
npm install express

# Install as dev dependency
npm install --save-dev nodemon

# Install globally
npm install -g nodemon

# Install specific version
npm install express@4.18.0

# Install from package.json
npm install
```

### package.json

```json
{
  "name": "my-app",
  "version": "1.0.0",
  "description": "My application",
  "main": "index.js",
  "scripts": {
    "start": "node index.js",
    "dev": "nodemon index.js"
  },
  "dependencies": {
    "express": "^4.18.0"
  },
  "devDependencies": {
    "nodemon": "^2.0.0"
  }
}
```

### Using npm Modules

```javascript
// Install: npm install express
const express = require('express');
const app = express();

app.get('/', (req, res) => {
    res.send('Hello, World!');
});

app.listen(3000);
```

### Popular npm Modules

```javascript
// Web framework
const express = require('express');

// Database
const mongoose = require('mongoose');
const mysql = require('mysql2');

// Validation
const joi = require('joi');

// Environment variables
require('dotenv').config();

// HTTP client
const axios = require('axios');

// File upload
const multer = require('multer');

// Authentication
const jwt = require('jsonwebtoken');
const bcrypt = require('bcrypt');
```

---

## Module Patterns

### Pattern 1: Single Export

```javascript
// calculator.js
module.exports = function calculate(a, b, operation) {
    switch (operation) {
        case 'add':
            return a + b;
        case 'subtract':
            return a - b;
        case 'multiply':
            return a * b;
        case 'divide':
            return a / b;
        default:
            throw new Error('Invalid operation');
    }
};

// app.js
const calculate = require('./calculator');
console.log(calculate(10, 5, 'add'));
```

### Pattern 2: Multiple Exports

```javascript
// utils.js
exports.add = (a, b) => a + b;
exports.subtract = (a, b) => a - b;
exports.multiply = (a, b) => a * b;
exports.divide = (a, b) => a / b;

// app.js
const { add, subtract } = require('./utils');
console.log(add(2, 3));
```

### Pattern 3: Class Export

```javascript
// User.js
class User {
    constructor(name, email) {
        this.name = name;
        this.email = email;
    }
    
    greet() {
        return `Hello, ${this.name}!`;
    }
}

module.exports = User;

// app.js
const User = require('./User');
const user = new User('Alice', 'alice@example.com');
console.log(user.greet());
```

### Pattern 4: Factory Function

```javascript
// createUser.js
module.exports = function createUser(name, email) {
    return {
        name,
        email,
        greet() {
            return `Hello, ${this.name}!`;
        }
    };
};

// app.js
const createUser = require('./createUser');
const user = createUser('Alice', 'alice@example.com');
console.log(user.greet());
```

### Pattern 5: Singleton

```javascript
// config.js
let instance = null;

class Config {
    constructor() {
        if (instance) {
            return instance;
        }
        this.settings = {};
        instance = this;
    }
    
    set(key, value) {
        this.settings[key] = value;
    }
    
    get(key) {
        return this.settings[key];
    }
}

module.exports = new Config();

// app.js
const config = require('./config');
config.set('port', 3000);
console.log(config.get('port'));
```

---

## Practice Exercise

### Exercise: Working with Modules

**Objective**: Practice creating modules, using core modules, installing npm modules, and applying module patterns.

**Instructions**:

1. Create Node.js modules
2. Use core modules
3. Install and use npm modules
4. Practice:
   - Creating custom modules
   - Using core modules
   - Installing npm packages
   - Applying module patterns

**Example Solution**:

```javascript
// src/utils/math.js
// Math utility module
exports.add = (a, b) => a + b;
exports.subtract = (a, b) => a - b;
exports.multiply = (a, b) => a * b;
exports.divide = (a, b) => {
    if (b === 0) {
        throw new Error('Division by zero');
    }
    return a / b;
};
```

```javascript
// src/utils/string.js
// String utility module
exports.capitalize = (str) => {
    return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
};

exports.reverse = (str) => {
    return str.split('').reverse().join('');
};

exports.isPalindrome = (str) => {
    const cleaned = str.toLowerCase().replace(/[^a-z0-9]/g, '');
    return cleaned === cleaned.split('').reverse().join('');
};
```

```javascript
// src/models/User.js
// User model module
class User {
    constructor(name, email) {
        this.id = Date.now();
        this.name = name;
        this.email = email;
        this.createdAt = new Date();
    }
    
    greet() {
        return `Hello, ${this.name}!`;
    }
    
    toJSON() {
        return {
            id: this.id,
            name: this.name,
            email: this.email,
            createdAt: this.createdAt
        };
    }
}

module.exports = User;
```

```javascript
// src/services/fileService.js
// File service using fs module
const fs = require('fs');
const path = require('path');

class FileService {
    readFile(filePath) {
        try {
            const fullPath = path.resolve(filePath);
            return fs.readFileSync(fullPath, 'utf8');
        } catch (error) {
            throw new Error(`Error reading file: ${error.message}`);
        }
    }
    
    writeFile(filePath, data) {
        try {
            const fullPath = path.resolve(filePath);
            fs.writeFileSync(fullPath, data, 'utf8');
            return true;
        } catch (error) {
            throw new Error(`Error writing file: ${error.message}`);
        }
    }
    
    fileExists(filePath) {
        const fullPath = path.resolve(filePath);
        return fs.existsSync(fullPath);
    }
    
    getFileInfo(filePath) {
        const fullPath = path.resolve(filePath);
        if (!fs.existsSync(fullPath)) {
            throw new Error('File does not exist');
        }
        
        const stats = fs.statSync(fullPath);
        return {
            path: fullPath,
            size: stats.size,
            created: stats.birthtime,
            modified: stats.mtime,
            isFile: stats.isFile(),
            isDirectory: stats.isDirectory()
        };
    }
}

module.exports = new FileService();
```

```javascript
// src/config/config.js
// Configuration module (singleton pattern)
const os = require('os');
const path = require('path');

class Config {
    constructor() {
        this.env = process.env.NODE_ENV || 'development';
        this.port = process.env.PORT || 3000;
        this.host = process.env.HOST || 'localhost';
        this.platform = os.platform();
        this.homeDir = os.homedir();
        this.appDir = __dirname;
    }
    
    get(key) {
        return this[key] || process.env[key];
    }
    
    set(key, value) {
        this[key] = value;
    }
    
    isDevelopment() {
        return this.env === 'development';
    }
    
    isProduction() {
        return this.env === 'production';
    }
}

module.exports = new Config();
```

```javascript
// src/app.js
// Main application using all modules
const math = require('./utils/math');
const string = require('./utils/string');
const User = require('./models/User');
const fileService = require('./services/fileService');
const config = require('./config/config');

console.log('=== Math Utilities ===');
console.log('Add:', math.add(10, 5));
console.log('Subtract:', math.subtract(10, 5));
console.log('Multiply:', math.multiply(10, 5));
console.log('Divide:', math.divide(10, 5));

console.log('\n=== String Utilities ===');
console.log('Capitalize:', string.capitalize('hello'));
console.log('Reverse:', string.reverse('hello'));
console.log('Is Palindrome:', string.isPalindrome('racecar'));

console.log('\n=== User Model ===');
const user = new User('Alice', 'alice@example.com');
console.log(user.greet());
console.log('User JSON:', JSON.stringify(user.toJSON(), null, 2));

console.log('\n=== File Service ===');
try {
    // Create a test file
    const testFile = 'test.txt';
    fileService.writeFile(testFile, 'Hello, World!');
    console.log('File written:', testFile);
    
    // Read the file
    const content = fileService.readFile(testFile);
    console.log('File content:', content);
    
    // Get file info
    const info = fileService.getFileInfo(testFile);
    console.log('File info:', info);
} catch (error) {
    console.error('File error:', error.message);
}

console.log('\n=== Configuration ===');
console.log('Environment:', config.env);
console.log('Port:', config.port);
console.log('Platform:', config.platform);
console.log('Is Development:', config.isDevelopment());
```

```json
// package.json
{
  "name": "nodejs-modules-practice",
  "version": "1.0.0",
  "description": "Node.js modules practice",
  "main": "src/app.js",
  "scripts": {
    "start": "node src/app.js",
    "test": "echo \"Error: no test specified\" && exit 1"
  },
  "keywords": ["nodejs", "modules"],
  "author": "",
  "license": "ISC"
}
```

**Expected Output**:

```bash
node src/app.js

=== Math Utilities ===
Add: 15
Subtract: 5
Multiply: 50
Divide: 2

=== String Utilities ===
Capitalize: Hello
Reverse: olleh
Is Palindrome: true

=== User Model ===
Hello, Alice!
User JSON: {
  "id": 1234567890,
  "name": "Alice",
  "email": "alice@example.com",
  "createdAt": "2024-01-01T00:00:00.000Z"
}

=== File Service ===
File written: test.txt
File content: Hello, World!
File info: { path: '...', size: 13, ... }

=== Configuration ===
Environment: development
Port: 3000
Platform: darwin
Is Development: true
```

**Challenge (Optional)**:
- Create more modules
- Build a complete application
- Use more core modules
- Install and use npm packages

---

## Common Mistakes

### 1. Circular Dependencies

```javascript
// ❌ Bad: Circular dependency
// a.js
const b = require('./b');
module.exports = { a: 'A' };

// b.js
const a = require('./a');
module.exports = { b: 'B' };

// ✅ Good: Avoid circular dependencies
// Use dependency injection or restructure
```

### 2. Not Handling Errors

```javascript
// ❌ Bad: No error handling
const data = fs.readFileSync('file.txt', 'utf8');

// ✅ Good: Handle errors
try {
    const data = fs.readFileSync('file.txt', 'utf8');
} catch (error) {
    console.error('Error:', error.message);
}
```

### 3. Using Wrong Path

```javascript
// ❌ Bad: Relative path issues
const module = require('./module');

// ✅ Good: Use path.resolve or absolute paths
const path = require('path');
const module = require(path.resolve(__dirname, 'module'));
```

---

## Key Takeaways

1. **CommonJS**: Module system used by Node.js
2. **require()**: Import modules
3. **module.exports**: Export modules
4. **Core Modules**: Built-in Node.js modules
5. **npm Modules**: Third-party packages
6. **Module Patterns**: Different ways to structure modules
7. **Best Practice**: Avoid circular dependencies, handle errors, use proper paths

---

## Quiz: Node.js Modules

Test your understanding with these questions:

1. **CommonJS uses:**
   - A) require() and module.exports
   - B) import and export
   - C) Both
   - D) Neither

2. **Core modules:**
   - A) Built-in
   - B) Need installation
   - C) Both
   - D) Neither

3. **npm modules:**
   - A) Built-in
   - B) Need installation
   - C) Both
   - D) Neither

4. **Modules are:**
   - A) Cached
   - B) Not cached
   - C) Both
   - D) Neither

5. **module.exports:**
   - A) Export module
   - B) Import module
   - C) Both
   - D) Neither

6. **require():**
   - A) Export module
   - B) Import module
   - C) Both
   - D) Neither

7. **Circular dependencies:**
   - A) Good practice
   - B) Should avoid
   - C) Both
   - D) Neither

**Answers**:
1. A) require() and module.exports
2. A) Built-in
3. B) Need installation
4. A) Cached
5. A) Export module
6. B) Import module
7. B) Should avoid

---

## Next Steps

Congratulations! You've learned Node.js modules. You now know:
- How to use CommonJS modules
- How to use core modules
- How to work with npm modules
- How to apply module patterns

**What's Next?**
- Lesson 28.3: File System Operations
- Learn reading and writing files
- Work with directories
- Understand streams

---

## Additional Resources

- **Node.js Modules**: [nodejs.org/api/modules.html](https://nodejs.org/api/modules.html)
- **Core Modules**: [nodejs.org/api](https://nodejs.org/api)
- **npm**: [docs.npmjs.com](https://docs.npmjs.com)
- **CommonJS**: [nodejs.org/api/modules.html#modules-commonjs-modules](https://nodejs.org/api/modules.html#modules-commonjs-modules)

---

*Lesson completed! You're ready to move on to the next lesson.*

