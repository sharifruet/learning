# Lesson 25.1: React Introduction

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what React is
- Know the React ecosystem
- Set up React projects
- Understand JSX syntax
- Create your first React app
- Work with React basics
- Build modern user interfaces

---

## Introduction to React

React is a JavaScript library for building user interfaces, particularly web applications.

### What is React?

- **Library**: Not a framework, but a library
- **Component-Based**: Build with reusable components
- **Declarative**: Describe what UI should look like
- **Virtual DOM**: Efficient updates
- **Unidirectional Data Flow**: Predictable data flow
- **Popular**: Most popular frontend library

### Why React?

- **Component Reusability**: Reuse components
- **Fast**: Virtual DOM for performance
- **Large Ecosystem**: Huge community and tools
- **Industry Standard**: Used by many companies
- **Great DX**: Excellent developer experience
- **Flexible**: Works with many tools

---

## React Ecosystem

### Core Libraries

```javascript
// React Core
react          // Core library
react-dom      // DOM rendering

// Routing
react-router   // Client-side routing

// State Management
redux          // Predictable state container
zustand        // Lightweight state management
recoil         // State management library

// UI Libraries
material-ui    // Material Design components
ant-design    // Enterprise UI components
chakra-ui     // Simple and modular
```

### Build Tools

```javascript
// Create React App
create-react-app

// Vite
vite

// Next.js (React framework)
next.js

// Remix (React framework)
remix
```

### Development Tools

```javascript
// React DevTools
// Browser extension for debugging

// Testing
@testing-library/react
jest

// Type Checking
TypeScript
PropTypes
```

---

## Setting Up React

### Create React App

```bash
# Create React app
npx create-react-app my-app

# Navigate to app
cd my-app

# Start development server
npm start
```

### Vite with React

```bash
# Create React app with Vite
npm create vite@latest my-app -- --template react

# Navigate to app
cd my-app

# Install dependencies
npm install

# Start development server
npm run dev
```

### Manual Setup

```bash
# Install React
npm install react react-dom

# Install build tools
npm install --save-dev @vitejs/plugin-react vite
```

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [react()]
});
```

---

## JSX Syntax

### What is JSX?

JSX is a syntax extension that lets you write HTML-like code in JavaScript.

### Basic JSX

```javascript
// JSX
const element = <h1>Hello, World!</h1>;

// Equivalent JavaScript
const element = React.createElement('h1', null, 'Hello, World!');
```

### JSX Expressions

```javascript
// Embedding expressions
const name = 'Alice';
const element = <h1>Hello, {name}!</h1>;

// Expressions in attributes
const element = <img src={imageUrl} alt={imageAlt} />;

// Expressions in JSX
const element = (
    <div>
        <h1>{title}</h1>
        <p>{2 + 2}</p>
        <p>{user.name}</p>
    </div>
);
```

### JSX Rules

```javascript
// 1. Return single element
// ❌ Bad
function Component() {
    return (
        <h1>Title</h1>
        <p>Content</p>
    );
}

// ✅ Good: Wrap in fragment or div
function Component() {
    return (
        <>
            <h1>Title</h1>
            <p>Content</p>
        </>
    );
}

// 2. Use className instead of class
<div className="container">Content</div>

// 3. Self-closing tags
<img src="image.jpg" alt="Image" />
<br />
<input type="text" />

// 4. camelCase for attributes
<div tabIndex={0} onClick={handleClick}></div>
```

### JSX with JavaScript

```javascript
// Conditional rendering
function Greeting({ isLoggedIn }) {
    if (isLoggedIn) {
        return <h1>Welcome back!</h1>;
    }
    return <h1>Please sign in.</h1>;
}

// Ternary operator
function Greeting({ isLoggedIn }) {
    return (
        <div>
            {isLoggedIn ? <h1>Welcome back!</h1> : <h1>Please sign in.</h1>}
        </div>
    );
}

// Logical AND
function Mailbox({ unreadMessages }) {
    return (
        <div>
            <h1>Hello!</h1>
            {unreadMessages.length > 0 && (
                <h2>You have {unreadMessages.length} unread messages.</h2>
            )}
        </div>
    );
}

