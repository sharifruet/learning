# Lesson 23.3: Modern Build Tools

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand modern build tools
- Use Vite for fast development
- Work with Parcel
- Understand esbuild
- Compare build tools
- Choose appropriate tool
- Set up modern build pipelines

---

## Introduction to Modern Build Tools

Modern build tools offer faster builds, better developer experience, and simpler configuration than traditional tools.

### Why Modern Build Tools?

- **Speed**: Much faster than webpack
- **Zero Config**: Work out of the box
- **Better DX**: Great developer experience
- **Modern**: Built for modern JavaScript
- **Hot Reload**: Fast hot module replacement
- **Simple**: Less configuration needed

### Popular Modern Tools

1. **Vite**: Fast, opinionated, great for modern frameworks
2. **Parcel**: Zero-config, fast, automatic
3. **esbuild**: Extremely fast, written in Go

---

## Vite

### What is Vite?

Vite is a next-generation frontend build tool that provides fast development and optimized production builds.

### Installation

```bash
# Create Vite project
npm create vite@latest my-project

# Or install manually
npm install --save-dev vite
```

### Basic Setup

```javascript
// vite.config.js
import { defineConfig } from 'vite';

export default defineConfig({
    root: './src',
    build: {
        outDir: '../dist'
    }
});
```

### package.json Scripts

```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "preview": "vite preview"
  }
}
```

### Vite Features

```javascript
// Automatic code splitting
// Fast HMR (Hot Module Replacement)
// Native ES modules in dev
// Optimized production builds
// Built-in TypeScript support
// CSS preprocessing support
```

### Vite with React

```bash
# Create React app with Vite
npm create vite@latest my-react-app -- --template react
```

### Vite Configuration

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [react()],
    server: {
        port: 3000,
        open: true
    },
    build: {
        outDir: 'dist',
        sourcemap: true
    }
});
```

---

## Parcel

### What is Parcel?

Parcel is a zero-configuration build tool that works out of the box.

### Installation

```bash
# Install Parcel
npm install --save-dev parcel

# Or globally
npm install -g parcel
```

### Basic Usage

```bash
# Development server
parcel index.html

# Production build
parcel build index.html
```

### package.json Scripts

```json
{
  "scripts": {
    "dev": "parcel index.html",
    "build": "parcel build index.html"
  }
}
```

### Parcel Features

```javascript
// Zero configuration
// Automatic code splitting
// Fast builds
// Built-in hot reload
// Automatic transforms
// Asset optimization
```

### Parcel Configuration

```json
// .parcelrc (optional)
{
  "extends": "@parcel/config-default",
  "transformers": {
    "*.js": ["@parcel/transformer-babel"]
  }
}
```

---

## esbuild

### What is esbuild?

esbuild is an extremely fast JavaScript bundler written in Go.

### Installation

```bash
# Install esbuild
npm install --save-dev esbuild
```

### Basic Usage

```javascript
// build.js
require('esbuild').build({
    entryPoints: ['src/index.js'],
    bundle: true,
    outfile: 'dist/bundle.js',
    minify: true,
    sourcemap: true
}).catch(() => process.exit(1));
```

### Command Line

```bash
# Bundle
esbuild src/index.js --bundle --outfile=dist/bundle.js

# Watch mode
esbuild src/index.js --bundle --outfile=dist/bundle.js --watch

# Minify
esbuild src/index.js --bundle --outfile=dist/bundle.js --minify
```

### esbuild Features

```javascript
// Extremely fast (10-100x faster)
// TypeScript support
// JSX support
// Minification
// Source maps
// Code splitting
```

### esbuild Configuration

```javascript
// build.js
const esbuild = require('esbuild');

esbuild.build({
    entryPoints: ['src/index.js'],
    bundle: true,
    outdir: 'dist',
    format: 'esm',
    platform: 'browser',
    target: 'es2020',
    minify: true,
    sourcemap: true,
    splitting: true
}).then(() => {
    console.log('Build complete');
}).catch(() => process.exit(1));
```

---

## Comparison

### Speed Comparison

```
esbuild:  ⚡⚡⚡⚡⚡ (Fastest)
Vite:     ⚡⚡⚡⚡ (Very Fast)
Parcel:   ⚡⚡⚡ (Fast)
Webpack:  ⚡⚡ (Slower)
```

### Configuration

```javascript
// Vite: Minimal config needed
export default defineConfig({
    // Usually works with defaults
});

