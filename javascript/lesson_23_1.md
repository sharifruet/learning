# Lesson 23.1: npm and Package Management

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand npm basics
- Work with package.json
- Install and manage packages
- Use npm scripts
- Understand package versions
- Manage dependencies
- Build professional projects

---

## Introduction to npm

npm (Node Package Manager) is the package manager for JavaScript. It's used to install, share, and manage code packages.

### Why npm?

- **Package Management**: Install and manage dependencies
- **Code Sharing**: Share your code as packages
- **Scripts**: Run build and development scripts
- **Standard**: Industry standard for JavaScript
- **Ecosystem**: Huge library of packages
- **Professional**: Essential for modern development

---

## npm Basics

### Installing npm

```bash
# npm comes with Node.js
# Download Node.js from nodejs.org

# Check if installed
node --version
npm --version
```

### Initializing a Project

```bash
# Initialize new project
npm init

# Or with defaults
npm init -y
```

### package.json

```json
{
  "name": "my-project",
  "version": "1.0.0",
  "description": "My project description",
  "main": "index.js",
  "scripts": {
    "test": "echo \"Error: no test specified\" && exit 1"
  },
  "keywords": [],
  "author": "",
  "license": "ISC"
}
```

---

## Installing Packages

### Install Commands

```bash
# Install package (adds to dependencies)
npm install package-name

# Short form
npm i package-name

# Install specific version
npm install package-name@1.2.3

# Install latest version
npm install package-name@latest

# Install dev dependency
npm install --save-dev package-name
npm install -D package-name

# Install globally
npm install -g package-name
```

### Package Types

```json
{
  "dependencies": {
    "lodash": "^4.17.21"
  },
  "devDependencies": {
    "jest": "^29.0.0"
  },
  "peerDependencies": {
    "react": "^18.0.0"
  },
  "optionalDependencies": {
    "optional-package": "^1.0.0"
  }
}
```

### Installing from package.json

```bash
# Install all dependencies
npm install

# Or
npm i
```

---

## package.json

### Basic Structure

```json
{
  "name": "my-project",
  "version": "1.0.0",
  "description": "Project description",
  "main": "index.js",
  "scripts": {
    "start": "node index.js",
    "test": "jest",
    "build": "webpack"
  },
  "keywords": ["keyword1", "keyword2"],
  "author": "Your Name",
  "license": "MIT",
  "dependencies": {
    "express": "^4.18.0"
  },
  "devDependencies": {
    "jest": "^29.0.0"
  }
}
```

### Important Fields

```json
{
  "name": "package-name",        // Package name
  "version": "1.0.0",            // Version (semver)
  "description": "Description",  // Package description
  "main": "index.js",            // Entry point
  "scripts": {},                 // npm scripts
  "dependencies": {},            // Production dependencies
  "devDependencies": {},         // Development dependencies
  "engines": {                   // Node/npm version requirements
    "node": ">=14.0.0",
    "npm": ">=6.0.0"
  }
}
```

---

## npm Scripts

### Basic Scripts

```json
{
  "scripts": {
    "start": "node index.js",
    "test": "jest",
    "build": "webpack --mode production",
    "dev": "webpack --mode development"
  }
}
```

### Running Scripts

```bash
# Run script
npm run script-name

# Shortcuts (start, test, stop, restart)
npm start
npm test
npm stop
npm restart
```

### Common Scripts

```json
{
  "scripts": {
    "start": "node server.js",
    "dev": "nodemon server.js",
    "build": "webpack",
    "test": "jest",
    "test:watch": "jest --watch",
    "test:coverage": "jest --coverage",
    "lint": "eslint .",
    "lint:fix": "eslint . --fix",
    "format": "prettier --write .",
    "prebuild": "npm run lint",
    "postbuild": "echo 'Build complete'"
  }
}
```

### Pre and Post Scripts

```json
{
  "scripts": {
    "prebuild": "npm run lint",      // Runs before build
    "build": "webpack",
    "postbuild": "echo 'Done'"       // Runs after build
  }
}
```

---

## Package Versions

### Semantic Versioning (Semver)

```javascript
// Version format: MAJOR.MINOR.PATCH
// 1.2.3
// ^1.2.3 - Compatible with 1.x.x (>=1.2.3 <2.0.0)
// ~1.2.3 - Compatible with 1.2.x (>=1.2.3 <1.3.0)
// 1.2.3  - Exact version
// *      - Any version
// latest - Latest version
```

### Version Ranges

```json
{
  "dependencies": {
    "package1": "^1.2.3",    // 1.2.3 to <2.0.0
    "package2": "~1.2.3",    // 1.2.3 to <1.3.0
    "package3": "1.2.3",     // Exact version
    "package4": ">=1.2.3",   // >= 1.2.3
    "package5": "<2.0.0",     // < 2.0.0
    "package6": "*"           // Any version
  }
}
```

### Updating Packages

```bash
# Check outdated packages
npm outdated

# Update package
npm update package-name

# Update all packages
npm update

# Install latest version
npm install package-name@latest
```

---

## Managing Dependencies

### Viewing Dependencies

```bash
# List installed packages
npm list

# List only top-level
npm list --depth=0

# Check package info
npm info package-name

# View package.json of package
npm view package-name
```

### Removing Packages

```bash
# Remove package
npm uninstall package-name

# Short form
npm uninstall package-name

# Remove from devDependencies
npm uninstall --save-dev package-name
```

### package-lock.json

```json
// package-lock.json locks exact versions
// Ensures consistent installs across environments
// Should be committed to version control
```