// Lists
function NumberList({ numbers }) {
    return (
        <ul>
            {numbers.map(number => (
                <li key={number}>{number}</li>
            ))}
        </ul>
    );
}
```

---

## Your First React App

### Simple Component

```javascript
// App.jsx
import React from 'react';

function App() {
    return (
        <div className="App">
            <h1>Hello, React!</h1>
            <p>Welcome to React</p>
        </div>
    );
}

export default App;
```

### Rendering

```javascript
// index.js
import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(<App />);
```

### HTML Structure

```html
<!-- public/index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>React App</title>
</head>
<body>
    <div id="root"></div>
</body>
</html>
```

---

## Practice Exercise

### Exercise: First React App

**Objective**: Practice setting up React, understanding JSX, and creating your first React application.

**Instructions**:

1. Set up a React project
2. Create components
3. Practice:
   - JSX syntax
   - Component creation
   - Rendering elements
   - Using expressions

**Example Solution**:

```bash
# Create React app with Vite
npm create vite@latest react-practice -- --template react
cd react-practice
npm install
```

```javascript
// src/App.jsx
import React from 'react';
import './App.css';

function App() {
    const name = 'React';
    const version = '18';
    const features = ['Components', 'JSX', 'Virtual DOM', 'Hooks'];
    
    return (
        <div className="App">
            <header className="App-header">
                <h1>Welcome to {name}!</h1>
                <p>Version {version}</p>
                
                <section>
                    <h2>About React</h2>
                    <p>
                        React is a JavaScript library for building user interfaces.
                        It's component-based and uses JSX syntax.
                    </p>
                </section>
                
                <section>
                    <h2>Key Features</h2>
                    <ul>
                        {features.map((feature, index) => (
                            <li key={index}>{feature}</li>
                        ))}
                    </ul>
                </section>
                
                <section>
                    <h2>JSX Examples</h2>
                    <p>Math: 2 + 2 = {2 + 2}</p>
                    <p>Current time: {new Date().toLocaleTimeString()}</p>
                    <p>Conditional: {features.length > 0 ? 'Features available' : 'No features'}</p>
                </section>
            </header>
        </div>
    );
}

export default App;
```

```css
/* src/App.css */
.App {
    text-align: center;
    padding: 20px;
}

.App-header {
    background-color: #282c34;
    padding: 20px;
    color: white;
    border-radius: 10px;
    margin: 20px auto;
    max-width: 800px;
}

.App-header h1 {
    color: #61dafb;
    margin-bottom: 10px;
}

.App-header section {
    margin: 20px 0;
    padding: 15px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 5px;
}

.App-header ul {
    list-style: none;
    padding: 0;
}

.App-header li {
    padding: 5px;
    margin: 5px 0;
    background-color: rgba(97, 218, 251, 0.2);
    border-radius: 3px;
}
```

```javascript
// src/main.jsx
import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import './index.css';

ReactDOM.createRoot(document.getElementById('root')).render(
    <React.StrictMode>
        <App />
    </React.StrictMode>
);
```

```css
/* src/index.css */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen',
        'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue',
        sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    background-color: #f5f5f5;
}

#root {
    min-height: 100vh;
}
```

```html
<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>React Practice</title>
</head>
<body>
    <div id="root"></div>
    <script type="module" src="/src/main.jsx"></script>
</body>
</html>
```

```javascript
// Additional JSX examples
// src/components/JSXExamples.jsx
import React from 'react';