// Parcel: Zero config
// No config file needed

// esbuild: Simple config
esbuild.build({
    entryPoints: ['src/index.js'],
    bundle: true
});

// Webpack: More config
module.exports = {
    entry: './src/index.js',
    // ... many options
};
```

### Use Cases

```javascript
// Vite: Best for
// - Modern frameworks (React, Vue, Svelte)
// - Fast development
// - Production builds

// Parcel: Best for
// - Quick setup
// - Zero config needed
// - Simple projects

// esbuild: Best for
// - Maximum speed
// - Simple bundling
// - Build scripts

// Webpack: Best for
// - Complex configurations
// - Legacy projects
// - Maximum flexibility
```

---

## Practice Exercise

### Exercise: Build Tool Setup

**Objective**: Practice setting up Vite, Parcel, and esbuild, and comparing their usage.

**Instructions**:

1. Set up projects with each tool
2. Compare build times
3. Practice:
   - Vite setup
   - Parcel setup
   - esbuild setup
   - Comparing tools

**Example Solution**:

```bash
# Vite Setup
npm create vite@latest vite-project -- --template vanilla
cd vite-project
npm install
npm run dev
```

```javascript
// vite-project/vite.config.js
import { defineConfig } from 'vite';

export default defineConfig({
    server: {
        port: 3000,
        open: true
    },
    build: {
        outDir: 'dist',
        sourcemap: true
    }
});
```

```json
// vite-project/package.json
{
  "name": "vite-project",
  "version": "1.0.0",
  "type": "module",
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "preview": "vite preview"
  },
  "devDependencies": {
    "vite": "^4.4.0"
  }
}
```

```bash
# Parcel Setup
mkdir parcel-project
cd parcel-project
npm init -y
npm install --save-dev parcel
```

```html
<!-- parcel-project/index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Project</title>
</head>
<body>
    <h1>Parcel Project</h1>
    <script type="module" src="./src/index.js"></script>
</body>
</html>
```

```javascript
// parcel-project/src/index.js
import './styles.css';

console.log('Parcel is working!');

document.body.innerHTML += '<p>Hello from Parcel!</p>';
```

```css
/* parcel-project/src/styles.css */
body {
    font-family: Arial, sans-serif;
    margin: 20px;
}
```

```json
// parcel-project/package.json
{
  "name": "parcel-project",
  "version": "1.0.0",
  "scripts": {
    "dev": "parcel index.html",
    "build": "parcel build index.html"
  },
  "devDependencies": {
    "parcel": "^2.9.0"
  }
}
```

```bash
# esbuild Setup
mkdir esbuild-project
cd esbuild-project
npm init -y
npm install --save-dev esbuild
```

```javascript
// esbuild-project/build.js
const esbuild = require('esbuild');

// Development
if (process.argv[2] === 'dev') {
    esbuild.build({
        entryPoints: ['src/index.js'],
        bundle: true,
        outfile: 'dist/bundle.js',
        sourcemap: true,
        watch: {
            onRebuild(error, result) {
                if (error) console.error('Build failed:', error);
                else console.log('Build succeeded');
            }
        }
    }).then(() => {
        console.log('Watching...');
    });
}

// Production
else {
    esbuild.build({
        entryPoints: ['src/index.js'],
        bundle: true,
        outfile: 'dist/bundle.js',
        minify: true,
        sourcemap: true
    }).then(() => {
        console.log('Build complete');
    }).catch(() => process.exit(1));
}
```

```javascript
// esbuild-project/src/index.js
console.log('esbuild is working!');

function add(a, b) {
    return a + b;
}

console.log('add(2, 3) =', add(2, 3));
```

```json
// esbuild-project/package.json
{
  "name": "esbuild-project",
  "version": "1.0.0",
  "scripts": {
    "dev": "node build.js dev",
    "build": "node build.js"
  },
  "devDependencies": {
    "esbuild": "^0.18.0"
  }
}
```

```javascript
// Comparison example
console.log("=== Build Tools Comparison ===");