---

## npm Registry

### Using npm Registry

```bash
# Install from npm registry (default)
npm install package-name

# Install from specific registry
npm install --registry=https://registry.npmjs.org/

# Set registry
npm config set registry https://registry.npmjs.org/
```

### Publishing Packages

```bash
# Login to npm
npm login

# Publish package
npm publish

# Publish with specific version
npm publish --tag beta
```

---

## Practice Exercise

### Exercise: npm Practice

**Objective**: Practice using npm, managing packages, and working with package.json.

**Instructions**:

1. Initialize a new npm project
2. Install packages
3. Create scripts
4. Practice:
   - Installing packages
   - Managing dependencies
   - Using scripts
   - Understanding versions

**Example Solution**:

```bash
# 1. Initialize project
npm init -y

# 2. Install dependencies
npm install express
npm install --save-dev jest

# 3. Create package.json with scripts
```

```json
// package.json
{
  "name": "npm-practice",
  "version": "1.0.0",
  "description": "npm practice project",
  "main": "index.js",
  "scripts": {
    "start": "node index.js",
    "dev": "node index.js",
    "test": "jest",
    "test:watch": "jest --watch",
    "lint": "echo 'Linting...'",
    "build": "echo 'Building...'"
  },
  "keywords": ["practice", "npm"],
  "author": "",
  "license": "ISC",
  "dependencies": {
    "express": "^4.18.0"
  },
  "devDependencies": {
    "jest": "^29.0.0"
  }
}
```

```javascript
// index.js
const express = require('express');
const app = express();

app.get('/', (req, res) => {
    res.send('Hello from npm practice!');
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
```

```javascript
// test.js
// Basic test example
function add(a, b) {
    return a + b;
}

// Run with: node test.js
console.log('Testing add function:');
console.log('add(2, 3) =', add(2, 3));
console.log('add(5, 7) =', add(5, 7));
```

```bash
# Commands to practice:

# Install packages
npm install lodash
npm install --save-dev nodemon

# View installed packages
npm list
npm list --depth=0

# Check outdated
npm outdated

# Update package
npm update lodash

# Remove package
npm uninstall lodash

# Run scripts
npm start
npm test
npm run dev

# Check package info
npm info express
npm view express version
```

**Expected Output** (when running commands):
```
# npm init -y
Wrote to package.json

# npm install express
added 1 package

# npm list
npm-practice@1.0.0
└── express@4.18.0

# npm start
Server running on port 3000
```

**Challenge (Optional)**:
- Create a complete project with npm
- Set up build scripts
- Manage multiple dependencies
- Publish your own package

---

## Common Mistakes

### 1. Not Using package-lock.json

```bash
# ❌ Bad: Delete package-lock.json
rm package-lock.json

# ✅ Good: Commit package-lock.json
git add package-lock.json
```

### 2. Installing Globally When Not Needed

```bash
# ❌ Bad: Install dev tools globally
npm install -g jest

# ✅ Good: Install as dev dependency
npm install --save-dev jest
```

### 3. Wrong Version Ranges

```json
// ❌ Bad: Too permissive
{
  "dependencies": {
    "package": "*"
  }
}

// ✅ Good: Specific range
{
  "dependencies": {
    "package": "^1.2.3"
  }
}
```

---

## Key Takeaways

1. **npm**: Node Package Manager for JavaScript
2. **package.json**: Project configuration file
3. **Dependencies**: Production and development
4. **Scripts**: Automate tasks with npm scripts
5. **Versions**: Use semantic versioning
6. **Best Practice**: Commit package-lock.json, use specific versions
7. **Ecosystem**: Huge library of packages available

---

## Quiz: npm

Test your understanding with these questions:

1. **npm stands for:**
   - A) Node Package Manager
   - B) Node Program Manager
   - C) New Package Manager
   - D) Nothing

2. **npm install adds to:**
   - A) dependencies
   - B) devDependencies
   - C) Both (depending on flag)
   - D) Neither

3. **package-lock.json:**
   - A) Should be committed
   - B) Should be ignored
   - C) Optional
   - D) Nothing

4. **^1.2.3 means:**
   - A) Exact version
   - B) Compatible with 1.x.x
   - C) Latest version
   - D) Nothing

5. **npm scripts run with:**
   - A) npm run script-name
   - B) npm script-name
   - C) Both (for some)
   - D) Neither

6. **devDependencies are:**
   - A) For production
   - B) For development
   - C) Both
   - D) Neither

7. **npm outdated shows:**
   - A) Outdated packages
   - B) All packages
   - C) Installed packages
   - D) Nothing

**Answers**:
1. A) Node Package Manager
2. C) Both (depending on flag)
3. A) Should be committed
4. B) Compatible with 1.x.x
5. C) Both (for some)
6. B) For development
7. A) Outdated packages

---

## Next Steps

Congratulations! You've learned npm and package management. You now know:
- How to use npm
- How to manage packages
- How to use scripts
- How to work with versions

**What's Next?**
- Lesson 23.2: Webpack
- Learn webpack basics
- Configure webpack
- Use loaders and plugins

---

## Additional Resources

- **npm Documentation**: [docs.npmjs.com](https://docs.npmjs.com)
- **package.json Guide**: [docs.npmjs.com/cli/v8/configuring-npm/package-json](https://docs.npmjs.com/cli/v8/configuring-npm/package-json)
- **Semantic Versioning**: [semver.org](https://semver.org)

---

*Lesson completed! You're ready to move on to the next lesson.*