function JSXExamples() {
    const user = {
        name: 'Alice',
        age: 30,
        email: 'alice@example.com'
    };
    
    const isLoggedIn = true;
    const items = ['Apple', 'Banana', 'Orange'];
    
    return (
        <div className="jsx-examples">
            <h2>JSX Examples</h2>
            
            {/* Expressions */}
            <section>
                <h3>Expressions</h3>
                <p>Name: {user.name}</p>
                <p>Age: {user.age}</p>
                <p>Math: 5 + 3 = {5 + 3}</p>
            </section>
            
            {/* Conditional Rendering */}
            <section>
                <h3>Conditional Rendering</h3>
                {isLoggedIn ? (
                    <p>Welcome, {user.name}!</p>
                ) : (
                    <p>Please log in</p>
                )}
                
                {isLoggedIn && <p>You are logged in</p>}
            </section>
            
            {/* Lists */}
            <section>
                <h3>Lists</h3>
                <ul>
                    {items.map((item, index) => (
                        <li key={index}>{item}</li>
                    ))}
                </ul>
            </section>
            
            {/* Attributes */}
            <section>
                <h3>Attributes</h3>
                <div className="container" id="main">
                    <input type="text" placeholder="Enter text" />
                    <button onClick={() => alert('Clicked!')}>
                        Click Me
                    </button>
                </div>
            </section>
            
            {/* Fragments */}
            <section>
                <h3>Fragments</h3>
                <>
                    <p>First paragraph</p>
                    <p>Second paragraph</p>
                </>
            </section>
        </div>
    );
}

export default JSXExamples;
```

**Expected Output** (in browser):
- React app with header
- JSX examples displayed
- Interactive elements
- Styled components

**Challenge (Optional)**:
- Build a complete React app
- Create multiple components
- Add interactivity
- Style your components

---

## Common Mistakes

### 1. Not Returning Single Element

```javascript
// ❌ Bad: Multiple root elements
function Component() {
    return (
        <h1>Title</h1>
        <p>Content</p>
    );
}

// ✅ Good: Single root or fragment
function Component() {
    return (
        <>
            <h1>Title</h1>
            <p>Content</p>
        </>
    );
}
```

### 2. Using class Instead of className

```javascript
// ❌ Bad: HTML class
<div class="container">Content</div>

// ✅ Good: JSX className
<div className="container">Content</div>
```

### 3. Missing Keys in Lists

```javascript
// ❌ Bad: No key
{items.map(item => <li>{item}</li>)}

// ✅ Good: With key
{items.map((item, index) => <li key={index}>{item}</li>)}
```

---

## Key Takeaways

1. **React**: JavaScript library for building UIs
2. **Component-Based**: Build with reusable components
3. **JSX**: HTML-like syntax in JavaScript
4. **Virtual DOM**: Efficient updates
5. **Setup**: Create React App or Vite
6. **Best Practice**: Single root element, use className, add keys
7. **Ecosystem**: Large ecosystem of tools and libraries

---

## Quiz: React Basics

Test your understanding with these questions:

1. **React is:**
   - A) Framework
   - B) Library
   - C) Both
   - D) Neither

2. **JSX is:**
   - A) HTML
   - B) JavaScript syntax extension
   - C) CSS
   - D) Nothing

3. **JSX uses:**
   - A) class
   - B) className
   - C) Both
   - D) Neither

4. **React components return:**
   - A) Single element
   - B) Multiple elements
   - C) Both
   - D) Neither

5. **JSX expressions use:**
   - A) {}
   - B) []
   - C) Both
   - D) Neither

6. **React uses:**
   - A) Virtual DOM
   - B) Real DOM
   - C) Both
   - D) Neither

7. **Create React App:**
   - A) Sets up React project
   - B) Installs React only
   - C) Both
   - D) Neither

**Answers**:
1. B) Library
2. B) JavaScript syntax extension
3. B) className
4. A) Single element (or fragment)
5. A) {}
6. A) Virtual DOM
7. A) Sets up React project

---

## Next Steps

Congratulations! You've learned React introduction. You now know:
- What React is
- How to set up React
- JSX syntax
- How to create components

**What's Next?**
- Lesson 25.2: Components and Props
- Learn functional and class components
- Understand props
- Build component composition

---

## Additional Resources

- **React Documentation**: [react.dev](https://react.dev)
- **React Tutorial**: [react.dev/learn](https://react.dev/learn)
- **JSX Guide**: [react.dev/learn/writing-markup-with-jsx](https://react.dev/learn/writing-markup-with-jsx)

---

*Lesson completed! You're ready to move on to the next lesson.*