console.log("\n=== Vite ===");
console.log("Pros:");
console.log("- Very fast development");
console.log("- Great for modern frameworks");
console.log("- Optimized production builds");
console.log("- Built-in HMR");
console.log("Cons:");
console.log("- Opinionated");
console.log("- Less flexible than webpack");

console.log("\n=== Parcel ===");
console.log("Pros:");
console.log("- Zero configuration");
console.log("- Fast builds");
console.log("- Automatic transforms");
console.log("Cons:");
console.log("- Less control");
console.log("- Can be slower than Vite/esbuild");

console.log("\n=== esbuild ===");
console.log("Pros:");
console.log("- Extremely fast");
console.log("- Simple API");
console.log("- Good for scripts");
console.log("Cons:");
console.log("- Less features than webpack");
console.log("- Not as mature ecosystem");

console.log("\n=== Webpack ===");
console.log("Pros:");
console.log("- Maximum flexibility");
console.log("- Huge ecosystem");
console.log("- Mature and stable");
console.log("Cons:");
console.log("- Slower than modern tools");
console.log("- More configuration needed");
```

**Expected Output** (when running each tool):
```
# Vite
VITE v4.4.0  ready in 500 ms
➜  Local:   http://localhost:5173/

# Parcel
Server running at http://localhost:1234

# esbuild
Watching...
Build succeeded
```

**Challenge (Optional)**:
- Set up projects with all three tools
- Compare build times
- Choose best tool for your use case
- Build a complete application

---

## Common Mistakes

### 1. Wrong Tool for Use Case

```javascript
// ❌ Bad: Using esbuild for complex React app
// esbuild lacks some React features

// ✅ Good: Use Vite for React
npm create vite@latest -- --template react
```

### 2. Not Using Modern Tools

```javascript
// ❌ Bad: Always using webpack
// Slower development experience

// ✅ Good: Consider modern tools
// Faster, better DX
```

### 3. Over-Configuring

```javascript
// ❌ Bad: Too much config for Parcel
// Parcel works with zero config

// ✅ Good: Start with defaults
// Add config only when needed
```

---

## Key Takeaways

1. **Vite**: Fast, great for modern frameworks
2. **Parcel**: Zero config, automatic
3. **esbuild**: Extremely fast, simple
4. **Comparison**: Each has strengths
5. **Choose**: Based on project needs
6. **Modern Tools**: Faster than webpack
7. **Best Practice**: Use right tool for job

---

## Quiz: Build Tools

Test your understanding with these questions:

1. **Vite is best for:**
   - A) Modern frameworks
   - B) Legacy projects
   - C) Both
   - D) Neither

2. **Parcel requires:**
   - A) Zero config
   - B) Lots of config
   - C) Some config
   - D) Random

3. **esbuild is:**
   - A) Fastest
   - B) Slowest
   - C) Medium speed
   - D) Unknown

4. **Vite uses:**
   - A) Native ES modules in dev
   - B) CommonJS in dev
   - C) Both
   - D) Neither

5. **Parcel:**
   - A) Zero config
   - B) Needs config
   - C) Optional config
   - D) Random

6. **esbuild is written in:**
   - A) JavaScript
   - B) Go
   - C) Rust
   - D) Python

7. **Modern tools are:**
   - A) Faster
   - B) Slower
   - C) Same speed
   - D) Unknown

**Answers**:
1. A) Modern frameworks
2. A) Zero config
3. A) Fastest
4. A) Native ES modules in dev
5. A) Zero config
6. B) Go
7. A) Faster

---

## Next Steps

Congratulations! You've completed Module 23: Build Tools and Bundlers. You now know:
- npm and package management
- Webpack configuration
- Modern build tools (Vite, Parcel, esbuild)
- How to choose the right tool

**What's Next?**
- Module 24: Code Quality and Linting
- Lesson 24.1: ESLint
- Learn code linting
- Set up ESLint

---

## Additional Resources

- **Vite**: [vitejs.dev](https://vitejs.dev)
- **Parcel**: [parceljs.org](https://parceljs.org)
- **esbuild**: [esbuild.github.io](https://esbuild.github.io)

---

*Lesson completed! You've finished Module 23: Build Tools and Bundlers. Ready for Module 24: Code Quality and Linting!*

